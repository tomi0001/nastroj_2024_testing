
<script src="{{ asset('./jquery/jquery-ui.js') }}"></script> 
<script src="{{ asset('./jquery/jquery-ui.min.js') }}"></script> 
<script>
$( function() {
    var nameAction = [
    @foreach ($listGroup as $list)
        "{{$list->name}}",
    @endforeach
    ];
    $( "#tagsGroup" ).autocomplete({
      source: nameAction,
      minLength: 3
    });
  } );
</script>
<div class="titleDrugsSettings">
                        DODAJ NOWĄ GRUPĘ
        </div>
<div class="bodyPage">
    <form method="get" id='formaddGroupNew'>
        <table class="table">
            <tr>
                <td class="tdColorDrugs">
                    Nazwa grupy
                </td>
                <td>
                    <input id="tagsGroup" type="text" name="nameGroup" class="form-control">
                 
                </td>
            </tr>
            
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-drugs  drugs" id="addNewGroupButton" onclick="addGroupNewSubmit()" value='DODAJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='addNewGroupSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>