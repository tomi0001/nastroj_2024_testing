@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Logowanie doktora
@endsection
@include('auth.main')

<br><Br>
<div id="PageLogin">
    <div class="titleDoctor">LOGOWANIE DOKTORA</div>
    <div class="tableUser">
        <form action="{{route('doctorlogin')}}" method="post">
            <table class="table">
                <tr>
                    <td class="tableRegister">
                        Twój login
                    </td>
                    <td class="input_lg">
                        <input type="text" name="login" class="form-control form-control-lg" placeholder="login" value="{{Request::old("email")}}">

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


                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>

                    <td class="buttonUser" colspan="2">
                        <button  class="btn-login btn-blue" >ZALOGUJ SIĘ</button>
                    </td>
                </tr>

            </table>
        </form>
       <div id="error">
            @if (!empty($errors2))
                @foreach ($errors2 as $error)
                    {{$error}}<br>
               @endforeach
           @endif
       </div>
    </div>
    </div>
@endsection