

<form id="formUpdateProduct">
    
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
                                                 @for($i=0;$i < count($listSub);$i++)
                                                 <div class="rowPercent">
                                                     
                                                     @if ($listSub[$i]["bool"] == true )
                                                       
                            
                                                          @php
                                                          
                                                            $arrayJson[$j]["idProduct"] = $idProduct;
                                                            $arrayJson[$j]["id"] = $listSub[$i]["id"];
                                                            $arrayJson[$j]["dose"] = $listSub[$i]["dose"];
                                                            $arrayJson[$j]["Mg_Ug"] = $listSub[$i]["Mg_Ug"];
                                                            $arrayJson[$j]["index"] = $i;
                                                            $j++;
                                                          @endphp
                                                                


                                                       
                                                        
                                                        
                                                      
                                                        
                                                         
                                                     @endif
                                                     
                                                    <div class='groupMain groupMainAllGroup'  id='divSubstanceProductChange_{{$listSub[$i]["id"]}}' onclick='selectedProductChangeMainValue({{$listSub[$i]["id"]}},{{$i}})'>{{$listSub[$i]["nameSub"]}} </div>
                                                    @if ($listSub[$i]["bool"] == true)
                                                        <div class="showPercentExecuting centerPercent" id='divActionPercent_{{$listSub[$i]["id"]}}'>
                                                            <div style="display: inline-block; width: 40%; " >
                                                                <input type="text" class="percentExecuting form-control form-control-lg " title="zawartość mg" placeholder="zawartość mg" name="howMg[]"  min="1" value="{{$listSub[$i]["dose"]}}">
                                                                       <select name="typeMgUg[]" class="form-control">
                                                                           @if ($listSub[$i]["Mg_Ug"] == 1)
                                                                                <option value="1" selected>Mg</option>
                                                                                <option value="2">Ug</option>
                                                                           
                                                                           @elseif ($listSub[$i]["Mg_Ug"] == 2)
                                                                                <option value="2" selected>Ug</option>
                                                                                <option value="1">Mg</option>
                                                                           
                                                                           @else 
                                                                                <option value="1" selected>Mg</option>
                                                                                <option value="2">Ug</option>
                                                                           @endif
                                                                
                                                            </select>
                                                            </div>
                                                            <input type="hidden"  id='idAction' name="idSubstance[]" value='{{$listSub[$i]["id"]}}'>
                                                        </div>
                                                    @else
                                                        <div class="hiddenPercentExecuting centerPercent" id='divActionPercent_{{$listSub[$i]["id"]}}'>
                                                            <div style="display: inline-block; width: 40%; ">
                                                                <input type="text" class="percentExecuting form-control form-control-lg " title="zawartość mg" placeholder="zawartość mg" name="howMg[]"  min="1">
                                                                 <select name="typeMgUg[]" class="form-control">
                                                                <option value="1">Mg</option>
                                                                <option value="2">Ug</option>
                                                            </select>
                                                            </div>
                                                            <input type="hidden"  id='idAction' name="idSubstance[]" value='{{$listSub[$i]["id"]}}'>
                                                        </div>
                                                    
                                                    @endif
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
                                                    <input type="text" name="newName" value="{{$percent->name}}" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdColorDrugs">
                                                    ile ma procent w przypadku napoju alkoholowego
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="percent" value="{{$percent->how_percent}}" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdColorDrugs">
                                                    rodzaj porcji
                                                    
                                                </td>
                                                <td>
                                                    <select name="type" class="form-control">
                                                        
                                                        @foreach (\App\Http\Services\Common::showListDoseProduct() as $type)
                                                            @if ($loop->index == $percent->type_of_portion)
                                                                <option value="{{$loop->index}}" selected>{{$type}}</option>
                                                            @else
                                                                <option value="{{$loop->index}}" >{{$type}}</option>
                                                            @endif
                                                            
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdColorDrugs">
                                                    Cena
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="price" value="{{$percent->price}}" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tdColorDrugs">
                                                    za ile
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="howMuch" value="{{$percent->how_much}}" class="form-control">
                                                </td>
                                            </tr>
                                            
    </table>
                                            <div id="formResult"></div></div>
                                      </form>

   <script type="application/json" id="jsonPro">
  <?php 
  if (count($arrayJson) > 0) {
  echo json_encode($arrayJson); 
  }
  
  ?>
</script>
 <script type="application/json" id="jsonLenghtPro">
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
        const myDataLenght = JSON.parse(document.getElementById("jsonLenghtPro").innerText);
        if (myDataLenght > 0) {
            const myData = JSON.parse(document.getElementById("jsonPro").innerText);
        

            selectedProductChangeMainSetValue(myData,myDataLenght);
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