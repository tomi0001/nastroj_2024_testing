
<script src="{{ asset('./jquery/jquery-ui.js') }}"></script> 
<script src="{{ asset('./jquery/jquery-ui.min.js') }}"></script> 
<script>
$( function() {
    var nameAction = [
    @foreach ($listAction as $list)
        "{{$list->name}}",
    @endforeach
    ];
    $( "#tagsAction" ).autocomplete({
      source: nameAction,
      minLength: 3
    });
  } );
</script>

<div class="titleMoodSettings">
                        DODAJ NOWĄ AKCJE
        </div>
<div class="bodyPage">
    <form method="get" id='formaddActionNew'>
        <table class="table">
            <tr>
                <td class="tdColorMood">
                    Nazwa akcji
                </td>
                <td>
                    
                     <input id="tagsAction" type="text" name="nameAction"  class="form-control">
                     
                </td>
            </tr>
            <tr>
                <td class="tdColorMood">
                    Poziom przyjemności od -20 do +20
                </td>
                <td>
                    <input type="text" name="levelPleasure" class="form-control">
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-mood  mood" onclick="addActionNewSubmit()" value='DODAJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='addNewActionSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>