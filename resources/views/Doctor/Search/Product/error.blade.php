@extends('Layout.Search')

@section('content')



@section ('title')
    Wyszukiwanie
@endsection

<br>
<div class="ajaxError center">
    @foreach ($errors as $error)

        {{$error}}<br>


    @endforeach
</div>
<br>
<div class='center'>
    <a href="javascript:history.back()"><button class="btn-mood mood" >WSTECZ</button></a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

@endsection
