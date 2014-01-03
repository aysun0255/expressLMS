@extends('layouts.master')

@section('content')
@if(isset($success))
    <div class="alert alert-success">
        <h3>{{ $success}}</h3>
    </div>
    @endif
    @if(isset($error))
    <div class="alert alert-danger">
        <h3>{{$error}}</h3>
    </div>
    @endif
@stop