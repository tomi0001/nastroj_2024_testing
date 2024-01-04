<html>
    <head>
        <title>Dzienniczek nastrojów - @yield('title')</title>
        
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageNotLoginwidth1810.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageNotLoginwidth1410.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageNotLoginwidth1210.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageNotLoginwidth700.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageNotLoginAll.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles_color') . '/css/pageNotLoginColor.css') }}" rel="stylesheet">


      
        <link rel="stylesheet"  href="{{asset('./bootstrap-5.1.3-dist/css/bootstrap.css')}}"  >
<script src="{{asset('./bootstrap-5.1.3-dist/js/bootstrap.js')}}" ></script>

<script src="{{ asset('./jquery-3.6.3.js') }}"></script>     
        
        
        <link rel="shortcut icon" href="{{ asset('./image/icon.png')}}">
        
        
        <script src="{{ asset('/js/pageMain.js')}}"></script>
        <script src="{{ asset('/js/pageLogin.js')}}"></script>

       <script data-ad-client="ca-pub-9009102811248163" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </head>
    <body>


            <div id="MainPage">
                
                
                    @yield('content')
                    
               
                
                    <br><br>
            </div>

    </body>
</html>