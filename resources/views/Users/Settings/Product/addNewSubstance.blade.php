<script>
    $(document).ready(function(){

     jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};
    $("#hideGroupGroup").keyup( function(e) {
      if ($("#hideGroupGroup").val() == "") {
          $('.groupMainAllGroup').show();
          return;
      }
        $('.groupMainAllGroup').hide();
        var val = $.trim($("#hideGroupGroup").val());
        val = ".groupMainAllGroup:contains("+val+")";
        $( val ).show();
      
    });
    $( ".message" ).prop( "disabled", true );
});

</script>

<script src="{{ asset('./jquery/jquery-ui.js') }}"></script> 
<script src="{{ asset('./jquery/jquery-ui.min.js') }}"></script> 
<script>
$( function() {
    var nameAction = [
    @foreach ($listSubstance as $list)
        "{{$list->name}}",
    @endforeach
    ];
    $( "#tagsSubstance" ).autocomplete({
      source: nameAction,
      minLength: 3
    });
  } );
</script>
<div class="titleDrugsSettings">
                        DODAJ NOWĄ SUBSTANCĘ
        </div>
<div class="bodyPage">
    <form method="get" id='formaddSubstanceNew'>
        <table class="table">
            <tr>
                <td class="tdColorDrugs">
                    Nazwa substancji
                </td>
                <td>
                    <input id="tagsSubstance" type="text" name="nameSubstance" class="form-control">
                </td>
            </tr>
            <tr>
                <td class="tdColorDrugs">
                    Grupy substancji
                </td>
                <td>
                    <div class='scroll' >
                     <div id="parentsGroupGroup">
                                                <div >
                                                    <input type="text" id="hideGroupGroup" class='form-control'  >
                                                </div>
                                            
                                                 @foreach ($listGroup as $list)
                                                 <div class="rowPercent">
                                                    <div class='groupMain groupMainAllGroup'  id='divGroupGroup_{{$list->id}}' onclick='selectedGroupSubstance({{$list->id}},{{$loop->index}})'>{{$list->name}}</div>
                                                
                                                 </div>
                                                 @endforeach
                                            </div>
                 </div>
                </td>
            </tr>

            <tr>
                <td class="tdColorDrugs">
                   równowaznik jeśli jest to benzodiazepina
                </td>
                <td>
                    <input type="text" name="equivalent" class="form-control">
                </td>
            </tr>
            <tr>
                <td colspan="2"  class="center">
                    <input type="button" class="btn-drugs  drugs" id= "addNewSubstanceButton" onclick="addSubstanceNewSubmit()" value='DODAJ'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class='center'>
                    <div id='addNewSubstanceSubmit' class=' center ajaxMessage'>

                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>