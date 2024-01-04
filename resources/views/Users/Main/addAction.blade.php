<div class=" centerMood" id="action" style="display: none;">
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
                        <form method='get' id="formAddAction">
                            <table class='table '>
                                <tr>
                                    <td   class='moodadd  widthMoodAdd'>
                                        Dzień
                                    </td>
                                    <td class='borderless'>
                                        <input type='date' name='date' class='form-control' value='{{ date("Y-m-d")}}'>
                                    </td>
                                </tr>
                                <tr>
                                    <td   class='moodadd  widthMoodAdd'>
                                        czas
                                    </td>
                                    <td class='borderless'>
                                        <input type='time' name='time' class='form-control'>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class='moodadd  widthMoodAdd' >
                                        Nazwa akcji
                                    </td>
                                    <td class='borderless'>
                                        <select name="actionDay" class="form-control" >
                                            @foreach (\App\Models\Action::selectAction(Auth::User()->id) as $listDay)
                                                <option value="{{$listDay->id}}">{{$listDay->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                

                                <tr>
                                    <td colspan="2" class="center">
                                        <input type="button" id="buttonActionAdd" onclick="addActionDay('{{ route('users.actionDaypAdd')}}')" class=" btn-action" value="Dodaj akcje" >
                                    </td>
                                </tr>    
                                <tr>
                                    <td colspan="2" class="center">
                                        <div  id="formResultAction"></div>
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