<form id="formUpdateAction2{{$idMood}}"></form>
<form id="formUpdateAction{{$idMood}}">
                                          
                                        <div class='scroll' >
                                            <div id="parentsAction{{$idMood}}">
                                                <div >
                                                    <input type="text" id="hideActions{{$idMood}}" class='form-control'  >
                                                </div>
                                                @php
                                                           $arrayJson = []; 
                                                           $i = 0;
                                                            
                                                @endphp
                                                 @foreach (\App\Models\Action::selectAction(Auth::User()->id)  as $list)
                                                 <div class="rowPercent">
                                                     
                                                     @if ($val = \App\Models\Moods_action::selectValueActionForMood($idMood,Auth::User()->id,$list->id) )
                                                        
                               
                                                          @php
  
                                                            $arrayJson["idMood"][$i] = $idMood;
                                                            $arrayJson["idList"][$i] = $list->id;
                                                            $arrayJson["index"][$i] = $loop->index;
                                                            $arrayJson["percent"][$i] = $val->percent_executing;
                                                            $arrayJson["minute"][$i] = $val->minute_exe;
                                                            $i++;
                                                          @endphp
                                                                


                                                       
                                                        
                                                        
                                                      
                                                        
                                                         
                                                     @endif
                                                    <div class='actionMain actionMain{{$idMood}}'  id='divAction_{{$list->id}}_{{$idMood}}' onclick='selectedActionMainValue({{$list->id}},{{$loop->index}},{{$idMood}})'>{{$list->name}}</div>
                                                    <div class="hiddenPercentExecuting centerPercent" id='divActionPercent_{{$list->id}}_{{$idMood}}'>
                                                        <div style="display: inline-block; width: 40%;">
                                                            <input type="number" class="percentExecuting form-control form-control-lg " title="procent wykonania" placeholder="procent wyk" id="percentExe_{{$loop->index}}_{{$idMood}}" name="percentExe{{$idMood}}[]" min="1" max="100">
                                                            <input type="number" class="percentExecuting form-control form-control-lg " title="minut wykonania" placeholder="minut wyk" id="minute_exe_{{$loop->index}}_{{$idMood}}" name="minute_exe{{$idMood}}[]" min="1">
                                                        </div>
                                                        <input type="hidden"  id='idAction' name="idActionss{{$idMood}}[]" value='{{$list->id}},{{$idMood}}'>
                                                    </div>
                                                 </div>
                                                 @endforeach

                                            </div>

                                            <div id="formResult{{$idMood}}"></div></div>
                                      </form>

   <script type="application/json" id="json{{$idMood}}">
  <?php 

  if (count($arrayJson) > 0) {
  echo json_encode($arrayJson); 
  }
  else {
      echo 0;
  }
  ?>
</script>
    <script type="application/json" id="jsonLenght{{$idMood}}">
  <?php
  if (count($arrayJson) > 0) {
  echo count($arrayJson["idMood"]) ;
  }
  else {
      echo 0;
  }
  ?>
</script>  
   <script>
       
    
   
    $(document).ready(function(){
    
        const myData = JSON.parse(document.getElementById("json{{$idMood}}").innerText);
        const myDataLenght = JSON.parse(document.getElementById("jsonLenght{{$idMood}}").innerText);
        //alert(myDataLenght);
        selectedActionMainSetValue(myData,myDataLenght);
        
     jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};
    $("#hideActions{{$idMood}}").keyup( function(e) {
        
      if ($("#hideActions{{$idMood}}").val() == "") {
          $('.actionMain{{$idMood}}').show();
          return;
      }
        $('.actionMain{{$idMood}}').hide();
        var val = $.trim($("#hideActions{{$idMood}}").val());
        val = ".actionMain{{$idMood}}:contains("+val+")";
        $( val ).show();
      
    });
    $( ".message{{$idMood}}" ).prop( "disabled", true );
});




</script>