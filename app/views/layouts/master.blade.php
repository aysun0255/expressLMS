<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ HTML::style('css/bootstrap.css'); }}
        {{ HTML::style('css/bootstrap.min.css'); }}
        {{ HTML::style('css/bootstrap-theme.css'); }}
        {{ HTML::style('css/bootstrap-theme.min.css'); }}
        {{ HTML::style('css/main.css'); }}
        {{ HTML::style('css/basic.css');}}
        {{ HTML::script('js/dropzone.js') }}
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="//code.jquery.com/jquery-1.9.1.js" type="text/javascript"></script>
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/bootstrap-datepicker.js') }}
        {{ HTML::style('css/datepicker.css');}}
        {{ HTML::style('css/bootstrap-glyphicons.css');}}
      <title>Express LMS</title>
    </head>
    <body>
        <header id="MainHeader"><h1>Express LMS</h1></header>
        <nav> 
            <div class="navbar navbar-inverse"><div class="container">
                    <div class="navbar-header">
                        <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#" class="navbar-brand">Express LMS</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><i class="icon-home icon-white"></i>{{link_to_route('home','Home')}}</li>
                            <li>{{link_to_route('users.index','Users')}}</li>
                            <li><a href="#contact">Contact</a></li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active"><p class='user-box'>
                                    @if(Auth::check())
                                    {{'Welcome back ',link_to_route('users.show', Auth::user()->username,[Auth::user()->username]);}}
                                    <a href="{{URL::to('/users/'.Auth::user()->username.'/edit')}}"><img src={{asset('images/preferences.png')}} width ="30"  height="30" alt="Logout"></a>
                                    <a href="{{URL::to('/logout')}}"><img src={{asset('images/logoutt.png')}} width ="20"  height="20" alt="Logout"></a>
                                    @endif</p>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div></div></nav>
        <div id="Container">
            <div id="content">
                <div class ='container'>

                    @yield('content')
                </div>
            </div>

        </div>
        <div id="footer">
            <div class="container">
                <p class="text-muted">Powered by Express LMS.</p>
            </div>
        </div>
     
    </body>
</html>