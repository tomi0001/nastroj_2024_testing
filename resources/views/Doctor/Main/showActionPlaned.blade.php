<table class="actionShow showAction">
            <thead >
                <tr>
                    <td colspan="4" class="center boldTitle">
                        AKCJE ZAPLANOWANE
                    </td>
                </tr>
                
                
                
            </thead>
                            <thead class="titleTheadAction">
                <tr class="bold">
                    <td class=" showAction center" style="width: 50%;  border-right-style: hidden;" >
                        nazwa
                    </td>
                    <td class=" showAction center" style="width: 20%;">
                        godzina
                    </td>
                    <td class="sizeTableMood showAction center" style="width: 20%;">
                        Długość
                    </td>
                    <td class="sizeTableMood showAction center" style="width: 10%;">
                        poziom przyjemności
                    </td>

                    
                </tr>
                </thead>
                
               
                @foreach ($actionPlan as $list)
                    <tr >
                        <td  class=" showAction tdAction center">
                            <div class='positionAction leveAction{{\App\Http\Services\Common::setColorPleasure($list->level_pleasure)}}'>{{$list->name}}</div>
                        </td>
                        <td  class=" showAction center tdAction ">
                            <a onclick="atHourActonPlan('{{ route('ajax.atHourActonPlan')}}',{{$list->id}})" style='cursor:pointer;'>{{substr($list->date,11,-3)}}</a>
                            <div id='actionPlan{{$list->id}}'></div>
                        </td>
                        <td  class=" showAction center tdAction ">
                            @if ($list->longer == "")
                                0 minut
                            @else
                            {{$list->longer}} minut
                            @endif
                        </td>
                        <td  class=" showAction center">
                            {{$list->level_pleasure}}
                        </td>
                    </tr>
                    
                    
                @endforeach
                
        </table>
    