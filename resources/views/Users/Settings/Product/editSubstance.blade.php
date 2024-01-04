<script>

      $(document).ready(function () {
          
      $('select').selectize({
          sortField: 'text'
      });
      //$("input[name='pleasure']").prop("disabled",true);
    
  });    
</script>
<div class="titleDrugsSettings">
                        EDYTUJ SUBSTANCĘ
        </div>
<div class="bodyPage">
    <form method="get" id='formUpdateSubstance2'>
        <table class="table">
            <tr>
                <td class="tdColorDrugs">
                    Nazwa substancji
                </td>
                <td width="50%">
                    <select id="nameSubstance" name="nameSubstance" class="form-control" onchange="loadChangeSubstance('{{ route('settings.changeSubstance')}}')">
                        <option value=""></option>
                         @foreach ($listSubstance as $list)
                            <option value="{{$list->id}}">{{$list->name}}</option>
                         @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="changeSubstanceDiv">
                        
                    </div>
                </td>
            </tr>

            
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-drugs  drugs" disabled id="editSubstanceSubmitButton" onclick="editSubstanceSubmit()" value='EDYTUJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='updateSubstanceDiv' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>