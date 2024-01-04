<html>
    <head>
        <title>Dzienniczek nastrojów - @yield('title')</title>
        

        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageMainwidth1810.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageMainwidth1410.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageMainwidth1210.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageMainwidth700.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/pageMainAll.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles_color') . '/css/pageMainColor.css') }}" rel="stylesheet">
        
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common1810.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common1410.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common1210.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/Common700.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles') . '/css/CommonAll.css') }}" rel="stylesheet">
        <link href="{{ asset('./styles/' . config('view.styles_color') . '/css/CommonColor.css') }}" rel="stylesheet">
      
        <link rel="stylesheet"  href="{{asset('./bootstrap-5.1.3-dist/css/bootstrap.css')}}"  >
<script src="{{asset('./bootstrap-5.1.3-dist/js/bootstrap.js')}}" ></script>

<script src="{{ asset('./jquery-3.6.3.js') }}"></script>     
        
        <link rel="shortcut icon" href="{{ asset('./image/icon.png')}}">
        

        
        
        <script src="{{ asset('./js/pageMain.js')}}"></script>


       <script data-ad-client="ca-pub-9009102811248163" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </head>
    <body>


            <div id="MainPage">
                <div id="menuMain" class="mood">
              
                    <div class="empty_menu">
                        &nbsp;
                    </div>
                    <div class="menu">
                        <a class="menu mainHref" href="{{route('users.main')}}" >GŁÓWNA STRONA</a>
                    </div>
                    <div class="menu">
                        <a class="menu mainHref" href="{{route('users.search')}}">WYSZUKAJ</a>
                    </div>

                    <div class="menu">

                        <a class="menu mainHref" href="{{route('users.setting')}}">USTAWIENIA KONTA</a>

                    </div>
                    <div class="menu">
                        <a class="menu mainHref" href="{{route('logout')}}">WYLOGUJ</a>
                    </div>

                    
                </div>
                    @yield('content')
                    
               
                
                
            </div>

    </body>
</html>