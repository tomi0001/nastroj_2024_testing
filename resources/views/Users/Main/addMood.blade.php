<div class=" centerMood" id="mood">
    <div class="row">
    <div class='col-md-0 col-lg-2 col-sm-0 col-xs-0'>
        
    </div>
    <div class='col-md-12 col-lg-8 col-sm-12 col-xs-12 '>
        <div class='bodyDiv'>
            <div class='formAddMood borderMood'>
                <div class='titleMood mood'>
                    DODAJ NOWY NASTRÓJ
                </div>
                <div class='row'>
                    <div class='col-lg-1 col-md-1 col-xs-0 col-sm-0'>
                    </div>    
                    <div class='col-lg-10 col-md-10 col-xs-10 col-sm-10'>
                        <form method='get' id="formAddMood">
                            <table class='table '>
                                <tr>
                                    <td rowspan='2' style='padding-top: 35px; ' class='moodadd  widthMoodAdd'>
                                        Godzina zaczęcia
                                    </td>
                                    <td class='borderless'>
                                        <input type='date' name='dateStart' class='form-control' value='{{ date("Y-m-d")}}'>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='borderless'>
                                         <input type='time' name='timeStart' class='form-control'>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan='2' style='padding-top: 35px; ' class='moodadd'>
                                        Godzina zakończenia
                                    </td>
                                    <td>
                                        <input type='date' name='dateEnd' class='form-control' value='{{ date("Y-m-d")}}'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type='time' name='timeEnd' class='form-control' >
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'>
                                        Poziom nastroju
                                    </td>
                                    <td>
                                        <input type='text'  name='moodLevel' class='form-control'  onkeypress="return submitEnter(event,'{{ route('users.moodAdd')}}','addMood')" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'>
                                        Poziom lęku
                                    </td>
                                    <td>
                                        <input type='text' name='anxietyLevel' class='form-control'  onkeypress="return submitEnter(event,'{{ route('users.moodAdd')}}','addMood')">
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'>
                                        Poziom napięcia
                                    </td>
                                    <td>
                                        <input type='text' name='voltageLevel' class='form-control'  onkeypress="return submitEnter(event,'{{ route('users.moodAdd')}}','addMood')">
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'>
                                        Poziom pobudzenia
                                    </td>
                                    <td>
                                        <input type='text' name='stimulationLevel' class='form-control'  onkeypress="return submitEnter(event,'{{ route('users.moodAdd')}}','addMood')" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'>
                                        Ilośc epizodów psychotycznych
                                    </td>
                                    <td>
                                        <input type='number'  name='epizodesPsychotic' class='form-control'  min='0' max='10000'  onkeypress="return submitEnter(event,'{{ route('users.moodAdd')}}','addMood')">
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'  style='padding-top: 13%; ' >
                                        Co robiłem
                                    </td>
                                    <td>
                                        <textarea name='whatWork' class='form-control' rows='7'></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'  style='padding-top: 18%; ' >
                                        Akcje
                                    </td>
                                    <td>
                                        <div class='scroll' >
                                            <div id="parentsAction">
                                                <div >
                                                    <input type="text" id="hideActions" class='form-control'  >
                                                </div>
                                            
                                                 @foreach (\App\Models\Action::selectAction(Auth::User()->id)  as $list)
                                                 <div class="rowPercent">
                                                    <div class='actionMain actionMainAll'  id='divAction_{{$list->id}}' onclick='selectedActionMain({{$list->id}},{{$loop->index}})'>{{$list->name}}</div>
                                                    <div class="hiddenPercentExecuting centerPercent" id='divActionPercent_{{$list->id}}'>
                                                        <div style="display: inline-block; width: 40%; ">
                                                            <input type="number" class="percentExecuting form-control form-control-lg " title="procent wykonania" placeholder="procent wyk" name="percentExe[]"  min="1" max="100">
                                                            <input type="number" class="percentExecuting form-control form-control-lg " title="minut wykonania" placeholder="minut wyk" name="minuteExe[]"  min="1" >
                                                        </div>
                                                        <input type="hidden"  id='idAction[]' name="idActionss[]" value='{{$list->id}}'>
                                                        
                                                    </div>
                                                 </div>
                                                 @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="center">
                                        <input type="button" id="buttonMoodAdd" onclick="addMood('{{ route('users.moodAdd')}}')" class=" btn-mood mood" value="Dodaj nastrój" >
                                    </td>
                                </tr>    
                                <tr>
                                    <td colspan="2" class="center">
                                        <div  id="formResult"></div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class='col-md-1 col-lg-2'>
        
    </div>
    </div>
</div>