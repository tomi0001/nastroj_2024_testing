@extends('Layout.Search')

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
                
               
                <div class="moodSearchResult">
                    <div class="dayMood">Dzień  {{$arrayList[$i]["dat"]}}    
                        
                        
                        @switch (date("w",strtotime($arrayList[$i]["dat"])))
                        
                        

                            @case (1)
                                Poniedziałek
                                @break
                            @case (2)
                                Wtorek
                                @break
                            @case (3)
                                Środa
                                @break
                            @case (4)
                                Czwartek
                                @break
                            @case (5)
                                Piątek
                                @break
                            @case (6)
                                Sobota
                                @break
                            @case (0)
                                Niedziela
                                @break
                            
                        @endswitch
                     
                    
                    
                    </div>  
                    <div style="margin-left: 5%; margin-right: 5%; margin-top: 2%; margin-bottom: 1%;">
                         <div class="divAtButtonDay">
                            <button  class=" buttonSearch btn-mood  mood" onclick="showDayMood('{{route("search.allDayMood")}}','{{$arrayList[$i]["dat"]}}')">Wartość nastroji dla dnia</button>
                            @if (count(\App\Models\Usee::listSubstnace($arrayList[$i]["dat"], Auth::User()->id,Auth::User()->start_day)) > 0)
                            <button  class="buttonSearch btn-mood  drugs" onclick="showDaySubstance('{{route("search.allSubstanceDay")}}','{{$arrayList[$i]["dat"]}}')">Substancje dla danego dnia</button>
                            @else
                            <button  style="  width: 200px;" type="button" class="buttonSearch disable "  disabled >nie było substancji</button>
                            @endif
                            
                            @if ((\App\Models\Mood::ifActionForDayMood($arrayList[$i]["dat"], Auth::User()->id,Auth::User()->start_day)) > 0)
                            <button  class="buttonSearch btn-mood  action" onclick="showDayAction('{{route("search.allActionDay")}}','{{$arrayList[$i]["dat"]}}')">Akcje dla danego dnia</button>
                            @else
                            <button  style="  width: 200px;" type="button" class="buttonSearch disable "  disabled >nie było akcji</button>
                            @endif
                            <a href="{{route("users.main")}}/{{str_replace("-","/",$arrayList[$i]["dat"])}}" target="_blank"><button class="buttonSearch btn-mood  day" >IDŹ DO DNIA</button></a>
                        </div>
                        <div style="clear: both;"></div>
                        <br>
                        
                        <div class='showAjaxDay'>
                            <div id="dayMood{{$arrayList[$i]["dat"]}}" style="display: none; float: left; margin-right: 10px;">

                            </div>
                            <div  id="daySubstance{{$arrayList[$i]["dat"]}}" style="float: left; display: none; margin-right: 10px;">
                                
                            </div>
                            <div style="clear: both;"></div>
                            <div  id="dayAction{{$arrayList[$i]["dat"]}}" class='divActionSum' style="float: left; display: none; margin-right: 10px; ">
                                
                            </div>
                        </div>
                    </div>
                    <table>
                        
                        <thead >
                <tr class="bold">
                    <td>{{\App\Http\Services\Common::calculateHourOne($arrayList[$i]["minutes"])}}</td>
                        
                </tr>
                </thead>
               
            
              
       
   
                  
                    </table>
                    <div class="dayMoodEnd"></div>  
                </div>
               
                
                @endfor

         
        </div>

    
    @endif



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

@endsection