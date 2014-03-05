@extends('layouts.master')

@section('content')
	
    <div class="offer offer-default">
        <div class="shape">
            <div class="shape-text">
                content								
            </div>
        </div>
        <div class="offer-content">
            <h3 class="lead">
                {{$content->title}}
            </h3>
            <p>
                {{$content->content}}
            </p>
        </div>
    </div>

@stop