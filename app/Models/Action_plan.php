<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Action_plan extends Model
{
    use HasFactory;
    protected $table = "actions_plans";
    public static function showActionPlan(string $date, int $idUsers, int $startDay) {
        return self::join("actions","actions.id","actions_plans.id_actions")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(    actions_plans.date ) >= '" . $startDay . "', actions_plans.date ,Date_add(actions_plans.date , INTERVAL - 1 DAY) )) )"))
                ->selectRaw("actions.name as name")
                ->selectRaw("actions.level_pleasure as level_pleasure")
                ->selectRaw("actions_plans.date as date")
                ->selectRaw("actions_plans.long as longer")
                ->selectRaw("actions_plans.id as id")
                ->selectRaw("actions_plans.what_work as what_work")
                ->where("actions_plans.id_users",$idUsers)
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    actions_plans.date ) >= '" . $startDay . "', actions_plans.date ,Date_add(actions_plans.date , INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                ->orderBy("actions_plans.date")->get();        
    }
    public static function selectHourId(int $id,int $idUsers) {
        return self::selectRaw("actions_plans.date as date")
                ->where("actions_plans.id_users",$idUsers)
                ->where("actions_plans.id",$id)
                ->first();        
    }
    public static function selectDayPlaned(string $date,int $startDay,int $idUsers) {
        return self::selectRaw("count(*) as how")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(    actions_plans.date ) >= '" . $startDay . "', actions_plans.date ,Date_add(actions_plans.date , INTERVAL - 1 DAY) ))  ) as dat"))
                ->where("actions_plans.id_users",$idUsers)
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    actions_plans.date ) >= '" . $startDay . "', actions_plans.date ,Date_add(actions_plans.date , INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                ->groupBy("dat")
                ->first();         
    }
    public static function selectLastAction(string $date, $minute,int $idUsers, $whatWork,int $idAction) {
        return self::where("id_users",$idUsers)
                    ->where("id_actions",$idAction)
                    ->where("date",$date)
                    ->where("long",$minute)
                    ->where("what_work",$whatWork)
                    ->first();     
    }
    public static function downloadListAction(int $idUsers) {
        return self::join("actions","actions.id","actions_plans.id_actions")
                    ->selectRaw("actions_plans.id as id")
                    ->selectRaw("actions.name as name")
                    ->selectRaw("actions_plans.date as date")
                    ->where("actions_plans.id_users",$idUsers)
                    ->orderBy("actions_plans.id","DESC")
                    ->get();           
    }
    public static function selectActionPlan(int $id,int $idUsers) {
        return self::join("actions","actions.id","actions_plans.id_actions")
                    ->selectRaw("actions_plans.id as id")
                    ->selectRaw("actions_plans.id_actions as id_actions")
                    ->selectRaw("actions_plans.what_work as what_work")
                    ->selectRaw("actions_plans.long as longer")
                    ->selectRaw("actions.name as name")
                    ->selectRaw("SUBSTRING_INDEX(actions_plans.date,' ',1) as date")
                    ->selectRaw("left(SUBSTRING_INDEX(actions_plans.date,' ',-1),5 )as time")
                    ->where("actions_plans.id",$id)
                    ->where("actions_plans.id_users",$idUsers)
                    ->first();
    }
    public static function ifIdExist(int $id, int $idUsers) {
        return self::where("id",$id)->where("id_users",$idUsers)->count();
    }
}
