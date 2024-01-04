<?php

/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use App\Models\Mood as MoodModel;
use App\Models\Moods_action as MoodAction;
use App\Models\Action_plan as Actions_plan;
use App\Models\Actions_day;
use App\Models\Action as actionModels;
use App\Http\Services\Calendar;
use Hash;
use Auth;
use DB;
class Action {
    public $error = [];
    public function checkErrorPlanedUpdate(Request $request) {
        if (($request->get("date") == "") ){
            array_push($this->error,"Uzupełnij datę");
        } 
        if ($request->get("time") == "") {
            array_push($this->error,"Uzupełnij czas");
        }
        if (strtotime($request->get("date") . " " . $request->get("time")) < strtotime(date("Y-m-d H:i:s"))) {
            array_push($this->error,"Data akcji zaplanowanej jest wieksza niż teraźniejsza data");
        }        
        if ((($request->get("long") != "" )  and  !is_numeric($request->get("long"))  and $request->get("long") < 0 )    ) {
            array_push($this->error,"Minuty musza być dodatnią liczbą całkowitą");
        }        
    }
    public function updateAction(Request $request) {
        $Actions_plan = new Actions_plan;
        $Actions_plan->where("id",$request->get("nameActionChange"))->update(["id_actions"=>$request->get("changeAction"),
            "date"=>$request->get("date") . " " . $request->get("time") ,
            "long"=>$request->get("long"),"what_work"=>$request->get("description")]);
        
    }
    public function checkErrorPlaned(Request $request) {
        if (($request->get("dateStart") == "") ){
            array_push($this->error,"Uzupełnij datę");
        } 
        if ($request->get("timeStart") == "") {
            array_push($this->error,"Uzupełnij czas");
        }
        if (strtotime($request->get("dateStart") . " " . $request->get("timeStart")) < strtotime(date("Y-m-d H:i:s"))) {
            array_push($this->error,"Data akcji zaplanowanej jest wieksza niż teraźniejsza data");
        }        
        if ((($request->get("minute") != "" )  and  !is_numeric($request->get("minute"))  and $request->get("minute") < 0 )    ) {
            array_push($this->error,"Minuty musza być dodatnią liczbą całkowitą");
        }
        if (empty($request->get("idAction"))) {
            array_push($this->error,"Musisz wpisać przynajmniej jedną akcję");
        }
        else if ($this->checkLastAction($request) == false) {
            array_push($this->error,"Już wpisałeś tą akcję");
        }
    }
    public function deleteActionPlan(int $id) {
        $Actions_plan = new Actions_plan;
        $Actions_plan->where("id",$id)->delete();
    }
    public function checkErrorChangeName(Request $request) {
        if (($request->get("nameAction") == "") ){
            array_push($this->error,"Wybierz akcję");
        }  
        if (($request->get("newName") == "") ){
            array_push($this->error,"Musisz wpisać nazwę");
        } 
        if (( $request->get("pleasure") < -20 or $request->get("pleasure") > 20) or ( (string)(float) $request->get("pleasure") !== $request->get("pleasure")  and ($request->get("pleasure") != "") ) ) {
            array_push($this->error,"Poziom przyjemności musi mieścić się w zakresie od -20 do +20");
        }
        if (actionModels::checkIfNameAction($request->get("newName"),Auth::User()->id,$request->get("nameAction")) > 0) {
            array_push($this->error,"Jest już akcja o takiej nazwie");
        }
    }
    private function checkLastAction(Request $request) {
        $bool = true;
        for ($i=0;$i < count($request->get("idAction"));$i++) {
            $if = Actions_plan::selectLastAction($request->get("dateStart") . " " . $request->get("timeStart"),$request->get("minute"),Auth::User()->id,str_replace("\n", "<br>", $request->get("description")),$request->get("idAction")[$i] );
            if (!empty($if)) {
                $bool = false;
            }
        }
        return $bool;
    }
    public function checkError(Request $request) {
        if (strtotime($request->get("date")) > strtotime(date("Y-m-d"))) {
            array_push($this->error,"Data akcji jest wieksza niż teraźniejsza data");
        }
        else if ($request->get("time") != "" and $request->get("actionDay") != "" and    !empty(Actions_day::selectLastActionDate($request->get("actionDay"),$request->get("date") . " " . $request->get("time")) ) ) {
            array_push($this->error, "Już wpisałeś tą akcje");
        }
        else if ($request->get("time") == "" and $request->get("actionDay") != "" and    !empty(Actions_day::selectLastAction($request->get("actionDay")) ) ) {
            array_push($this->error, "Już wpisałeś tą akcje");
        } 
    }
    public function saveAction(Request $request) {
        $ActionDay = new Actions_day;
        $ActionDay->id_users = Auth::User()->id;
        $ActionDay->id_actions = $request->get("actionDay");
        if ($request->get("time") != "") {
            $ActionDay->date = $request->get("date") . " " . $request->get("time");
        }
        else {
            $ActionDay->date = $request->get("date") . " " . date("H:i:s");
        }
        $ActionDay->save();
    }

    public function removeActionDay(int $id) {
        $ActionsDay = new Actions_day;
        $ActionsDay->where("id",$id)->where("id_users",Auth::User()->id)->delete();
    }
    public function updateActionDay(Request $request)  {
        $ActionDay = new Actions_day;
        $ActionDay->where("id_users",Auth::User()->id)->where("id",$request->get("id"))->update(["id_actions"=> $request->get("idAction")]);
        
    }
    public function removeActionMoods(int $id) {
        $MoodAction = new MoodAction;
        $MoodAction->where("id_moods",$id)->delete();
    }
    public function addNewAction(Request $request) {
        $Action = new actionModels;
        $Action->name  = $request->get("nameAction");
        $Action->level_pleasure  = $request->get("levelPleasure");
        $Action->id_users  = Auth::User()->id;
        $Action->save();
    }
    public function saveActionPlaned(Request $request) {
        for ($i=0;$i < count($request->get("idAction"));$i++) {
            $Action = new Actions_plan;
            $Action->id_users  = Auth::User()->id;
            $Action->id_actions  = $request->get("idAction")[$i];
            $Action->date  = $request->get("dateStart") . " " . $request->get("timeStart");
            $Action->long  = $request->get("minute");
            $Action->what_work  = str_replace("\n", "<br>", $request->get("description"));
            $Action->save();
        }
    }
    public function updateActionName(Request $request) {
        $Action = new actionModels;
        $Action->where("id",$request->get("nameAction"))->where("id_users",Auth::User()->id)->update(["name"=>$request->get("newName"),"level_pleasure"=>$request->get("pleasure")]);
    }
}
