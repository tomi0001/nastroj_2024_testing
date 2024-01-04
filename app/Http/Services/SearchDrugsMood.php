<?php
/*
 * copyright 2023 Tomasz Leszczyński tomi0001@gmail.com
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


class SearchDrugsMood {
    public $idUsers;
    public $startDay;
    public $errors = [];
    public $countProduct = 0;
    public $countProductNot = 0;
    public $arrayProduct2 = [];
    public $arrayProductNot = [];
    public $arrayProdduct = [];
    public $dateFrom;
    public $dateTo;
    public $timeFrom;
    public $timeTo;
    public $listMood = [];
    function __construct($request,$bool = 0) {
        if ($bool == 0) {
            $this->idUsers = Auth::User()->id;
        }
        else {
            
            $this->idUsers  = Auth::User()->id_users;
        }
        $this->startDay  = Auth::User()->start_day;
        $this->setDate($request->get("dateFrom"), $request->get("dateTo"));
        $this->setHour($request);
        $this->setArray($request);
    }
    private function setArray(Request $request) {
        $this->arrayProdduct["dateFrom"] = $this->dateFrom;
        $this->arrayProdduct["dateTo"] = $this->dateTo;
        $this->arrayProdduct["timeFrom"] = $this->timeFrom;
        $this->arrayProdduct["timeTo"] = $this->timeTo;
        $this->arrayProdduct["whatWork"] = $request->get("whatWork");
    } 
    private function setDate($dateFrom,$dateTo) {
         if ($dateFrom != "") {
             $this->dateFrom = $dateFrom;
         }
         else {
             $this->dateFrom = MoodModel::selecFirstMoods()->date_start;
         }
         if ($dateTo != "") {
             $this->dateTo = $dateTo;
         }
         else {
             $this->dateTo = MoodModel::selectLastMoods()->date_end;
         }
     }
     public function checkError(Request $request) {
         
         for ($i=0;$i < count($request->get("drugsMoodFrom") );$i++) {
             if (($request->get("drugsMoodFrom")[$i] != "") and (  $request->get("drugsMoodFrom")[$i] < 0   or  ( (string)(float) $request->get("drugsMoodFrom")[$i] !== $request->get("drugsMoodFrom")[$i]  ) )  ) {
               array_push($this->errors,"dawka od musi byc dodatnią liczbą zmnienno przecinkową");
             }
             if (($request->get("drugsMoodTo")[$i] != "") and (  $request->get("drugsMoodTo")[$i] < 0   or  ( (string)(float) $request->get("drugsMoodTo")[$i] !== $request->get("drugsMoodTo")[$i]  ) )  ) {
               array_push($this->errors,"dawka od musi byc dodatnią liczbą zmnienno przecinkową");
             }
         }
         
        
     }
     public function search(Request $request) {
         $arrayProduct = array();
         $arrayProductNot  = array();
         for ($i=0;$i < count($request->get("drugsMood"));$i++) {
             if ($request->get("drugsMood")[$i] != "") {
                 if (isset($request->get("ifBool")[$i]) and $request->get("ifBool")[$i] == "on") {
                      
                      $this->arrayProductNot[$this->countProductNot] = Usee::selectDateUsee($this->idUsers, $request->get("drugsMood")[$i],Auth::User()->start_day,$request->get("drugsMoodFrom")[$i],$request->get("drugsMoodTo")[$i],$this->arrayProdduct);
                      $this->countProductNot++;
                     
                 }
                 else {
                      $this->arrayProduct2[$this->countProduct] = Usee::selectDateUsee($this->idUsers, $request->get("drugsMood")[$i],Auth::User()->start_day,$request->get("drugsMoodFrom")[$i],$request->get("drugsMoodTo")[$i],$this->arrayProdduct);
                      $this->countProduct++;
                 }
                 
                 
                 
                 
             }
             
             
         }
         for ($i=0;$i < count($request->get("nameSubstanceMood"));$i++) {
             
         }
         for ($i=0;$i < count($request->get("nameGroupMood"));$i++) {
             
         }
         if ($this->countProduct == 0 and $this->countProductNot == 0) {
             return false;
         }
         return true;
         
         
     }
     public function searchMoodDrugs($nextDay = "") {
         if ($this->countProduct == 0) {
             return;
         }
         for ($i =strtotime($this->dateFrom);$i < strtotime($this->dateTo);$i+= 86400) {
             $bool = false;
             for ($j = 0;$j < $this->countProduct;$j++) {
                 if (!array_search(date("Y-m-d",$i),array_column(  $this->arrayProduct2[$j]->toArray(),"dat") )) {
                     $bool = true;
                     break;
                 }
                 
             }
             if ($bool == false) {
                    if ($nextDay == "on") {
                        array_push($this->listMood,date("Y-m-d",$i+86400));
                    }
                    else {
                        array_push($this->listMood,date("Y-m-d",$i));
                    }
             }
         }
     }
     public function searchMoodDrugsNot($nextDay = "") {
         if ($this->countProductNot == 0) {
             return;
         }
         for ($i =strtotime($this->dateFrom);$i < strtotime($this->dateTo);$i+= 86400) {
             $bool = false;
             for ($j = 0;$j < $this->countProductNot;$j++) {
                 if (array_search(date("Y-m-d",$i),array_column(  $this->arrayProductNot[$j]->toArray(),"dat") )) {
                     $bool = true;
                     break;
                 }
                 
             }
             if ($bool == false) {
                    if ($nextDay == "on") {
                        array_push($this->listMood,date("Y-m-d",$i+86400));
                    }
                    else {
                        array_push($this->listMood,date("Y-m-d",$i));
                    }
             }
         }
     }
     public function AverageMood() {
         $mood = 0;
         $anxienty = 0;
         $voltage=  0;
         $stimula = 0;
         $epizodes_psychotik = 0;
         $text =  implode("','",$this->listMood);
         $text = "('" . $text . "')";
         $array = MoodModel::sumAllDrugsMood($text, $this->startDay, $this->idUsers);
         if (count($array) == 0) {
             return false;
         }
         for ($i=0;$i < count($array);$i++) {

             $mood += $array[$i]->sum_mood;
             $anxienty += $array[$i]->sum_anxiety;
             $voltage +=  $array[$i]->sum_nervousness;
             $stimula += $array[$i]->sum_stimulation;
             $epizodes_psychotik += $array[$i]->epizodes_psychotik;
             
             
         }
         return ["mood" => $mood / $i,
                 "anxienty" => $anxienty / $i,
                 "voltage" => $voltage / $i,
                 "stimulation" => $stimula / $i,
                 "epizodes_psychotik" => $epizodes_psychotik,
                 "count" => count($array),
             ];
     }
    private function setHour(Request $request) {
        $hour  = $this->startDay;
        if (($request->get("timeFrom") != "" and $request->get("timeTo") != "") ) {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $timeTo = explode(":",$request->get("timeTo"));
            $this->timeFrom = $this->sumHour($timeFrom,$this->startDay);
            $this->timeTo  = $this->sumHour($timeTo,$this->startDay);
            
            //return array($hourFrom,$hourTo);
            //$drugsModel->setHourTwo($hourFrom,$hourTo,$this->startDay);
            

        }
        else if ($request->get("timeTo") != "" ) {
            $this->timeTo = $request->get("timeTo");
            //$drugsModel->setHourTo($request->get("timeTo"));

        }
        else if ($request->get("timeFrom") != "") {
            $this->timeFrom = ($request->get("timeFrom"));
            //$drugsModel->setHourFrom($request->get("timeFrom"));

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
}
