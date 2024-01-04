
        <table class="actionShow showAction">
            <thead >
                <tr>
                    <td colspan="5" class="center boldTitle">
                        AKCJE CAŁODNIOWE
                    </td>
                </tr>
                
                
                
            </thead>
                            <thead class="titleTheadAction">
                <tr class="bold">
                    <td class=" showAction center" style="width: 50%; border-right-style: hidden;" colspan="1" >
                        nazwa
                    </td>
                    <td colspan="2">
                        
                    </td>
                    <td class=" showAction center" style="width: 40%;">
                        godzina
                    </td>
                    <td class="sizeTableMood showAction center" style="width: 10%;">
                        poziom przyjemności
                    </td>

                    
                </tr>
                </thead>
                
               
                @foreach ($actionForDay as $list)
                    <tr id="tractionId{{$list->id}}">
                        <td  class=" showAction tdAction center">
                            <div class='positionAction leveAction{{\App\Http\Services\Common::setColorPleasure($list->level_pleasure)}}' id="editActionDay{{$list->id}}">{{$list->name}}
                       
                            </div>
                        </td>
                        <td class=" showAction tdAction center">
                            <div>
                                <a id="deleteActionDayButton{{$list->id}}" onclick="deleteActionDay('{{route('ajax.deleteActionDay')}}',{{$list->id}})"><button class="danger small main">USUŃ</button></a>
                                <a id="updateActionDayButton{{$list->id}}" onclick="updateActionDay('{{route('ajax.updateActionDay')}}',{{$list->id}})" style="display: none;"><button class="updateAction small main">UAKTUALNIJ</button></a>
                            </div>
                        </td>
                        <td class=" showAction tdAction center">
                            <div>
                                <a  id="cancelActionDayButton{{$list->id}}" onclick="cancelActionDay('{{route('ajax.cancelActionDay')}}',{{$list->id}})" style="display: none;"><button class=" btn-actionDay small main">ANULUJ</button></a>
                                <a  id="editActionDayButton{{$list->id}}" onclick="editActionDay('{{route('ajax.editActionDay')}}',{{$list->id}},{{$list->idAction}})" ><button class=" btn-actionDay small main">EDYTUJ</button></a>
                            </div>
                        </td>
                        <td  class=" showAction center tdAction ">
                            {{substr($list->date,11,-3)}}
                        </td>
                        <td  class=" showAction center">
                            {{$list->level_pleasure}}
                        </td>
                    </tr>
                    
                    
                @endforeach
                
        </table>
    