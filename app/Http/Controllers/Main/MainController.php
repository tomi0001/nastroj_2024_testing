<?php
/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\Main;

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
        $Mood = new Main;
        $Drugs = new Product;
        $listMood = $Mood->downloadMood($Calendar->year, $Calendar->month, $Calendar->day);
        $listDrugs = Usee::selectUsee($Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day, Auth::User()->id, Auth::User()->start_day);
        $listSubstance = Usee::listSubstnace($Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day, Auth::User()->id, Auth::User()->start_day);
        $percent =  Mood::sortMood($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->start_day,Auth::User()->id);
        $percent = $Mood->setPercent($percent);
        $sumAll = \App\Models\Mood::sumAll($Calendar->year . "-" . $Calendar->month . "-" . $Calendar->day, Auth::User()->start_day,Auth::User()->id);
        $Mood->createDayColorMood($Calendar->year, $Calendar->month, $Calendar->day);
        $actionForDay = Actions_day::showActionForAllDay($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->id,Auth::User()->start_day);
        $actionPlan = Action_plan::showActionPlan($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->id,Auth::User()->start_day);
        $actionSum = Mood::sumAction($Calendar->year . "-" . $Calendar->month . "-" .  $Calendar->day,Auth::User()->id,Auth::User()->start_day);

        return View("Users.Main.main")->with("text_month",$Calendar->text_month)
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
    public function addActionDay(Request $request) {
        $Action = new serviceAction;
        $Action->checkError($request);
        if (count($Action->error) > 0 ) {
            return View("ajax.error")->with("error",$Action->error);
        }
        else {
            $Action->saveAction($request);
        }
    }
    public function addSleep(Request $request) {
        $Sleep = new Sleep;
        $Sleep->checkError($request);
        if (count($Sleep->errors) != 0) {
                return View("ajax.error")->with("error",$Sleep->errors);
        }
        else {
            $Sleep->addSleep($request);
        }
    }
    public function addProduct(Request $request) {
            
            
            $Drugs = new Product;
            $error = $Drugs->setDate($request);
            if ($error == false) {
                array_push($this->error, "Błędna data");
            }
            else if (StrToTime( date("Y-m-d H:i:s") ) < strtotime($Drugs->date)) {
                array_push($this->error,"Data wzięcia jest wieksza od teraźniejszej daty");
            }
            if ($request->get("nameProduct") == "" and $request->get("namePlaned") == "") {
                array_push($this->error, "Wpisz nazwę");
            }
            if ($request->get("dose") == "" and $request->get("namePlaned") == "") {
                array_push($this->error, "Uzupełnij pole dawka");
            }
            else if (!is_numeric($request->get("dose")) )  {
                array_push($this->error, "Pole dawka musi być numeryczne");
            }
            if (($request->get("dose")) <= 0 ) {
                array_push($this->error, "Pole dawka musi być większe o 0");
            }
            else if ( $request->get("nameProduct") != "" and    !empty(Usee::selectLastDrugs($request->get("nameProduct"),$Drugs->date,$request->get("dose")) )) {
                array_push($this->error, "Już wpisałeś ten lek");
            }
            else if ($request->get("nameProduct") == "") {
                
                $namePlaned = Planned_drug::showName($request->get("namePlaned"));
                $showPlaned = Planned_drug::showPlanedOne($namePlaned->name);
                if (!empty(Usee::selectLastDrugsPlaned($showPlaned->id_products,$Drugs->date) )) {
                    array_push($this->error, "Już wpisałeś tą dawkę zaplanowaną");
                }
            }
            if (count($this->error) != 0) {
                return View("ajax.error")->with("error",$this->error);
            }
           
            else {
                if ($request->get("nameProduct") != "") {
                    $price = $Drugs->sumPrice($request->get("dose"),$request->get("nameProduct"));
                    $Drugs->addDrugs($request,$Drugs->date,$price);
                }
                else  {
                    $Drugs->addPlanedDose($request,$Drugs->date);
                }
      
                
            }
             
            
    }
    public function addMood(Request $request) {
            
            $Mood = new serviceMood;
            if ($request->get("timeStart") == ""  ) {
                $timeStart = Mood::selectLastMoods();
                if (empty($timeStart)) {
                   return View("ajax.error")->with("error",["uzupełnij czas zaczęcia"]);
                }
                else {
                    $timeStart = $timeStart->date_end;
                    
                }
            }
            else {
                $timeStart = $request->get("dateStart") . " " .  $request->get("timeStart");
            }
            if ($request->get("timeEnd") == "") {
                $timeEnd = date("Y-m-d H:i");
            }
            else {
                $timeEnd = $request->get("dateEnd") . " " .  $request->get("timeEnd");
            }
            $Mood->setVariableMood($request);
            $Mood->checkError($timeStart,$timeEnd);
            $Mood->checkAddMood($Mood->moodsVariable);
            
            if (!empty($request->get("idActions")) ) {
                $Mood->checkErrorAction($request,round(((StrToTime($timeEnd) - StrToTime($timeStart)) /60 ),2) );
            }
            if (count($Mood->errors) != 0) {
                return View("ajax.error")->with("error",$Mood->errors);
            }
            else {
                $id = $Mood->saveMood($request,$timeStart,$timeEnd,$Mood->moodsVariable);
            }
             

            if (!empty($request->get("idAction"))) {
                    $Mood->saveAction($request,$id);
            }
    }
    public function actionPlanedpAdd(Request $request) {
        $Action = new ActionServices;
        $Action->checkErrorPlaned($request);
        if ( count($Action->error) > 0  ) {
            return View("ajax.error")->with("error",$Action->error);
        }
        else {
            $Action->saveActionPlaned($request);
        }
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
    public function deleteActionDay(Request $request) {
        $Action = new ActionServices;
        $Action->removeActionDay($request->get("id"));
    }
    public function editActionDay(Request $request) {
        $listAction = Action::showActionDay(Auth::User()->id);
        print json_encode($listAction);
    }
    public function cancelActionDay(Request $request) {
        $listAction = Actions_day::returnNameAction(Auth::User()->id,$request->get("id"));
        print json_encode($listAction);
    }
    public function updateActionDay(Request $request) {
        $Action = new ActionServices;
        $Action->updateActionDay($request);
        $listAction = Action::returnNameAction($request->get("idAction"),Auth::User()->id);
        print $listAction->name;
    }
    public function updateMood(Request $request) {
        $Mood = new MoodServices;
        $Mood->updateMood($request);
        $valueMood = Mood::selectValueMood($request->get("id"),Auth::User()->id);
        print json_encode($valueMood);
    }
    public function deleteMood(Request $request) {
        $Mood = new MoodServices;
        $Action = new ActionServices;
        $Action->removeActionMoods($request->get("id"));
        $Mood->deleteMood($request->get("id"));
        
    }
    public function deleteSleep(Request $request) {
        $Mood = new MoodServices;
        $Mood->deleteMood($request->get("id"));
    }
    public function deleteDrugs(Request $request) {
        $Product = new Product;
        $Product->removeDescriptionDrugs($request->get("id"));
        $Product->deleteDrugs($request->get("id"));
    }
    public function editMoodDescription(Request $request) {
        $description = Mood::selectDescription($request->get("id"),Auth::User()->id);
        print json_encode($description);
    }
    public function editSleepDescription(Request $request) {
        $description = Mood::selectDescription($request->get("id"),Auth::User()->id);
        print json_encode($description);
    }
    public function updateDescription(Request $request) {
        $Mood = new MoodServices;
        $Mood->updateDescription($request,Auth::User()->id);
    }
    public function showMoodDescription(Request $request) {
        $description = Mood::selectDescriptionShow($request->get("id"),Auth::User()->id);
        print $description->what_work;
    }
    public function showMoodDescriptionSleep(Request $request) {
        $description = Mood::selectDescriptionShow($request->get("id"),Auth::User()->id);
        print $description->what_work;
    }
    
    
    public function showAction(Request $request) {
        $listAction = Moods_action::selectlistAction($request->get("id"),Auth::User()->id);
        return View("ajax.showAction")->with("listAction",$listAction);
        
    }
    public function showDrugs(Request $request) {
        $listDate = Mood::selectDateMoods($request->get("id"),Auth::User()->id);
        $listDrugsAt = Usee::selectlistDrugs(date("Y-m-d H:i:s", strtotime($listDate->date_start) - 3600),date("Y-m-d H:i:s", strtotime($listDate->date_start)-1),Auth::User()->id);
        $listDrugs = Usee::selectlistDrugs($listDate->date_start,$listDate->date_end,Auth::User()->id);
        return View("ajax.showDrugs")->with("listDrugs",$listDrugs)->with("listDrugsAt",$listDrugsAt);
    }
    public function editActionMood(Request $request) {
        return View("ajax.editActionMood")->with("idMood",$request->get("id"));
        
    }
    public function updateAction(Request $request) {
        $Mood =  new MoodServices;
        //var_dump($request->get("idAction"));
        if (Mood::ifIdUsersExist($request->get("idMood"),Auth::User()->id) != NULL ) {
            $datemood = Mood::selectDateMood($request->get("idMood"));
            $Mood->checkErrorAction($request,round(((StrToTime($datemood->dateEnd) - StrToTime($datemood->dateStart)) /60 ),2) );
            if (count($Mood->errors) == 0) {
                $MoodServices = new MoodServices;
                $MoodServices->deleteMoodAction($request->get("idMood"));
                $MoodServices->saveActionUpdate($request,$request->get("idMood"));
            }
            else {
                return View("ajax.error")->with("error",$Mood->errors);
            }
        }
    }
    public function updateSleep(Request $request) {
        $Mood = new MoodServices;
        $Mood->updateSleep($request);
        $valueSleep = Mood::selectValueSleep($request->get("id"),Auth::User()->id);
        print json_encode($valueSleep);
    }
    public function showDescriptionDrugs(Request $request) {
        if (Usee::ifIdUsersExist($request->get("id"),Auth::User()->id) > 0 ) {
            $description = new Product;
            $desctptionList = $description->showDescriptions($request->get("id"));
            return View("ajax.showDescriptionDrugs")->with("list",$desctptionList);
        }
    }
    public function addDescriptionDrugs(Request $request) {
        if ($request->get("description") == "") {
            return View("ajax.error")->with("error",["Uzupełnij nazwe, nazwa nie może być pusta."]);
        }
        else if (!empty(Usee::selectLastDescription($request->get("id"),date("Y-m-d H:i:s"),str_replace("\n", "<br>", $request->get("description"))))) {
            return View("ajax.error")->with("error",["Już wpisałeś ten opis."]);
        }
        else {
            $description = new Product;
            $description->addDescription($request, $request->get("id"), date("Y-m-d H:i:s"));
            return View("ajax.succes")->with("succes","Pomyślnie dodano");
        }
    }
    public function updateDrugs(Request $request) {
        $Product = new Product;
        $error = Common::ifDateTrue($request->get("date") . " " . $request->get("time") . ":00");
        if (!Common::ifDateTrue($request->get("date") . " " . $request->get("time") . ":00")) {
            print json_encode(["errorDate" =>true]);
        }
        else {
            $price = $Product->sumPrice($request->get("doseEdit"),$request->get("idProduct"));
            $Product->updateProduct($request,$price);
            $valueDrugs = Usee::selectValueDrugs($request->get("id"),Auth::User()->id);
            $valueDrugs->type = Common::showDoseProduct($valueDrugs->type);
            print json_encode($valueDrugs);
        }
         
    }
    
    
    public function loadTypePortion(Request $request) {
        $type = ModelProduct::selectTypeProduct($request->get("nameProduct"),Auth::User()->id);
        $typeText = Common::showDoseProduct($type->type_of_portion);
        return View("ajax.showTypyPortion")->with("type",$typeText);
    }
    
    public function showAverage(Request $request) {
        $Equivalent = null;
        $allSubstance = Usee::selectAllSubstance($request->get("id"),Auth::User()->id);
        $productName = Usee::selectProductName($request->get("id"),Auth::User()->id);
        if (Usee::checkEquivalent($request->get("id"),Auth::User()->id) != null) {
            $Equivalent = $request->get("id");
        }
        return View("ajax.showAverage")->with("allSubstance",$allSubstance)->with("productName",$productName)
                ->with("id",$request->get("id"))->with("Equivalent",$Equivalent);
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
                case 1 : $result = $Product->sumAverageProduct($type[1],$request->get("id"),$request->get("hourFrom"),$request->get("hourTo"),Auth::User()->id);
                    break;
                case 2 : $result = $Product->sumAverageSubstances($type[1],$request->get("id"),$request->get("hourFrom"),$request->get("hourTo"),Auth::User()->id);
                    break;
                case 3 : $result = $Product->sumEquivalent($type[1],$request->get("hourFrom"),$request->get("hourTo"),Auth::User()->id);
                    break;
                    
                    
               
            }
            if ($type[0] == 1 or $type[0] == 2 or $type[0] == 3) {
                return View("ajax.sumAverage")->with("listAverage",$result);
            }
        }
    }
    
}
