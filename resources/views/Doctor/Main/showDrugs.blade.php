<div id="showdrugs"  style="display: none;" class="formAddMood borderdrugs">
              <div class='titleMoodShow drugs'>
                            LEKI
              </div>
    
    <table class="drugsShow">
        <thead class="titleTheadDrugs">
                <tr class="bold">
                    <td class=" drugsShow  showdrugs drugsTd"  >
                        nazwa produktu
                    </td>
                    <td class=" drugsShow  showdrugs drugsTd"  >
                        substancje produktu
                    </td>
                    <td class=" drugsShow drugsTd showdrugs">
                        dawka
                    </td>
                    <td class=" drugsShow drugsTd showdrugs">
                        godzina wzięcia
                    </td>
                    <td class=" drugsShow drugsTd showdrugs">
                        ile kosztowało
                    </td>

                    
                </tr>
                </thead>
                <tr>
                    <td colspan="7">
                        <br>
                    </td>
                </tr>
                @foreach ($listDrugs as $list)
                                    <tr class='drugsClass{{$list->id}}'>
                    <td class=" drugsShow drugsTd showdrugs"  >
                        <div  class="showMenuDrugs{{$list->id}}" id="nameDrugs{{$list->id}}">
                            {{$list->name}}
                        </div>
                        <div class="showMenuEditDrugs{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            <select id='nameProductEdit{{$list->id}}' class="form-control"  >
                            <option value="" class="form-control"></option>
                            @foreach (\App\Models\Product::selectProduct() as $listDrugsEdit)
                                @if ($list->products_id == $listDrugsEdit->id)
                                    <option value="{{$listDrugsEdit->id}}" class="form-control" selected>{{$listDrugsEdit->name}}</option>
                                @else
                                    <option value="{{$listDrugsEdit->id}}" class="form-control">{{$listDrugsEdit->name}}</option>
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td class=" drugsShow drugsTd showdrugs" id="substanceDrugs{{$list->id}}" >
                       
                        @foreach (\App\Models\Substances_product::showSubstance($list->products_id) as $list2)

                            [{{$list2->name}}] 
                            @if ($loop->index > 3)
                                <a onclick ="showAllSubstance('{{route('ajax.showAllSubctance')}}')">.....</a>
                                @break
                            @endif
                        @endforeach
                        @if (count(\App\Models\Substances_product::showSubstance($list->products_id)) == 0)
                            <span class="warning">Nie było żadnych substancji</span>
                        @endif
                       
                        
                    </td>
                    
                    <td class=" drugsShow drugsTd showdrugs">
                        <div  class="showMenuDrugs{{$list->id}}"  id="doseDrugs{{$list->id}}">
                        {{$list->portion}} {{\App\Http\Services\Common::showDoseProduct($list->type)}}
                        </div>
                        <div class="showMenuEditDrugs{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            <input type="text" id='doseEdit{{$list->id}}' class="form-control" size="2" value="{{$list->portion}}">
                        </div>
                    </td>
                    <td class=" drugsShow drugsTd showdrugs">
                        <div  class="showMenuDrugs{{$list->id}}"  id="dateDrugs{{$list->id}}">
                        {{substr($list->date,11,-3)}}
                        </div>
                        <div class="showMenuEditDrugs{{$list->id}}" style="display: none; width: 70%; margin-left: auto; margin-right: auto; ">
                            
                            <input type="date" id="dateDrugsEdit{{$list->id}}" value="{{substr($list->date,0,10)}}" class="form-control">
                            <input type="time" id="timeDrugsEdit{{$list->id}}" value="{{substr($list->date,11,-3)}}" class="form-control">
                        </div>
                    </td>
                    <td class=" drugsShow drugsTd showdrugs" id="percentDrugs{{$list->id}}">
                        {{$list->price}} zł
                    </td>


                    
                </tr>
                <tr class='drugsClass{{$list->id}}'>
                    <td colspan="7" class="moodButton">
                        <div  class="showMenuDrugs{{$list->id}}">
                        <table  class="tableCenter"  >
                            <tr>
                                <td style="padding-right: 7px;">
                                   
                                        @if ((\App\Models\Usee::ifDescriptionDrugs($list->id,Auth::User()->id_users) ) > 0)
                                            <button class="btn-drugs main" onclick="showDescriptionDrugs('{{ route('Doctor.ajax.showDescriptionDrugs')}}',{{$list->id}})">pokaż opis</button>
                                        @else
                                            <button type="button" class="disable "  disabled>nie było opisu</button>
                                        @endif
                                    
                                     
                                    
                                </td>
                             
                                <td style="padding-right: 7px;">
                                   
                                        <button class="btn-drugs main" onclick="showAverage({{$list->id}},'{{ route('Doctor.ajax.showAverage')}}')">oblicz średnią</button>
                                    
                                     
                                    
                                </td>
                          
                         
                            </tr>
                        </table>
                        </div>
              
                    </td>
                    
                </tr>
                <tr class='drugsClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood descriptionShowDrugs{{$list->id}}" style="display: none;">
                            
                            <div id="messageDescriptionshowDrugs{{$list->id}}" ></div>
                        </div>
                    </td>
                
                </tr>
                <tr class='drugsClass{{$list->id}}'>
                    <td  colspan="7">
                        <div  class="hiddenMood showAverage{{$list->id}}" style="display: none;">
                            
                            <div id="messageDescriptionshowAverage{{$list->id}}" ></div>
                        </div>
                    </td>
                
                </tr>
       
                @endforeach
    </table>
</div>