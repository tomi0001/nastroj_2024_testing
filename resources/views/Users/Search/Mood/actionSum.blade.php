<div class="actionSum">
        <table class="actionShow showAction">
            <thead >
                <tr>
                    <td colspan="3" class="center boldTitle">
                        AKCJE 
                    </td>
                </tr>
                
                
                
            </thead>
                            <thead class="titleTheadAction">
                <tr class="bold">
                    <td class=" showAction center" style="width: 50%; border-right-style: hidden;" >
                        nazwa
                    </td>
                    <td class=" showAction center" style="width: 40%;">
                        Łączna ilośc czasu dla całego dnia
                    </td>
                    <td class="sizeTableMood showAction center" style="width: 40%;">
                        poziom przyjemności
                    </td>

                    
                </tr>
                </thead>
                
               
                @foreach ($actionSum[$i] as $list)
                    <tr >
                        <td  class=" showAction tdAction center">
                            <div class='positionAction leveAction{{\App\Http\Services\Common::setColorPleasure($list->level_pleasure)}}'>{{$list->name}}</div>
                        </td>
                        <td  class=" showAction center tdAction ">
                            @if ($list->sum == 0)
                            <span class="warning">Mniej niż minuta</span>
                            @else
                            {{\App\Http\Services\Common::calculateHourOne($list->sum * 60)}}
                            @endif
                        </td>
                        <td class="sizeTableMood showAction center">
                            {{$list->level_pleasure}}
                        </td>
                    </tr>
                    
                    
                @endforeach
                
        </table>
</div>