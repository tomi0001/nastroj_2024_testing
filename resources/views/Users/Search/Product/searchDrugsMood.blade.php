

<div class="titleDrugsSettings">
                      WYSZUKAJ NASTRÓJ WG  PRODUKT
</div>
<div class="bodyPage">
    
        <form  method='get' id='searchDrugsMoodFrom'>
            <table class='table searchTableDrugs'>
                <tr>
                    <td style='padding-top: 10px; width: 37%;'>
                        nazwy produktów
                    </td>
                    <td colspan="3" >
                    <div style='clear: both;'>
                        <div id="idProductMood">
                            <div style='float: left; width:35%;'>
                                <input type='text' name='drugsMood[]' class='form-control' placeholder="nazwa">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='drugsMoodFrom[]' class='form-control' placeholder="wartość od">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='drugsMoodTo[]' class='form-control' placeholder="wartość do">
                            </div>
                            <div style='float: left; width:15%; margin-left: 5px;'>
                                <div class="form-check form-switch">
                                    <input type='checkbox' name='ifBool[]' class='form-check-input' placeholder="niewystępuje">
                                </div>
                            </div>
                        </div>
                         <div id="idProductMoodCopy" style="display: none;">
                            <div style='float: left; width:35%;'>
                                <input type='text' name='drugsMood[]' class='form-control' placeholder="nazwa">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='drugsMoodFrom[]' class='form-control' placeholder="wartość od">
                            </div>
                            <div style='float: left; width:20%; margin-left: 10px;'>
                                <input type='text' name='drugsMoodTo[]' class='form-control' placeholder="wartość do">
                            </div>
                            <div style='float: left; width:15%; margin-left: 5px;'>
                                <div class="form-check form-switch">
                                    <input type='checkbox' name='ifBool[]' class='form-check-input' placeholder="niewystępuje">
                                </div>
                            </div>

                        </div>





                        <div style='float: left; margin-left: 45px; '>
                        <a onclick="addFieldDrugsMood()" style="cursor: pointer;">
                    <div class="plusButton plusMinusButton" id='addFieldWhatWork'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_plus.png')}}"></div>
                </a>
                        </div>
                    </div>
                    </td>



                </tr>
    <tr>
                    <td style='padding-top: 10px; width: 37%;'>
                        nazwy substancji
                    </td>
                    <td colspan="3">
                    <div style='clear: both;'>
                        <div style='float: left; width:75%;' id="idNameSubstanceMood">
                            <input type='text' name='nameSubstanceMood[]' class='form-control' placeholder="słowa kluczowe">
                        </div>
                        <div style='float: left; width:75%; display: none;' id="idNameSubstanceMoodCopy" >
                            <input type='text' name='nameSubstanceMood[]' class='form-control' placeholder="słowa kluczowe">
                        </div>
                        <div style='float: left; margin-left: 66px;' >
                        <a onclick="addFieldnameSubstanceMood()" style="cursor: pointer;">
                    <div class="plusButton plusMinusButton" id='addFieldWhatWork'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_plus.png')}}"></div>
                </a>
                        </div>
                    </div>
                    </td>



                </tr>
    <tr>
                    <td style='padding-top: 10px; width: 37%;'>
                        nazwy grup
                    </td>
                    <td colspan="3">
                    <div style='clear: both;'>
                        <div style='float: left; width:75%;' id="idNameGroupMood">
                            <input type='text' name='nameGroupMood[]' class='form-control' placeholder="słowa kluczowe">
                        </div>
                        <div style='float: left; width:75%; display: none;' id="idNameGroupMoodCopy" >
                            <input type='text' name='nameGroupMood[]' class='form-control' placeholder="słowa kluczowe">
                        </div>
                        <div style='float: left; margin-left: 66px;' >
                        <a onclick="addFieldnameGroupMood()" style="cursor: pointer;">
                    <div class="plusButton plusMinusButton" id='addFieldWhatWork'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_plus.png')}}"></div>
                </a>
                        </div>
                    </div>
                    </td>



                </tr>
                <tr>
                    <td style='padding-top: 10px; width: 37%;'>
                        fraza
                    </td>
                    <td colspan="3">
                        <input type="text" name="whatWork" class="form-control" placeholder="fraza">
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
                        Wyszukja tylko produkty, które mają jakiś opis
                    </td>
                    <td colspan="3">
                        <input type='checkbox' name='ifWhatWork' class='form-check-input'>
                    </td>

                </tr>
                <tr>
                    <td style='padding-top: 10px; width: 37%;'>
                        dawka dobowa
                    </td>
                    <td colspan="3">
                        <input type='checkbox' name='doseDay' class='form-check-input'>
                    </td>

                </tr>
                <tr>
                    <td style='padding-top: 10px; width: 37%;'>
                        Nastepne dni
                    </td>
                    <td colspan="3">
                        <input type='checkbox' name='nextDay' class='form-check-input'>
                    </td>

                </tr>
                <tr>
                    <td style='padding-top: 10px; width: 37%;' colspan="4">
                     <div style='text-align: center;'>
                       <input type="button"  onclick="searchDrugsMoodSubmit('{{route('search.searchDrugsMoodSubmit')}}')" class="btn-drugs  drugs"  value='SZUKAJ'>
                     </div>
                    </td>
                </tr>
            </table>
        </form>


</div>
    <div id="searchDrugsMoodDiv2" class="searchDrugsMoodDiv" >

    </div>

