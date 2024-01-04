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

            @if ($i == 0 or $arrayList[$i]->dat != $arrayList[$i-1]->dat)
                <div class="drugsSearchResult">
                    <div class="dayDrugs">Dzień  {{$arrayList[$i]->dat}}</div>
                    <div style="margin-left: 5%; margin-right: 5%; margin-top: 2%; margin-bottom: 1%;">
                        <div class="divAtButtonDay">
                        <div class="firstDiv">
                            <button  style=" float: left; margin-right: 10px;"  class="btn-drugs   mood" onclick="showDayMood('{{route("doctor.allDayMood")}}','{{$arrayList[$i]->dat}}')">Wartość nastroji dla dnia</button>
                            @if (count(\App\Models\Usee::listSubstnace($arrayList[$i]->dat, Auth::User()->id_users,Auth::User()->start_day)) > 0)
                                <button style=" float: left; margin-right: 10px;" class="btn-drugs   drugs" onclick="showDaySubstance('{{route("doctor.allSubstanceDay")}}','{{$arrayList[$i]->dat}}')">Substancje dla danego dnia</button>
                            @else
                                <button style=" float: left; margin-right: 10px; width: 200px;" type="button" class="disable "  disabled >nie było substancji</button>
                            @endif

                            @if ((\App\Models\Mood::ifActionForDayMood($arrayList[$i]->dat, Auth::User()->id_users,Auth::User()->start_day)) > 0)
                                <button style=" float: left; margin-right: 10px;" class="btn-drugs   action" onclick="showDayAction('{{route("doctor.allActionDay")}}','{{$arrayList[$i]->dat}}')">Akcje dla danego dnia</button>
                            @else
                                <button style=" float: left; margin-right: 10px; width: 200px;" type="button" class="disable "  disabled >nie było akcji</button>
                            @endif
                            
                        </div>
                            <div class="secondDiv">
                                    <a href="{{route("doctor.main")}}/{{str_replace("-","/",$arrayList[$i]->dat)}}"  target="_blank"><button class="buttonSearch btn-mood  day" >IDŹ DO DNIA</button></a>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                        <br>

                        <div class='showAjaxDay'>
                            <div id="dayMood{{$arrayList[$i]->dat}}" style="display: none; float: left; margin-right: 10px;">

                            </div>
                            <div  id="daySubstance{{$arrayList[$i]->dat}}" style="float: left; display: none; margin-right: 10px;">

                            </div>
                            <div style="clear: both;"></div>
                            <div  id="dayAction{{$arrayList[$i]->dat}}" class='divActionSum' style="float: left; display: none; margin-right: 10px; ">

                            </div>
                        </div>
                    </div>
                    <table>

                        <thead >
                        <tr class="bold">
                            <td style="width: 3%;"></td>
                            <td style="width: 2%;">

                            </td>
                            <td class="sizeTableMood showDrugs titleTheadDrugs" style=" width: 25%;" >
                                Nazwa produktu
                            </td>
                            <td class="sizeTableMood showDrugs titleTheadDrugs" style="width: 32%;">
                                Substancje produktu
                            </td>
                            <td class="sizeTableMood showDrugs titleTheadDrugs" style="width: 10%;">
                                dawka
                            </td>
                            <td class="sizeTableMood showDrugs titleTheadDrugs" style="width: 10%;">
                                Ilość wzięć
                            </td>
                            <td class="sizeTableMood showDrugs titleTheadDrugs" style="width: 12%;">
                                ile kosztowało
                            </td>

                            <td >

                            </td>
                            <td style="width: 3%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        </thead>




                        @endif
                        <tr>
                            <td></td>
                            <td ></td>
                            <td class="showDrugs start sizeTableMood" >
                                <span class="fontMood" >{{$arrayList[$i]->name}}</span>
                            </td>
                            <td class="showDrugs start sizeTableMood" >
                           <span class="fontMood" >


                               @foreach (\App\Models\Substances_product::showSubstance($arrayList[$i]->id) as $list2)

                                   [{{$list2->name}}]
                                   @if ($loop->index > 3)
                                       <a onclick ="showAllSubstance('{{route('doctor.ajax.showAllSubctance')}}')">.....</a>
                                       @break
                                   @endif
                               @endforeach
                               @if (count(\App\Models\Substances_product::showSubstance($arrayList[$i]->id)) == 0)
                                   <span class="warning">Nie było żadnych substancji</span>
                               @endif

                           </span>
                                <br>

                            </td>
                            <td class="sizeTableMood showDrugs ">

                                <span class="fontMood" >{{$arrayList[$i]->portion}} {{\App\Http\Services\Common::showDoseProduct($arrayList[$i]->type)}}</span>

                            </td>
                            <td class="sizeTableMood showDrugs ">

                                <span class="fontMood"  >{{$arrayList[$i]->count}} </span>

                            </td>
                            <td class="sizeTableMood showDrugs ">

                                <span class="fontMood"  >{{$arrayList[$i]->price}} zł</span>

                            </td>


                            <td  ></td>
                            <td></td>
                        </tr>






                        @if ($i == count($arrayList)-1 or $arrayList[$i]->dat != $arrayList[$i+1]->dat)
                        <tr>
                            <td>
                                <br>
                            </td>
                        </tr>
                    </table>
                    <div class="dayDrugsEnd"></div>
                </div>
            @endif

        @endfor
        <div class="d-flex justify-content-center">
            @php
                $arrayList->appends(['sort'=>Request::get('sort')])
                        ->appends(['nameSubstance'=>Request::get('nameSubstance')])
                        ->appends(['nameProduct'=>Request::get('nameProduct')])
                        ->appends(['nameGroup'=>Request::get('nameGroup')])

                ->appends(['dateFrom'=>Request::get("dateFrom")])
                ->appends(['dateTo'=>Request::get("dateTo")])
                ->appends(['doseFrom'=>Request::get("doseFrom")])
                ->appends(['doseTo'=>Request::get("doseTo")])
                ->appends(['timeFrom'=>Request::get("timeFrom")])
                ->appends(['timeTo'=>Request::get("timeTo")])
                ->appends(['doseDay'=>'on'])
                ->appends(["whatWork" => Request::get("whatWork")])
                ->appends(['ifWhatWork'=>Request::get("ifWhatWork")])
                ->appends(['sort2'=>Request::get("sort2")])
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
