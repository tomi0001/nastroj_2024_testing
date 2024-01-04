

<div id="showmood" class="formAddMood borderMood" style="display: none;">

              <div class='titleMoodShow mood'>
                            NASTROJE
              </div>
            <table class="moodShow">
                <thead>
                <tr class="bold">
                    <td class="start showMood titleTheadMood" style=" border-right-style: hidden;" >
                        Start
                    </td>
                    <td class="end showMood titleTheadMood">
                        Koniec
                    </td>
                    <td class="sizeTableMood showMood titleTheadMood">
                        Nastrój
                    </td>
                    <td class="sizeTableMood showMood titleTheadMood"  >
                        Lęk
                    </td>
                    <td class="sizeTableMood showMood titleTheadMood">
                        napięcie /<br>rozdrażnienie
                    </td>
                    <td class="sizeTableMood showMood titleTheadMood">
                        Pobudzenie
                    </td>
                    <td class="center showMood titleTheadMood wakeUp">
                        Ilośc wybudzeń /<br> Epizodów psychotycznych
                    </td>

                </tr>
                </thead>
                <tr>
                    <td colspan="7">
                        <br>
                    </td>
                </tr>
                @foreach ($listMood as $list)


                <tr class='moodClass{{$list->id}}'>
                    <td  class="start showMood" colspan="2">
                        <span class="left"> {{substr($list->date_start,11,-3)}}</span>

                        <span class='right'>{{substr($list->date_end,11,-3)}}</span>
                        <br>

                        @if ($list->type == "sleep")
                            <div class='levelSleep level' style='width: {{$percent[(array_search($list->id,array_column($percent, 'id')))]["percent"]}}%'>&nbsp;</div>
                        @else
                            <div class='cell{{\App\Http\Services\Common::setColor($list->level_mood)}} level' style='width: {{$percent[(array_search($list->id,array_column($percent, 'id')))]["percent"]}}%'>&nbsp;</div>
                        @endif
                        <br>
                      
                        <div style="text-align: center; width: 70%;">
                        <span class="HourMood">{{\App\Http\Services\Common::calculateHour($list->date_start,$list->date_end)}}</span>
                        </div>
                    </td>
                    @if ($list->type == "mood")
                    <td class="sizeTableMood showMood ">
                        <div  class="showMenuMood{{$list->id}}">
                            <span class="fontMood" id="levelMood{{$list->id}}" >{{$list->level_mood}}</span>
                        </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            <input class="form-control" type="text" id="levelMoodEdit{{$list->id}}" value="{{$list->level_mood}}" style="width:85%;">
                        </div>
                    </td>
                    <td class="sizeTableMood showMood">
                        <div  class="showMenuMood{{$list->id}}">
                            <span class="fontMood" id="levelAnxiety{{$list->id}}">{{$list->level_anxiety}}</span>
                        </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            <input class="form-control" type="text" id="levelAnxietyEdit{{$list->id}}" value="{{$list->level_anxiety}}" style="width:85%;">
                        </div>
                    </td>
                    <td class="sizeTableMood showMood">
                        <div  class="showMenuMood{{$list->id}}">
                            <span class="fontMood" id="levelNervousness{{$list->id}}">{{$list->level_nervousness}}</span>
                        </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            <input class="form-control" type="text" id="levelNervousnessEdit{{$list->id}}" value="{{$list->level_nervousness}}" style="width:85%;">
                        </div>
                    </td>
                    <td class="sizeTableMood showMood">
                        <div  class="showMenuMood{{$list->id}}" >
                            <span class="fontMood" id="levelStimulation{{$list->id}}">{{$list->level_stimulation}}</span>
                        </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            <input class="form-control" type="text" id="levelStimulationEdit{{$list->id}}" value="{{$list->level_stimulation}}" style="width:85%;">
                        </div>
                    </td>
                    @else
                    <td class="sizeTableMood  showMood" colspan="4">
                        <span class="fontMoodNot" >Nie dotyczy</span>
                    </td>
                    @endif
                    <td class="center showMood">
                        @if ($list->type == "mood")
                            <div  class="showMenuMood{{$list->id}}">
                                @if ($list->epizodes_psychotik != 0)
                                    <span class="MessageError" id="levelEpizodes{{$list->id}}">{{$list->epizodes_psychotik}} epizodów psychotycznych</span>
                                @else
                                   <span  id="levelEpizodes{{$list->id}}"> Brak </span>
                                @endif
                            </div>
                            <div class=" showMenuEditMood{{$list->id}} " style="display: none; width: 40%; margin-left: auto; margin-right: auto; ">

                                    <input class="form-control" type="text" id="levelEpizodesEdit{{$list->id}}" value="{{$list->epizodes_psychotik}}" >

                            </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none;">
                        @else
                               <div  class="showMenuMood{{$list->id}}">
                                @if ($list->epizodes_psychotik != 0)
                                    <span class="MessageError" id="levelEpizodes{{$list->id}}">{{$list->epizodes_psychotik}} wybudzeń</span>
                                @else
                                   <span  id="levelEpizodes{{$list->id}}"> Brak </span>
                                @endif
                            </div>
                            <div class=" showMenuEditMood{{$list->id}} " style="display: none; width: 40%; margin-left: auto; margin-right: auto; ">

                                    <input class="form-control" type="text" id="levelEpizodesEdit{{$list->id}}" value="{{$list->epizodes_psychotik}}" >

                            </div>

                        @endif
                        </div>
                    </td>
                </tr>
                <tr class='moodClass{{$list->id}}'>
                    <td colspan="7" class="moodButton">
                        @if ($list->type == "mood")
                        <div class="showMenuMood{{$list->id}} ">

                                   <div class="divButton">
                                        @if (!empty(\App\Models\Usee::ifExistUsee($list->date_start,$list->date_end,Auth::User()->id) ))
                                            <button class="btn-drugs main" onclick="showDrugs('{{ route('ajax.showDrugs')}}',{{$list->id}})">pokaż leki</button>
                                        @else
                                            <button type="button" class="disable "  disabled>nie było leków</button>
                                        @endif
                                   </div>

                                   <div class="divButton">
                                        @if (!empty(\App\Models\Moods_action::ifExistAction($list->id) ))
                                            <button class="btn-action main" onclick="showAction('{{ route('ajax.showAction')}}',{{$list->id}})">pokaż akcje</button>
                                        @else
                                            <button type="button" class="disable "  disabled>nie było akcji</button>
                                        @endif
                                   </div>
                                   <div class="divButton">

                                        @if ((\App\Models\Mood::showDescription($list->id)->what_work != "" ))
                                            <button class="btn-mood main mood" onclick="showDescritionMood('{{route("ajax.showMoodDescription")}}',{{$list->id}})">pokaż  opis</button>
                                        @else
                                            <button type="button" class="disable "  disabled>nie było opisu</button>
                                        @endif
                                    </div>
                                    <div class="divButton ">

                                            <button class="btn-mood main-long mood" onclick="editMood({{$list->id}})">Edytuj nastrój</button>
                                     </div>
                                    <div class="divButton divButtonBr">

                                            <button class="btn-mood main-long mood" onclick="editMoodDescription('{{route("ajax.editMoodDescription")}}',{{$list->id}})">Edytuj Dodaj opis</button>
                                     </div>
                                   <div class="divButton">

                                            <button class="danger main" onclick="deleteMood('{{route("ajax.deleteMood")}}',{{$list->id}})">Usuń nastrój</button>
                                    </div>
                                    <div class="divButton">

                                            <button class="btn-mood main-long mood" onclick="editActionMood('{{route("ajax.editActionMood")}}',{{$list->id}})">Dodaj usuń akcje</button>
                                     </div>

                        </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none;">
                            <table  class="tableCenter"  >
                                <tr>
                                    <td style="padding-right: 7px;">

                                            <button class="btn-mood main mood" onclick="updateMood('{{route('ajax.updateMood')}}',{{$list->id}})">Uaktualnij</button>

                                    </td>
                                    <td style="padding-right: 7px;">

                                            <button class="btn-mood main mood" onclick="cancel({{$list->id}})">Anuluj</button>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        @else
                        <div class="showMenuMood{{$list->id}}">
                            <table  class="tableCenter"  >
                                <tr>




                                    <td style="padding-right: 7px;">

                                        @if ((\App\Models\Mood::showDescription($list->id)->what_work != "" ))
                                            <button class="btn-sleep main" onclick="showDescritionSleep('{{route("ajax.showMoodDescriptionSleep")}}',{{$list->id}})">pokaż  opis</button>
                                        @else
                                            <button type="button" class="disable "  disabled>nie było opisu</button>
                                        @endif
                                    </td>
                                    <td style="padding-right: 7px;">

                                            <button class="btn-sleep main-long" onclick="editMoodSleep({{$list->id}})">Edytuj Sen</button>

                                    </td>

                                    <td style="padding-right: 7px;">

                                            <button class="btn-sleep main-long" onclick="editSleepDescription('{{route("ajax.editSleepDescription")}}',{{$list->id}})">Edytuj Dodaj opis</button>

                                    </td>

                                    <td style="padding-right: 7px;">

                                            <button class="danger main" onclick="deleteSleep('{{route("ajax.deleteSleep")}}',{{$list->id}})">Usuń sen</button>

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="showMenuEditMood{{$list->id}}" style="display: none;">
                            <table  class="tableCenter"  >
                                <tr>
                                    <td style="padding-right: 7px;">

                                            <button class="btn-sleep main" onclick="updateSleep('{{route('ajax.updateSleep')}}',{{$list->id}})">Uaktualnij</button>

                                    </td>
                                    <td style="padding-right: 7px;">

                                            <button class="btn-sleep main" onclick="cancel({{$list->id}})">Anuluj</button>

                                    </td>
                                </tr>
                            </table>
                        </div>

                        @endif
                    </td>
                </tr>
                @if ($list->type == "mood")
                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMoodEdit description{{$list->id}}" style="display: none;">
                            <textarea  rows='6' class="description{{$list->id}} form-control " id="description{{$list->id}}" style="display: none; " ></textarea>
                            <button class="btn-mood main mood" onclick="updateDescription('{{route('ajax.updateDescription')}}',{{$list->id}})">Modyfikuj opis</button>
                            <div id="messageDescription{{$list->id}}"></div>
                        </div>
                    </td>

                </tr>
                @else
                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        
                        <div  class="hiddenMoodEdit descriptionSleep{{$list->id}}" style="display: none;">
                            <textarea  rows='6' class="descriptionSleep{{$list->id}} form-control " id="description{{$list->id}}" style="display: none; " ></textarea>
                            <button class="btn-mood main sleep" onclick="updateDescription('{{route('ajax.updateDescription')}}',{{$list->id}})">Modyfikuj opis</button>
                            <div id="messageDescription{{$list->id}}"></div>
                            
                        </div>
                    </td>

                </tr>
                @endif
                @if ($list->type == "sleep")
                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood descriptionShowSleep{{$list->id}}" style="display: none;">

                            <div id="messageDescriptionshowSleep{{$list->id}}" class="descriptionModShowSleep"></div>
                        </div>
                    </td>

                </tr>
                @else
                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood descriptionShowMood{{$list->id}}" style="display: none;">

                            <div id="messageDescriptionshowMood{{$list->id}}" class="descriptionModShowMood"></div>
                        </div>
                    </td>

                </tr>
                @endif
                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood actionShow{{$list->id}}" style="display: none;">

                            <div id="messageactionShow{{$list->id}}" class="actionShowModShow">


                            </div>
                            <br>
                        </div>
                    </td>

                </tr>
                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood drugsShow{{$list->id}}" style="display: none;">

                            <div id="messagedrugsShow{{$list->id}}" class="drugssShowModShow">


                            </div>
                            <br>
                        </div>
                    </td>

                </tr>

                <tr class='moodClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood actionMoodShow{{$list->id}}" style="display: none;">

                            <div id="messageactionMoodShow{{$list->id}}" class="actionMoodShowModShow">


                            </div>
                            <button class="btn-action MainEdit " onclick="updateActionForMood('{{ route('ajax.updateAction')}}',{{$list->id}})">Modyfikuj akcje</button>
                            <br><br>

                        </div>

                    </td>

                </tr>
                @endforeach
            </table>
        </div>


