@extends('Doctor.Layout.Search')

@section('content')



    @section ('title') 
    Wyszukiwanie
    @endsection

    @if ($count == 0 )
        <div class="countSearch error">
            Ilość wyników  {{$count}}
        </div>
        <br>
        <div class='center'>
        <a href="javascript:history.back()"><button class="btn-mood mood" >WSTECZ</button></a>
        </div>   
    @else
        <div class="countSearch notError">
              Ilość wyników  {{$count}}
          </div>


        <br> 
      
        <div class='tableSearchMood' id="ajaxData">
            <div class="titleSearchResult titleSearchResultMood">WYSZUKIWANIE</div>
            
                @for ($i=0;$i < count($arrayList);$i++)
                
                @if ($i == 0 or $arrayList[$i]->dateDay != $arrayList[$i-1]->dateDay)
                <div class="moodSearchResult">
                    <div class="dayMood">Dzień  {{$arrayList[$i]->dateDay}}
                    
                        @switch ($arrayList[$i]->dayweek)
                        
                        

                            @case (0)
                                Poniedziałek
                                @break
                            @case (1)
                                Wtorek
                                @break
                            @case (2)
                                Środa
                                @break
                            @case (3)
                                Czwartek
                                @break
                            @case (4)
                                Piątek
                                @break
                            @case (5)
                                Sobota
                                @break
                            @case (6)
                                Niedziela
                                @break
                            
                        @endswitch
                        
                    </div>  
                    <div style="margin-left: 5%; margin-right: 5%; margin-top: 2%; margin-bottom: 1%;">
                         <div class="divAtButtonDay">
                            <button  class=" buttonSearch btn-mood  mood" onclick="showDayMood('{{route("doctor.allDayMood")}}','{{$arrayList[$i]->dateDay}}')">Wartość nastroji dla dnia</button>
                            @if (count(\App\Models\Usee::listSubstnace($arrayList[$i]->dateDay, Auth::User()->id_users,Auth::User()->start_day)) > 0)
                            <button  class="buttonSearch btn-mood  drugs" onclick="showDaySubstance('{{route("doctor.allSubstanceDay")}}','{{$arrayList[$i]->dateDay}}')">Substancje dla danego dnia</button>
                            @else
                            <button  style="  width: 200px;" type="button" class="buttonSearch disable "  disabled >nie było substancji</button>
                            @endif
                            
                            @if ((\App\Models\Mood::ifActionForDayMood($arrayList[$i]->dateDay, Auth::User()->id_users,Auth::User()->start_day)) > 0)
                            <button  class="buttonSearch btn-mood  action" onclick="showDayAction('{{route("doctor.allActionDay")}}','{{$arrayList[$i]->dateDay}}')">Akcje dla danego dnia</button>
                            @else
                            <button  style="  width: 200px;" type="button" class="buttonSearch disable "  disabled >nie było akcji</button>
                            @endif
                            <a href="{{route("doctor.main")}}/{{str_replace("-","/",$arrayList[$i]->dateDay)}}" target="_blank"><button class="buttonSearch btn-mood  day" >IDŹ DO DNIA</button></a>
                        </div>
                        <div style="clear: both;"></div>
                        <br>
                        
                        <div class='showAjaxDay'>
                            <div id="dayMood{{$arrayList[$i]->dateDay}}" style="display: none; float: left; margin-right: 10px;">

                            </div>
                            <div  id="daySubstance{{$arrayList[$i]->dateDay}}" style="float: left; display: none; margin-right: 10px;">
                                
                            </div>
                            <div style="clear: both;"></div>
                            <div  id="dayAction{{$arrayList[$i]->dateDay}}" class='divActionSum' style="float: left; display: none; margin-right: 10px; ">
                                
                            </div>
                        </div>
                    </div>
                    <table>
                        
                        <thead >
                <tr class="bold">
                    <td style="width: 10%;"></td>
                    <td style="width: 2%;">
                        
                    </td>
                    <td class="start showMood titleTheadMood center" style="width: 25%;" >
                        Nazwa akcji
                    </td>
                    <td class="start showMood titleTheadMood center" style="width: 25%;">
                        Godzina
                    </td>
                    <td class="start showMood titleTheadMood center" style="width: 25%;">
                       Poziom przyjemności
                    </td>
                    <td >
                        
                    </td>
                    <td style="width: 3%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                </thead>
               
            
              
       
                @endif
                
                <tr class='moodClass{{$arrayList[$i]->id}}'>
                     <td></td>
                     <td ></td>
                    <td  class="sizeTableMood showMood ">
                       
                        
                           <div class="actionDay">
                                 
                                    
                        <span class="fontMood" >    {{$arrayList[$i]->name}} </span>
                                  

                           </div>
                       
                      
                     
                        
                    </td>
                    <td  class="sizeTableMood showMood ">
                              <div class="actionDay">
                                    
                                        {{date("H:i",strtotime($arrayList[$i]->date))}}
                                         </div>
                                  
                    </td>
                    <td  class="sizeTableMood showMood ">
                        <div class="actionDay">
                            {{$arrayList[$i]->level_pleasure}}
                             </div>
                       
                    </td>
                     <td ></td>
                     <td></td>
                </tr>
                <tr >
                    <td  colspan="11">
                        <div  class="hiddenMood descriptionShowMood{{$arrayList[$i]->id}}" style="display: none;">
                            
                            <div id="messageDescriptionshowMood{{$arrayList[$i]->id}}" class="descriptionModShowMood"></div>
                        </div>
                    </td>
                
                </tr>
                <tr >
                    <td  colspan="11">
                        <div  class="hiddenMood actionShow{{$arrayList[$i]->id}}" style="display: none;">
                            
                            <div id="messageactionShow{{$arrayList[$i]->id}}" class="actionShowModShow">
                                
                                
                            </div>
                            <br>
                        </div>
                    </td>
                
                </tr>      
                <tr >
                    <td  colspan="11">
                        <div  class="hiddenMood drugsShow{{$arrayList[$i]->id}}" style="display: none;">
                            
                            <div id="messagedrugsShow{{$arrayList[$i]->id}}" class="drugssShowModShow">
                                
                                
                            </div>
                            <br>
                        </div>
                    </td>
                
                </tr>
                @if ($i == count($arrayList)-1 or $arrayList[$i]->dateDay != $arrayList[$i+1]->dateDay)
                  
                    </table>
                    <div class="dayMoodEnd"></div>  
                </div>
                @endif
                
                @endfor
                <div class="d-flex justify-content-center">
                        @php 
                        $arrayList->appends(['sort'=>Request::get('sort')])
                        ->appends(['dateFrom'=>Request::get("dateFrom")])
                        ->appends(['dateTo'=>Request::get("dateTo")])
                        ->appends(['timeFrom'=>Request::get("timeFrom")])
                        ->appends(['timeTo'=>Request::get("timeTo")])
                        ->appends(["action" => Request::get("action")])
                        ->appends(['sort2'=>Request::get("sort2")])
                        
                        ->appends(['day1'=>Request::get("day1")])
                        ->appends(['day2'=>Request::get("day2")])
                        ->appends(['day3'=>Request::get("day3")])
                        ->appends(['day4'=>Request::get("day4")])
                        ->appends(["day5" => Request::get("day5")])
                        ->appends(['day6'=>Request::get("day6")])
                        ->appends(['day7'=>Request::get("day7")])
                        ->links();
                        @endphp
                        {{$arrayList}}
                </div>
         
        </div>

    
    @endif



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

@endsection