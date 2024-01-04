@extends('Layout.User')
@section('content')
<br>
@section ('title') 
 Logowanie
@endsection
@include('auth.main')

<br><Br>

<div id="PageLogin">
    <div class="titleUser">LOGOWANIE UŻYTKOWNIKA</div>
    <div class="tableUser">
        <form action="{{route('login')}}" method="post">
            <table class="table">
                <tr>
                    <td class="tableRegister">
                        Twój email
                    </td>
                    <td class="input_lg">
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="email" value="testowy@wp.pl">

                    </td>
                </tr>
                
                <tr>
                    <td class="tableRegister">
                        Twoje hasło
                    </td>
                    <td class="input_lg">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="hasło" value="testowe1234">

                    </td>
                </tr>
                <tr>
                <td class="tableRegister">
                         <label class="form-check-label" for="remember">
                                                {{ __('Zapamiętaj mnie') }}
                                            </label>

                </td>
                <td align='left'>
                                           <input class="form-control-lg form-check-input" type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                </td>
                </tr>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tr>

                    <td class="buttonUser" colspan="2">
                        <button  class="btn-login  btn-yellow " >ZALOGUJ SIĘ</button>
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



