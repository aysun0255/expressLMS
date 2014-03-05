@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-15">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-list"></span>Course Categories
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($categories as $category)
                        <li class="list-group-item">
                            <div class="checkbox"> 
                                    {{$category->name}}
                            </div>
                            <div class="pull-right action-buttons">
                                <a href="{{route('admincp.categories.edit',$category->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a href="{{route('admincp.categories.remove',$category->id)}}" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6">
                            {{$categories->links()}}
                        </div>
                         <div class="col-md-6">
                             <a href="{{route('admincp.categories.create')}}"> Add new category</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop