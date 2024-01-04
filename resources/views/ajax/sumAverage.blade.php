<div class="sumAverage">
    


    
    @for ($i=0;$i < count($listAverage);$i++)
        <div class="averageDiv">
            {{$listAverage[$i]["dateStart"]}} - {{$listAverage[$i]["dateEnd"]}} <br>
            Dawka = {{$listAverage[$i]["portions"]}} {{\App\Http\Services\Common::showDoseProduct($listAverage[$i]["type"])}}<br>
            <div class="how-type {{\App\Http\Services\Common::showColorTypeHow($listAverage[$i]["how"])}}"> ilośc wzięć = {{($listAverage[$i]["how"])}} </div> 
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
        @if (($i !=(count($listAverage) - 1  ) )    and ( strtotime($listAverage[$i]["dateStart"])  - strtotime($listAverage[$i+1]["dateEnd"]) ) >   ( 86400)  and \App\Http\Services\Common::ifChangeTimeWinterOne($listAverage[$i]["dateStart"]) == false )
        
          
       
            @php
                $daySub = \App\Http\Services\Common::calculateHourAverage(($listAverage[$i]["dateStart"]), ($listAverage[$i+1]["dateEnd"]))
            @endphp
            @if  ($daySub < 3)
                 <div class="lineAverage lineAverageNr1">przerwa  dni {{$daySub-1}}</div>
            @elseif ($daySub > 2 and $daySub < 20)
                <div class="lineAverage lineAverageNr2 ">przerwa dni {{$daySub-1}}</div>
            @else
                <div class="lineAverage lineAverageNr3 ">przerwa dni {{$daySub-1}}</div>
            
            @endif
        
          
        @endif
    @endfor
    
    
</div>