<script type="text/javascript" src="{{asset('./datatables.css')}}"></script>
<script type="text/javascript" src="{{asset('./datatables.js')}}"></script>




<div class="dayMoodAverage" style=" padding: 10px; ">

    <div style="margin-left: auto;margin-right: auto; ">

        <div class="dateSumDayMood">
            <div class="titleSearchSumDayMood">
                <span class="titleSearchSumDayMood">DATA</span>
            </div>
            <span class="fontSearchSumDay">
                    Od
                    @if ($dateFrom == "")
                    początku
                @else
                    {{$dateFrom}}
                @endif
                    do
                    @if ($dateTo == "")
                    końca
                @else
                    {{$dateTo}}
                @endif
                    </span>
        </div>
        <div class="dateSumDayMood">
            <div class="titleSearchSumDayMood">
                <span class="titleSearchSumDayMood">GODZINA</span>
            </div>
            <span class="fontSearchSumDay">
                    Od
                    @if ($timeFrom == "")
                    najmniejszej
                @else
                    {{$timeFrom}}
                @endif
                    do
                    @if ($timeTo == "")
                    największej
                @else
                    {{$timeTo}}
                @endif
                    </span>
        </div>
        <div class="dateSumDayMoodAverageDayWeek " >
            <div class="titleSearchSumDayMood">
                <span class="titleSearchSumDayMood">DNI TYGODNIA</span>
            </div>
            <span class="fontSearchSumDay">
                        @if (count($week) == 7)
                    <div class="dayWeekDivAverage">Wszystkie dni</div>
                @else
                    @foreach ($week as $week2)

                        @if ($week2 == 2)
                            <div class="dayWeekDivAverageOne"> Poniedziałek </div>
                        @endif

                        @if ($week2 == 3)
                            <div class="dayWeekDivAverageOne"> Wtorek </div>
                        @endif

                        @if ($week2 == 4)
                            <div class="dayWeekDivAverageOne"> Środa </div>
                        @endif

                        @if ($week2 == 5)
                            <div class="dayWeekDivAverageOne"> Czwartek </div>
                        @endif

                        @if ($week2 == 6)
                            <div class="dayWeekDivAverageOne">  Piątek </div>
                        @endif

                        @if ($week2 == 7)
                            <div class="dayWeekDivAverageOne">  Sobota </div>
                        @endif

                        @if ($week2 == 1)
                            <div class="dayWeekDivAverageOne">  Niedziela </div>
                        @endif


                    @endforeach
                @endif
                    </span>
        </div>


    </div></div>

<div class="center" style="width: 100%;">
    <table class="display  cell-border compact stripe row-border" id="tblSort">


        <thead>

        <tr class="borderTrAverageTitle">
            <th style="width:26%; text-align: center; font-weight: bold; font-size: 20px;" class="hrefSettingCursor rightBorder">

                Data
            </th>



            <th style="width:15%; text-align: center; font-weight: bold; font-size: 20px;" class="hrefSettingCursor rightBorder">
                Poziom nastroju
            </th>


            <th style="width:15%; text-align: center;  font-weight: bold; font-size: 20px;" class="hrefSettingCursor rightBorder">
                Poziom lęku
            </th>

            <th style="width:15%; text-align: center;  font-weight: bold; font-size: 20px;" class="hrefSettingCursor rightBorder">
                Poziom zdenerowania
            </th>

            <th style="width:15%; text-align: center;  font-weight: bold; font-size: 20px;" class="hrefSettingCursor rightBorder">
                Poziom pobudzenia
            </th>

            <th style="width:15%; text-align: center;" class="hrefSettingCursor">
                ilośc nastroji

            </th>
        </tr>
        </thead>
        <tbody>

        @for ($i=0;$i < count($minMax["mood"]);$i++)
            <tr class="borderTrAverage">
                <td style="text-align: center;  font-size: 18px; " class="rightBorder">
                    {{$minMax["dateStart"][$i]}} - {{$minMax["dateEnd"][$i]}}
                </td>



                <td style="text-align: center;  font-size: 18px; " class="rightBorder">
                    {{round($minMax["mood"][$i],3)}}
                </td>


                <td style="text-align: center; font-size: 18px; " class="rightBorder">
                    {{round($minMax["anxienty"][$i],3)}}
                </td>


                <td style="text-align: center;  font-size: 18px; " class="rightBorder">
                    {{round($minMax["voltage"][$i],3)}}
                </td>


                <td style="text-align: center;  font-size: 18px; " class="rightBorder">
                    {{round($minMax["stimulation"][$i],3)}}
                </td>

                <td style="text-align: center;   font-size: 18px; ">
                    {{round($minMax["count"][$i])}}

                </td>
            </tr>

        @endfor
        </tbody>

    </table>
</div>
<br><br>
<script>
    $('#tblSort').DataTable({
        columnDefs: [
            {
                targets: -1,
                className: 'dt-body-right'
            }
        ],
        "bPaginate": false,

    });
</script>
