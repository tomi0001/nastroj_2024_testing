<?php
/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\Doctor\Main;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use Hash;
use App\Http\Services\Calendar;
use App\Http\Services\Main;
use App\Http\Services\Action as ActionServices;
use App\Http\Services\Mood as MoodServices;
use App\Models\Action;
use App\Models\Actions_day;
use App\Models\Action_plan;
use App\Models\Mood;
use App\Http\Services\Mood as serviceMood; 
use App\Models\Moods_action;
use App\Models\Usee;
use App\Models\Planned_drug;
use App\Http\Services\Sleep;
use App\Models\Product as ModelProduct;
use App\Http\Services\Product;
use App\Http\Services\Common;
use App\Http\Services\Action as serviceAction;
use Auth;
class MainController {
    public $error = [];
    public function index($year = "",$month  ="",$day = "") {   

        $Calendar = new Calendar($year, $month, $day);
        $Mood = new Main(false);
        $Drugs = new Product;
        $listMood = $Mood->downloadMood($Calendar->year, $Calendar->month, $Calendar->day);
        $listDrugs = Usee::selectUsee($Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day, Auth::User()->id_users, Auth::User()->start_day);
        $listSubstance = Usee::listSubstnace($Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day, Auth::User()->id_users, Auth::User()->start_day);
        $percent =  Mood::sortMood($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->start_day,Auth::User()->id_users);
        $percent = $Mood->setPercent($percent);
        $sumAll = \App\Models\Mood::sumAll($Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day, Auth::User()->start_day,Auth::User()->id_users);
        $Mood->createDayColorMood($Calendar->year, $Calendar->month, $Calendar->day);
        $actionForDay = Actions_day::showActionForAllDay($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->id_users,Auth::User()->start_day);
        $actionPlan = Action_plan::showActionPlan($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->id_users,Auth::User()->start_day);
        $actionSum = Mood::sumAction($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->id_users,Auth::User()->start_day);

        return View("Doctor.Main.main")->with("text_month",$Calendar->text_month)
                                ->with("year",$Calendar->year)
                                ->with("day2",1)
                                ->with("day1",1)
                                ->with("how_day_month",$Calendar->how_day_month)
                                ->with("day_week",$Calendar->day_week)
                                ->with("day3",$Calendar->day)
                                ->with("color",$Mood->listColor)
                                ->with("month",$Calendar->month)
                                ->with("back",$Calendar->back_month)
                                ->with("next",$Calendar->next_month)
                                ->with("back_year",$Calendar->back_year)
                                ->with("next_year",$Calendar->next_year)
                                ->with("listMood",$listMood)
                                ->with("percent",$percent)
                                ->with("sumAll",$sumAll)
                                ->with("listDrugs",$listDrugs)
                                ->with("listSubstance",$listSubstance)
                                ->with("actionForDay",$actionForDay)
                                ->with("actionPlan",$actionPlan)
                                ->with("listPlanedAction",$Mood->listPlanedAction)
                                ->with("actionSum",$actionSum)
                                ->with("date",$Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day);
    
    }


    public function atHourActonPlan(Request $request) {
        $hour = Action_plan::selectHourId($request->get("id"),Auth::User()->id);
        if (strtotime(date("Y-m-d H:i:s")) > strtotime($hour->date)) {
            print "Już się odbyło";
        }
        else {
            
            print "Za " . \App\Http\Services\Common::calculateHour(date("Y-m-d H:i:s"),$hour->date);
        }
        
    }

    public function showMoodDescription(Request $request) {
        $description = Mood::selectDescriptionShow($request->get("id"),Auth::User()->id_users);
        print $description->what_work;
    }
    public function showMoodDescriptionSleep(Request $request) {
        $description = Mood::selectDescriptionShow($request->get("id"),Auth::User()->id);
        print $description->what_work;
    }
    
    
    public function showAction(Request $request) {
        $listAction = Moods_action::selectlistAction($request->get("id"),Auth::User()->id_users);
        return View("ajax.showAction")->with("listAction",$listAction);
        
    }
    public function showDrugs(Request $request) {
        $listDate = Mood::selectDateMoods($request->get("id"),Auth::User()->id_users);
        $listDrugsAt = Usee::selectlistDrugs(date("Y-m-d H:i:s", strtotime($listDate->date_start) - 3600),date("Y-m-d H:i:s", strtotime($listDate->date_start)-1),Auth::User()->id_users);
        $listDrugs = Usee::selectlistDrugs($listDate->date_start,$listDate->date_end,Auth::User()->id_users);
        return View("ajax.showDrugs")->with("listDrugs",$listDrugs)->with("listDrugsAt",$listDrugsAt);
    }

    public function showDescriptionDrugs(Request $request) {
        if (Usee::ifIdUsersExist($request->get("id"),Auth::User()->id_users) > 0 ) {
            $description = new Product;
            $desctptionList = $description->showDescriptions($request->get("id"));
            return View("ajax.showDescriptionDrugs")->with("list",$desctptionList);
        }
    }

    public function loadTypePortion(Request $request) {
        $type = ModelProduct::selectTypeProduct($request->get("nameProduct"));
        $typeText = Common::showDoseProduct($type->type_of_portion);
        return View("ajax.showTypyPortion")->with("type",$typeText);
    }
    
    public function showAverage(Request $request) {
        $allSubstance = Usee::selectAllSubstance($request->get("id"),Auth::User()->id_users);
        $productName = Usee::selectProductName($request->get("id"),Auth::User()->id_users);
        return View("ajax.Doctor.showAverage")->with("allSubstance",$allSubstance)->with("productName",$productName)->with("id",$request->get("id"));
    }
    public function sumAverage(Request $request) {
        
        $Product = new Product;
        $type = explode("_",$request->get("averageType"));
        $Product->checkErrorAverage($request->get("hourFrom"),$request->get("hourTo"));
        if (count($Product->error) > 0) {
            return View("ajax.error")->with("error",$Product->error);
        }
        else {
            switch($type[0]) {
                case 1 : $result = $Product->sumAverageProduct($type[1],$request->get("id"),$request->get("hourFrom"),$request->get("hourTo"),Auth::User()->id_users);
                    break;
                case 2 : $result = $Product->sumAverageSubstances($type[1],$request->get("id"),$request->get("hourFrom"),$request->get("hourTo"),Auth::User()->id_users);
               
            }
            if ($type[0] == 1 or $type[0] == 2) {
                return View("ajax.Doctor.sumAverage")->with("listAverage",$result);
            }
        }
    }
    
    
}
