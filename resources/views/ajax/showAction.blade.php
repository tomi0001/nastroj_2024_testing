<div class="titleActionShowAjax">
    &nbsp;
</div>
<table class="actionShowIdMood">
    <thead>
        <tr>
            <td class="titleAction">
                Nazwa akcji
            </td>
            <td class="titleAction">
                Minut wykonania
            </td>
        </tr>
    </thead>
@foreach ($listAction as $list)
<tr>
    <td> <div class='positionAction leveAction{{\App\Http\Services\Common::setColorPleasure($list->level_pleasure)}}'>{{$list->name}}</div> </td>
    <td> 
        @if ($list->sum == 0 )
        <span class="warning">Mniej niż minuta</span>
        @else
        {{\App\Http\Services\Common::calculateHourOne($list->sum * 60)}}  
        @endif
    </td>
    
</tr>
@endforeach
</table>
