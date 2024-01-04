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
use App\Http\Services\User;
use Auth;
class SettingsUserController {
    public function addDoctorNew() {
        //$User = new User;
        $doctorId = MUser::selectIdDoctor(Auth::User()->id);
        if (empty($doctorId)) {
            return view("Users.Settings.Users.addNewDoctor")->with("nameDoctor",null);
        }
        else {
            return view("Users.Settings.Users.addNewDoctor")->with("nameDoctor",$doctorId->name);
        }
    }
    
    
    public function addDoctorNewSubmit(Request $request) {
        $User = new User;
        $User->checkError($request);
        if (count($User->errors) > 0) {
            return View("ajax.error")->with("error",$User->errors);
        }
        else {
            $User->updateUserDoctor($request);
            return View("ajax.succes")->with("succes","pomyslnie zmodyfikwano ustawienia");
        }
    }
    
}
