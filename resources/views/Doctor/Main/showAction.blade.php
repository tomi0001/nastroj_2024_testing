<div id="showaction" class="formAddAction borderAction" style="display: none;">
            
              <div class='titleActionShow action'>
                            AKCJE
              </div>
    
    
    @if (strTotime($date) <= strToTime(date("Y-m-d") ) )
    
        @if (count($actionForDay) == 0) 
            <div class="NotShow" >
                NIE BYŁO AKCJI CAŁODNIOWYCH
            </div>
        @else
            @include('Doctor.Main.showActionDays')
        
        @endif
        @if (count($actionSum) == 0) 
            <div class="NotShow  " >
                NIE BYŁO AKCJI
            </div>
        @else
            @include('Doctor.Main.showActionSum')
        @endif
        @if (count($actionPlan) == 0) 
            <div class="NotShow  " >
                NIE BYŁO AKCJI ZAPLANOWANYCH
            </div>
        @else
            @include('Doctor.Main.showActionPlaned')
        @endif
    @else
        @if (count($actionPlan) == 0) 
            <div class="NotShow  " >
                NIE BYŁO AKCJI ZAPLANOWANYCH
            </div>
        @else
            @include('Doctor.Main.showActionPlaned')
        @endif
        @if (count($actionForDay) == 0) 
            <div class="NotShow" >
                NIE BYŁO AKCJI CAŁODNIOWYCH
            </div>
        @else
            @include('Doctor.Main.showActionDays')
        
        @endif
        

    @endif
    
    <br><br>
</div>