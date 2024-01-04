

@if (empty($arrayList)  )
    <div class="countSearch error">
        nic nie znaleziono
    </div>
    <br>
    <div class='center'>
        <a href="javascript:history.back()"><button class="btn-mood mood" >WSTECZ</button></a>
    </div>
@else



    <br>

    <div class='tableSearchMood' id="ajaxData">
        <div class="titleSearchResult titleSearchResultMood">WYSZUKIWANIE</div>

      


                <div class="moodSearchResult">
                    <div class="moodSearchResult">
                        <div class="dayMood" >

                            <div style="margin-left: auto;margin-right: auto; ">

                                <div class="dateSumDayMood">
                                    <div class="titleSearchSumDayMood">
                                        <span class="titleSearchSumDayMood">DATA</span>
                                    </div>
                                    <span class="fontSearchSumDay">
                    Od
                    @if ($dateFrom == "")
                                            początku
                                        @else
                                            {{$dateFrom}}
                                        @endif
                    do
                    @if ($dateTo == "")
                                            końca
                                        @else
                                            {{$dateTo}}
                                        @endif
                    </span>
                                </div>
                                <div class="dateSumDayMood">
                                    <div class="titleSearchSumDayMood">
                                        <span class="titleSearchSumDayMood">GODZINA</span>
                                    </div>
                                    <span class="fontSearchSumDay">
                    Od
                    @if ($timeFrom == "")
                                            najmniejszej
                                        @else
                                            {{$timeFrom}}
                                        @endif
                    do
                    @if ($timeTo == "")
                                            największej
                                        @else
                                            {{$timeTo}}
                                        @endif
                    </span>
                                </div>

                                <div class="dateSumMoodDrugs">
                                    <div class="titleSearchSumDayMood">
                                        <span class="titleSearchSumDayMood">PRODUKTY</span>
                                    </div>
                                    
                                      <table class="tableMoodDrugs">
                                        
                                    @for($i=0;$i < count($request->get("drugsMood"));$i++)  
                                        @if ($request->get("drugsMood")[$i] == "" )
                                            @continue
                                        @endif
                                        @if ($request->get("drugsMood")[$i] != "" )
                                            <tr>
                                              <td class="tdMoodDrugs"> <span class="fontSearchSumDay">  {{$request->get("drugsMood")[$i]}}   </span>  </td>
                                           
                                        @endif
                                        @if ($request->get("drugsMoodFrom")[$i] != "" )
                                           <td class="tdMoodDrugsDose"> <span class="fontSearchSumDay"> {{$request->get("drugsMoodFrom")[$i]}} </span>  </td>
                                        @else
                                            <td class="tdMoodDrugsDose">  </td>
                                        @endif
                                        @if ($request->get("drugsMoodTo")[$i] != "" )
                                           <td class="tdMoodDrugsDose"> <span class="fontSearchSumDay"> {{$request->get("drugsMoodTo")[$i]}} </span>  </td>
                                        @else
                                            <td class="tdMoodDrugsDose">  </td>
                                        @endif
                                        @if ($request->get("drugsMood")[$i] != "" )
                                            </tr>
                                        @endif
                                       
                                    @endfor
                                      </table>
                   
                                </div>

                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                    <table>

                        <thead >
                        <tr class="bold">
                            <td style="width: 3%;"></td>
                            <td style="width: 2%;">

                            </td>
                            <td class="start showMood titleTheadMood" style=" border-right-style: hidden; width: 22%;" >
                                Start
                            </td>
                            <td class="end showMood titleTheadMood" style="width: 22%;">
                                Koniec
                            </td>
                            <td class="sizeTableMood showMood titleTheadMood" style="width: 6%;">
                                Nastrój
                            </td>
                            <td class="sizeTableMood showMood titleTheadMood" style="width: 6%;">
                                Lęk
                            </td>
                            <td class="sizeTableMood showMood titleTheadMood" style="width: 6%;">
                                napięcie /<br>rozdrażnienie
                            </td>
                            <td class="sizeTableMood showMood titleTheadMood" style="width: 5%;">
                                Pobudzenie
                            </td>
                            <td class="sizeTableMood showMood titleTheadMood" style="width: 10%;">
                                ilość dni
                            </td>
                            <td class="center showMood titleTheadMood" style="width: 5%;">
                                Epizodów psychotycznych
                            </td>
                            <td >

                            </td>
                            <td style="width: 3%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        </thead>

                       



                        <tr>
                            <td></td>
                            <td ></td>
                            <td class="showMood start" colspan="2" ">
                            
                            <br>
                            <div class="cell{{\App\Http\Services\Common::setColor($arrayList["mood"])}} level" style="width: 100%">&nbsp;</div>
                            <div style="text-align: center; width: 70%;">
                                
                            </div>
                            </td>
                            <td class="sizeTableMood showMood ">

                                <span class="fontMood" >{{round($arrayList["mood"],3)}}</span>

                            </td>
                            <td class="sizeTableMood showMood ">
                                <span class="fontMood"  >{{round($arrayList["anxienty"],3)}}</span>

                            </td>
                            <td class="sizeTableMood showMood ">

                                <span class="fontMood"  >{{round($arrayList["voltage"],3)}}</span>

                            </td>
                            <td class="sizeTableMood showMood ">

                                <span class="fontMood"  >{{round($arrayList["stimulation"],3)}}</span>

                            </td>
                            <td class="sizeTableMood showMood ">

                                <span class="fontMood"  >{{$arrayList["count"]}}</span>

                            </td>
                            <td class="sizeTableMood showMood ">

                                @if ($arrayList["epizodes_psychotik"] != 0)
                                    <span class="MessageError" >{{$arrayList["epizodes_psychotik"]}} epizodów psychotycznych</span>
                                @else
                                    <span  > Brak </span>
                                @endif

                            </td>
                            <td  ></td>
                            <td></td>
                        </tr>


                       

                    </table>
                    <div class="dayMoodEnd"></div>
                </div>
            

     


    </div>

    </div>
@endif

