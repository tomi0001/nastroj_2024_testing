
<br>

    <div id="PageMenuLogin">
    
    <div class="row">
        <div class="col-md-4">
            <a href="{{route('register')}}" class="nounderline">
                <div class="menuMain register menuMainColorUp" onmouseover="changeClassLoginUp('register')" id="register" onmouseout="changeClassLoginDown('register')">REJESTRACJA UŻYTKOWNIKA</div>
            </a>
                
        </div>
        <div class="col-md-4">
            <a href="{{route('login')}}" class="nounderline">
            <div class="menuMain loginUser menuMainColorUp"  onmouseover="changeClassLoginUp('login')" id="login" onmouseout="changeClassLoginDown('login')">LOGOWANIE UŻYTKOWNIKA</div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{route('doctorlogin')}}" class="nounderline">
            <div class="menuMain loginDoctor menuMainColorUp"  onmouseover="changeClassLoginUp('doctor')" id="doctor" onmouseout="changeClassLoginDown('doctor')">LOGOWANIE  LEKARZA</div>
            </a>
        </div>
    </div>
    
 </div>
