<?php

/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\Doctor\Search;

use Illuminate\Http\Request;
use App\Models\User as MUser;
use Hash;
use App\Http\Services\SearchMood;
use App\Http\Services\SearchMoodAI;
use App\Models\Mood;
use Auth;
use \Illuminate\Pagination\Paginator;
use IlluminatePaginationPaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use IlluminateSupportCollection;
class SearchMoodController {
        public function paginate($items, $perPage = 5, $page = null, $options = [])

    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof \Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    }
    public function searchActionDay(Request $request) {
        $SearchMood = new SearchMood(1);
         $SearchMood->setDayWeek($request);
        $result = $SearchMood->createQuestionActionDay($request);
       
         return View("Doctor.Search.Mood.searchResultActionDay")->with("arrayList",$result)->with("count",$SearchMood->count);
        
    }
    public function searchSleepSubmit(Request $request) {
        
        $SearchMood = new SearchMood(1);
        $SearchMood->checkErrorSleep($request);
        if (count($SearchMood->errors) > 0) {
            return View("Doctor.Search.Mood.error")->with("errors",$SearchMood->errors);
        }
        else {
            $result = $SearchMood->createQuestionSleep($request);
            if ($SearchMood->count > 0) {
                 $arrayPercent = $SearchMood->sortMoods($result);
            } else {
                 $arrayPercent = [];
            }
            return View("Doctor.Search.Mood.searchResultSleep")->with("arrayList", $result)->with("count", $SearchMood->count)->with("percent", $arrayPercent);
            
        }
    }
    public function searchMoodSubmit(Request $request) {
        
        $SearchMood = new SearchMood(1);
        $SearchMood->checkError($request);
        if (count($SearchMood->errors) > 0) {
            return View("Doctor.Search.Mood.error")->with("errors",$SearchMood->errors);
        }
        else {
            if ($request->get("groupDay") == "on" and  (empty($request->get("action")[0])  ) ) {
                
                $result = $SearchMood->createQuestionGroupDay($request);
                if ($SearchMood->count > 0) {
                    $arrayPercent = $SearchMood->sortMoods($result);
                } else {
                    $arrayPercent = [];
                }
                return View("Doctor.Search.Mood.searchResultMoodGroupDay")->with("arrayList", $result)->with("count", $SearchMood->count)->with("percent", $arrayPercent);
            }
            else if ($request->get("groupDay") == "on" and  (!empty($request->get("action"))  ) ) {
                
                $result = $SearchMood->createQuestion($request,true);
                $newArray = $SearchMood->groupActionDay($result);
                
                //$paginator = new LengthAwarePaginator($newArray, count($newArray), 15, 1);
             
                //$myCollectionObj = collect($newArray);

                $data = $this->paginate($newArray,15);
                $data->withPath(route('search.searchMoodSubmit'));
                if ($SearchMood->count > 0) {
                    $arrayPercent = $SearchMood->sortMoodsGroupAction($newArray);
                } else {
                    $arrayPercent = [];
                }
                return View("Doctor.Search.Mood.searchResultMoodGroupAction")->with("arrayList", $data)->with("count", $SearchMood->count)->with("percent", $arrayPercent);
            
            }
            else if ($request->get("sumDay") == "on") {
                $result = $SearchMood->createQuestion($request,true);
                $newArray = $SearchMood->groupActionDay($result);
                $sumDays = $SearchMood->sumDays($newArray);
                $SearchMood->setDate($request->get("dateFrom"),$request->get("dateTo"));
                $sumAction = Mood::sumActionAll($SearchMood->dateFrom,$SearchMood->dateTo,Auth::User()->id, Auth::User()->start_day);
                return View("Doctor.Search.Mood.searchResultMoodSumDay")
                    ->with("arrayList", $sumDays)->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"))
                    ->with("timeFrom",$request->get("timeFrom"))->with("timeTo",$request->get("timeTo"))
                    ->with("moodFrom",$request->get("moodFrom"))->with("moodTo",$request->get("moodTo"))
                    ->with("anxientyFrom",$request->get("anxientyFrom"))->with("anxientyTo",$request->get("anxientyTo"))
                    ->with("voltageFrom",$request->get("voltageFrom"))->with("voltageTo",$request->get("voltageTo"))
                    ->with("stimulationFrom",$request->get("stimulationFrom"))->with("stimulationTo",$request->get("stimulationTo"))
                    ->with("longMoodFrom",$request->get("longMoodHourFrom") . ":" . $request->get("longMoodMinuteFrom"))
                    ->with("longMoodTo",$request->get("longMoodHourTo") . ":" . $request->get("longMoodMinuteTo"))
                    ->with("actionSum",$sumAction);
            }
            else if ( ($request->get("groupWeek") == "on") ) {
                $SearchMoodAI = new SearchMoodAI(Auth::User()->id_users,Auth::User()->start_day);
                $SearchMood->setDate($request->get("dateFrom"),$request->get("dateTo"));
                         $arrayWeek = $SearchMoodAI->createWeek($SearchMood->dateFrom,$SearchMood->dateTo);
                         //var_dump($arrayWeek);
                  $SearchMood->createQuestionForWeekList($request,$arrayWeek,true);
                  //print ("<pre>");
                  //print_r ($SearchMood->listWeek);
//                                 print("<pre>");
//                print_r($sort);
                 return View("Doctor.Search.Mood.searchResultMoodGroupWeek")
                    ->with("arrayList", $SearchMood->listWeek)->with("dateFrom",$request->get("dateFrom"))->with("dateTo",$request->get("dateTo"))
                    ->with("timeFrom",$request->get("timeFrom"))->with("timeTo",$request->get("timeTo"))
                    ->with("moodFrom",$request->get("moodFrom"))->with("moodTo",$request->get("moodTo"))
                    ->with("anxientyFrom",$request->get("anxientyFrom"))->with("anxientyTo",$request->get("anxientyTo"))
                    ->with("voltageFrom",$request->get("voltageFrom"))->with("voltageTo",$request->get("voltageTo"))
                    ->with("stimulationFrom",$request->get("stimulationFrom"))->with("stimulationTo",$request->get("stimulationTo"))
                    ->with("longMoodFrom",$request->get("longMoodHourFrom") . ":" . $request->get("longMoodMinuteFrom"))
                    ->with("longMoodTo",$request->get("longMoodHourTo") . ":" . $request->get("longMoodMinuteTo"))
                    ->with("actionSum",$SearchMood->listAction)->with("arrayWeek",$arrayWeek);
            }
            else {
                $result = $SearchMood->createQuestion($request);
                if ($SearchMood->count > 0) {
                    $arrayPercent = $SearchMood->sortMoods($result);
                } else {
                    $arrayPercent = [];
                }
                return View("Doctor.Search.Mood.searchResultMood")->with("arrayList", $result)->with("count", $SearchMood->count)->with("percent", $arrayPercent);
            }
        }
    }
    public function allDayMood(Request $request) {
        $sumAll = Mood::sumAll($request->get("date"),Auth::User()->start_day,  Auth::User()->id_users);
        return  View("Doctor.Search.Mood.showAllDayMood")->with("sumAll",$sumAll);
    }
    public function allActionDay(Request $request) {

        $sumAction = Mood::sumAction($request->get("date"),Auth::User()->id_users, Auth::User()->start_day);
        return View("Users.Search.Mood.showAllDayAction")->with("actionSum",$sumAction);
    }
    public function averageMoodSumSubmit(Request $request) {
            $SearchMoodAI = new SearchMoodAI(Auth::User()->id_users,Auth::User()->start_day);
            $SearchMoodAI->checkError($request);
            if (count($SearchMoodAI->errors) > 0) {
                return View("ajax.error")->with("error",$SearchMoodAI->errors);
            }
            else {
                //print $request->get("dateFrom");
                $SearchMoodAI->setVariable($request);
                $SearchMoodAI->setDayWeek($request);
                $SearchMoodAI->setHour($request);
//                $SearchMoodAI->setHourAI($request);
//                if ($request->get("sumDay") == "on" and $request->get("divMinute") > 0) {
//                    $SearchMoodAI->setHourSumDay($request);
//                }
//                else {
                    //$SearchMoodAI->se
                 
                    //return;
                if ($request->get("sumDay") == "on" and $request->get("divMinute") > 0) {
                    $j = 0;
                    for ($i=0;$i < count($SearchMoodAI->hourSum)-1;$i++) {
                        //$minMax = $SearchMoodAI->createQuestions($request);
                        $minMax[$i] = $SearchMoodAI->createQuestionsMinuteSumDay($request,$SearchMoodAI->hourSum[$i],$SearchMoodAI->hourSum[$i+1]);
                        if (count($minMax[$i]) > 0) {
                            //print "dd";
                            $sum[$j] = $SearchMoodAI->sortSumDayMinute($minMax[$i],$SearchMoodAI->hourSum[$i],$SearchMoodAI->hourSum[$i+1]);
                            $j++;
                        }
                        
                    }
                    if (empty($sum)) {
                        goto END;
                    }
                     
                    //$list = $SearchMoodAI->createQuestionsMinuteSumDay($request);
                    //$minMax = $SearchMoodAI->createQuestions($request);
                }
                else {
                    
                    $minMax = $SearchMoodAI->createQuestions($request);
                }
                //$list = $SearchMoodAI->createQuestionsMinMax($request);
//                print("<pre>");
//                print_r($minMax);
           

                if (count($minMax) > 0) {
                    if ( ($request->get("groupWeek") == "on") ) {
                         $arrayWeek = $SearchMoodAI->createWeek($SearchMoodAI->dateFrom,$SearchMoodAI->dateTo);
                    
                    $sort = $SearchMoodAI->sortWeek($minMax,$arrayWeek);
//                                 print("<pre>");
//                print_r($sort);
                        return View("Doctor.Search.Mood.AverageMoodGroupWeek")->with("minMax", $sort)
                            ->with("timeFrom", $request->get("timeFrom"))->with("timeTo", $request->get("timeTo"))
                            ->with("dateFrom", $request->get("dateFrom"))->with("dateTo", $request->get("dateTo"))
                            ->with("week", $SearchMoodAI->dayWeek);
                    }
                    else if ($request->get("sumDay") == "on" and $request->get("divMinute") == 0) {
                        $sum = $SearchMoodAI->sortSumDay($minMax);
                        return View("Doctor.Search.Mood.AverageMoodSumDay")->with("minMax", $sum)
                            ->with("timeFrom", $request->get("timeFrom"))->with("timeTo", $request->get("timeTo"))
                            ->with("dateFrom", $request->get("dateFrom"))->with("dateTo", $request->get("dateTo"))
                            ->with("week", $SearchMoodAI->dayWeek);
                    }
                    else if ($request->get("sumDay") == "on" and $request->get("divMinute") >  0) {
                        
                        return View("Doctor.Search.Mood.AverageMoodSumDayMinute")->with("minMax", $sum)
                            ->with("timeFrom", $request->get("timeFrom"))->with("timeTo", $request->get("timeTo"))
                            ->with("dateFrom", $request->get("dateFrom"))->with("dateTo", $request->get("dateTo"))
                            ->with("week", $SearchMoodAI->dayWeek)->with("startDay",Auth::User()->start_day);
                    }
                    else {
                        return View("Doctor.Search.Mood.AverageMood")->with("minMax", $minMax)
                            ->with("timeFrom", $request->get("timeFrom"))->with("timeTo", $request->get("timeTo"))
                            ->with("dateFrom", $request->get("dateFrom"))->with("dateTo", $request->get("dateTo"))
                            ->with("week", $SearchMoodAI->dayWeek);
                    }
                }
                else {
                    END:
                    return View("ajax.error")->with("error",["Nic nie wyszukano"]);
                }
//                for ($i=0;$i < count($minMax["mood"]);$i++) {
//                    print "<br>" .  $minMax["mood"][$i] . "/" . $minMax["dat_end"][$i];
//                }
//                print "<br><br>";
//                for ($i=0;$i < count($list);$i++) {
//                    print "<br>" . "///" . $list[$i]->dat_end;
//                }
//                print "<br><br><br><br>";

                //print count($minMax["mood"]) . "/" . count($list) . "<br>";

            }

    }
//    public function searchMoodAjaxSubmit(Request $request) {
//        $SearchMood = new SearchMood;
//
//
//
//            $result = $SearchMood->createQuestion($request);
//            if ($SearchMood->count > 0) {
//                $arrayPercent = $SearchMood->sortMoods($result);
//            }
//            else {
//                $arrayPercent = [];
//            }
//            return View("Users.Search.Mood.seachResultMoodAjax")->with("arrayList",$result)->with("count",$SearchMood->count)->with("percent",$arrayPercent)->render();
//
//
//    }
}
