@section('content')

@extends('adminlte::page')

@section('title', '【時間管理システム】案件編集')

@section('content_header')
    <h1>案件編集</h1>
@stop

@section('content')
    {{ errors() }}
    <div class="card">
        <div class="card-body">
            {!! Form::open(['method' => 'PUT', 'url' => route('project.update', $project->id)]) !!}
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>発注元</label>
                            {!! ordererSelect('orderer_id', old('orderer_id', isset($project) ? $project->orderer_id : null), ['class' => 'form-control p-region-id ' . errClass('orderer_id')]) !!}
                        </div>
                        <div class="form-group">
                            <label>ソート</label>
                            {{Form::number('sort', old('sort', isset($project) ? $project->sort : null), ['class' => errClass('sort').' form-control', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>名前</label>
                            {{Form::text('name', old('name', isset($project) ? $project->name : null), ['class' => errClass('name').' form-control', 'autocomplete' => 'off', 'id' => 'name'])}}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-default mr-3" href="{{ route('project.list', ['reload' => config('const.RELOAD_ON')]) }}">
                        <i class="fas fa-angle-left"></i> 一覧へ戻る
                    </a>
                    {{Form::button('<i class="far fa-save"></i> 更新', ['class'=> config('adminlte.classes_auth_btn').' w_110','type'=>'submit'])}}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('css')
@stop

@section('js')
@stop
