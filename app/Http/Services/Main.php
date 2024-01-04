<?php
/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use App\Models\Mood as MoodModel;
use App\Http\Services\Calendar;
use App\Http\Services\Common;
use Hash;
use Auth;
use DB;
class Main {
    public $errors = [];
    public $listMood = [];
    public $listColor = [];
    private $IdUsers;
    public $listPlanedAction = [];
    function __construct(bool $typeUser = true) {
        if ($typeUser == true) {
            $this->IdUsers = Auth::User()->id;
        }
        else {
            $this->IdUsers = Auth::User()->id_users;
        }
    }

    public function createDayColorMood($year,$month,$day) {
        $listMood = [];
        $dayMonth = calendar::checkMonth($month,$year);
        $nextMonth = calendar::nextMonth($year,$month);
        $this->listMood = \App\Models\Mood::sumMoodMonth($year . "-" .  $month . "-01",$nextMonth . "-01", Auth::User()->start_day,$this->IdUsers);
        //var_dump($this->listMood);
        $arrayMonth = $this->listMood->toArray();
        $j = 0;
        for ($i=0;$i < $dayMonth;$i++) {
            if (is_int(array_search(($i+1),array_column($arrayMonth, 'dat') )  )) {
                $this->listColor[$i] = Common::setColor(round($this->listMood[$j]->sum_mood,3));
                $j++;
            }
            else {
                
                $this->listPlanedAction[$i] = \App\Models\Action_plan::selectDayPlaned($year . "-" . $month . "-" . ($i+1), Auth::User()->start_day,$this->IdUsers);
                if (empty($this->listPlanedAction[$i])) {
                    $this->listColor[$i] = 10000;
                }
                else {
                    $this->listColor[$i] = 100000;
                }
            }
            

        }

    }
    public function downloadMood($year,$month,$day) {

        $listMood = MoodModel::downloadMood($year . "-" . $month . "-" . $day, Auth::User()->start_day, $this->IdUsers);
        return $listMood;
   
    }

    public function setPercent($list) {
        $percent = [];
        $i = 0;
        foreach ($list as $array) {
            if ($i == 0) {
                $percent[$i]["percent"] = 100;
                $percentOne = $array->second;
                $percent[$i]["id"] =  $array->id;
            }
            else {
                $sum =  ($array->second / $percentOne ) * 100;
                if ($sum < 1) {
                    $percent[$i]["percent"] = 1;
                }
                else {
                    $percent[$i]["percent"] = round($sum);
                }
                
                $percent[$i]["id"] =  $array->id;
            }
            $i++;
        }
        return $percent;
    }
    
}
