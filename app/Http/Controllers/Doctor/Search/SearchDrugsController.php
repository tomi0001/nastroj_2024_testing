<?php

/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\Doctor\Search;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use Hash;
use App\Http\Services\SearchDrugs;
use App\Models\Mood;
use Auth;
use App\Models\Usee;

class SearchDrugsController {
    public function allSubstanceDay(Request $request) {
       $listSubstance = Usee::listSubstnace($request->get("date"), Auth::User()->id_users,Auth::User()->start_day);
       return  View("Doctor.Search.Product.showAllSubstanceMood")->with("listSubstance",$listSubstance);
    }
    public function searchDrugsSubmit(Request $request) {
        
        $SearchDrugs = new SearchDrugs($request,1);
        $SearchDrugs->checkError($request);
        if (count($SearchDrugs->errors) > 0) {
            return View("Doctor.Search.Product.error")->with("errors",$SearchDrugs->errors);
        }
        else {
            if ($request->get("doseDay") == "on") {
                $result = $SearchDrugs->createQuestionGroupDay($request);
                return View("Doctor.Search.Product.searchResultDrugsGroupDay")->with("arrayList",$result)->with("count",$SearchDrugs->count);
            }
            else if ($request->get("sumDay") == "on") {
                $result = $SearchDrugs->createQuestionSumDay($request);
                return View("Doctor.Search.Product.searchResultDrugsSumDay")
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
                return View("Doctor.Search.Product.searchResultDrugs")->with("arrayList",$result)->with("count",$SearchDrugs->count);
            }

        }
    }
}
