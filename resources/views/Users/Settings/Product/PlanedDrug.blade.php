<script>

      $(document).ready(function () {
          
      $('select').selectize({
          sortField: 'text'
      });
     
      //$("input[name='pleasure']").prop("disabled",true);
    
  });  

</script>
<div class="titleDrugsSettings">
                        ZAPLANUJ DAWKĘ
        </div>
<div class="bodyPage">
    <form method="get" id='formaddNewPlaned'>
        <table class="table">
            <tr>
                <td class="tdColorDrugs">
                    dodaj nowy plan
                </td>
                <td width="50%">
                    <input type="text" name="namePlanedNew" class="form-control">
                </td>
            </tr>
            <tr>
                <td class="tdColorDrugs">
                    produkt
                </td>
                <td width="50%">
                    <select name="idProduct"  class="form-control">
                        @foreach ($listProduct as $list)
                            <option value="{{$list->id}}">{{$list->name}}</option>
                            
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tdColorDrugs">
                    porcja
                </td>
                <td width="50%">
                    <input type="text" name="portion" class="form-control">
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-drugs  drugs"  id="addNewPlanedButton" onclick="addNewPlaned('{{ route('settings.addNewPlaned')}}')" value='DODAJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="planedAddNew">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="tdColorDrugs">
                    Wybierz zaplanową dawkę
                </td>
                <td width="50%">
                    <select  name="namePlaned"  class="form-control" onchange="loadChangePlaned('{{ route('settings.loadChangePlaned')}}')">

                        @foreach ($listPlaned as $list2)
                            <option value="{{$list2->name}}">{{$list2->name}}</option>
                            
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="loadChangePlaned">
                        
                    </div>
                </td>
            </tr>
            <tr>
                <td class="center">
                    <div style="float: left;">
                        <div class="plusButton addPlusButton" style="float: left; pointer-events:none;" disabled onclick="addNewPosition()">  <img width="60" class="minus" id="bool{{$list->id}}" src="{{asset('/image/icon_plus.png')}}"></div>
                        <div style="float: left;  padding-left: 25px; "><input type="button" class="btn-drugs  drugs" disabled id="editPlanedSubmitButton" onclick="editPlanedSubmitFunction('{{ route('setting.editPlanedsubmit')}}')" value='EDYTUJ'></div>
                        
                    </div>
                </td>
                <td class="center">
                    <input type="button" class="danger main" disabled id="deletePlanedSubmitButton" onclick="deletePlanedSubmit('{{ route('settings.deletePlaned')}}')" value='USUŃ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='updatePlanedDiv' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>