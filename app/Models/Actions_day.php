<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class Actions_day extends Model
{
    use HasFactory;
    public $questions;
    public function createQuestionActionDay(int $startDay) {
         $this->questions =  self::query();
         $this->questions->leftjoin("actions","actions_days.id_actions","actions.id")
                        ->selectRaw("actions_days.date as date")
                        ->selectRaw("actions.name as name")
                        ->selectRaw("actions.level_pleasure as level_pleasure")
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    actions_days.date) >= '" . $startDay . "', actions_days.date,Date_add(actions_days.date, INTERVAL - 1 DAY) )) ) as dateDay " ))
                        ->selectRaw(DB::Raw("WEEKDAY(DATE(IF(HOUR(    actions_days.date) >= '" . $startDay . "', actions_days.date,Date_add(actions_days.date, INTERVAL - 1 DAY) )) ) as dayweek " ));
                        //->selectRaw(DB::Raw("WEEKDAY((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) )) as dayweek" ));
                        
    }
    public function setWeekDay(array $week,int $startDay) {
        //$this->questions->whereRaw("DAYOFWEEK(moods.date_end)",$week);
        $this->questions->whereRaw(DB::raw("DAYOFWEEK((DATE(IF(HOUR(    actions_days.date) >= '" . $startDay . "', actions_days.date,Date_add(actions_days.date, INTERVAL - 1 DAY) )) ))  in (" . implode(",", $week) . ")")  );
    }
    public function orderBy(string $asc,string $type) {

        switch ($type) {

            case 'date': $this->questions->orderBy("actions_days.date",$asc);
                break;
            case 'hour' : $this->questions->orderByRaw("time(actions_days.date) $asc");
                break;

        }
    }
    public function setDate($dateFrom,$dateTo,$startDay) {
        if ($dateFrom != "" )  {
            $this->questions->whereRaw(DB::raw("(DATE(IF(HOUR(    actions_days.date) >= '" . $startDay . "', actions_days.date,Date_add(actions_days.date, INTERVAL - 1 DAY) )) ) >= '$dateFrom'" )  );
        
                
        }
        if ($dateTo != "" ) {
            $this->questions->whereRaw(DB::raw("(DATE(IF(HOUR(    actions_days.date) >= '" . $startDay . "', actions_days.date,Date_add(actions_days.date, INTERVAL - 1 DAY) )) ) <= '$dateTo'" )  );
        }
    }
   public function searchAction(array $action) {

        $this->questions->where(function ($query) use ($action) {
        for ($i=0;$i < count ($action);$i++) {
            if ($action[$i] == "NULL") {
                continue;
            }

             else if ($action[$i] != "" ) {

                 $query->orwhereRaw("actions.name like '%" . $action[$i]  . "%'");
             }





         }

        });
    }

    public function idUsers(int $idUsers) {
        $this->questions->where("actions_days.id_users",$idUsers);
    }
    public function setHourTwo($hourFrom,$hourTo,$startDay) {
        //print $hourTo;
        $this->questions->whereRaw("(time(date_add(actions_days.date,INTERVAL - $startDay hour))) < '$hourTo'");
        $this->questions->whereRaw("(time(date_add(actions_days.date,INTERVAL - $startDay hour))) > '$hourFrom'");
    }

    public function setHourTo(string $hourTo) {
        $this->questions->whereRaw("time(actions_days.date) <= " . "'" .  $hourTo . ":00'");
    }
    public function setHourFrom(string $hourFrom) {
        $this->questions->whereRaw("time(actions_days.date) >= " . "'" .  $hourFrom . ":00'");
    }
    
    public static function showActionForAllDay(string $date, int $idUsers,int $startDay) {
        return self::join("actions","actions.id","actions_days.id_actions")
                ->selectRaw("actions.name as name")
                ->selectRaw("actions_days.id as id")
                ->selectRaw("actions.id as idAction")
                ->selectRaw("actions.level_pleasure as level_pleasure")
                ->selectRaw("actions_days.date as date")
                ->where("actions_days.id_users",$idUsers)
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    actions_days.date) >= '" . $startDay . "', actions_days.date,Date_add(actions_days.date, INTERVAL - 1 DAY) )) ) = '$date'" ))
                ->orderBy("actions_days.date")->get();
    }

    public static function returnNameAction(int $idUsers,int $id) {
         return self::join("actions","actions.id","actions_days.id_actions")
                ->selectRaw("actions.name as name")
                ->selectRaw("actions.id as id")
                
                ->where("actions_days.id_users",$idUsers)
                ->where("actions_days.id",$id)
                ->first();
    }
    public static function selectLastAction(int $idAction) {
        return self::selectRaw("date")->where("id_users",Auth::User()->id)->where("id_actions",$idAction)
                ->where("created_at",">=",date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") )- 80))->first();
    }
    public static function selectLastActionDate(int $idAction,string $date) {
        //print $date;
        return self::selectRaw("date")->where("id_users",Auth::User()->id)->where("id_actions",$idAction)->where("date",$date . ":00")
                ->where("created_at",">=",date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") )- 80))->first();
    }

}
