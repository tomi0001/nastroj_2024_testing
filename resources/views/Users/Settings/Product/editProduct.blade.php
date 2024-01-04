<script>

      $(document).ready(function () {
          
      $('select').selectize({
          sortField: 'text'
      });
      //$("input[name='pleasure']").prop("disabled",true);
    
  });    
</script>
<div class="titleDrugsSettings">
                        EDYTUJ PRODUKT
        </div>
<div class="bodyPage">
    <form method="get" id='formUpdateProduct2'>
        <table class="table">
            <tr>
                <td class="tdColorDrugs">
                    Nazwa produktu
                </td>
                <td width="50%">
                    <select id="nameProduct" name="nameProduct" class="form-control" onchange="loadChangeProduct('{{ route('settings.changeProduct')}}')">
                        <option value=""></option>
                         @foreach ($listProduct as $list)
                            <option value="{{$list->id}}">{{$list->name}}</option>
                         @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="changeProductDiv">
                        
                    </div>
                </td>
            </tr>

            
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-drugs  drugs" disabled id="editProductSubmitButton" onclick="editProductSubmit()" value='EDYTUJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='updateProductDiv' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>