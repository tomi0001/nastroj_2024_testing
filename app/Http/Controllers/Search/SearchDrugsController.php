<?php

/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use Hash;
use App\Http\Services\SearchDrugs;
use App\Http\Services\SearchDrugsMood;
use App\Models\Mood;
use Auth;
use App\Models\Usee;

class SearchDrugsController {
    public function allSubstanceDay(Request $request) {
       $listSubstance = Usee::listSubstnace($request->get("date"), Auth::User()->id,Auth::User()->start_day);
       return  View("Users.Search.Product.showAllSubstanceMood")->with("listSubstance",$listSubstance);
    }
    public function searchDrugsSubmit(Request $request) {
        $SearchDrugs = new SearchDrugs($request);
        $SearchDrugs->checkError($request);
        if (count($SearchDrugs->errors) > 0) {
            return View("Users.Search.Product.error")->with("errors",$SearchDrugs->errors);
        }
        else {
            if ($request->get("doseDay") == "on") {
                $result = $SearchDrugs->createQuestionGroupDay($request);
                return View("Users.Search.Product.searchResultDrugsGroupDay")->with("arrayList",$result)->with("count",$SearchDrugs->count);
            }
            else if ($request->get("sumDay") == "on") {
                $result = $SearchDrugs->createQuestionSumDay($request);
                return View("Users.Search.Product.searchResultDrugsSumDay")
                    ->with("arrayList",$result)->with("count",$SearchDrugs->count)
                    ->with("dateFrom",$request->get("dateFrom"))
                    ->with("dateTo",$request->get("dateTo"))
                    ->with("timeFrom",$request->get("timeFrom"))
                    ->with("timeTo",$request->get("timeTo"))
                    ->with("doseFrom",$request->get("doseFrom"))
                    ->with("doseTo",$request->get("doseTo"));
            }
            else {
                $result = $SearchDrugs->createQuestion($request);
                return View("Users.Search.Product.searchResultDrugs")->with("arrayList",$result)->with("count",$SearchDrugs->count);
            }

        }
    }
    /*
     * update may 2023
     */
    public function searchDrugsMoodSubmit(Request $request) {
        $SearchDrugs = new SearchDrugsMood($request);
        $SearchDrugs->checkError($request);
        if (count($SearchDrugs->errors) > 0) {
            return View("Users.Search.Product.error")->with("errors",$SearchDrugs->errors);
        }
        else {
            $array = $SearchDrugs->search($request);
            $SearchDrugs->searchMoodDrugs($request->get("nextDay"));
            $SearchDrugs->searchMoodDrugsNot($request->get("nextDay"));
            
            if (count($SearchDrugs->listMood) == 0 or $array == false) {
                    return View("ajax.error")->with("error",["Nic nie wyszukano"]);
            }
            $result = $SearchDrugs->AverageMood();
            if ($result == false) {
                return View("ajax.error")->with("error",["Nic nie wyszukano"]);
            }
            return View("Users.Search.Mood.searchResultMoodDrugsDay")
                    ->with("arrayList", $result)->with("dateFrom",$SearchDrugs->dateFrom)->with("dateTo",$SearchDrugs->dateTo)
                    ->with("timeFrom",$request->get("timeFrom"))->with("timeTo",$request->get("timeTo"))->with("request",$request);
          
           
            
        }
    }
}
