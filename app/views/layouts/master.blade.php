<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        {{ HTML::style('css/bootstrap-glyphicons.css');}}
        {{ HTML::style('css/bootstrap.min.css'); }}
        {{ HTML::style('css/calendar.min.css'); }}
        {{ HTML::style('css/bootstrap-theme.css'); }}
        {{ HTML::style('css/bootstrap-theme.min.css'); }}
        {{ HTML::style('css/main.css'); }}
        {{ HTML::style('css/basic.css');}}
        {{ HTML::style('css/selectize.bootstrap3.css');}}
        {{ HTML::script('js/dropzone.js') }}
        {{ HTML::script('js/jquery-1.10.2.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/bootstrap-datepicker.js') }}
        {{ HTML::style('css/datepicker.css');}}
        {{ HTML::script('js/tinymce/tinymce.min.js') }}
        <script src="js/bootstrap_calendar.min.js"></script>
        <link href="css/bootstrap_calendar.css" rel="stylesheet">
        <script type="text/javascript">
tinymce.init({
    selector: ".tinyMCE",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
        </script>
        {{ HTML::script('js/selectize.js') }}
        {{ HTML::script('js/typeahead.js') }}

        <title>Express LMS</title>
    </head>
    <body>
        <header id="MainHeader"><h1>Express LMS</h1></header>
        <nav> 
            <div class="navbar navbar-inverse">
                <div class="container">
                    <div class="navbar-header">
                        <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#" class="navbar-brand">Express LMS</a><br>

                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active">{{link_to_route('home',Lang::get('menu.home'))}}</li>
                            <?php
                            $categories = new CourseCategory;
                            $categories = $categories->get()->all();
                            if (Auth::check()) {
                                $user = new User;
                                $user = $user->whereId(Auth::user()->id)->first();
                                $userCourses = $user->courses;
                            }
                            ?>
                            @if(Auth::check())
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">{{Lang::get('menu.mycourses')}}<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    @foreach($userCourses as $course)
                                    <li><a href="{{route('courses.show', $course->id)}}">{{$course->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="{{route('courses.index')}}">{{Lang::get('menu.courses')}}<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('courses.index')}}">{{Lang::get('menu.allcourses')}}</a></li>
                                    @foreach($categories as $category)
                                    <li class="dropdown-header">{{$category->name}}</li>
                                    <li class="divider"></li>
                                    @foreach($category->courses as $course)
                                    <li><a href="{{route('courses.show', $course->id)}}">{{$course->name}}</a></li>
                                    @endforeach
                                    @endforeach
                                </ul>
                            </li>

                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <form class="navbar-form" role="search">
                                    <div class="form-group" style="width: 240px;">
                                        <select style="display: none;" tabindex="-1" id="searchbox" name="q"  class="form-control selectized"><option value="" selected="selected">{{Lang::get('menu.search')}}</option></select>
                                    </div>
                                    <script type="text/javascript">
                                        var root = '{{url("/")}}';
                                    </script>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#searchbox').selectize({
                                                valueField: 'url',
                                                labelField: 'username',
                                                searchField: ['username'],
                                                maxOptions: 10,
                                                options: [],
                                                create: false,
                                                render: {
                                                    option: function(item, escape) {
                                                        return '<div><img src="' + item.icon + '" width="50" height="50">' + escape(item.name) + '</div>';
                                                    }
                                                },
                                                optgroups: [
                                                    {value: 'user', label: 'Users'},
                                                    {value: 'course', label: 'Courses'}
                                                ],
                                                optgroupField: 'class',
                                                optgroupOrder: ['user', 'course'],
                                                load: function(query, callback) {
                                                    if (!query.length)
                                                        return callback();
                                                    $.ajax({
                                                        url: root + '/api/search',
                                                        type: 'GET',
                                                        dataType: 'json',
                                                        data: {
                                                            q: query
                                                        },
                                                        error: function() {
                                                            callback();
                                                        },
                                                        success: function(res) {
                                                            callback(res.data);
                                                        }
                                                    });
                                                },
                                                onChange: function() {
                                                    window.location = this.items[0];
                                                }
                                            });
                                        });
                                    </script>
                                </form>
                            </li>
                            <li class="active"><p class='user-box'>

                                    @if(Auth::check())
                                    {{Lang::get('menu.welcome'),link_to_route('users.show', Auth::user()->username,[Auth::user()->username]);}}
                                    <a href="{{URL::to('/users/'.Auth::user()->username.'/edit')}}"><img src={{asset('images/preferences.png')}} width ="30"  height="30" alt="Logout"></a>
                                    <a href="{{URL::to('/messages')}}"><img src={{asset('images/messages.png')}} width ="25"  height="25" alt="Messages"></a>
                                    <a href="{{URL::to('/logout')}}"><img src={{asset('images/logoutt.png')}} width ="20"  height="20" alt="Logout"></a>
                                    <br>
                                    {{Lang::get('menu.language')}} <select id="language">
                                        <?php
                                        $languages = Language::get();
                                        foreach ($languages as $language) {
                                            echo '<option value="' . $language->code . '" onclick="javascript:window.location.href=\'' . route('setLanguage', $language->code) . '\'">' . $language->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                    @else
                                    {{Lang::get('menu.notlogged')}}
                                    @endif


                                </p>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </nav>
        <div id="Container">

            <div class ='container'>
                {{ Breadcrumbs::render() }}
                @if(Session::has('success'))
                <div class="alert alert-success">

                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <p>{{ Session::get('error') }}</p>
                </div>
                @endif
                @yield('content')
            </div>


        </div>
        <footer>
            <div class="container">
                <p class="text-muted">Powered by Express LMS.<a href="http://validator.w3.org/check?uri=referer"><img
                            src="http://www.explosetraffic.com/images/html.png"
                            alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>

                    <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img style="border:0;width:88px;height:31px"
                             src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
                             alt="Valid CSS!" />
                    </a></p>
            </div>
        </footer>

    </body>
</html>