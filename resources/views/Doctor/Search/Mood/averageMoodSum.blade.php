
<div class="titleMoodSettings">
    OBLICZ ŚREDNIĄ TRWANIA NASTROJU
</div>
<div class="bodyPage">
    <form id="averageSumForm" method='get'>
        <table class='table searchTableMood'>


            <tr>
                <td style='padding-top: 10px; width: 37%;'>
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
                <td style='padding-top: 10px; width: 37%;'>
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
                <td style='padding-top: 10px; width: 37%;'>
                    Rozdzielenie minut
                </td>
                <td>
                    <input type='number' name='divMinute' class='form-control' min="0" max ='1440' value="0">
                </td>


            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    słowa kluczowe akcji
                </td>
                <td colspan="3" >
                    <div style='clear: both;'>
                        <div id="idAction">
                            <div style='float: left; width:40%;'>
                                <input type='text' name='action[]' class='form-control' placeholder="nazwa">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='actionFrom[]' class='form-control' placeholder="wartość od">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='actionTo[]' class='form-control' placeholder="wartość do">
                            </div>
                        </div>
                        <div id="idActionCopy" style="display: none;">
                            <div style='float: left; width:40%;'>
                                <input type='text' name='action[]' class='form-control' placeholder="nazwa">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='actionFrom[]' class='form-control' placeholder="wartość od">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='actionTo[]' class='form-control' placeholder="wartość do">
                            </div>


                        </div>





                        <div style='float: left; margin-left: 20px; '>
                            <a onclick="addFieldAction()" style="cursor: pointer;">
                                <div class="plusButton plusMinusButton" id='addFieldWhatWork'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_plus.png')}}"></div>
                            </a>
                        </div>
                    </div>
                </td>



            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
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
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Wyszukja tylko wpisy, które mają jakiąś akcję
                </td>
                <td>
                    <input type='checkbox' name='ifAction' class='form-check-input'>
                </td>

            </tr>

            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Pogrupuj wg. tygodnia
                </td>
                <td>
                    <input type='checkbox' name='groupWeek' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Pogrupuj wg. miesiąca
                </td>
                <td>
                    <input type='checkbox' name='groupMonth' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Sumuj wszystkie nastroje
                </td>
                <td>
                    <input type='checkbox' name='sumDay' class='form-check-input'>
                </td>

            </tr>


            <tr>
                <td style='padding-top: 10px; width: 37%;' colspan="4">
                    <div style='text-align: center;'>

                        <input type="button" class="btn-mood  mood "  onclick="averageMoodSumSubmit('{{route('doctor.averageMoodSumSubmit')}}')" value='SZUKAJ' id="searchAverageSum">
                    </div>
                </td>
            </tr>
        </table>
    </form>

</div>
<div id="averageSumDiv" class="averageSumDiv" >

</div>
<br><br>

