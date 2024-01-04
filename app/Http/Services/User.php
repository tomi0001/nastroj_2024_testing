<?php
/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use Hash;
use Auth;
class User {
    public $errors = [];
    public function saveUser(Request $request) {
        $User = new MUser;
        $User->name = $request->get("name");
        $User->email = $request->get("email");
        $User->password = Hash::make($request->get("password"));
        $User->start_day = $request->get("startDay");
        $User->save();
    }
    public function checkError(Request $request) {
        if ($request->get("login") == "") {
            array_push($this->errors,"Uzupełnij pole login");
        }
        if ($request->get("password") == "") {
            array_push($this->errors,"Uzupełnij pole hasło");
        }
        if (MUser::IfExistUser($request->get("login"),Auth::User()->id) > 0   and MUser::IfExistUser($request->get("login")) > 0) {
            array_push($this->errors,"Już jest podany użytkwomnik wybierz inna nazwę");
        }
        
    }
    public function updateUserDoctor(Request $request) {
        if (MUser::checkIfCountDoctorId(Auth::User()->id) == 0) {
            $this->createDoctor($request);
        }
        else {
            $this->updateDoctor($request);
        }
    }
    private function updateDoctor(Request $request) {
        if ($request->get("ifTrue") == "on") {
            $ifTrue = 1;
        }
        else {
            $ifTrue = 0;
        }
        $MUser = new MUser;
        $MUser->where("name",$request->get("login"))->update(["password" => Hash::make( $request->get("password") ),"if_true" => $ifTrue]);
    }
    private function createDoctor(Request $request) {
        $MUser = new MUser;
        $MUser->name = $request->get("login");
        $MUser->password = Hash::make( $request->get("password"));
        $MUser->id_users = ( Auth::User()->id);
        $MUser->type = "doctor";
        if ($request->get("ifTrue") == "on") {
            $MUser->if_true = 1;
        }
        else {
            $MUser->if_true = 0;
        }
        $MUser->save();
        
    }
}
