        <div class="titleMoodSettings">
                      WYSZUKAJ NASTRÓJ
        </div>
<div class="bodyPage">
    <form action='{{route("doctor.searchMoodSubmit")}}' method='get'>
        <table class='table searchTableMood'>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    poziom nastroju
                </td>
                <td>
                    <input type='text' name='moodFrom' class='form-control' value="{{Request::old("moodFrom")}}">
                </td>
                <td style='padding-top: 10px;'>
                    do
                </td>
                <td>
                    <input type='text' name='moodTo' class='form-control'>
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    poziom lęku
                </td>
                <td>
                    <input type='text' name='anxientyFrom' class='form-control'>
                </td>
                <td style='padding-top: 10px;'>
                    do
                </td>
                <td>
                    <input type='text' name='anxientyTo' class='form-control'>
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    poziom napięcia
                </td>
                <td>
                    <input type='text' name='voltageFrom' class='form-control'>
                </td>
                <td style='padding-top: 10px;'>
                    do
                </td>
                <td>
                    <input type='text' name='voltageTo' class='form-control'>
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    poziom pobudzenia
                <td>
                    <input type='text' name='stimulationFrom' class='form-control'>
                </td>
                <td style='padding-top: 10px;'>
                    do
                </td>
                <td>
                    <input type='text' name='stimulationTo' class='form-control'>
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    długośc nastroju od
                </td>
                <td>
                    <input type='text' name='longMoodHourFrom' class='form-control' placeholder="Godziny">
                </td>
                <td style='padding-top: 10px;'>

                </td>
                <td>
                    <input type='text' name='longMoodMinuteFrom' class='form-control' placeholder="Minuty">
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    długośc nastroju do
                </td>
                <td>
                    <input type='text' name='longMoodHourTo' class='form-control' placeholder="Godziny">
                </td>
                <td style='padding-top: 10px;'>

                </td>
                <td>
                    <input type='text' name='longMoodMinuteTo' class='form-control' placeholder="Minuty">
                </td>
            </tr>
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
                    słowa kluczowe co robiłem
                </td>
                <td colspan="3">
                <div style='clear: both;'>
                    <div style='float: left; width:75%;' id="idWhatWork">
                        <input type='text' name='whatWork[]' class='form-control' placeholder="słowa kluczowe">
                    </div>
                    <div style='float: left; width:75%; display: none;' id="idWhatWorkCopy" >
                        <input type='text' name='whatWork[]' class='form-control' placeholder="słowa kluczowe">
                    </div>
                    <div style='float: left; margin-left: 66px;' >
                    <a onclick="addFieldWhatWork()" style="cursor: pointer;">
                <div class="plusButton plusMinusButton" id='addFieldWhatWork'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_plus.png')}}"></div>
            </a>
                    </div>
                </div>
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
                    Wyszukja tylko wpisy, które mają jakiąś akcję
                </td>
                <td>
                    <input type='checkbox' name='ifAction' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Wyszukja tylko wpisy, które mają jakiś opis
                </td>
                <td>
                    <input type='checkbox' name='ifWhatWork' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Pogrupuj wg. dnia
                </td>
                <td>
                    <input type='checkbox' name='groupDay' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Sumuj wszystkie dni
                </td>
                <td>
                    <input type='checkbox' name='sumDay' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Sumuj wszystkie nastroje
                </td>
                <td>
                    <input type='checkbox' name='sumMood' class='form-check-input'>
                </td>

            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Pogrupuj według tygodnia
                </td>
                <td>
                    <input type='checkbox' name='groupWeek' class='form-check-input'>
                </td>

            </tr>

            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Sortuj wg.
                </td>
                <td colspan="3">
                    <select name='sort' class='form-control'>
                        <option value='date'>Daty</option>
                        <option value='hour'>Godziny</option>
                        <option value='mood'>Nastroju</option>
                        <option value='anxienty'>Leku</option>
                        <option value='voltage'>Napięcia</option>
                        <option value='stimulation'>Pobudzenia</option>
                        <option value='longMood'>Długości trwania nastroju</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    Malejąco czy rosnocą
                </td>
                <td colspan="3">
                    <select name='sort2' class='form-control'>
                        <option value='desc'>Od największego</option>
                        <option value='asc'>Od najmniejszego</option>

                    </select>

                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;' colspan="4">
                 <div style='text-align: center;'>
                   <input type="submit" class="btn-mood  mood"  value='SZUKAJ'>
                 </div>
                </td>
            </tr>
        </table>
    </form>

</div>
