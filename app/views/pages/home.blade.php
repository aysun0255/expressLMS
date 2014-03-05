@extends('layouts.master')

@section('content')
<div class="well-lg">
    <div class="col-xs-12 col-sm-6 col-lg-8">
        <div class="well">
            <h3>{{Lang::get('home.courses')}}</h3>
            @foreach($courses as $course)
            <div class="offer offer-default">
                <div class="shape">
                    <div class="shape-text"> course </div>
                </div>
                <div class="offer-content">
                    <h3 class="lead"> <a href="{{ route('courses.show', $course->id) }}">{{$course->name}}</a></h3>

                    <div class="right">
                        {{$course->description}}

                    </div>

                    <br>

                </div></div>
            @endforeach
            <a href="{{route('courses.index')}}">{{Lang::get('home.viewallcourses')}}</a>
        </div>
    </div>
    <div class="col-xs-6 col-lg-4">
        <script>
            $(document).on('click', '.panel-heading span.clickable', function(e) {
                var $this = $(this);
                if (!$this.hasClass('panel-collapsed')) {
                    $this.parents('.panel').find('.panel-bodyy').slideUp();
                    $this.addClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                } else {
                    $this.parents('.panel').find('.panel-bodyy').slideDown();
                    $this.removeClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                }
            })
        </script>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{Lang::get('home.calendar')}}</h3>
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
            </div>
            <div class="panel-bodyy"><div id="testDiv">
                        <div class="calendar_test" ></div>

                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            theMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                            theDays = ["S", "M", "T", "W", "T", "F", "S"];

                            $('.calendar_test').calendar({
                                months: theMonths,
                                days: theDays,
                                req_ajax: {
                                    type: 'get',
                                    url: 'calendar/events'
                                }
                            });
                        });
                    </script>
               
            </div>
        </div>

    </div>
</div>
@stop