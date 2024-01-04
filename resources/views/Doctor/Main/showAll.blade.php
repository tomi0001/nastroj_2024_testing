<div id="allMoodDrugsAction">
        <div class="row">

            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="sumMood">

                    @if (  $sumAll->sum_mood !== null )
                    <div class="level level{{\App\Http\Services\Common::setColor($sumAll->sum_mood)}}" style="height: 20%; padding-top: 3px;">
                                Poziom nastroju {{(round($sumAll->sum_mood,2) == '-0') ? '0' : round($sumAll->sum_mood,3)}} dla całego dnia
                    </div>
                    <div class="level{{\App\Http\Services\Common::setColor(-$sumAll->sum_anxiety)}} level " style="height: 20%; padding-top: 3px;">
                                Poziom lęku {{( round($sumAll->sum_anxiety,2)) == '-0' ? '0' : round($sumAll->sum_anxiety,3)}} dla całego dnia
                    </div>
                    <div class="level{{\App\Http\Services\Common::setColor(-$sumAll->sum_nervousness)}} level " style="height: 20%; padding-top: 3px;">
                                Poziom napięcia {{( round($sumAll->sum_nervousness,2)) == '-0' ? '0': round($sumAll->sum_nervousness,3)}} dla całego dnia
                    </div>
                    <div class="level{{\App\Http\Services\Common::setColor($sumAll->sum_stimulation)}} level" style="height: 20%; padding-top: 3px;">
                                Poziom pobudzenia {{( round($sumAll->sum_stimulation,2) == '-0' ? '0' : round($sumAll->sum_stimulation,3))}} dla całego dnia
                    </div>
                    @else
                        <div class="errorMainMessage">
                            Nie było żadnych nastroji dla tego dnia
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="sumDrugs">
                    @if (count($listDrugs) > 0 )
                        <div class='sumDrugsAt'>
                            @foreach ($listSubstance as $list)
                                <div class='positionDrugs'>{{$list->name}}</div>
                                <div class='positionDrugsDose'>{{$list->portion}} {{\App\Http\Services\Common::showDoseProductSubstance($list->type)}}</div>
                            @endforeach
                        </div>
                    @else
                        <div class="errorMainMessage">
                            Nie było żadnych leków dla tego dnia
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="sumAction">
                    @if (strTotime($date) <= strToTime(date("Y-m-d") ) )
                        @if (count($actionForDay) > 0)
                            <div class='sumDrugsAt'>
                                @foreach ($actionForDay as $list)


                                     <div class='positionAction leveAction{{\App\Http\Services\Common::setColorPleasure($list->level_pleasure)}}'>{{$list->name}}</div>


                                @endforeach
                            </div>
                        @else
                            <div class="errorMainMessagesmall">
                                Nie ma żadnych akcji całodniowych dla tego dnia
                            </div>
                        @endif
                    @else
                        @if (count($actionPlan) > 0)
                            <div class='sumDrugsAt'>
                                @foreach ($actionPlan as $list)


                                     <div class='positionAction leveAction{{\App\Http\Services\Common::setColorPleasure($list->level_pleasure)}}'>{{$list->name}}</div>
                                     <div class="hourPlan">Godzina <b>{{substr($list->date,11,-3)}}</b></div>


                                @endforeach
                            </div>
                        @else
                            <div class="errorMainMessagesmall">
                                Nic nie jest zaplanowane na ten dzień
                            </div>
                        @endif
                    @endif
                </div>
            </div>



        </div>
</div>
<br>
