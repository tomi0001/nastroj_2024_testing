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
use App\Models\Group;
use App\Http\Services\Mood as serviceMood; 
use App\Models\Moods_action;
use App\Models\Usee;
use App\Models\Substance;
use App\Http\Services\Sleep;
use App\Models\Product as ModelProduct;
use App\Models\Planned_drug;
use App\Http\Services\Product;
use App\Http\Services\Common;
use App\Http\Services\Action as serviceAction;
use Auth;
class SettingsProductController {
    public function addNewGroup() {
        $listGroup = Group::selectListGroup(Auth::User()->id);
        return view("Users.Settings.Product.addNewGroup")->with("listGroup",$listGroup);
    }
    public function addNewSubstance() {
        $listSubstance = Substance::selectListSubstance(Auth::User()->id);
        $listGroup = Group::selectListGroup(Auth::User()->id);
        return view("Users.Settings.Product.addNewSubstance")->with("listGroup",$listGroup)->with("listSubstance",$listSubstance);
    }
    public function addNewProduct() {
        $listSubstance = Substance::selectListSubstance(Auth::User()->id);
        $listProduct = ModelProduct::selectListProduct(Auth::User()->id);
        return view("Users.Settings.Product.addNewProduct")->with("listSubstance",$listSubstance)->with("listProduct",$listProduct);
    }
    public function editGroup() {
        $listGroup = Group::selectListGroup(Auth::User()->id);
        return view("Users.Settings.Product.editGroup")->with("listGroup",$listGroup);
    }
    public function editSubstance() {
        $listSubstance = Substance::selectListSubstance(Auth::User()->id);
        return view("Users.Settings.Product.editSubstance")->with("listSubstance",$listSubstance);
    }
    public function editProduct() {
        $listProduct = ModelProduct::selectListProduct(Auth::User()->id);
        return view("Users.Settings.Product.editProduct")->with("listProduct",$listProduct);
    }
    public function planedDose() {
        $listProduct = ModelProduct::selectListProduct(Auth::User()->id);
        $listPlaned = Planned_drug::selectDose(Auth::User()->id);
        return view("Users.Settings.Product.PlanedDrug")->with("listProduct",$listProduct)->with("listPlaned",$listPlaned);
    }
    public function loadChangePlaned(Request $request) {
        $namePlaned = Planned_drug::showNameName($request->get("id"));
        $listPlaned = Planned_drug::showPlanedOneSettings($namePlaned->name);
        //print_r("<pre>");
        //print_r($listPlaned);
        $listProduct = ModelProduct::selectListProduct(Auth::User()->id);
        return View("Users.Settings.Product.changeLoadPlaned")->with("listPlaned",$listPlaned)->with("listProduct",$listProduct)
                ->with("id",$namePlaned->name);
    }
    public function editPlanedsubmit(Request $request) {
        $namePlaned = Planned_drug::ifExist($request->get("id"),Auth::User()->id);
        $Product = new Product;
        $Product->deletePlaned($namePlaned->name);
        $Product->addNewPlanedArray($request,$namePlaned->name);
        return View("ajax.succes")->with("succes","pomyślnie zmodyfikowano zaplanowaną dawkę.");
    }
    public function deletePlaned(Request $request) {
        $namePlaned = Planned_drug::showName($request->get("id"));
        $Product = new Product;
        $Product->deletePlaned($namePlaned->name);
    }
    public function addNewPlaned(Request $request) {
        $Product = new Product;
        $Product->checkErrorNewPlaned($request);
        if (count($Product->error) > 0) {
            return View("ajax.error")->with("error",$Product->error);
            
        }
        else {
            $Product->addNewPlaned($request);
            return View("ajax.succes")->with("succes","Pomyślnie dodano zaplaniowaną dawkę");
        }
    } 
    public function addNewGroupSubmit(Request $request) {
        
        $ifExist = Group::ifExist($request->get("nameGroup"),Auth::User()->id);
        if (!empty($ifExist) ) {
            print json_encode(["error"=>"Już jest taka akcja"]);
        }
        else {
            $Group = new Product;
            $Group->addNewGroup($request);
            
            print json_encode(["error"=>0,"succes"=>"Pomyślnie dodano grupę"]);
        }
    }
    public function changeSubstance(Request $request) {
        $listGroup = Group::selectListGroup(Auth::User()->id);
        $showSettingsSubstance = Substance::showSettingsSubstance($request->get("id"),Auth::User()->id);
        $equivalent = Substance::showSubstanceEquivalentName($request->get("id"),Auth::User()->id);
        $Product = new Product;
        $newList = $Product->sortWhereSubstance($listGroup,$showSettingsSubstance);
        return View("Users.Settings.Product.editSubstanceLoadGroup")->with("listGroup",$newList)->with("idSubstance",$request->get("id"))
                ->with("equivalent",$equivalent);    
    }
    
    public function changeProduct(Request $request) {
        $listSubstance = Substance::selectListSubstance(Auth::User()->id);
        $showSettingsProduct = ModelProduct::showSettingsProduct($request->get("id"),Auth::User()->id);
        $percent = ModelProduct::showProductPercentName($request->get("id"),Auth::User()->id);
        $Product = new Product;
        $newList = $Product->sortWhereProduct($listSubstance,$showSettingsProduct);
        return View("Users.Settings.Product.editProductLoadSubstance")->with("listSub",$newList)->with("idProduct",$request->get("id"))
                ->with("percent",$percent);   
    }
    
    
    public function editGroupSubmit(Request $request) {
        $ifExist = Group::checkIfNameAction($request->get("newNameGroup"),Auth::User()->id,$request->get("newNameGroupHidden"));
        if (!empty($ifExist) ) {
            return View("ajax.error")->with("error",["Już jest taka Grupa"]);
            //print json_encode(["error"=>"Już jest taka Grupa"]);
        }
        else {
            $Group = new Product;
            $Group->editNameGroup($request);
            
            return View("ajax.succes")->with("succes","Pomyślnie zmodyfikowano nazwę grupy");
        }
    }
    public function editProductSubmit(Request $request) {
        $Product = new Product;
        $Product->checkErrorEditProduct($request);
        if (count($Product->error) > 0) {
            return View("ajax.error")->with("error",$Product->error);
            
        }
        else {
            $Product->resetProduct($request);
            
            $Product->updateProductSubstancename($request);
            
            if (!empty($request->get("idSubstance2")) ) {
                $Product->updateProductSubstance($request);
            }
            return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowano produkt");
        }
        
    }
    public function addNewSubstanceSubmit(Request $request) {
        $Substance = new Product;
        $Substance->checkErrorAddSubstance($request);
        if (count($Substance->error) > 0) {
            return View("ajax.error")->with("error",$Substance->error);
            
        }

        
        else {
            
            $Substance->addNewSubstance($request);
            return View("ajax.succes")->with("succes","Pomyślnie dodano substancę");
        }
    }
    public function editSubstanceSubmit(Request $request) {
        $Substance = new Product;
        $Substance->checkErrorEditSubstance($request);
        if (count($Substance->error) > 0) {
            return View("ajax.error")->with("error",$Substance->error);
            
        }
        else {
            $Substance->resetSubstance($request);
            
            $Substance->updateSubstanceGroupname($request);
            
            if (!empty($request->get("idGroup")) ) {
                $Substance->updateSubstanceGroup($request);
            }
            return View("ajax.succes")->with("succes","Pomyslnie zmodyfikowano susbtancę");
        }
    }
    public function addNewProductSubmit(Request $request) {
        $Product = new Product;
        $Product->checkErrorAddProduct($request);
        if (count($Product->error) > 0) {
            return View("ajax.error")->with("error",$Product->error);
            
        }

        
        else {
            
            $Product->addNewProduct($request);
            return View("ajax.succes")->with("succes","Pomyślnie dodano produkt");
        }
    } 
   
}
