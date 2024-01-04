<div class=" centerMood" id="actionPlaned" style="display: none;">
    <div class="row">
    <div class='col-md-0 col-lg-2 col-sm-0 col-xs-0'>
        
    </div>
    <div class='col-md-12 col-lg-8 col-sm-12 col-xs-12 '>
        <div class='bodyDiv'>
            <div class='formAddMood borderAction'>
                <div class='titleMood action'>
                    DODAJ NOWĄ AKCJE CAŁODNIOWĄ
                </div>
                <div class='row'>
                    <div class='col-lg-1 col-md-1 col-xs-0 col-sm-0'>
                    </div>    
                    <div class='col-lg-10 col-md-10 col-xs-10 col-sm-10'>
                        <form method='get' id="formAddActionPlaned">
                            <table class='table '>
                                <tr>
                                    <td rowspan='2' style='padding-top: 35px; ' class='moodadd  widthMoodAdd'>
                                        Dzień i godzina
                                    </td>
                                    <td class='borderless'>
                                        <input type='date' name='dateStart' class='form-control' value='{{ date("Y-m-d",StrToTime(date("Y-m-d")) + 3600 * 24)}}'>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='borderless'>
                                         <input type='time' name='timeStart' class='form-control'>
                                    </td>
                                </tr>
                                <tr>
                                    <td   class='moodadd  widthMoodAdd'>
                                        czas trwanie w minutach
                                    </td>
                                    <td class='borderless'>
                                        <input type='number' name='minute' class='form-control' min="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td   class='moodadd  widthMoodAdd' style='padding-top: 5%; '>
                                        Opis
                                    </td>
                                    <td class='borderless'>
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='moodadd'  style='padding-top: 18%; ' >
                                        Akcje
                                    </td>
                                    <td>
                                        <div class='scroll' >
                                            <div id="parentsActionAction">
                                                <div >
                                                    <input type="text" id="hideActionsAction" class='form-control'  >
                                                </div>
                                            
                                                 @foreach (\App\Models\Action::selectAction(Auth::User()->id)  as $list)
                                                 <div class="rowPercent">
                                                    <div class='actionMain actionMainAllAction'  id='divActionAction_{{$list->id}}' onclick='selectedActionAction({{$list->id}},{{$loop->index}})'>{{$list->name}}</div>
                                                    <div class="hiddenPercentExecuting centerPercent" id='divActionPercent_{{$list->id}}'>
                                                        
                                                        <input type="hidden"  id='idActionAction[]' name="idActionssAction[]" value='{{$list->id}}'>
                                                        
                                                    </div>
                                                 </div>
                                                 @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                

                                <tr>
                                    <td colspan="2" class="center">
                                        <input type="button" id="buttonActionAddPlaned" onclick="addActionPlaned('{{ route('users.actionPlanedpAdd')}}')" class=" btn-action" value="Zaplanuj akcje" >
                                    </td>
                                </tr>    
                                <tr>
                                    <td colspan="2" class="center">
                                        <div  id="formResultActionPlaned"></div>
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