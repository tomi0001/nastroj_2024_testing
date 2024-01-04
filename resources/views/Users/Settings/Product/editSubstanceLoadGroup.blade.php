

<form id="formUpdateSubstance">
    
    <table width="100%">
        <tr>
            <td width="50%" class="tdColorDrugs">
                grupy należące do tej substancji
            </td>
      
            
            <td width="48%">
                
                                        <div class='scroll' >
                                            <div id="parentsSubstance">
                                                <div >
                                                    <input type="text" id="hideActions" class='form-control'  >
                                                </div>
                                                @php
                                                           $arrayJson = []; 
                                                           $j = 0;
                                                            
                                                @endphp
                                                 @for($i=0;$i < count($listGroup);$i++)
                                                 <div class="rowPercent">
                                                     
                                                     @if ($listGroup[$i]["bool"] == true )
                                                       
                               
                                                          @php
                                                          
                                                            $arrayJson[$j]["idSubstance"] = $idSubstance;
                                                            $arrayJson[$j]["id"] = $listGroup[$i]["id"];
                                                            $arrayJson[$j]["index"] = $i;
                                                            $j++;
                                                          @endphp
                                                                


                                                       
                                                        
                                                        
                                                      
                                                        
                                                         
                                                     @endif
                                                     
                                                    <div class='groupMain groupMainAllGroup'  id='divSubstanceSubstanceChange_{{$listGroup[$i]["id"]}}' onclick='selectedSubstanceChangeMainValue({{$listGroup[$i]["id"]}},{{$i}})'>{{$listGroup[$i]["nameGroup"]}} </div>
                                                    <div class="hiddenPercentExecuting centerPercent" id='divActionPercent_{{$listGroup[$i]["id"]}}'>
                                                        <div style="display: inline-block; width: 40%;">

                                                        </div>
                                                        <input type="hidden"  id='idAction' name="idActionss[]" value='{{$listGroup[$i]["id"]}}'>
                                                    </div>
                                                 </div>
                                                 @endfor

                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td  class="tdColorDrugs">
                                                    Nowa nazwa
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="newName" value="{{$equivalent->name}}" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdColorDrugs">
                                                    Równoważnik jeśli jest to benzodiazepina
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="equivalent" value="{{$equivalent->equivalent}}" class="form-control">
                                                </td>
                                            </tr>
    </table>
                                            <div id="formResult"></div></div>
                                      </form>

   <script type="application/json" id="jsonSub">
  <?php 
  if (count($arrayJson) > 0) {
  echo json_encode($arrayJson); 
  }
  
  ?>
</script>
 <script type="application/json" id="jsonLenghtSub">
  <?php
  if (count($arrayJson) > 0) {
  echo count($arrayJson) ;
  }
  else {
      echo 0;
  }
  ?>
</script>  
   <script>
   
    
   
    $(document).ready(function(){
        const myDataLenght = JSON.parse(document.getElementById("jsonLenghtSub").innerText);
        if (myDataLenght > 0) {
            const myData = JSON.parse(document.getElementById("jsonSub").innerText);
        
        //alert(myDataLenght);
            
        
            selectedSubstanceChangeMainSetValue(myData,myDataLenght);
        }
     jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};
    $("#hideActions").keyup( function(e) {
      if ($("#hideActions").val() == "") {
          $('.groupMainAllGroup').show();
          return;
      }
        $('.groupMainAllGroup').hide();
        var val = $.trim($("#hideActions").val());
        val = ".groupMainAllGroup:contains("+val+")";
        $( val ).show();
      
    });
    $( ".message" ).prop( "disabled", true );
});




</script>