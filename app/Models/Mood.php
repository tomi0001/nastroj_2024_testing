<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Http\Request;
//use AgliPanci\LaravelCase\Query\CaseBuilder;
class Mood extends Model
{
    use HasFactory;
    public $questions;
    public $questionsMinute = [];
    public $questionsMinMax;
    public function createQuestionSumDay(int $startDay) {
        $this->questions =  self::query();
        $this->questions
            ->selectRaw("sum(TIMESTAMPDIFF (minute, moods.date_start , moods.date_end)) as longMood")
            ->selectRaw(" round((sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_mood)  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) ),3  )as level_mood ")
            ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_anxiety)  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_anxiety ")
            ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_nervousness )  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_nervousness ")
            ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_stimulation)  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_stimulation ")
            ->selectRaw("min(moods.date_start) minMood")
            ->selectRaw("count(moods.id ) as count")
            ->selectRaw("max(moods.date_end) maxMood")
            ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as datStart " ))
            ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as datEnd" ));

    }
    public function countMoods() {
        //$this->questions =  self::query();
        $this->questions->selectRaw("(count(moods.id ) ) as count");
    }
    public function createQuestionMinMaxAI(int $startDay) {
        $this->questionsMinMax =  self::query();
        $this->questionsMinMax
            //->selectRaw("sum(TIMESTAMPDIFF (minute, moods.date_start , moods.date_end)) as longMood")
//            ->selectRaw("  ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) as time ")
//            ->selectRaw(" moods.level_mood as level_mood ")
//            ->selectRaw(" moods.level_anxiety  as level_anxiety ")
//            ->selectRaw("  moods.level_nervousness  as level_nervousness ")
//            ->selectRaw("  moods.level_stimulation  as level_stimulation ")
            //->selectRaw("  moods.date_start  as date_start ")
            //->selectRaw("  moods.date_end  as date_end ")
//            ->selectRaw("Date_add(date_start, INTERVAL - '$startDay' HOUR) as date_start")
            ->selectRaw("min(moods.level_mood) as minMood")
            ->selectRaw("max(moods.level_mood) as maxMood")
            ->selectRaw("count(moods.level_mood) as count")
//            ->selectRaw("Date_add(date_end, INTERVAL - '$startDay' HOUR) as date_end")
            ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat_end" ));
            //->selectRaw("DATE(Date_add(date_end,INTERVAL - '$startDay' HOUR)) as dat_end");
        //->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as datStart " ))
        //->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat_end" ));

    }
    public function createQuestionAI(int $startDay,$timeFrom,$timeTo) {
       
        $this->questions =  self::query();
        $this->questions
            //->selectRaw("sum(TIMESTAMPDIFF (minute, moods.date_start , moods.date_end)) as longMood")
            //->selectRaw("  sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_mood  as time ")
          
                 ->selectRaw("min(moods.level_mood) as minMood")
            ->selectRaw("max(moods.level_mood) as maxMood")
            ->selectRaw("count(moods.level_mood) as count")
            ->selectRaw(" (  sum(

                              CASE

                         WHEN   TIME_TO_SEC
                         (
                             timediff(
                                 time(
                                     Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN (unix_timestamp(date_add(moods.date_end ,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                          ),
                                          '$timeTo'


                                 ))
                                 >= 0 THEN
                         (  (   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp( Date_add( moods.date_start,INTERVAL - '$startDay' HOUR) )   )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR)) END


                  * moods.level_mood ) /


        sum(

            CASE
                         WHEN   TIME_TO_SEC
        (
            timediff(
                time(
                    Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN   (unix_timestamp(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                            ),
                                            '$timeTo'


                                 )
                                 )
                                 >= 0 THEN
        ((   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp(  Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)  ) )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR))


               END  )

)as mood  ")
                            ->selectRaw(" (  sum(

                              CASE

                         WHEN   TIME_TO_SEC
                         (
                             timediff(
                                 time(
                                     Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN (unix_timestamp(date_add(moods.date_end ,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                          ),
                                          '$timeTo'


                                 ))
                                 >= 0 THEN
                         (  (   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp( Date_add( moods.date_start,INTERVAL - '$startDay' HOUR) )   )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR)) END


                  * moods.level_anxiety ) /


        sum(

            CASE
                         WHEN   TIME_TO_SEC
        (
            timediff(
                time(
                    Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN   (unix_timestamp(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                            ),
                                            '$timeTo'


                                 )
                                 )
                                 >= 0 THEN
        ((   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp(  Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)  ) )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR))


               END  )

)as anxienty  ")
                            ->selectRaw(" (  sum(

                              CASE

                         WHEN   TIME_TO_SEC
                         (
                             timediff(
                                 time(
                                     Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN (unix_timestamp(date_add(moods.date_end ,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                          ),
                                          '$timeTo'


                                 ))
                                 >= 0 THEN
                         (  (   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp( Date_add( moods.date_start,INTERVAL - '$startDay' HOUR) )   )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR)) END


                  * moods.level_nervousness ) /


        sum(

            CASE
                         WHEN   TIME_TO_SEC
        (
            timediff(
                time(
                    Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN   (unix_timestamp(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                            ),
                                            '$timeTo'


                                 )
                                 )
                                 >= 0 THEN
        ((   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp(  Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)  ) )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR))


               END  )

)as voltage  ")
                            ->selectRaw(" (  sum(

                              CASE

                         WHEN   TIME_TO_SEC
                         (
                             timediff(
                                 time(
                                     Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN (unix_timestamp(date_add(moods.date_end ,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                          ),
                                          '$timeTo'


                                 ))
                                 >= 0 THEN
                         (  (   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp( Date_add( moods.date_start,INTERVAL - '$startDay' HOUR) )   )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR)) END


                  * moods.level_stimulation ) /


        sum(

            CASE
                         WHEN   TIME_TO_SEC
        (
            timediff(
                time(
                    Date_add(date_start, INTERVAL - '$startDay' HOUR)
                                            )
                                            ,
                                 '$timeFrom')
                                 )
                                 <= 0
                                 THEN   (unix_timestamp(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR) ) -  (unix_timestamp( CONCAT( date(Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)),' ', '$timeFrom' )   )))



                                 WHEN
                                     TIME_TO_SEC
                                     (
                                         timediff(

                                             time(
                                                 Date_add(date_end, INTERVAL - '$startDay' HOUR)
                                            ),
                                            '$timeTo'


                                 )
                                 )
                                 >= 0 THEN
        ((   unix_timestamp(CONCAT( date(Date_add(moods.date_end,INTERVAL - '$startDay' HOUR)),' ', '$timeTo' ) )) -  unix_timestamp(  Date_add(moods.date_start,INTERVAL - '$startDay' HOUR)  ) )

                              ELSE  (unix_timestamp(date_add(moods.date_end,INTERVAL - '$startDay' HOUR))) - unix_timestamp(date_add(moods.date_start,INTERVAL - '$startDay' HOUR))


               END  )

)as stimulation  ")


            ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat_end" ));

    }
    
 
    public function createQuestionGroupDay(int $startDay) {
        $this->questions =  self::query();


            $this->questions
                ->selectRaw("sum(TIMESTAMPDIFF (minute, moods.date_start , moods.date_end)) as longMood")
                //->selectRaw("sum(moods.level_mood)  as level_mood")
                ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_mood)  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_mood ")
                ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_anxiety)  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_anxiety ")
                ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_nervousness )  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_nervousness ")
                ->selectRaw(" round(sum( ( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ) * moods.level_stimulation)  / sum( unix_timestamp(moods.date_end) - unix_timestamp(moods.date_start) ),3 ) as level_stimulation ")
            ->selectRaw("(count(moods.id ) ) as count")

            ->selectRaw("min(moods.date_start) minMood")

            ->selectRaw("max(moods.date_end) maxMood")
            ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as datStart " ))
            ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as datEnd" ))
            ->selectRaw(DB::Raw("WEEKDAY((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) )) as dayweek" ));

//        if ($ifAction == true or $actionOn == "on") {
//            $this->questions->crossjoin("moods_actions","moods_actions.id_moods","moods.id");
//            //->join("actions","actions.id","moods_actions.id_actions");
//
//        }
    }
    public function havingActionOn() {
        //$this->questions->havingRaw("count(moods_actions.id_actions) <= 3");
    }
    public function setGroupWeek(int $startDay) {
        $this->questions->groupBy(DB::Raw("YEARWEEK(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) ))) "));
    }
    public function setWhereWeek($dateFrom,$dateTo,int $startDay) {
        $this->questions->whereRaw("moods.date_end BETWEEN '$dateFrom' AND '$dateTo'");
    }
    public function whereEpizodes($workingFrom,$workingTo) {
        if ($workingFrom != "") {
              $this->questions->where("moods.epizodes_psychotik",">=",$workingFrom);
        }
        if ($workingTo != "") {
              $this->questions->where("moods.epizodes_psychotik","<=",$workingTo);
        }
        
    }
    public function createQuestionsSleep(int $startDay = 0) {
        //$hourSlepp = config('app.sleepHour');
        $this->questions =  self::query();
        $this->questions->selectRaw("moods.date_start as date_start")
                        ->selectRaw("moods.id as id")
                        ->selectRaw("moods.date_end as date_end")
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as datStart " ))
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as datEnd" ))
                        ->selectRaw(DB::Raw("WEEKDAY((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) )) as dayweek" ))
                        ->selectRaw("(TIMESTAMPDIFF (minute, date_start , date_end)) as longMood")
                        ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                        ->selectRaw("moods.what_work as what_work");
                        
                        
                        
                        
                        
    }
    public function createQuestionsSleepSumDay(int $startDay = 0) {
        $this->questions =  self::query();
        $this->questions->selectRaw("moods.date_start as date_start")
                        ->selectRaw("moods.id as id")
                        ->selectRaw("moods.date_end as date_end")
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as datStart " ))
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as datEnd" ))
                        ->selectRaw(DB::Raw("WEEKDAY((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) )) as dayweek" ))
                        ->selectRaw("(sum(TIMESTAMPDIFF (second, date_start , date_end)) / count(*)  ) as average")
                        ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                        ->selectRaw("moods.what_work as what_work");        
    }
    public function createQuestions(int $startDay) {
        $this->questions =  self::query();
        $this->questions->leftjoin("moods_actions","moods_actions.id_moods","moods.id")
                        ->leftjoin("actions","actions.id","moods_actions.id_actions")
                        ->selectRaw("moods.date_start as date_start")
                        ->selectRaw("moods.id as id")
                        ->selectRaw("moods.date_end as date_end")
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as datStart " ))
                        ->selectRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as datEnd" ))
                        ->selectRaw(DB::Raw("WEEKDAY((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) )) as dayweek" ))
                        ->selectRaw("moods.level_mood as level_mood")
                        ->selectRaw("(TIMESTAMPDIFF (minute, date_start , date_end)) as longMood")
                        ->selectRaw("moods.level_anxiety as level_anxiety")
                        ->selectRaw("moods.level_nervousness as level_nervousness")
                        ->selectRaw("moods.level_stimulation as level_stimulation")
                        ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                        ->selectRaw("moods.what_work as what_work")
                        ->selectRaw("actions.name as nameActions")
                        ->selectRaw("actions.level_pleasure as level_pleasure")
                        ->selectRaw("moods_actions.percent_executing as percent_executing")
                        ->selectRaw("moods_actions.minute_exe as minute_exe")
                        ->selectRaw(" (CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END) as percent " );
    }
    public function groupByAction() {
        $this->questions->groupBy("moods.id");
    }

    public function groupMoodAction() {
        $this->questions->whereExists(function ($query) {
            $query
                ->select(DB::raw(1))
                ->from('moods_actions')
                ->whereColumn('moods_actions.id_moods', 'moods.id');
        });
        //$this->questions->groupBy("moods_actions.id_actions");
    }
    public function idUsers(int $idUsers) {
        $this->questions->where("moods.id_users",$idUsers);
    }
    public function idUsersMinMax(int $idUsers) {
        $this->questionsMinMax->where("moods.id_users",$idUsers);
    }
    public function moodsSelect() {
        $this->questions->where("moods.type","mood");
    }
    public function sleepSelect() {
        $this->questions->where("moods.type","sleep");
    }
    public function setHourAI($hourFrom,$hourTo,$startDay)
    {
        $this->questions->whereRaw("time(Date_add(date_start,INTERVAL - '$startDay' HOUR)) <= '" . $hourTo. "'");
        $this->questions->whereRaw("time(Date_add(date_end,INTERVAL - '$startDay' HOUR)) >= '" . $hourFrom. "'");
    }
    public function setHourTwo($hourFrom,$hourTo,$startDay) {
        //print $hourTo;
        $this->questions->whereRaw("(time(date_add(moods.date_start,INTERVAL - $startDay hour))) < '$hourTo'");
        $this->questions->whereRaw("(time(date_add(moods.date_end,INTERVAL - $startDay hour))) > '$hourFrom'");
    }
    public function setHourTwoMinMax($hourFrom,$hourTo,$startDay) {
        $this->questionsMinMax->whereRaw("(time(date_add(moods.date_start,INTERVAL - $startDay hour))) < '$hourTo'");
        $this->questionsMinMax->whereRaw("(time(date_add(moods.date_end,INTERVAL - $startDay hour))) > '$hourFrom'");
    }
    public function setHourTo(string $hourTo) {
        $this->questions->whereRaw("time(moods.date_end) <= " . "'" .  $hourTo . ":00'");
    }
    public function setHourFrom(string $hourFrom) {
        $this->questions->whereRaw("time(moods.date_start) >= " . "'" .  $hourFrom . ":00'");
    }
    public function searchWhatWork(array $arrayWork) {
       $this->questions->where(function ($query) use ($arrayWork) {
        for ($i=0;$i < count ($arrayWork);$i++) {
             if ($arrayWork[$i] != "") {
                 $query->orwhereRaw("what_work like '%" . $arrayWork[$i]  . "%'");
             }
         }
        });

    }
    public function actionOn() {
        $this->questions->where("moods_actions.id","!=","");
    }
    public function whatWorkOn() {
        $this->questions->where("moods.what_work","!=","");
    }
    public function orderBy(string $asc,string $type) {

        switch ($type) {

            case 'date': $this->questions->orderBy("moods.date_end",$asc);
                break;
            case 'hour' : $this->questions->orderByRaw("time(moods.date_end) $asc");
                break;
            case 'mood' : $this->questions->orderBy("moods.level_mood",$asc);
                break;
            case 'anxienty' : $this->questions->orderBy("moods.level_anxiety",$asc);
                break;
            case 'voltage' : $this->questions->orderBy("moods.level_nervousness",$asc);
                break;
            case 'stimulation' : $this->questions->orderBy("moods.level_stimulation",$asc);
                break;
            case 'longMood' : $this->questions->orderBy("longMood",$asc);
                break;

        }
    }
    public function orderByAIMinMax() {
        $this->questionsMinMax->orderBy("moods.date_end","asc");
    }
    public function orderByAI() {
        $this->questions->orderBy("moods.date_end","asc");
    }
    public function searchAction(array $action,array $actionFrom,array $actionTo) {

        $this->questions->where(function ($query) use ($action,$actionFrom,$actionTo) {
        for ($i=0;$i < count ($action);$i++) {
            if ($action[$i] == "NULL") {
                continue;
            }
             if ($action[$i] != "" and (!empty($actionFrom) and (!empty($actionTo)))  and  ($actionFrom[$i] != "" and $actionTo[$i] != "")) {
                 $query->orwhereRaw("("
                         . "actions.name like '%" . $action[$i]  . "%'  and  (" .
                         "(CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)  >='" . $actionFrom[$i] .  "')"
                         . "and ("
                         . "(CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)  <='" . $actionTo[$i] .  "')"
                         . ""
                         . ")"

                          );

             }
              else if ($action[$i] != "" and  ( (!empty($actionTo)))  and  ($actionTo[$i] != "")) {
                 $query->orwhereRaw("("
                         . "actions.name like '%" . $action[$i]  . "%'  and  (("
                         .      " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . ""
                        . " END)"
                         . ")  <= '" . $actionTo[$i] .  "')"
                         . " " );
             }
              else if ($action[$i] != "" and  (!empty($actionFrom) )  and  ($actionFrom[$i] != "")) {
                 $query->orwhereRaw("("
                         . "actions.name like '%" . $action[$i]  . "%'  and  (("
                         .      " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)"
                         . ")  >= '" . $actionFrom[$i] .  "')"
                         . " " );
             }
             else if ($action[$i] != "" ) {

                 $query->orwhereRaw("actions.name like '%" . $action[$i]  . "%'");
             }





         }

        });
    }
    public function searchActionGroup(array $action,array $actionFrom,array $actionTo)
    {

        $this->questions
            //->select(DB::Raw(" name from actions where actions.name like '%" . $action[0] . "%'"))
                ->selectRaw(" name ")
            ->where(function ($query) use ($action, $actionFrom, $actionTo) {



            for ($i = 0; $i < count($action); $i++) {
                if ($action[$i] == "NULL") {
                    continue;
                }
                if ($action[$i] != "" and (!empty($actionFrom) and (!empty($actionTo))) and ($actionFrom[$i] != "" and $actionTo[$i] != "")) {
                    $query->orwhereRaw("("
                        . "actions.name like '%" . $action[$i] . "%'  and  (" .
                        "(CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)  >='" . $actionFrom[$i] . "')"
                        . "and ("
                        . "(CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)  <='" . $actionTo[$i] . "')"
                        . ""
                        . ")"

                    );

                } else if ($action[$i] != "" and ((!empty($actionTo))) and ($actionTo[$i] != "")) {
                    $query->orwhereRaw("("
                        . "actions.name like '%" . $action[$i] . "%'  and  (("
                        . " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . ""
                        . " END)"
                        . ")  <= '" . $actionTo[$i] . "')"
                        . " ");
                } else if ($action[$i] != "" and (!empty($actionFrom)) and ($actionFrom[$i] != "")) {
                    $query->orwhereRaw("("
                        . "actions.name like '%" . $action[$i] . "%'  and  (("
                        . " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)"
                        . ")  >= '" . $actionFrom[$i] . "')"
                        . " ");
                } else if ($action[$i] != "") {

                    $query->orwhereRaw("actions.name like '%" . $action[$i] . "%'");
                }


            }
            //$query->where('actions.id','moods_actions.id_actions');
            //$query->where('moods.id','moods_actions.id_moods');
        });
    }
    public function setDate($dateFrom,$dateTo,$startDay) {
        if ($dateFrom != "" and $dateFrom != "undefined")  {

        $this->questions->where(function ($query) use ($startDay,$dateFrom) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) >= '$dateFrom'" ))
                    ->orwhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) >= '$dateFrom'" ));
                });
        }
        if ($dateTo != "" and $dateTo != "undefined") {

           $this->questions->where(function ($query) use ($startDay,$dateTo) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) < '$dateTo'" ))
                    ->orwhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) < '$dateTo'" ));
                });
        }
    }
    public function setDateAI($dateFrom,$dateTo,$startDay) {
        $this->questions->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) >= '$dateFrom'" ));
        $this->questions->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) < '$dateTo'" ));
    }
  
            
    public function setDateMinMaxAI($dateFrom,$dateTo,$startDay) {
        $this->questionsMinMax->where("moods.date_start",">=",$dateFrom);
        $this->questionsMinMax->where("moods.date_end","<",$dateTo);
    }
    public function setWeekDay(array $week,int $startDay) {
        //$this->questions->whereRaw("DAYOFWEEK(moods.date_end)",$week);
        $this->questions->whereRaw(DB::raw("DAYOFWEEK((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ))  in (" . implode(",", $week) . ")")  );
    }
    public function setWeekDayMinMax(array $week,int $startDay) {
        //$this->questions->whereRaw("DAYOFWEEK(moods.date_end)",$week);
        $this->questionsMinMax->whereRaw(DB::raw("DAYOFWEEK((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ))  in (" . implode(",", $week) . ")")  );
    }
    public function setMood(Request $request) {
         if ($request->get("moodFrom") != "" and $request->get("moodFrom") != "undefined")  {
             $this->questions->where("moods.level_mood",">=",$request->get("moodFrom"));
         }
         if ($request->get("moodTo") != "" and $request->get("moodTo") != "undefined") {
             $this->questions->where("moods.level_mood","<=",$request->get("moodTo"));
         }
         if ($request->get("anxientyFrom") != "" and $request->get("anxientyFrom") != "undefined")  {
             $this->questions->where("moods.level_anxiety",">=",$request->get("anxientyFrom"));
         }
         if ($request->get("anxientyTo") != "" and $request->get("anxientyTo") != "undefined") {
             $this->questions->where("moods.level_anxiety","<=",$request->get("anxientyTo"));
         }
         if ($request->get("voltageFrom") != "" and $request->get("voltageFrom") != "undefined")  {
             $this->questions->where("moods.level_nervousness",">=",$request->get("voltageFrom"));
         }
         if ($request->get("voltageTo") != "" and $request->get("voltageTo") != "undefined") {
             $this->questions->where("moods.level_nervousness","<=",$request->get("voltageTo"));
         }
         if ($request->get("stimulationFrom") != "" and $request->get("stimulationFrom") != "undefined")   {
             $this->questions->where("moods.level_stimulation",">=",$request->get("stimulationFrom"));
         }
         if ($request->get("stimulationTo") != "" and $request->get("stimulationTo") != "undefined") {
             $this->questions->where("moods.level_stimulation","<=",$request->get("stimulationTo"));
         }
     }
     public function setLongSleep(Request $request) {
         $timeFrom = 0;
         $timeTo = 0;
         if ($request->get("longSleepHourFrom") != "" )  {
             $timeFrom += $request->get("longSleepHourFrom") * 60;
         }
         if ($request->get("longSleepMinuteFrom") != ""  )  {
             $timeFrom += $request->get("longSleepMinuteFrom");
         }
         if (($request->get("longSleepHourFrom") != "" or $request->get("longSleepMinuteFrom") != "")  ) {
             $this->questions->whereRaw("TIMESTAMPDIFF (MINUTE, moods.date_start , moods.date_end) " . ">=" . $timeFrom);
         }
         if ($request->get("longSleepHourTo") != "" )  {
             $timeTo += $request->get("longSleepHourTo") * 60;

         }
         if ($request->get("longSleepMinuteTo") != "")  {
             $timeTo += $request->get("longSleepMinuteTo");
         }
         if (($request->get("longSleepHourTo") != "" or $request->get("longSleepMinuteTo") != "")  ) {
             $this->questions->whereRaw("TIMESTAMPDIFF (MINUTE, moods.date_start , moods.date_end) " . "<=" . $timeTo);
         }
     }
     public function setLongMood(Request $request) {
         $timeFrom = 0;
         $timeTo = 0;
         if ($request->get("longMoodHourFrom") != "" and  $request->get("longMoodHourFrom") != "undefined"  )  {
             $timeFrom += $request->get("longMoodHourFrom") * 60;
         }
         if ($request->get("longMoodMinuteFrom") != "" and  $request->get("longMoodHourFrom") != "undefined"  )  {
             $timeFrom += $request->get("longMoodMinuteFrom");
         }
         if (($request->get("longMoodHourFrom") != "" or $request->get("longMoodMinuteFrom") != "")   and  ($request->get("longMoodHourFrom") != "undefined" or $request->get("longMoodMinuteFrom") != "undefined")) {
             $this->questions->whereRaw("TIMESTAMPDIFF (MINUTE, moods.date_start , moods.date_end) " . ">=" . $timeFrom);
         }
         if ($request->get("longMoodHourTo") != "" and $request->get("longMoodHourTo") != "undefined")  {
             $timeTo += $request->get("longMoodHourTo") * 60;

         }
         if ($request->get("longMoodMinuteTo") != "" and $request->get("longMoodHourTo") != "undefined")  {
             $timeTo += $request->get("longMoodMinuteTo");
         }
         if (($request->get("longMoodHourTo") != "" or $request->get("longMoodMinuteTo") != "")  and ($request->get("longMoodHourTo") != "undefined" or $request->get("longMoodMinuteTo") != "undefined")) {
             $this->questions->whereRaw("TIMESTAMPDIFF (MINUTE, moods.date_start , moods.date_end) " . "<=" . $timeTo);
         }

     }
    public function setGroupDay(int $startDay) {
        $this->questions->groupBy(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) ))) "));
    }
    public function setGroupDayMinMax(int $startDay) {
        $this->questionsMinMax->groupBy(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) ))) "));
    }
//    public function setGroupWeekMinMax(int $startDay) {
//        $this->questionsMinMax->groupBy(DB::Raw("YEARWEEK(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) ))) "));
//    }
//    public static function sumMood(string $date,  $startDay,int $idUsers) {
//        return self::selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
//                ->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat2"))
//                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_mood)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_mood ")
//                ->where("type","mood")
//                ->where("id_users",$idUsers)
//                ->where(function ($query) use ($date,$startDay) {
//                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '$date'" ))
//                    ->orwhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '$date'" ));
//                })
//                ->groupBy("dat")
//                ->groupBy("dat2")
//                ->first();
//    }
    public static function sumMoodMonth(string $date1,  $date2,  $startDay,int $idUsers) {
        return self::selectRaw(DB::Raw("(DAY(IF(HOUR(moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat2"))
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_mood)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_mood ")
                ->where("type","mood")
                ->where("id_users",$idUsers)
                ->where(function ($query) use ($date1,$date2,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) >= '$date1' " ))
                    ->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) < '$date2'" ));
                })
                ->orderBy("dat")
                ->groupBy("dat")
                ->groupBy("dat2")
                ->get();
    }
    public static function selectDateMood(int $idMood) {
        return self::selectRaw("date_start as dateStart")
                ->selectRaw("date_end as dateEnd")
                ->where("id",$idMood)->first();
    }
    public static function sumAll(string $date,  $startDay,int $idUsers) {
        return self::selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat2"))
                ->selectRaw(" ((sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_mood)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) )  )as sum_mood ")
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_anxiety)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_anxiety ")
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_nervousness )  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_nervousness ")
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_stimulation)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_stimulation ")
                ->where("type","mood")
                ->where("id_users",$idUsers)
                ->where(function ($query) use ($date,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '$date'" ))
                    ->orwhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '$date'" ));
                })


                //->groupBy("dat")
                //->groupBy("dat2")
                ->first();
    }

    public static function selectLastMoods() {
        return Mood::selectRaw("SUBSTRING((date_end),1,16) as date_end")->where("id_users",Auth::User()->id)->orderBy("date_end","DESC")->first();
    }
    public static function selecFirstMoods() {
        return Mood::selectRaw("SUBSTRING((date_start),1,16) as date_start")->where("id_users",Auth::User()->id)->orderBy("date_start")->first();
    }
    public static function checkTimeExist($dateStart,$dateEnd) {
        return self::where("date_start","<=",$dateEnd)->where("date_end",">",$dateStart)->where("id_users",Auth::User()->id)->first();
    }
    public static function sortMood(string $date, $startDay,int $idUsers) {
        return self::selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
                ->selectRaw("unix_timestamp(date_end) - unix_timestamp(date_start) as second")
                ->selectRaw("id")
                ->where(function ($query) use ($date,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '$date'" ))
                    ->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '$date'" ));
                })
                ->where("id_users",$idUsers)->orderByRaw("unix_timestamp(date_end) - unix_timestamp(date_start)  DESC")->get();
    }
    public static function showDescription(int $idMood) {
        return self::select("what_work")->where("id",$idMood)->first();
    }
    public static function downloadMood(string $date,int $startDay,int $IdUsers) {
        return self::selectRaw("moods.id as id")
                ->selectRaw("moods.date_start as date_start")
                ->selectRaw("moods.date_end as date_end")
                ->selectRaw("moods.level_mood as level_mood")
                ->selectRaw("moods.level_anxiety as level_anxiety")
                ->selectRaw("moods.level_nervousness as level_nervousness")
                ->selectRaw("moods.level_stimulation  as level_stimulation")
                ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                ->selectRaw("moods.type as type")
                ->selectRaw(" ((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_mood) as average_mood")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) as average_anxiety")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) as average_nervousness")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) as average_stimulation")
                ->selectRaw("moods.what_work  as what_work ")
                ->where("moods.id_users",$IdUsers)
                ->whereRaw("(CASE

                         WHEN   moods.type = 'mood' THEN 
                            (
                            DATE(
                                IF(
                                   HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) "
                           . "    ) "
                           . "  ) = '" . $date . "'"
                           . ")  or ((DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '" . $date . "'" 

                          
                        . ")"
                        . " ELSE "
                        . "("
                        . "   DATE( "
                        . "         IF("
                        . "             HOUR(    moods.date_start) >= '" . 0 . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY)"
                        . "           )"
                        . "        ) = '" . $date . "'"
                        . ")  "
                        . "    or ((DATE(IF(HOUR(    moods.date_end) >= '" . 0 . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '" . $date . "'"   
                        . ")"
                        . " END)")
                
                ->orderBy("moods.date_start")
                ->get();
    }
    public static function sumAction(string $date, int $idUsers, int $startDay) {
        return self::join("moods_actions","moods_actions.id_moods","moods.id")
                ->join("actions","actions.id","moods_actions.id_actions")
                ->selectRaw("actions.name as name")
                ->selectRaw("actions.level_pleasure as level_pleasure")
                                ->selectRaw(" sum(round("
                        . " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . "ELSE 1 "
                        . " END))"
                        . "  as sum ")
                ->where("moods.id_users",$idUsers)
                //->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                //->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                 ->where(function ($query) use ($date,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                    ->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ));
                })
                
                ->groupBy("actions.id")
                ->get();
    }
    public static function sumActionAll(string $dateFrom, string $dateTo, int $idUsers, int $startDay) {
        return self::join("moods_actions","moods_actions.id_moods","moods.id")
                ->join("actions","actions.id","moods_actions.id_actions")
                ->selectRaw("actions.name as name")
                ->selectRaw("actions.level_pleasure as level_pleasure")
                                ->selectRaw(" sum(round("
                        . " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . "ELSE 1 "
                        . " END))"
                        . "  as sum ")
                ->where("moods.id_users",$idUsers)
                //->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                //->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                
                 ->where(function ($query) use ($dateFrom,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) >= '" . $dateFrom . "'" ))
                    ->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) >= '" . $dateFrom . "'" ));
                })
                
                 ->where(function ($query) use ($dateTo,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) < '" . $dateTo . "'" ))
                    ->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) < '" . $dateTo . "'" ));
                })
                ->groupBy("actions.id")
                ->get();
    }
    public static function ifActionForDayMood(string $date, int $idUsers, int $startDay) {
        return self::join("moods_actions","moods_actions.id_moods","moods.id")
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                ->orWhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) = '" . $date . "'" ))
                ->where("moods.id_users",$idUsers)->count();
    }
    public static function ifExistDAteMood(string $dateFrom, string $dateTo,int $idUsers,int $startDay) {
        return self::whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) >= '" . $dateFrom . "'" ))
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) <= '" . $dateTo . "'" ))
                    ->where("moods.id_users",$idUsers)
                    ->count();
                
    }
    public static function selectValueMood(int $id,int $idUsers) {
        return self::selectRaw("round(moods.level_mood,2) as level_mood")
                ->selectRaw("round(moods.level_anxiety,2) as level_anxiety")
                ->selectRaw("round(moods.level_nervousness,2) as level_nervousness")
                ->selectRaw("round(moods.level_stimulation ,2) as level_stimulation")
                ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                ->where("moods.id_users",$idUsers)
                ->where("moods.id",$id)
                ->first();
    }
    public static function selectValueSleep(int $id,int $idUsers) {
        return self::selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                ->where("moods.id_users",$idUsers)
                ->where("moods.id",$id)
                ->first();
    }
    public static function selectDescription(int $id,int $idUsers) {
        return self::selectRaw("REPLACE(what_work,'<br>','\n') as what_work")
                ->where("moods.id_users",$idUsers)
                ->where("moods.id",$id)
                ->first();
    }
    public static function selectDescriptionShow(int $id,int $idUsers) {
        return self::selectRaw("what_work as what_work")
                ->where("moods.id_users",$idUsers)
                ->where("moods.id",$id)
                ->first();
    }
    public static function selectDateMoods(int $id,int $idUsers) {
        return self::selectRaw("date_start as date_start")
                ->selectRaw("date_end as date_end")
                ->where("id_users",$idUsers)
                ->where("id",$id)->first();
    }
    public static function ifIdUsersExist(int $idMood, int $idUsers) {
        return self::where("id",$idMood)->where("id_users",$idUsers)->first();
    }
     /*
      * 
      * Created januar 2023 
      */
    public function searchActionGroupDay( $action, $actionFrom, $actionTo) {

     
        
        
             if ($action != ""  and  ($actionFrom!= "" and $actionTo != "")) {
                 $this->questions->whereRaw("("
                         . "actions.name like '%" . $action  . "%'  and  (" .
                         "(CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)  >='" . $actionFrom.  "')"
                         . "and ("
                         . "(CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)  <='" . $actionTo .  "')"
                         . ""
                         . ")"

                          );

             }
              else if ($action != ""   and  ($actionTo != "")) {
                 $this->questions->whereRaw("("
                         . "actions.name like '%" . $action  . "%'  and  (("
                         .      " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . ""
                        . " END)"
                         . ")  <= '" . $actionTo .  "')"
                         . " " );
             }
              else if ($action != ""   and  ($actionFrom != "")) {
                 $this->questions->whereRaw("("
                         . "actions.name like '%" . $action  . "%'  and  (("
                         .      " CASE "
                        . " WHEN moods_actions.percent_executing is NULL && moods_actions.minute_exe is  NULL THEN (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) ) "
                        . " WHEN moods_actions.minute_exe is NOT NULL  THEN (moods_actions.minute_exe)    "
                        . " WHEN moods_actions.percent_executing is NOT NULL THEN     (  moods_actions.percent_executing / 100) * (TIMESTAMPDIFF(minute,moods.date_start,moods.date_end) )  "
                        . " "
                        . " END)"
                         . ")  >= '" . $actionFrom .  "')"
                         . " " );
             }
             else if ($action != "" ) {

                 $this->questions->whereRaw("actions.name like '%" . $action  . "%'");
             }





         

       
    }
    /*
     * update may 2023
     */
    public static function sumAllDrugsMood(string $date,  $startDay,int $idUsers) {
        return self::selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat"))
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) as dat2"))
                ->selectRaw(" ((sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_mood)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) )  )as sum_mood ")
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_anxiety)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_anxiety ")
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_nervousness )  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_nervousness ")
                ->selectRaw(" (sum( ( unix_timestamp(date_end) - unix_timestamp(date_start) ) * level_stimulation)  / sum( unix_timestamp(date_end) - unix_timestamp(date_start) ) ) as sum_stimulation ")
                ->selectRaw("sum(moods.epizodes_psychotik) as epizodes_psychotik")
                ->where("type","mood")
                ->where("id_users",$idUsers)
                ->where(function ($query) use ($date,$startDay) {
                    $query->whereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_start) >= '" . $startDay . "', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) IN $date" ))
                    ->orwhereRaw(DB::Raw("(DATE(IF(HOUR(    moods.date_end) >= '" . $startDay . "', moods.date_end,Date_add(moods.date_end, INTERVAL - 1 DAY) )) ) IN $date" ));
                })


                ->groupBy("dat")
                //->groupBy("dat2")
                ->get();
    }
    /*
     * update june 2023
     */
    public static function selectLastSleep(array $data, $startDay,int $idUsers) {
        return self::selectRaw("left(date_end,10) as dat")
                    ->selectRaw("date_end as date_end")
                ->where("type","sleep")
                ->where("id_users",$idUsers)
                ->whereRaw("time(moods.date_end) <  '12:20:20' ")
                ->whereRaw("time(moods.date_end) >  '05:00:20' ")
                ->where(function ($query) use ($data) {
                    
                    if (isset($data["dateFrom"])) {
                        $query->where("moods.date_start",">=",$data["dateFrom"] );
                    }
                    if (isset($data["dateTo"])) {
                        $query->where("moods.date_end","<",$data["dateTo"]);
                    }
                    
                    if (isset($data["longSleepHourFrom"])) {
                        $query->whereRaw("(  ( unix_timestamp(date_end) - unix_timestamp(date_start) ) / 3600 ) >= " . $data["longSleepHourFrom"]);
                    }
                    if (isset($data["longSleepHourTo"])) {
                        $query->whereRaw("(  ( unix_timestamp(date_end) - unix_timestamp(date_start) ) / 3600 ) < " . $data["longSleepHourTo"]);
                    }
                    
                    if (isset($data["longSleepMinuteFrom"])) {
                        $query->whereRaw("(  ( unix_timestamp(date_end) - unix_timestamp(date_start) ) / 60 ) >= " . $data["longSleepMinuteFrom"]);
                    }
                    if (isset($data["longSleepMinuteTo"])) {
                        $query->whereRaw("(  ( unix_timestamp(date_end) - unix_timestamp(date_start) ) / 60 ) < " . $data["longSleepMinuteTo"]);
                    }
                    })
                    ->get();
    }
    

}
