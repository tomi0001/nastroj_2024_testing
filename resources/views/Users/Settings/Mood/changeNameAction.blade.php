<script>
      $(document).ready(function () {
          
      $('select').selectize({
          sortField: 'text'
      });
      $("input[name='pleasure']").prop("disabled",true);
    
  });    
</script>
    
<div class="titleMoodSettings">
                        ZMIEŃ NAZWY AKCJI
        </div>
<div class="bodyPage">
    <form method="get" id='formchangeNameAction'>
        <table class="table">
            <tr>
                <td class="tdColorMood">
                    Nazwa akcji
                </td>
                <td>
                    <select name="nameAction"   class="form-control" onchange="loadPleasure('{{route('settings.loadValuePlasure')}}')">
                        <option value=""></option>
                        @foreach ($listAction as $list)
                            <option value="{{$list->id}}" class="form-control">{{$list->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tdColorMood">
                    Poziom przyjemności od -20 do +20
                </td>
                <td>
                    <input type="text" name="pleasure" class="form-control">
                </td>
            </tr>
            <tr id="newName" style="visibility: hidden;">
                <td class="tdColorMood">
                    Nowa nazwa
                </td>
                <td>
                    <textarea name="newName" class="form-control"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-mood  mood" onclick="changeNameActionSubmit()" value='ZMIEŃ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='changeNameActionSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>