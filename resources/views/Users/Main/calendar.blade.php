<div id="calendar">

	<table  align=center class='kalendar'>
	  <tr>
	    <td colspan=7><div align=center><span class="kalendarBig">{{$text_month}} {{$year}}</span></div></td>
	  </tr>
	  <tr>
	    <td><div align=center><span class="kalendar">Pon</span></div></td>
	    <td><div align=center><span class="kalendar">Wto</span></div></td>
	    <td><div align=center><span class="kalendar">śro</span></div></td>
	    <td><div align=center><span class="kalendar">Czwa</span></div></td>
	    <td><div align=center><span class="kalendar">Pią</span></div></td>
	    <td><div align=center><span class="kalendar">Sob</span></div></td>
	    <td><div align=center><span class="kalendar">Nie</span></div></td>
	  </tr>
	  <tbody>

@php
$tmp = -10;
@endphp
  @while ( $day2 <= $how_day_month) 

    <tr class='trCalendar'>
    
    @for ($cols=0;$cols < 7;$cols++) 
    <td class='tdCalendar'>
      @if ($day2 <= $how_day_month ) 

	
	
        @if ($day1 >= $day_week )

            @if ( $day2 == $day3 ) 
                <div  align=center id='day_{{$day2}}' class="cell_active"><span class="active">{{$day2}}</span></div>


            @else
     
                <div onmouseover='calendarOn("day_{{$day2}}")' onmouseout='calendarOff("day_{{$day2}}")' align=center id='day_{{$day2}}' class="cell{{$color[$day2-1]}} cell cellBorder mainHref" onclick="LoadPage('{{route('users.main')}}/{{$year}}/{{$month}}/{{$day2}}')"><a  class="no_active " href="{{route('users.main')}}/{{$year}}/{{$month}}/{{$day2}}  ">{{$day2}} <div class='howAction'> {{empty($listPlanedAction[$day2-1])? '' :  $listPlanedAction[$day2-1]->how  }}</div></a></div>
                
            @endif
            </td>
            @php
                
                $day2++;
            @endphp
            
       
        
        
       
        @endif
	@php 
        $day1++;
	@endphp
	
      @endif
        
    @endfor
    </tr>

  @endwhile
  <tr>

</table>
</div>
<br>


<div class="row center">
  <div class="col-md-0 col-lg-2 "></div>
  <div class="col-md-3 col-xs-3 col-lg-2">
      <button class="calendar mainHref" onclick=location.href="{{ route('users.main')}}/{{$back[0]}}/{{$back[1]}}/1/">Miesiąc Wstecz</button>
  </div>
  <div class="col-md-3 col-xs-3 col-lg-2 ">
          <button class="calendar mainHref" onclick=location.href="{{ route('users.main')}}/{{$back_year[0]}}/{{$back_year[1]}}/1/">Rok Wstecz</button>
  </div>
  <div class="col-md-3 col-xs-3 col-lg-2 ">
      <button class="calendar mainHref" onclick=location.href="{{ route('users.main')}}/{{$next_year[0]}}/{{$next_year[1]}}/1/">Rok Dalej</button>
      
  </div>
  <div class="col-md-3 col-xs-3 col-lg-2">
      <button class="calendar mainHref" onclick=location.href="{{ route('users.main')}}/{{$next[0]}}/{{$next[1]}}/1/">miesiąc Dalej</button>
      
      
  </div>
  
</div>


    
