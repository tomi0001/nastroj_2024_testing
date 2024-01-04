        <div class="titleUserSettings">
                        LOGOWANIE DOKTORA
        </div>
<div class="bodyPage">
    <form method="get" id='formaddNewDoctor'>
        <table class="table">
            <tr>
                <td class="tdColorUser" style="width: 50%;">
                    Login doktora
                </td>
                <td>
                    <input type="text" name="login" class="form-control" value="{{$nameDoctor}}">
                </td>
            </tr>
            <tr>
                <td class="tdColorUser">
                    Hasło dla doktora
                </td>
                <td>
                    <input type="password" name="password" class="form-control">
                </td>
            </tr>
            <tr>
                <td class="tdColorUser">
                    Logowanie włączone
                </td>
                <td>
                    <input type="checkbox" name="ifTrue" class="form-check-input">
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-user  user" onclick="addNewDoctorSubmit()" value='DODAJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='addNewDoctorSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>