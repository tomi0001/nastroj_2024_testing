@extends('Layout.User')
@section('content')

    @section ('title') 
     Rejestracja
    @endsection
    <div id="PageRegister">
    <div class="titleRegister">REJESTRACJA UŻYTKOWNIKA</div>
    <div class="tableUser">
        <form action="{{route('registerSubmits')}}" method="post">
            <table class="table">
                <tr>
                    <td class="tableRegister">
                        Twój email
                    </td>
                    <td class="input_lg">
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="email" value="{{Request::old("email")}}">

                    </td>
                </tr>
                <tr>
                    <td class="tableRegister">
                        Twój login
                    </td>
                    <td class="input_lg">
                        <input type="text" name="name" class="form-control form-control-lg" placeholder="login" value="{{Request::old("name")}}">

                    </td>
                </tr>
                <tr>
                    <td class="tableRegister">
                        Twoje hasło
                    </td>
                    <td class="input_lg">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="hasło">

                    </td>
                </tr>
                <tr>
                    <td class="tableRegister">
                        powtórz hasło
                    </td>
                    <td class="input_lg">
                        <input type="password" name="password_confirm" class="form-control form-control-lg" placeholder="hasło">

                    </td>
                </tr>
                <tr>
                    <td class="tableRegister">
                       początek dnia
                    </td>
                    <td class="input_lg">
                        <input type="number" min="0" max="23" name="startDay" class="form-control form-control-lg" value="0" title="Tutaj pisz wartość od 0 do 23 wartośc o które  godzinie będzie się zaczynał dzień " value="{{Request::old("startDay")}}">

                    </td>
                </tr>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>

                    <td class="buttonUser" colspan="2">
                        <button  class="btn-login btn-green" >ZAREJESTRUJ SIĘ</button>
                    </td>
                </tr>
            </table>
        </form>
       <div id="error">
            @if (!empty(session('errors')))
                @foreach ($errors->all() as $error)
                    {{$error}}<br>
               @endforeach
           @endif
       </div>
    </div>
    </div>
@endsection