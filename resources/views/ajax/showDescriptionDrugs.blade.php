@foreach ($list as $listDescription)
   <div class="descriptionDrugsShow">
       {!!$listDescription->description!!}<br>
    {{$listDescription->date}}
   </div>
    <br>
@endforeach