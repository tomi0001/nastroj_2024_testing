            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="sumDrugs">
                    @if (count($listSubstance) > 0 )
                        <div class='sumDrugsAt'>
                            @foreach ($listSubstance as $list)
                                <div class='positionDrugs'>{{$list->name}}</div>
                                <div class='positionDrugsDose'>{{$list->portions}} {{\App\Http\Services\Common::showDoseProductSubstance($list->type)}}</div>
                            @endforeach
                        </div>
                    @else
                        <div class="errorMainMessage">
                            Nie było żadnych leków dla tego dnia
                        </div>
                    @endif
                </div>
            </div>