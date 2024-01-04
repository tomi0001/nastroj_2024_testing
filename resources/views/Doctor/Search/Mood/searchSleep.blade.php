        <div class="titleMoodSettings">
                      WYSZUKAJ SEN
        </div>
<div class="bodyPage">
    <form action='{{route("doctor.searchSleepSubmit")}}' method='get'>
        <table class='table searchTableMood'>
            
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    długośc snu od
                </td>
                <td>
                    <input type='text' name='longSleepHourFrom' class='form-control' placeholder="Godziny">
                </td>
                <td style='padding-top: 10px;'>

                </td>
                <td>
                    <input type='text' name='longSleepMinuteFrom' class='form-control' placeholder="Minuty">
                </td>
            </tr>
            <tr>
                <td style='padding-top: 10px; width: 37%;'>
                    długośc snu do
                </td>
                <td>
                    <input type='text' name='longSleepHourTo' class='form-control' placeholder="Godziny">
                </td>
                <td style='padding-top: 10px;'>

                </td>
                <td>
                    <input type='text' name='longSleepMinuteTo' class='form-control' placeholder="Minuty">
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
                    Wyszukja tylko wpisy, które mają jakis opis
                </td>
                <td>
                    <input type='checkbox' name='ifSleep' class='form-check-input'>
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
                    ilośc wybudzeń od
                </td>
                <td>
                    <input type='number' name='workingFrom' class='form-control' placeholder="wybudzenia" min="0">
                </td>
                <td style='padding-top: 10px;'>
                       do 
                </td>
                <td>
                    <input type='number' name='workingTo' class='form-control' placeholder="wybudzenia" max="50">
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
                        <option value='longMood'>Długości trwania snu</option>
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
