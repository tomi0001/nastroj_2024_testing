<div class="sumAverage">
    


    
    @for ($i=0;$i < count($listAverage);$i++)
        <div class="averageDiv">
            {{$listAverage[$i]["dateStart"]}} - {{$listAverage[$i]["dateEnd"]}} <br>
            Dawka = {{$listAverage[$i]["portion"]}} {{\App\Http\Services\Common::showDoseProduct($listAverage[$i]["type"])}}<br>
            ilośc wzięć = {{$listAverage[$i]["how"]}} <br>
            @php
                $diff = \App\Http\Services\Common::calculateHourAverage(date("Y-m-d",strtotime($listAverage[$i]["dateStart"]) - 8400),$listAverage[$i]["dateEnd"]);
            @endphp
            @if  ($diff == 1)
                 <div class="averageNr1 averageNr">ilośc dni {{$diff}}</div>
            @elseif ($diff > 1 and $diff < 20)
                <div class="averageNr2 averageNr">ilośc dni {{$diff}}</div>
            @else
                <div class="averageNrEnd averageNr">ilośc dni {{$diff}}</div>
            
            @endif
            
            
             <br>
        </div>
        @if (($i !=(count($listAverage) - 1  ) )    and ( strtotime($listAverage[$i]["dateStart"])  - strtotime($listAverage[$i+1]["dateEnd"]) ) >   ( 86400)   )
        
          
        <div class="lineAverage">
            
        </div>
          
        @endif
    @endfor
    
    
</div>