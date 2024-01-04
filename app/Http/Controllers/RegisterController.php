<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Services\User as ServiceUser;


/**
 * Description of RegisterController
 *
 * @author tomi2
 */
class RegisterController extends Controller {
    //put your code here
    
    public function registerSubmit(Request $request) {
        
        $validator = Validator::make(
            $request->all(),
            ['name' => 'required|unique:users|min:4|max:25',
             'email' => 'required|unique:users|min:4|max:25',
             'password' => 'required',
             'password' => 'min:6|max:20',
             'password_confirm' => 'required_with:password|same:password|min:6',
             'start_day' => 'integer|min:0|integer|max:23',
             ]
    
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }
        else {
            $User = new ServiceUser;
            $User->saveUser($request);
            return redirect()->route('login')->withSuccess("Rejestracja zakończona możesz się zalogować");
        }
         
    }
}
