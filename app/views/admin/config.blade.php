@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div id="adminpanel" style="width:100%;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-list-alt"></span> Site Config</h3>
                </div>
                </br>
                <div class="panel-bodyy">
                    {{Form::open(array('route'=>'admincp.configUpdate'))}}
                    @foreach($config as $conf)

                    <?php
                    $rule = $conf->rule;
                    $rule = str_replace("_", " ", $conf->rule);
                    $rule = ucfirst($rule);
                    ?>
                    {{Form::label($conf->rule,$rule.':'),
        Form::input('text',$conf->rule,$conf->value,['class' => 'form-control'])}}
                    </br>
                    @endforeach
                    {{Form::submit('Save Site Config',['type' => 'button','class' => 'btn btn-lg btn-primary btn-block'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>

@stop