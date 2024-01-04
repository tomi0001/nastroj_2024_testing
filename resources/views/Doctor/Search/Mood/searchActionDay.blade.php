
<div class="titleMoodSettings">
    WYSZUKAJ AKCJE CAŁODIOWĄ
</div>
<div class="bodyPage">
    <form id="searchActionDayForm" method='get' action='{{route("doctor.searchActionDay")}}'>
        <table class='table searchTableMood'>


            <tr>
                <td style='padding-top: 10px; width: 27%;'>
                    data od
                </td>
                <td>
                    <input type='date' name='dateFrom' class='form-control'>
                </td>
                <td style='padding-top: 10px;'>
                    do
                </td>
                <td>
                    <input type='date' name='dateTo' class='form-control'>
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 27%;'>
                    Godzina od
                </td>
                <td>
                    <input type='time' name='timeFrom' class='form-control'>
                </td>
                <td style='padding-top: 10px;'>
                    do
                </td>
                <td>
                    <input type='time' name='timeTo' class='form-control'>
                </td>
            </tr>
   
            <tr>
                <td style='padding-top: 10px; width: 27%;'>
                    słowa kluczowe akcji
                </td>
                <td colspan="3" >
                    <div style='clear: both;'>
                        <div id="idActionDay">
                            <div style='float: left; width:70%;'>
                                <input type='text' name='action[]' class='form-control' placeholder="nazwa">
                            </div>
                            
                        </div>
                        <div id="idActionDayCopy" style="display: none;">
                            <div style='float: left; width:70%;'>
                                <input type='text' name='action[]' class='form-control' placeholder="nazwa">
                            </div>
                           


                        </div>





                        <div style='float: left; margin-left: 20px; '>
                            <a onclick="addFieldActionDay()"  style="cursor: pointer;">
                                <div class="plusButton plusMinusButton" id='addNewAction'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_plus.png')}}"></div>
                            </a>
                        </div>
                    </div>
                </td>



            </tr>
            <tr>
                <td style='padding-top: 10px; width: 27%;'>
                    Dni
                </td>
                <td colspan="6">
                    <div style="clear:both;">
                    <div class="dayWeekDiv" >
                        <div class="dayOne" >
                            Poniedziałek
                        </div>
                        <div class="dayOne2">
                            <input type='checkbox' name='day2' class='form-check-input' checked>
                        </div>
                    </div>
                   <div class="dayWeekDiv">
                        <div class="dayOne" >
                        Wtorek
                        </div>
                        <div class="dayOne2" >
                            <input type='checkbox' name='day3' class='form-check-input' checked>
                        </div>
                    </div>
                    <div class="dayWeekDiv">
                        <div class="dayOne" >
                             Środa
                        </div>
                        <div class="dayOne2">
                            <input type='checkbox' name='day4' class='form-check-input' checked>
                        </div>
                    </div>
                         <div class="dayWeekDiv" >
                        <div class="dayOne" >
                         Czwartek
                        </div>
                        <div class="dayOne2" >
                            <input type='checkbox' name='day5' class='form-check-input' checked>
                        </div>
                    </div>
                    <div class="dayWeekDiv">
                        <div class="dayOne" >
                            Piątek
                        </div>
                        <div class="dayOne2">
                            <input type='checkbox' name='day6' class='form-check-input' checked>
                        </div>
                    </div>
                             
                    <div class="dayWeekDiv" >
                        <div class="dayOne" >
                            Sobota
                        </div>
                        <div class="dayOne2">
                            <input type='checkbox' name='day7' class='form-check-input' checked>
                        </div>
                    </div>
                    <div class="dayWeekDiv">
                        <div class="dayOne" >
                             Niedziela
                        </div>
                        <div class="dayOne2" >
                            <input type='checkbox' name='day1' class='form-check-input' checked>
                        </div>
                    </div>
     
              
                    </div>

                </td>

            </tr>
            


            <tr >
                <td style='padding-top: 10px; width: 27%;' colspan="4">
                    <div style='text-align: center;'>

                        <input type="submit" class="btn-mood  mood"  value='SZUKAJ'>
                    </div>
                </td>
            </tr>
        </table>
    </form>

</div>
<div id="averageSumDiv" class="averageSumDiv" >

</div>
<br><br>

