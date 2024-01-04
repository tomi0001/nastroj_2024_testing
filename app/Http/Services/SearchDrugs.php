<?php
/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use App\Models\Mood as MoodModel;
use App\Models\Product as Product;
use App\Models\Usee as Usee;
use App\Models\Substance as Substance;
use App\Models\Group as Group;
use App\Models\Moods_action as MoodAction;
use App\Http\Services\Calendar;
use Hash;
use Auth;
use DB;

class SearchDrugs {
     public $errors = [];
     private $idUsers;
     private $startDay;
     public $question;
     public $count;
     private $idProduct = [];
   


     function __construct($request,$bool = 0) {
        if ($bool == 0) {
            $this->idUsers = Auth::User()->id;
        }
        else {
            
            $this->idUsers  = Auth::User()->id_users;
        }
        $this->startDay  = Auth::User()->start_day;
        $this->setIdProduct($request->get("nameProduct"));
        $this->setIdSubstance($request->get("nameSubstance"));
        $this->setIdGroup($request->get("nameGroup"));
     }

     public function checkError(Request $request) {
         if (($request->get("doseFrom") != "") and (  $request->get("doseFrom") < 0   or  ( (string)(float) $request->get("doseFrom") !== $request->get("doseFrom")  ) )  ) {
             array_push($this->errors,"dawka od musi byc dodatnią liczbą zmnienno przecinkową");
         }
         if (($request->get("doseTo") != "") and (  $request->get("doseTo") < 0   or  ( (string)(float) $request->get("doseTo") !== $request->get("doseTo")  ) )  ) {
             array_push($this->errors,"dawka do musi byc dodatnią liczbą zmnienno przecinkową");
         }
     }

     public function createQuestionSumDay(Request $request) {
         $Usee = new Usee;
         $Usee->createQuestionsSumDay($this->startDay);
         $Usee->setIdUsers($this->idUsers);
         $Usee->setDate($request->get("dateFrom"),$request->get("dateTo"),$this->startDay);
         $this->setHour($Usee,$request);
         $Usee->setDose($request->get("doseFrom"),$request->get("doseTo"));
         $Usee->setProduct($this->idProduct);
//         if ($request->get("whatWork") != "") {
//             $Usee->setWhatWork($request->get("whatWork"));
//         }
//         if ($request->get("ifWhatWork") == "on") {
//             $Usee->setWhatWorkOn();
//         }
         $Usee->setGroupIdProduct();
         if ($request->get("sort2") == "asc") {
             $Usee->orderByGroupDay("asc",$request->get("sort"));
         }
         else {
             $Usee->orderByGroupDay("desc",$request->get("sort"));
         }
         //$Usee->setGroupDescription();
         $this->count = $Usee->questions->get()->count();
         return $Usee->questions->paginate(15);
     }
     public function createQuestionGroupDay(Request $request) {
         $Usee = new Usee;
         $Usee->createQuestionsGroupDay($this->startDay,$request->get("ifWhatWork"));
         $Usee->setIdUsers($this->idUsers);
         $Usee->setDate($request->get("dateFrom"),$request->get("dateTo"),$this->startDay);
         $this->setHour($Usee,$request);
         
         $Usee->setProduct($this->idProduct);
//         if ($request->get("whatWork") != "") {
//             $Usee->setWhatWork($request->get("whatWork"));
//         }
//         if ($request->get("ifWhatWork") == "on") {
//             $Usee->setWhatWorkOn();
//         }
         //$Usee->setCount();

         $Usee->setGroupDay(Auth::User()->start_day);

         $Usee->setGroupIdProduct();
         $Usee->setDoseGroupDay($request->get("doseFrom"),$request->get("doseTo"));
         //$Usee->setGroupDescription();
         if ($request->get("sort2") == "asc") {
             $Usee->orderByGroupDay("asc",$request->get("sort"));
             
         }
         else {
        
              $Usee->orderByGroupDay("desc",$request->get("sort"));
             
         }
         $this->count = $Usee->questions->get()->count();
         return $Usee->questions->paginate(15);
     }

     public function createQuestion(Request $request) {
         $Usee = new Usee;
         $Usee->createQuestions($this->startDay);
         $Usee->setDate($request->get("dateFrom"),$request->get("dateTo"),$this->startDay);
         $this->setHour($Usee,$request);
         $Usee->setDose($request->get("doseFrom"),$request->get("doseTo"));
         $Usee->setProduct($this->idProduct);
         $Usee->setIdUsers($this->idUsers);
         if ($request->get("whatWork") != "") {
             $Usee->setWhatWork($request->get("whatWork"));
         }
         if ($request->get("ifWhatWork") == "on") {
             $Usee->setWhatWorkOn();
         }

         $Usee->setGroupDescription();
         if ($request->get("sort2") == "asc") {
             $Usee->orderBy("asc",$request->get("sort"),$this->startDay);
         }
         else {
             $Usee->orderBy("desc",$request->get("sort"),$this->startDay);
         }
         $this->count = $Usee->questions->get()->count();
         return $Usee->questions->paginate(15);

     }
     private function setIdProduct( $nameProduct) {
         if (empty($nameProduct)) {
             return;
         }
         for ($i=0;$i < count($nameProduct);$i++) {
             if ($nameProduct[$i] != null) {

                 $array = Product::selectIdNameProduct($nameProduct[$i]);
                 foreach ($array as $list) {
                     array_push($this->idProduct, $list->id);
                 }
             }
         }
     }
    private function setHour($drugsModel,Request $request) {
        $hour  = $this->startDay;
        if (($request->get("timeFrom") != "" and $request->get("timeTo") != "") ) {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $timeTo = explode(":",$request->get("timeTo"));
            $hourFrom = $this->sumHour($timeFrom,$this->startDay);
            $hourTo = $this->sumHour($timeTo,$this->startDay);
            $drugsModel->setHourTwo($hourFrom,$hourTo,$this->startDay);


        }
        else if ($request->get("timeTo") != "" ) {
            $drugsModel->setHourTo($request->get("timeTo"));

        }
        else if ($request->get("timeFrom") != "") {
            $drugsModel->setHourFrom($request->get("timeFrom"));

        }


    }
    private function sumHour($hour,$startDay) {
        $sumHour = $hour[0] - $startDay;
        if ($sumHour < 0) {
            $sumHour = 24 + $sumHour;
        }
        if (strlen($sumHour) == 1) {
            $sumHour = "0" .$sumHour;
        }
        if (strlen($hour[1]) == 1) {
            $hour[1] = "0" . $hour[1];
        }

        return $sumHour . ":" .  $hour[1] . ":00";
    }
    private function setIdSubstance( $nameSubstance) {
        if (empty($nameSubstance)) {
            return;
        }
        for ($i=0;$i < count($nameSubstance);$i++) {
            if ($nameSubstance[$i] != null) {
                $array = Substance::selectIdNameSubstanceIdProduct($nameSubstance[$i]);
                foreach ($array as $list) {
                    array_push($this->idProduct, $list->id);
                }
            }
        }
    }
    private function setIdGroup( $nameGroup) {
        if (empty($nameGroup)) {
            return;
        }
        for ($i=0;$i < count($nameGroup);$i++) {
            if ($nameGroup[$i] != null) {
                $array = Group::selectIdNameGroupIdProduct($nameGroup[$i]);
                foreach ($array as $list) {
                    array_push($this->idProduct, $list->id);
                }
            }
        }
    }
}
