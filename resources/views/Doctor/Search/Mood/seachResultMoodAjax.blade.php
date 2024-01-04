
    <head>
        <title>Dzienniczek nastrojów - @yield('title')</title>
        

        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageSearchwidth1810.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageSearchwidth1410.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageSearchwidth1210.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageSearchwidth700.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageSearchAll.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageSearchColor.css') }}" rel="stylesheet">
        
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common1810.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common1410.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common1210.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common700.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/CommonAll.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/CommonColor.css') }}" rel="stylesheet">

      
        <link rel="stylesheet"  href="{{asset('./bootstrap-5.1.3-dist/css/bootstrap.css')}}"  >
<script src="{{asset('./bootstrap-5.1.3-dist/js/bootstrap.js')}}" ></script>

        <link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
        
        <link rel="shortcut icon" href="{{ asset('./image/icon.png')}}">
        

        
        
        <script src="{{ asset('./styles/'. config('view.styles') . '/js/pageSearch.js')}}"></script>


       <script data-ad-client="ca-pub-9009102811248163" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </head>
      

            <div class="titleSearchResult titleSearchResultMood">WYSZUKIWANIE</div>
            <table class='moodShow'>
                <thead class="titleTheadMood">
                <tr class="bold">
                    <td class="start showMood" style=" border-right-style: hidden;" >
                        Start
                    </td>
                    <td class="end showMood">
                        Koniec
                    </td>
                    <td class="sizeTableMood showMood">
                        Nastrój
                    </td>
                    <td class="sizeTableMood showMood">
                        Lęk
                    </td>
                    <td class="sizeTableMood showMood">
                        napięcie /<br>rozdrażnienie
                    </td>
                    <td class="sizeTableMood showMood">
                        Pobudzenie
                    </td>
                    <td class="center showMood" style="width: 17%;">
                        Ilośc wybudzeń /<br> Epizodów psychotycznych
                    </td>
                    
                </tr>
                </thead>
                @foreach ($arrayList as $list)
                <tr>
                    <td class="showMood start" colspan="2" style="width: 55%;">
                        <span class="left">{{date("H:i",strtotime($list->date_start) )}}</span>
                        <span class="right">{{date("H:i",strtotime($list->date_end) )}}</span>
                        <br>
                        <div class="cell{{\App\Http\Services\Common::setColor($list->level_mood)}} level" style="width: {{$percent[array_search($list->id,array_column($percent, 'id'))]["percent"]}}%">&nbsp;</div>
                        <div style="text-align: center; width: 70%;">
                        <span class="HourMood">{{\App\Http\Services\Common::calculateHour($list->date_start,$list->date_end)}}</span>
                        </div>
                    </td>
                    <td>
                        
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7" class=" ">
                        @php 
                        $arrayList->appends(['sort'=>Request::get('sort')])
                        ->appends(['moodFrom'=>Request::get("moodFrom")])
                        ->appends(['moodTo'=>Request::get("moodTo")])
                        ->appends(['anxietyFrom'=>Request::get("anxietyFrom")])
                        ->appends(['anxietyTo'=>Request::get("anxietyTo")])
                        ->appends(['voltageFrom'=>Request::get("voltageFrom")])
                        ->appends(['voltageTo'=>Request::get("voltageTo")])
                        ->appends(['stimulationFrom'=>Request::get("stimulationFrom")])
                        ->appends(['stimulationTo'=>Request::get("stimulationTo")])
                        ->appends(['dateFrom'=>Request::get("dateFrom")])
                        ->appends(['dateTo'=>Request::get("dateTo")])
                        ->appends(['timeFrom'=>Request::get("timeFrom")])
                        ->appends(['timeTo'=>Request::get("timeTo")])
                        ->appends(['longMoodFromHour'=>Request::get("longMoodFromHour")])
                        ->appends(['longMoodFromMinutes'=>Request::get("longMoodFromMinutes")])
                        ->appends(['longMoodHourTo'=>Request::get("longMoodHourTo")])
                        ->appends(['longMoodToMinutes'=>Request::get("longMoodToMinutes")])
                        ->appends(["action" => Request::get("action")])
                        ->appends(["actionsNumberFrom" => Request::get("actionsNumberFrom")])
                        ->appends(["actionsNumberTo" => Request::get("actionsNumberTo")])
                        ->appends(["descriptions" => Request::get("descriptions")])
                        ->appends(['epizodesFrom'=>Request::get("epizodesFrom")])
                        ->appends(['epizodesTo'=>Request::get("epizodesTo")])
                        ->appends(['ifDescriptions'=>Request::get("ifDescriptions")])
                        ->appends(['ifactions'=>Request::get("ifactions")])
                        ->appends(['sort2'=>Request::get("sort2")])
                        ->links();
                        @endphp
                        {{$arrayList}}

                    </td>
            </tr>
            </table>
  

    
    
