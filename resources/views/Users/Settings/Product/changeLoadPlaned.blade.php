<script>

      $(document).ready(function () {
          
      $('.selectize').selectize({
          
          sortField: 'text'
      });
     
      //$("input[name='pleasure']").prop("disabled",true);
    
  });  

</script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap-glyphicons.css">
<form id="formupdatePlaned">
    
</form>
<table class="table" id="tablePlaned">
    @foreach ($listPlaned as $list)

    <tr>
        <td  class="tdColorDrugs ">
               pozycja {{$loop->index+1}}
        </td>
        <td class="tdColorDrugs " ">
            <select name="position[]" class="form-control selectize"  id="trPlanedSelect{{$loop->index+1}}">
                @foreach ($listProduct as $list2)
                    @if ($list2->id == $list->id_product)
                        <option value="{{$list2->id}}" selected>{{$list2->name}}</option>
                    @else
                        <option value="{{$list2->id}}" >{{$list2->name}}</option>
                    @endif
                @endforeach
            </select>
        </td>
        
        <script>
            idPlaned2 = '{{$id}}';
            positionPlaned = {{$loop->index}};
            
        </script>
        <td class="tdColorDrugs ">
               <input type="text" name="portion[]" class="form-control" value="{{$list->portions}}" id="trPlanedInput{{$loop->index+1}}">
        </td>
        <td  class="tdColorDrugs">
            <a onclick="changeStatusPlaned({{$loop->index+1}},'{{asset('/image/icon_minus.png')}}','{{asset('/image/icon_plus.png')}}')" style="cursor: pointer;">
                <div class="minusButton plusMinusButton" id='bool2{{$loop->index+1}}'> <img width="40" class="minus" id="bool{{$loop->index+1}}" src="{{asset('/image/icon_minus.png')}}"></div>
            </a>
        </td>
    </tr>
    
    @endforeach

</table>

<div id="selectHidden" style="display: none;">
                <select name="position[]" class="form-control tmpId" id="trPlanedSelect">
                    <option value="" selected></option>

                    @foreach ($listProduct as $list3)
                    
                        <option value="{{$list3->id}}" >{{$list3->name}}</option>
                    
                     @endforeach
                </select>
</div>
    <div id="hiddenTd" style="display: none;">
            <a onclick="changeStatusPlaned2(xxxx,'{{asset('/image/icon_minus.png')}}','{{asset('/image/icon_plus.png')}}')" style="cursor: pointer;">
                <div class="minusButton plusMinusButton" id='bool2xxxx'> <img width="40" class="minus" id="boolxxxx" src="{{asset('/image/icon_minus.png')}}"></div>
            </a>
        
    </div>