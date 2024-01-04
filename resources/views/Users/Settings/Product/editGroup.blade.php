
<script>
      $(document).ready(function () {
          
      $('select').selectize({
          sortField: 'text'
      });
      //$("input[name='pleasure']").prop("disabled",true);
    
  });    
</script>

<div class="titleDrugsSettings">
                        EDYTUJ GRUPĘ
        </div>
<div class="bodyPage">
    <form method="get" id='formeditGroup'>
        <table class="table">
            <tr>
                <td class="tdColorDrugs">
                    Nazwa grupy
                </td>
                <td width="50%">
                    <select name="nameGroupEdit" class="form-control" onchange="changeNameGroup()">
                        <option value=""></option>
                        @foreach ($listGroup as $list)
                            <option value="{{$list->id}}">{{$list->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div   style="display: none;" id="newName">
                        <table width="100%">
                            <tr>
                                <td class="tdColorDrugs">
                                    Nowa nazwa grupy
                                </td>
                                <td width="49%">
                                    <input type="text" name="newNameGroup" class="form-control">
                                    <input type="hidden" name="newNameGroupHidden" value="">
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-drugs  drugs " disabled onclick="editGroupSubmit()" value='EDYTUJ' id="editGroupButton">
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='editGroupSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>