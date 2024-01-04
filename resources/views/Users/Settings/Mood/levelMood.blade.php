        <div class="titleMoodSettings">
                        POZIOMY NASTROJU
        </div>
<div class="bodyPage">
    <form method="get" id='formlevelMoodSubmit'>
        <table class="table">
            <tr>
                <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                   Wartośc nastroju od do przy której czujesz myśli samobójcze i totalną depresję
                </td>
                <td>
                    <input type="text" name="valueMood-10From" class="form-control" value="{{$arrayLevel[0]["from"]}}" disabled>
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-10To" class="form-control" value="{{$arrayLevel[0]["to"]}}" disabled>
                </td>

            </tr>
            <tr>
                <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                    Wartośc nastroju od do przy której czujesz myśli samobójcze i totalną depresję, ale trochę mniejsze
                </td>
                <td>
                    <input type="text" name="valueMood-9From" class="form-control" value="{{$arrayLevel[1]["from"]}}" onkeyup="loadValue('valueMood-10To','valueMood-9From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-9To" class="form-control" value="{{$arrayLevel[1]["to"]}}" disabled>
                </td>

            </tr>
            <tr>
                <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                    Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i totalną depresję
                </td>
                <td>
                    <input type="text" name="valueMood-8From" class="form-control" value="{{$arrayLevel[2]["from"]}}" onkeyup="loadValue('valueMood-9To','valueMood-8From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-8To" class="form-control" value="{{$arrayLevel[2]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                  Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i totalną depresję, ale trochę mniejsze
                </td>
                <td>
                    <input type="text" name="valueMood-7From" class="form-control" value="{{$arrayLevel[3]["from"]}}"  onkeyup="loadValue('valueMood-8To','valueMood-7From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-7To" class="form-control" value="{{$arrayLevel[3]["to"]}}" disabled>
                </td>

                        </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                  Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i totalną depresję
                </td>
                <td>
                    <input type="text" name="valueMood-6From" class="form-control" value="{{$arrayLevel[4]["from"]}}"  onkeyup="loadValue('valueMood-7To','valueMood-6From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-6To" class="form-control" value="{{$arrayLevel[4]["to"]}}" disabled>
                </td>

                        </tr>

                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                   Wartośc nastroju od do przy której czujesz myśli rezygnacyjne i umiarkowną depresję
                </td>
                <td>
                    <input type="text" name="valueMood-5From" class="form-control" value="{{$arrayLevel[5]["from"]}}"  onkeyup="loadValue('valueMood-6To','valueMood-5From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-5To" class="form-control" value="{{$arrayLevel[5]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
                 Wartośc nastroju od do przy której czujesz myśli lekką depresję
                </td>
                <td>
                    <input type="text" name="valueMood-4From" class="form-control" value="{{$arrayLevel[6]["from"]}}"  onkeyup="loadValue('valueMood-5To','valueMood-4From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-4To" class="form-control" value="{{$arrayLevel[6]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
             Wartośc nastroju od do przy której czujesz lekkie obniżenie nastroju
                </td>
                <td>
                    <input type="text" name="valueMood-3From" class="form-control" value="{{$arrayLevel[7]["from"]}}"  onkeyup="loadValue('valueMood-4To','valueMood-3From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-3To" class="form-control" value="{{$arrayLevel[7]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
             Wartośc nastroju od do przy której czujesz myśli chandre
                </td>
                <td>
                    <input type="text" name="valueMood-2From" class="form-control" value="{{$arrayLevel[8]["from"]}}"  onkeyup="loadValue('valueMood-3To','valueMood-2From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-2To" class="form-control" value="{{$arrayLevel[8]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
  Wartośc nastroju od do przy której czujesz myśli lzejszą handrę
                </td>
                <td>
                    <input type="text" name="valueMood-1From" class="form-control" value="{{$arrayLevel[9]["from"]}}"  onkeyup="loadValue('valueMood-2To','valueMood-1From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood-1To" class="form-control" value="{{$arrayLevel[9]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
            Wartośc nastroju od do przy której czujesz się normalnie
                </td>
                <td>
                    <input type="text" name="valueMood0From" class="form-control" value="{{$arrayLevel[10]["from"]}}"  onkeyup="loadValue('valueMood-1To','valueMood0From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood0To" class="form-control" value="{{$arrayLevel[10]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
              Wartośc nastroju od do przy której czujesz się trochę lepiej
                </td>
                <td>
                    <input type="text" name="valueMood1From" class="form-control" value="{{$arrayLevel[11]["from"]}}"  onkeyup="loadValue('valueMood0To','valueMood1From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood1To" class="form-control" value="{{$arrayLevel[11]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
            Wartośc nastroju od do przy której czujesz, że masz nastrój lekko podwyższony
                </td>
                <td>
                    <input type="text" name="valueMood2From" class="form-control" value="{{$arrayLevel[12]["from"]}}"  onkeyup="loadValue('valueMood1To','valueMood2From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood2To" class="form-control" value="{{$arrayLevel[12]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
           Wartośc nastroju od do przy której czujesz, że masz nastrój jeszcze bardziej podwyższony
                </td>
                <td>
                    <input type="text" name="valueMood3From" class="form-control" value="{{$arrayLevel[13]["from"]}}"  onkeyup="loadValue('valueMood2To','valueMood3From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood3To" class="form-control" value="{{$arrayLevel[13]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
       Wartośc nastroju od do przy której czujesz, że masz lekką hipomanię
                </td>
                <td>
                    <input type="text" name="valueMood4From" class="form-control" value="{{$arrayLevel[14]["from"]}}"  onkeyup="loadValue('valueMood3To','valueMood4From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood4To" class="form-control" value="{{$arrayLevel[14]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
           Wartośc nastroju od do przy której czujesz, że masz hipomanię
                </td>
                <td>
                    <input type="text" name="valueMood5From" class="form-control" value="{{$arrayLevel[15]["from"]}}"  onkeyup="loadValue('valueMood4To','valueMood5From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood5To" class="form-control" value="{{$arrayLevel[15]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
       Wartośc nastroju od do przy której czujesz, że masz większą hipomanię
                </td>
                <td>
                    <input type="text" name="valueMood6From" class="form-control" value="{{$arrayLevel[16]["from"]}}"  onkeyup="loadValue('valueMood5To','valueMood6From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood6To" class="form-control" value="{{$arrayLevel[16]["to"]}}" disabled>
                </td>

            </tr>
                        <tr>
                            <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
    Wartośc nastroju od do przy której czujesz, że masz lekką manię
                </td>
                <td>
                    <input type="text" name="valueMood7From" class="form-control" value="{{$arrayLevel[17]["from"]}}"  onkeyup="loadValue('valueMood6To','valueMood7From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood7To" class="form-control" value="{{$arrayLevel[17]["to"]}}" disabled>
                </td>

            </tr>
                                    <tr>
                                        <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
       Wartośc nastroju od do przy której czujesz, że masz manię
                </td>
                <td>
                    <input type="text" name="valueMood8From" class="form-control" value="{{$arrayLevel[18]["from"]}}"  onkeyup="loadValue('valueMood7To','valueMood8From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood8To" class="form-control" value="{{$arrayLevel[18]["to"]}}" disabled>
                </td>

            </tr>
                                    <tr>
                                        <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
      Wartośc nastroju od do przy której czujesz, że masz silniejszą manię
                </td>
                <td>
                    <input type="text" name="valueMood9From" class="form-control" value="{{$arrayLevel[19]["from"]}}"  onkeyup="loadValue('valueMood8To','valueMood9From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood9To" class="form-control" value="{{$arrayLevel[19]["to"]}}" disabled>
                </td>

            </tr>
                                    <tr>
                                        <td style='width: 5px;'>
                    {{$i++}}
                </td>
                <td class="tdColorMood">
       Wartośc nastroju od do przy której czujesz, że masz bardzo silną manię	

                </td>
                <td >
                    <input type="text" name="valueMood10From" class="form-control " value="{{$arrayLevel[20]["from"]}}"  onkeyup="loadValue('valueMood9To','valueMood10From',{{$i-12}})">
                </td>
                <td class="tdColorMood">
                    Do
                </td>
                <td>
                    <input type="text" name="valueMood10To" class="form-control" value="{{$arrayLevel[20]["to"]}}" disabled>
                </td>

            </tr>
            <tr>
                <td colspan="5"  class="center">
                    <input type="button" class="btn-mood  mood" onclick="levelMoodSubmit()" value='EDYTUJ'>
                </td>
            </tr>
            <tr>
                <td colspan="5" class='center'>
                    <div id='levelMoodSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>