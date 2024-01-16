@section('content')

@extends('adminlte::page')

@section('title', '【時間管理システム】作業時間編集')

@section('content_header')
    <h1>作業時間編集</h1>
@stop

@section('content')
    {{ errors() }}
    <div class="card">
        <div class="card-body">
            {!! Form::open(['method' => 'PUT', 'url' => route('times.update', $times->id)]) !!}
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>案件</label>
                            {!! projectSelect('project_id', old('project_id', isset($times) ? $times->project_id : null), ['class' => 'form-control p-region-id ' . errClass('project_id')]) !!}
                        </div>
                        <div class="form-group">
                            <label>社員</label>
                            {!! employeeSelect('employee_id', old('employee_id', isset($times) ? $times->employee_id : null), ['class' => 'form-control p-region-id ' . errClass('employee_id')]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>作業日付</label>
                            {{Form::text('work_date', old('work_date', isset($times) ? $times->work_date->format('Y/m/d') : null), ['class' => errClass('work_date').' form-control date', 'autocomplete' => 'off', 'id' => 'work_date'])}}
                        </div>
                        <div class="form-group">
                            <label>作業時間</label>
                            {{Form::number('work_time', old('work_time', isset($times) ? $times->work_time : null), ['class' => errClass('work_time').' form-control', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-default mr-3" href="{{ route('times.list', ['reload' => config('const.RELOAD_ON')]) }}">
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
