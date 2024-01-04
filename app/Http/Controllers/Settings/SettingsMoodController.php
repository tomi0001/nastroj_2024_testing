<?php

/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\Settings;

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
use App\Http\Services\Sleep;
use App\Models\Product as ModelProduct;
use App\Http\Services\Product;
use App\Http\Services\Common;
use App\Http\Services\Action as serviceAction;
use Auth;
class SettingsMoodController {
    public function addNewAction() {
        $listAction = Action::downloadListAction(Auth::User()->id);
        return view("Users.Settings.Mood.addNewAction")->with("listAction",$listAction);
    }
    public function addNewActionSubmit(Request $request) {
        
        $ifExist = Action::ifExist($request->get("nameAction"),Auth::User()->id);
        if (!empty($ifExist) ) {
            print json_encode(["error"=>"Już jest taka akcja"]);
        }
        else {
            $Action = new serviceAction;
            $Action->addNewAction($request);
            
            print json_encode(["error"=>0,"succes"=>"Pomyślnie dodano akcję"]);
        }
    }
    public function levelMood() {
        $Mood = new MoodServices;
        $bool = $Mood->setLevelMood(Auth::User()->id);

        return view("Users.Settings.Mood.levelMood")->with("arrayLevel",$Mood->levelMood)->with("i",1);

    }
    public function levelMoodSubmit(Request $request) {
        $Mood = new MoodServices;
        $Mood->checkErrorLevelMood($request);
        if (count($Mood->errors) > 0) {
            return View("ajax.error")->with("error",$Mood->errors);
        }
        else {
            $Mood->updateSettingMood($request);
            return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowano dane");
        }
    }
    public function changeNameAction() {
        $listAction = Action::downloadListAction(Auth::User()->id);
        return view("Users.Settings.Mood.changeNameAction")->with("listAction",$listAction);
    }
    public function loadValuePlasure(Request $request) {
        $pleasure = Action::showPleasure(Auth::User()->id,$request->get("id"));
        print json_encode($pleasure);
    }
    public function changeNameActionSubmit(Request $request) {
        $Action = new ActionServices;
        $Action->checkErrorChangeName($request);
        if (count($Action->error) > 0 ) {
            return View("ajax.error")->with("error",$Action->error);
        }
        else {
            $Action->updateActionName($request);
            return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowano");
        }
        
    }
    
    public function changeDateAction() {
        $listAction = Action_plan::downloadListAction(Auth::User()->id);
        return view("Users.Settings.Mood.changeDateAction")->with("listAction",$listAction);
    }
    
    
    public function loadActionChange(Request $request) {
        $actionId = Action_plan::selectActionPlan($request->get('id'),Auth::User()->id);
        $listAction = Action::downloadListAction(Auth::User()->id);
        
        if (StrTotime($actionId->date . " " . $actionId->time . ":00") < time()) {
            $bool = true;
        }
        else {
            $bool = false;
        }
        $json["actionPlan"] = $actionId;
        $json["actionList"] = $listAction;
        $json["bool"] = $bool;
        print json_encode($json);
         
    }
    public function deleteAction(Request $request) {
        $bool = Action_plan::ifIdExist($request->get('id'),Auth::User()->id);
        if ($bool > 0) {
            $Action = new serviceAction;
            $Action->deleteActionPlan($request->get('id'));
        }
    }
    public function changeDateActionSubmit(Request $request) {
        $ActionServices = new ActionServices;
        $ActionServices->checkErrorPlanedUpdate($request);
        if (count($ActionServices->error) > 0 ) {
            return View("ajax.error")->with("error",$ActionServices->error);
        }
        else {
            $ActionServices->updateAction($request);
            return View("ajax.succes")->with("succes","Pomyślnie zmodyfikowano akcje");
        }
    }
    
}
