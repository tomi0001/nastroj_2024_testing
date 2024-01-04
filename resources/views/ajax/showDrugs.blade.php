<div class="titleDrugsShowAjax">
    &nbsp;
</div>

@if (count($listDrugsAt) > 0)
    

    
    <table class="actionShowIdMood">
    <thead>
        <tr>
            <td class="titleDrugs" style="opacity: 0.5;">
                Nazwa produktu
            </td>
            <td class="titleDrugs" style="opacity: 0.5;">
                dawka
            </td>
            <td class="titleDrugs" style="opacity: 0.5;">
                Godzina wzięcia
            </td>
        </tr>
    </thead>
@foreach ($listDrugsAt as $list)
<tr>
    <td> {{$list->name}} </td>
    <td> 
        {{$list->portion}} {{\App\Http\Services\Common::showDoseProduct($list->type)}}
    </td>
    <td> 
        {{substr($list->date,11,-3)}}
    </td>
</tr>
@endforeach
</table>
<hr class="drugs">

@endif


<table class="actionShowIdMood">
    <thead>
        <tr>
            <td class="titleDrugs" >
                Nazwa produktu
            </td>
            <td class="titleDrugs">
                dawka
            </td>
            <td class="titleDrugs">
                Godzina wzięcia
            </td>
        </tr>
    </thead>
@foreach ($listDrugs as $list)
<tr>
    <td> {{$list->name}} </td>
    <td> 
        {{$list->portions}} {{\App\Http\Services\Common::showDoseProduct($list->type)}}
    </td>
    <td> 
        {{substr($list->date,11,-3)}}
    </td>
</tr>
@endforeach
</table>
