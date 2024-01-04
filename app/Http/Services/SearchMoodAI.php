<?php
/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use App\Models\Mood as MoodModel;
use App\Models\Moods_action as MoodAction;
use App\Http\Services\Calendar;
use Hash;
use Datetime;
use App\Http\Services\Common;
use Auth;
use DB;


class SearchMoodAI
{
    public $errors = [];
    private $idUsers;
    private $startDay;
    public $dateTo;
    public $dateFrom;
    
    private $arrayWeek = [];
    private $hourStart;
    private $hourEnd;
    public $hourSum = [];
    public $boolHourEnd = false;
    public $listMood = [];
    public $dayWeek = [];
    private $howWeek = 0;

    function __construct(int $idUsers, int $startDay)
    {
        $this->idUsers = $idUsers;
        $this->startDay = $startDay;

    }

    public function setDayWeek(Request $request)
    {
        if ($request->get("day1") == "on") {
            array_push($this->dayWeek, 1);
        }
        if ($request->get("day2") == "on") {
            array_push($this->dayWeek, 2);
        }
        if ($request->get("day3") == "on") {
            array_push($this->dayWeek, 3);
        }
        if ($request->get("day4") == "on") {
            array_push($this->dayWeek, 4);
        }
        if ($request->get("day5") == "on") {
            array_push($this->dayWeek, 5);
        }
        if ($request->get("day6") == "on") {
            array_push($this->dayWeek, 6);
        }
        if ($request->get("day7") == "on") {
            array_push($this->dayWeek, 7);
        }
    }

    public function checkError(Request $request)
    {
        if ($request->get("dateFrom") == "") {
            array_push($this->errors, "Uzupełnij date zaczęcia");
        }
        if ((($request->get("divMinute") < 0 or $request->get("divMinute") >= 1440) or ((string)(int)$request->get("divMinute") !== $request->get("divMinute")))) {
            array_push($this->errors, "liczba Rozdzielenie minut musi być dodatnią liczbą cakowtą od 0 do 1440");
        }
        if ($this->checkHourError($request) == true) {
            array_push($this->errors, "Godzina zaczęcia jest większa lub równa godzinie skończenia");
        }
    }

    public function setVariable(Request $request)
    {
        if ($request->get("dateTo") == "") {
            $this->dateTo = date("Y-m-d",strtotime(date("Y-m-d") ) + 86400);
        } else {
            $this->dateTo = $request->get("dateTo");
        }
        $this->dateFrom = $request->get("dateFrom");
    }

    public function createQuestionsMinMax(Request $request)
    {
        $moodModel = new  MoodModel;
        $moodModel->createQuestionMinMaxAI($this->startDay);
        $moodModel->setDateMinMaxAI($this->dateFrom, $this->dateTo, $this->startDay);
        $moodModel->setWeekDayMinMax($this->dayWeek, $this->startDay);
        $this->setHour($moodModel, $request, false);

        $moodModel->idUsersMinMax($this->idUsers);

        $moodModel->setGroupDayMinMax($this->startDay);

        $moodModel->orderByAIMinMax();
        return $moodModel->questionsMinMax->get();
    }

    public function createQuestions(Request $request)
    {
        $moodModel = new  MoodModel;
        $moodModel->createQuestionAI($this->startDay,$this->hourStart, $this->hourEnd);
        //print $this->dateFrom;
        $moodModel->setDateAI($this->dateFrom, $this->dateTo, $this->startDay);
        $moodModel->setWeekDay($this->dayWeek, $this->startDay);
        $moodModel->setHourTwo($this->hourStart, $this->hourEnd, $this->startDay);
        $moodModel->moodsSelect();
        $moodModel->idUsers($this->idUsers);
        //$moodModel->setGroupDay($this->startDay);
//        if ($request->get("groupWeek") == "on") {
//            $moodModel->setWhereWeek($this->dateFrom, $this->dateTo,$this->startDay);
//            $moodModel->setGroupWeek($this->startDay);
//            
//        }
//        else {
        
            $moodModel->setGroupDay($this->startDay);
        
        //}
        $moodModel->orderByAI();
        $list = $moodModel->questions->get();
       
            //$this->setWeekDays($this->dateFrom, $this->dateTo);
            //$a = $this->filtrQuestionsGroupWeek4($list);

            //var_dump($a);
        //} else {
          //  $this->filtrQuestions($list);
        
        return $list;
    }

    public function createQuestionsMinuteSumDay(Request $request,$hourFrom,$hourEnd) {
        $moodModel = new  MoodModel;
        $moodModel->createQuestionAI($this->startDay,$hourFrom, $hourEnd);
        $moodModel->setDateAI($this->dateFrom, $this->dateTo, $this->startDay);
        $moodModel->setWeekDay($this->dayWeek, $this->startDay);
        $moodModel->setHourTwo($hourFrom, $hourEnd, $this->startDay);
        $moodModel->moodsSelect();
        $moodModel->idUsers($this->idUsers);
        //$moodModel->setGroupDay($this->startDay);
//        if ($request->get("groupWeek") == "on") {
//            $moodModel->setWhereWeek($this->dateFrom, $this->dateTo,$this->startDay);
//            $moodModel->setGroupWeek($this->startDay);
//            
//        }
//        else {
        
            $moodModel->setGroupDay($this->startDay);
        
        //}
        $moodModel->orderByAI();
        $list = $moodModel->questions->get();
       
            //$this->setWeekDays($this->dateFrom, $this->dateTo);
            //$a = $this->filtrQuestionsGroupWeek4($list);

            //var_dump($a);
        //} else {
          //  $this->filtrQuestions($list);
        
        return $list;
    }
    
    
    public function createWeek(string $dateFrom,string $dateTo) {
        $week = 1;
        $arrayWeek = [];
        $j = 0;
        for ($i = strtotime($dateFrom);$i <= strtotime($dateTo);$i+= 86400 * 7) {
            $dateIFrom = date("Y-m-d",$i);
            $dateITo = date("Y-m-d",$i+ (86400 * 6) );
            if (MoodModel::ifExistDAteMood($dateIFrom, $dateITo, $this->idUsers,$this->startDay) > 0 ) {
//                if (Common::ifChangeTimeWinterOne(date("Y-m-d",$i))) {
//                    $arrayWeek["dateStart"][$j] = date("Y-m-d",$i+ (86400) );
//                    $arrayWeek["dateEnd"][$j] = date("Y-m-d",$i+ (86400 * 7) );
//                }
//                else if (Common::ifChangeTimeWinterTwo(date("Y-m-d",$i))) {
//                     $arrayWeek["dateStart"][$j] = date("Y-m-d",$i+ (86400) );
//                     $arrayWeek["dateEnd"][$j] = date("Y-m-d",$i+ (86400 * 7) );
//                }
//                else {
                    $arrayWeek["dateStart"][$j] = date("Y-m-d",$i);
                    $arrayWeek["dateEnd"][$j] = date("Y-m-d",$i+ (86400 * 6) );
                //}
                
     
               
                
                $j++;
            }
            //$i+= 86400;
            
        }
        return $arrayWeek;
    }
    
    public function subCreateMonth( $date) {
        
        $arrayWeek = [];
        $j = 0;
        
        for ($i = 0;$i < count($date["dateStart"]);$i++) {
           
            if (MoodModel::ifExistDAteMood($date["dateStart"][$i], $date["dateEnd"][$i], $this->idUsers,$this->startDay) > 0 ) {
                    
                    $arrayWeek["dateStart"][$j] = $date["dateStart"][$i];
                    $arrayWeek["dateEnd"][$j] = $date["dateEnd"][$i];

                    $j++;
            }
            
        }
        return $arrayWeek;
    
    }
    
    public function createMonth(string $dateFrom,string $dateTo) {
        //$week = 1;
        $arrayWeek = [];
        //$j = 0;
        $year = date("Y",strtotime($dateFrom));
        $month = date("m",strtotime($dateFrom));
        //$month = date("m",strtotime($dateFrom));
        $arrayWeek["dateStart"][0] = date("Y-m-d",strtotime($year  . "-" . $month . "-01"));
            $howMonth = Common::subMonth($dateFrom,$dateTo);
                
            for ($i = 0;$i <= $howMonth;$i++)  {
                
               if ($i < $howMonth+1and $i != 0) {
                   $arrayWeek["dateStart"][$i] = date("Y-m-d",strtotime($year  . "-" . $month . "-01"));
               }
                
                if ($i == $howMonth) {
                    $arrayWeek["dateEnd"][$i] = date("Y-m-d",strtotime($year  . "-" . $month . "-" .   calendar::checkMonth($month,$year)) );
                    break;
                }
                $arrayWeek["dateEnd"][$i] = date("Y-m-d",strtotime($year  . "-" . $month  . "-" .   calendar::checkMonth($month,$year) ) );
                if ($month == 12) {
                    $month = 1;
                    $year++;
                }
                else {
                    $month++;
                }
                
                
      
            }

            
     return $arrayWeek;
    }

    public function sortSumDayMinute($list,$hourArrayFrom,$hourArrayTo) {
        $arrayNew = [];
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $count = 0;
        for ($i=0;$i < count($list);$i++) {
            if ($i == 0) {
                $arrayNew["dateStart"] = $list[$i]->dat_end;
                //$arrayNew["hourStart"][0] = $hourArray[0];
            }
            if ($i == count($list)-1) {
                $arrayNew["dateEnd"] = $list[$i]->dat_end;
                //$arrayNew["hourEnd"][0] = $hourArray[$i];
            }
            $arrayNew["hourStart"] = $hourArrayFrom;
            //if ($i == count($list)-1) {
                $arrayNew["hourEnd"] = $hourArrayTo;
            //}
            $sumMood += $list[$i]->mood;
            $sumAnxienty += $list[$i]->anxienty;
            $sumVoltage += $list[$i]->voltage;
            $sumStimulation += $list[$i]->stimulation;
            $count += $list[$i]->count;
        }
        //$arrayNew["dateStart"] = $arrayWeek["dateStart"][$y];
        //$arrayNew["dateEnd"] = $arrayWeek["dateEnd"][$y];
        $arrayNew["mood"] = $sumMood /$i;
        $arrayNew["anxienty"] = $sumAnxienty / $i;
        $arrayNew["voltage"] =  $sumVoltage / $i;
        $arrayNew["stimulation"] = $sumStimulation /  $i;
        $arrayNew["count"] = $count;
        return $arrayNew;
    }
    public function sortSumDay($list) {
        $arrayNew = [];
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $count = 0;
        for ($i=0;$i < count($list);$i++) {
            if ($i == 0) {
                $arrayNew["dateStart"][0] = $list[$i]->dat_end;
            }
            if ($i == count($list)-1) {
                $arrayNew["dateEnd"][0] = $list[$i]->dat_end;
            }
            $sumMood += $list[$i]->mood;
            $sumAnxienty += $list[$i]->anxienty;
            $sumVoltage += $list[$i]->voltage;
            $sumStimulation += $list[$i]->stimulation;
            $count += $list[$i]->count;
        }
        //$arrayNew["dateStart"] = $arrayWeek["dateStart"][$y];
        //$arrayNew["dateEnd"] = $arrayWeek["dateEnd"][$y];
        $arrayNew["mood"][0] = $sumMood /$i;
        $arrayNew["anxienty"][0] = $sumAnxienty / $i;
        $arrayNew["voltage"][0] =  $sumVoltage / $i;
        $arrayNew["stimulation"][0] = $sumStimulation /  $i;
        $arrayNew["count"][0] = $count;
        return $arrayNew;
    }
    
    public function sortWeek($list,$arrayWeek) {
        
        $j = 0;
        $day = 0;
        $arrayNew = [];
        $y = 0;
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $count = 0;
        for ($i=0;$i < count($list);$i++) {
            if ($i == count($list)-1) {
                $sumMood += $list[$i]->mood;
                $sumAnxienty += $list[$i]->anxienty;
                $sumVoltage += $list[$i]->voltage;
                $sumStimulation += $list[$i]->stimulation;
                $count += $list[$i]->count;
                $day++;
                goto END;
            }
            if (strtotime($arrayWeek["dateStart"][$j]) <= strtotime($list[$i]->dat_end) and strtotime($arrayWeek["dateEnd"][$j]) >= strtotime($list[$i]->dat_end) ) {
                
                $sumMood += $list[$i]->mood;
                $sumAnxienty += $list[$i]->anxienty;
                $sumVoltage += $list[$i]->voltage;
                $sumStimulation += $list[$i]->stimulation;
                $count += $list[$i]->count;
                
                
                $day++;
            }
            else {
                END:
                $arrayNew["dateStart"][$y] = $arrayWeek["dateStart"][$y];
                $arrayNew["dateEnd"][$y] = $arrayWeek["dateEnd"][$y];
                $arrayNew["mood"][$y] = $sumMood /$day;
                $arrayNew["anxienty"][$y] = $sumAnxienty / $day;
                $arrayNew["voltage"][$y] =  $sumVoltage / $day;
                $arrayNew["stimulation"][$y] = $sumStimulation /  $day;
                $arrayNew["count"][$y] = $count;
                $sumMood = 0;
                $sumAnxienty = 0;
                $sumVoltage = 0;
                $sumStimulation = 0;
                $count = 0;
                $sumMood += $list[$i]->mood;
                $sumAnxienty += $list[$i]->anxienty;
                $sumVoltage += $list[$i]->voltage;
                $sumStimulation += $list[$i]->stimulation;
                $count += $list[$i]->count;
                $y++;
                $j++;
                $day = 1;
            }
            
        }
        return $arrayNew;
        
    }
   
    
    public function sortMonth($list,$arrayWeek) {
        $j = 0;
        $day = 0;
        $arrayNew = [];
        $y = 0;
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $count = 0;
        for ($i=0;$i < count($list);$i++) {
            if ($i == count($list)-1) {
                $sumMood += $list[$i]->mood;
                $sumAnxienty += $list[$i]->anxienty;
                $sumVoltage += $list[$i]->voltage;
                $sumStimulation += $list[$i]->stimulation;
                $count += $list[$i]->count;
                $day++;
                goto END;
            }
           
            if  ( (strtotime($arrayWeek["dateStart"][$j]) <= strtotime($list[$i]->dat_end) and strtotime($arrayWeek["dateEnd"][$j]) >= strtotime($list[$i]->dat_end)  )    ) {
                
                $sumMood += $list[$i]->mood;
                $sumAnxienty += $list[$i]->anxienty;
                $sumVoltage += $list[$i]->voltage;
                $sumStimulation += $list[$i]->stimulation;
                $count += $list[$i]->count;
                
               
                $day++;
            }
            else {
                END:
                
                
                $arrayNew["dateStart"][$y] = $arrayWeek["dateStart"][$y];
                $arrayNew["dateEnd"][$y] = $arrayWeek["dateEnd"][$y];
                $arrayNew["mood"][$y] = $sumMood /$day;
                $arrayNew["anxienty"][$y] = $sumAnxienty / $day;
                $arrayNew["voltage"][$y] =  $sumVoltage / $day;
                $arrayNew["stimulation"][$y] = $sumStimulation /  $day;
                $arrayNew["count"][$y] = $count;
                $sumMood = 0;
                $sumAnxienty = 0;
                $sumVoltage = 0;
                $sumStimulation = 0;
                $count = 0;
                $sumMood += $list[$i]->mood;
                $sumAnxienty += $list[$i]->anxienty;
                $sumVoltage += $list[$i]->voltage;
                $sumStimulation += $list[$i]->stimulation;
                $count += $list[$i]->count;
                $y++;
                $j++;
                $day = 1;
//                END2:
//                   if  (   (strtotime($arrayWeek["dateEnd"][$j]) <= strtotime($list[$i]->dat_end))  )      {
//                    if ($j >= count($arrayWeek["dateEnd"]))  {
//                        return $arrayNew;
//                    }
//                    $j++;
//                    print "dos";
//                    goto END2;
//                }
             
            }
            
        }
        
        return $arrayNew;
        
    }
    
//    private function setWeekDays(string $dateFrom,string $dateTo) {
//
//        for ($i = strtotime($dateFrom); $i < strtotime($dateTo); $i+= (86400 * 7)) {
//            $this->arrayWeek['date_start'][] = date("Y-m-d",$i);
//            $this->arrayWeek['date_end'][] = date("Y-m-d",$i + (86400 * 7));
//        }
//    }
    private function filtrQuestionsGroupWeek4($list) {
        $array = [];
        $array2 = [];
        $g = 0;
        for ($i = strtotime($this->dateFrom);$i <= strtotime($this->dateTo);$i += (86400 * 7) ) {
            $array = $this->filtrQuestionsWeek($list,($i),($i+ (86400 * 7)));
            if (count($array) == 0) {
                continue;
            }
            $mood = 0;
            $anxienty = 0;
            $voltage = 0;
            $stimulation = 0;
            for ($j=0;$j < count($array);$j++) {
                $mood += $array["mood"][$j];
                $anxienty += $array["anxienty"][$j];
                $voltage += $array["voltage"][$j];
                $stimulation += $array["stimulation"][$j];

//                $array["mood"][$j] = $sumMood / $second;
//                $array["anxienty"][$j] = $sumAnxienty / $second;
//                $array["voltage"][$j] = $sumVoltage / $second;
//                $array["stimulation"][$j] = $sumStimulation / $second;
//                $array["dat_end"][$j] = $list[$i - 1]->dat_end;
//                $array["howWeek"][$j] = $howWeek;
            }

            $array2["mood"][$g] = $mood / $this->howWeek;
            $array2["anxienty"][$g] = $anxienty / $this->howWeek;
            $array2["voltage"][$g] = $voltage/  $this->howWeek;
            $array2["stimulation"][$g] = $stimulation / $this->howWeek;
            $array2["dat_end"][$g] = date("Y-m-d",$i) . " - " . date("Y-m-d",$i+ (86400 * 7));
            $this->howWeek = 0;

            $g++;
        }
        return $array2;
    }
    private function filtrQuestionsGroupWeek3($list) {

        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $second = 0;
        $j = 0;
        $count = 0;
        $bool = false;
        for($i=0;$i < count($list);$i++) {

            if ($i == 0) {
                $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);
                //$dayWeek = date('w', strtotime($list[$i]->dat_end ));
                $firstDate = $list[$i]->dat_end;
                $firstDate2 = new DateTime($firstDate);
                $secondDate = date("Y-m-d",strtotime($list[$i]->dat_end) + (86400 * 6));
                $secondDate2 = new DateTime($secondDate);
                $diff = $firstDate2->diff($secondDate2);
                $dayWeek = date('w', strtotime($list[$i]->dat_end ));

            }
            if ($i > 0 and $list[$i]->dat_end != $list[$i - 1]->dat_end) {
                if ($second > 0) {
                    if ($diff->days >= 7 ) {
                        print "kola<br>";
                        $this->listMood["mood"][$j] = $sumMood / $second;
                        $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                        $this->listMood["voltage"][$j] = $sumVoltage / $second;
                        $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                        $this->listMood["dat_end"][$j] = $firstDate . "-" . $secondDate;
                        $this->listMood["count"][$j] = $count;

                        $firstDate = $list[$i]->dat_end;
                        $firstDate2 = new DateTime($firstDate);
                        $j++;
                        $sumMood = 0;
                        $sumAnxienty = 0;
                        $sumVoltage = 0;
                        $sumStimulation = 0;
                        $second = 0;
                        $count = 0;
                        $bool = false;
                    }
                    else {

                        //if ($dayWeek == date('w', strtotime($list[$i]->dat_end ))) {
                            print "koasdsd";
                            //$firstDate = $list[$i]->dat_end;
                            //$firstDate2 = new DateTime($firstDate);
                            $secondDate = date("Y-m-d",strtotime($list[$i]->dat_end) + (86400 * 6));
                            $secondDate2 = new DateTime($secondDate);
                            $diff = $firstDate2->diff($secondDate2);

                        //}
//                        else {
//                            print "kolos";
//                            $bool = true;
//                        }

                    }
                }
                $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);
            }
            if ($i == count($list) -1) {
                if ($second > 0) {
                    $this->listMood["mood"][$j] = $sumMood / $second;
                    $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                    $this->listMood["voltage"][$j] = $sumVoltage / $second;
                    $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                    $this->listMood["dat_end"][$j] = $list[$i]->dat_end;
                    $this->listMood["count"][$j] = $count;
                }
                else {
                    if (strtotime($list[$i]->date_start) >= $startDay) {
                        $start = strtotime($list[$i]->date_start);
                    } else {
                        $start = $startDay;
                    }

                    if (strtotime($list[$i]->date_end) <= $endDay) {
                        $end = strtotime($list[$i]->date_end);
                    } else {
                        $end = $endDay;
                    }
                    $sumMood += (($end - $start) * $list[$i]->level_mood);
                    $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
                    $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
                    $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);
                    $second += $end - $start;
                    if ($second == 0) {
                        $second++;
                    }

                    $this->listMood["mood"][$j] = $sumMood / $second;
                    $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                    $this->listMood["voltage"][$j] = $sumVoltage / $second;
                    $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                    $this->listMood["dat_end"][$j] = $list[$i]->dat_end;
                    $this->listMood["count"][$j] = $count;
                }
            }

            if (strtotime($list[$i]->date_start) >= $startDay) {
                $start = strtotime($list[$i]->date_start);
            } else {
                $start = $startDay;
            }

            if (strtotime($list[$i]->date_end) <= $endDay) {
                $end = strtotime($list[$i]->date_end);
            } else {
                $end = $endDay;
            }

            $sumMood += (($end - $start) * $list[$i]->level_mood);
            $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
            $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
            $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);

            $second += $end - $start;
            $count++;
            //print $second . "<br>";

        }
    }
    private function filtrQuestionsGroupWeek2($list) {
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $second = 0;
        $j = 0;
        $count = 0;
        $dayBack = "";
        $strotoFrom = strtotime($this->dateFrom);
        $strotoTo = strtotime($this->dateTo);
        $x = 0;
        $z = 0;
        $j = 0;
        $v = 0;
        for ($i = $strotoFrom; $i < ($strotoTo); $i+= (86400)) {




    print "else";
            for ($x = $z; $x < count($list); $x++) {

                print "<font color=red>" . array_search(date("Y-m-d",$i),array_column((array)$list[$x], 'dat_end') ) . "</font>";
                //if ()
                //if ($i == $strotoFrom) {
                    $startDay = strtotime($list[$x]->dat_end . " " . $this->hourStart);
                    $endDay = strtotime($list[$x]->dat_end . " " . $this->hourEnd);
//                $dayBack = $list[$i]->dat_end;
//                $dayNext = date("Y-m-d", strtotime($dayBack) + (86400 * 6));

                //}
                //else {

                //}
                if (strtotime($list[$x]->date_start) >= $startDay) {
                    $start = strtotime($list[$x]->date_start);
                } else {
                    $start = $startDay;
                }

                if (strtotime($list[$x]->date_end) <= $endDay) {
                    $end = strtotime($list[$x]->date_end);
                } else {
                    $end = $endDay;
                }

                $sumMood += (($end - $start) * $list[$x]->level_mood);
                $sumAnxienty += (($end - $start) * $list[$x]->level_anxiety);
                $sumVoltage += (($end - $start) * $list[$x]->level_nervousness);
                $sumStimulation += (($end - $start) * $list[$x]->level_stimulation);

                $second += $end - $start;
                $count++;
                if (  $this->arrayWeek['date_start'][$v] < array_search(date("Y-m-d",$i),array_column((array)$list[$x], 'dat_end') )
                    and $this->arrayWeek['date_end'][$v] < array_search(date("Y-m-d",$i),array_column((array)$list[$x], 'dat_end') ) ) {

                }
                if ( $i <= strtotime($list[$x]->date_end)) {
                    print "dos<br>";
                    break;
                }
            }
            //$second = 1;
            if ($second > 0) {


                $this->listMood["mood"][$j] = $sumMood / $second;
                $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                $this->listMood["voltage"][$j] = $sumVoltage / $second;
                $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                $this->listMood["dat_end"][$j]  = date("Y-m-d",$i) . " - " . date("Y-m-d",$i + (86400 * 7));
                $this->listMood["count"][$j] = $count;
            }

            $sumMood = 0;
            $sumAnxienty = 0;
            $sumVoltage = 0;
            $sumStimulation = 0;
            $second = 0;
            $count = 0;
            $j++;
            $z = $x;
            //$j++;
        }
    }

    private function filtrQuestionsGroupWeek($list)
    {
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $second = 0;
        $j = 0;
        $count = 0;
        $dayBack = "";
        for ($i = 0; $i < count($list); $i++) {

            if ($i == 0) {
                $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);
                $firstDate = new DateTime($list[$i]->dat_end);
                //$dayBack = $list[$i]->dat_end;
                //$dayNext = date("Y-m-d", strtotime($dayBack) + (86400 * 6));

            }
            else {
                $firstDate = new DateTime($dayBack);
                $secondDate = new DateTime($list[$i]->dat_end);
                $diff = $firstDate->diff($secondDate);
                print $diff->days . "<br>";
            }




            if ($i > 0 and $diff->days >= 6) {
                $dayBack = $list[$i]->dat_end;
                //print "stos";


                    if ($second > 0) {
                        $this->listMood["mood"][$j] = $sumMood / $second;
                        $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                        $this->listMood["voltage"][$j] = $sumVoltage / $second;
                        $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                        $this->listMood["dat_end"][$j] = $list[$i-1]->dat_end . " - " . $list[$i]->dat_end;
                        $this->listMood["count"][$j] = $count;
                        $j++;
                        print "kup";

                        $sumMood = 0;
                        $sumAnxienty = 0;
                        $sumVoltage = 0;
                        $sumStimulation = 0;
                        $second = 0;
                        $count = 0;
                    }



                    //$dayBack = date("Y-m-d", strtotime($dayNext) + (86400) );
                    //$dayNext = date("Y-m-d", strtotime($dayBack) + (86400 * 6));

                $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);
            }
            if ($i == count($list) - 1) {
                if ($second > 0) {
                    $this->listMood["mood"][$j] = $sumMood / $second;
                    $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                    $this->listMood["voltage"][$j] = $sumVoltage / $second;
                    $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                    $this->listMood["dat_end"][$j] = $list[$i-1]->dat_end . " - " . $list[$i]->dat_end;
                    $this->listMood["count"][$j] = $count;
                } else {
                    if (strtotime($list[$i]->date_start) >= $startDay) {
                        $start = strtotime($list[$i]->date_start);
                    } else {
                        $start = $startDay;
                    }

                    if (strtotime($list[$i]->date_end) <= $endDay) {
                        $end = strtotime($list[$i]->date_end);
                    } else {
                        $end = $endDay;
                    }
                    $sumMood += (($end - $start) * $list[$i]->level_mood);
                    $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
                    $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
                    $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);
                    $second += $end - $start;
                    if ($second == 0) {
                        $second++;
                    }

                    $this->listMood["mood"][$j] = $sumMood / $second;
                    $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                    $this->listMood["voltage"][$j] = $sumVoltage / $second;
                    $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                    $this->listMood["dat_end"][$j] = $list[$i-1]->dat_end . " - " . $list[$i]->dat_end;
                    $this->listMood["count"][$j] = $count;
                }
            }



        if (strtotime($list[$i]->date_start) >= $startDay) {
            $start = strtotime($list[$i]->date_start);
        } else {
            $start = $startDay;
        }

        if (strtotime($list[$i]->date_end) <= $endDay) {
            $end = strtotime($list[$i]->date_end);
        } else {
            $end = $endDay;
        }

        $sumMood += (($end - $start) * $list[$i]->level_mood);
        $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
        $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
        $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);

        $second += $end - $start;
        $count++;

    }
}


    private function filtrQuestionsWeek($list,int $dateStart,int $dateEnd) {
        $array = [];
        $sumMood = 0;
        $sumAnxienty = 0;
        $sumVoltage = 0;
        $sumStimulation = 0;
        $second = 0;

        $j = 0;
        for($i=0;$i < count($list);$i++) {
            if  ((strtotime($list[$i]->dat_end) <=$dateEnd ) and (strtotime($list[$i]->dat_end) > $dateStart ) ) {
                if ($i == 0) {
                    $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                    $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);

                }
                if ($i > 0 and $list[$i]->dat_end != $list[$i - 1]->dat_end) {
                    if ($second > 0) {
                        $this->howWeek++;
                        $array["mood"][$j] = $sumMood / $second;
                        $array["anxienty"][$j] = $sumAnxienty / $second;
                        $array["voltage"][$j] = $sumVoltage / $second;
                        $array["stimulation"][$j] = $sumStimulation / $second;
                        $array["dat_end"][$j] = $list[$i - 1]->dat_end;
                        //$array["howWeek"][$j] = $howWeek;


                        $j++;
                        $sumMood = 0;
                        $sumAnxienty = 0;
                        $sumVoltage = 0;
                        $sumStimulation = 0;
                        $second = 0;
                    }
                    $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                    $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);
                }
                if ($i == count($list) - 1) {
                    if ($second > 0) {
                        $this->howWeek++;
                        $array["mood"][$j] = $sumMood / $second;
                        $array["anxienty"][$j] = $sumAnxienty / $second;
                        $array["voltage"][$j] = $sumVoltage / $second;
                        $array["stimulation"][$j] = $sumStimulation / $second;
                        $array["dat_end"][$j] = $list[$i]->dat_end;


                    } else {
                        if (strtotime($list[$i]->date_start) >= $startDay) {
                            $start = strtotime($list[$i]->date_start);
                        } else {
                            $start = $startDay;
                        }

                        if (strtotime($list[$i]->date_end) <= $endDay) {
                            $end = strtotime($list[$i]->date_end);
                        } else {
                            $end = $endDay;
                        }
                        $sumMood += (($end - $start) * $list[$i]->level_mood);
                        $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
                        $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
                        $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);
                        $second += $end - $start;
                        if ($second == 0) {
                            $second++;
                        }

                        $array["mood"][$j] = $sumMood / $second;
                        $array["anxienty"][$j] = $sumAnxienty / $second;
                        $array["voltage"][$j] = $sumVoltage / $second;
                        $array["stimulation"][$j] = $sumStimulation / $second;
                        $array["dat_end"][$j] = $list[$i]->dat_end;

                    }
                }

                if (strtotime($list[$i]->date_start) >= $startDay) {
                    $start = strtotime($list[$i]->date_start);
                } else {
                    $start = $startDay;
                }

                if (strtotime($list[$i]->date_end) <= $endDay) {
                    $end = strtotime($list[$i]->date_end);
                } else {
                    $end = $endDay;
                }

                $sumMood += (($end - $start) * $list[$i]->level_mood);
                $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
                $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
                $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);

                $second += $end - $start;
                //print $second . "<br>";
            }
        }
        return $array;
    }


        private function filtrQuestions($list) {

            $sumMood = 0;
            $sumAnxienty = 0;
            $sumVoltage = 0;
            $sumStimulation = 0;
            $second = 0;
            $j = 0;
                for($i=0;$i < count($list);$i++) {

                    if ($i == 0) {
                        $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                        $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);

                    }
                    if ($i > 0 and $list[$i]->dat_end != $list[$i - 1]->dat_end) {
                        if ($second > 0) {
                            $this->listMood["mood"][$j] = $sumMood / $second;
                            $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                            $this->listMood["voltage"][$j] = $sumVoltage / $second;
                            $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                            $this->listMood["dat_end"][$j] = $list[$i - 1]->dat_end;


                            $j++;
                            $sumMood = 0;
                            $sumAnxienty = 0;
                            $sumVoltage = 0;
                            $sumStimulation = 0;
                            $second = 0;
                        }
                        $startDay = strtotime($list[$i]->dat_end . " " . $this->hourStart);
                        $endDay = strtotime($list[$i]->dat_end . " " . $this->hourEnd);
                    }
                    if ($i == count($list) -1) {
                        if ($second > 0) {
                            $this->listMood["mood"][$j] = $sumMood / $second;
                            $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                            $this->listMood["voltage"][$j] = $sumVoltage / $second;
                            $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                            $this->listMood["dat_end"][$j] = $list[$i]->dat_end;
                        }
                        else {
                            if (strtotime($list[$i]->date_start) >= $startDay) {
                                $start = strtotime($list[$i]->date_start);
                            } else {
                                $start = $startDay;
                            }

                            if (strtotime($list[$i]->date_end) <= $endDay) {
                                $end = strtotime($list[$i]->date_end);
                            } else {
                                $end = $endDay;
                            }
                            $sumMood += (($end - $start) * $list[$i]->level_mood);
                            $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
                            $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
                            $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);
                            $second += $end - $start;
                            if ($second == 0) {
                                $second++;
                            }

                            $this->listMood["mood"][$j] = $sumMood / $second;
                            $this->listMood["anxienty"][$j] = $sumAnxienty / $second;
                            $this->listMood["voltage"][$j] = $sumVoltage / $second;
                            $this->listMood["stimulation"][$j] = $sumStimulation / $second;
                            $this->listMood["dat_end"][$j] = $list[$i]->dat_end;
                        }
                    }

                        if (strtotime($list[$i]->date_start) >= $startDay) {
                            $start = strtotime($list[$i]->date_start);
                        } else {
                            $start = $startDay;
                        }

                        if (strtotime($list[$i]->date_end) <= $endDay) {
                            $end = strtotime($list[$i]->date_end);
                        } else {
                            $end = $endDay;
                        }

                        $sumMood += (($end - $start) * $list[$i]->level_mood);
                        $sumAnxienty += (($end - $start) * $list[$i]->level_anxiety);
                        $sumVoltage += (($end - $start) * $list[$i]->level_nervousness);
                        $sumStimulation += (($end - $start) * $list[$i]->level_stimulation);

                        $second += $end - $start;
                    //print $second . "<br>";

                }
        }
    private function checkHourError(Request $request) {
        if (($request->get("timeFrom") != "" and $request->get("timeTo") != "") ) {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $timeTo = explode(":",$request->get("timeTo"));
            $hourFrom = $this->sumHour($timeFrom,$this->startDay);
            $hourTo = $this->sumHour($timeTo,$this->startDay);
            if (strtotime($hourFrom) >= strtotime($hourTo)) {
                return true;
            }
            else {
                return false;
            }
        }

    }
    private function setHourArray(int $divMinute,$start,$end) {
        $j = 0;
        for ($i = $start;$i <= $end + $divMinute;$i += $divMinute * 60) {
            $this->hourSum[$j] = date("H:i:s",$i);
            $j++;
        }
    }
//    public function setHourSumDay(Request $request) {
//        if (($request->get("timeFrom") != "" and $request->get("timeTo") != "") ) {
//            $timeFrom = explode(":",$request->get("timeFrom"));
//            $timeTo = explode(":",$request->get("timeTo"));
//            $hourFrom = $this->sumHour($timeFrom,$this->startDay);
//            $hourTo = $this->sumHour($timeTo,$this->startDay);
//            
//            $this->hourStart = $hourFrom;
//            $this->hourEnd = $hourTo;
//
//
//
//        }
//        else if ($request->get("timeTo") != ""){
//            $timeTo = explode(":",$request->get("timeTo"));
//            $hourTo = $this->sumHour($timeTo,$this->startDay);
//            $hourFrom = $this->sumHour(explode(":",$this->startDay . ":00:00"),$this->startDay);
//            
//            //$moodModel->setHourTo($hourTo);
//            $this->hourStart = $hourFrom;
//            $this->hourEnd = $hourTo;
//        }
//        else if ($request->get("timeFrom") != "" ) {
//            $timeFrom = explode(":",$request->get("timeFrom"));
//            $hourFrom = $this->sumHour($timeFrom,$this->startDay);
//            $hourTo = $this->sumHour(explode(":",date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60) ),$this->startDay);
//            //$moodModel->setHourFrom($hourFrom);
//            $this->hourStart = $hourFrom;
//            $this->hourEnd = $hourTo;
//
//        }
//        else {
//            //print "jad";
//            //print date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60);
//            $this->hourStart  = $this->sumHour(explode(":",$this->startDay . ":00:00"),$this->startDay);
//            $this->hourEnd  = $this->sumHour(explode(":",date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60)) ,$this->startDay);
//        }
//    }
    public function setHour(Request $request) {
        //$hour  = $this->startDay;
        if (($request->get("timeFrom") != "" and $request->get("timeTo") != "") ) {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $timeTo = explode(":",$request->get("timeTo"));
            $hourFrom = $this->sumHour($timeFrom,$this->startDay);
            $hourTo = $this->sumHour($timeTo,$this->startDay);
            $this->hourStart = $hourFrom;
            $this->hourEnd = $hourTo;



        }
        else if ($request->get("timeTo") != ""){
            $timeTo = explode(":",$request->get("timeTo"));
            $hourTo = $this->sumHour($timeTo,$this->startDay);
            $hourFrom = $this->sumHour(explode(":",$this->startDay . ":00:00"),$this->startDay);
            //$moodModel->setHourTo($hourTo);
            $this->hourStart = $hourFrom;
            $this->hourEnd = $hourTo;
        }
        else if ($request->get("timeFrom") != "" ) {
            $timeFrom = explode(":",$request->get("timeFrom"));
            $hourFrom = $this->sumHour($timeFrom,$this->startDay);
            $hourTo = $this->sumHour(explode(":",date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60) ),$this->startDay);
            //$moodModel->setHourFrom($hourFrom);
            $this->hourStart = $hourFrom;
            $this->hourEnd = $hourTo;

        }
        else {
            //print "jad";
            //print date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60);
            $this->hourStart  = $this->sumHour(explode(":",$this->startDay . ":00:00"),$this->startDay);
            $this->hourEnd  = $this->sumHour(explode(":",date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60)) ,$this->startDay);
        }
        if ($request->get("sumDay") == "on" and $request->get("divMinute") > 0) {
            $this->setHourArray($request->get("divMinute"), strtotime($this->hourStart),strtotime($this->hourEnd));
            //var_dump($this->hourSum);
        }
        //print $hourFrom;

//        else {
//            $this->hourStart = $request->get("timeFrom");
//            $this->hourEnd = $request->get("timeTo");
//        }


    }
    public function setHourAI(Request $request) {
            if ($request->get("timeFrom") == "" and $request->get("timeTo") == "") {
                $this->hourStart = $this->startDay . ":00:00";
                $this->hourEnd = date("H:i:s",strtotime(  "2012-01-01 " . $this->startDay . ":00:00") - 60) ;
            }
            else if ($request->get("timeFrom") != "" and $request->get("timeTo") == "") {

                $this->hourStart = $request->get("timeFrom");
                $this->hourEnd = date("H:i:s",strtotime("2012-01-01 " . $this->startDay . ":00:00") - 60);
            }
            else if ($request->get("timeFrom") == "" and $request->get("timeTo") != "") {
                $this->hourStart = $this->startDay . ":00:00";
                $this->hourEnd = $request->get("timeTo");
            }
            else {
                $this->hourStart = $request->get("timeFrom");
                $this->hourEnd = $request->get("timeTo");
            }

        $div = explode(":",$this->hourEnd);

        if ($div[0] < 8) {
            //print "sdfsdf";
            $this->boolHourEnd = true;
        }
            //print $this->hourStart  . ";;;" . $this->hourEnd;

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
