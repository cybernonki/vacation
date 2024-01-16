@section('content')

@extends('adminlte::page')

@section('title', '【時間管理システム】特別休暇編集')

@section('content_header')
    <h1>特別休暇編集</h1>
@stop

@section('content')
    {{ errors() }}
    <div class="card">
        <div class="card-body">
            {!! Form::open(['method' => 'PUT', 'url' => route('employee.update', $employee->id)]) !!}
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>名前</label>
                            {{Form::text('name', old('name', isset($employee) ? $employee->name : null), ['class' => errClass('name').' form-control', 'autocomplete' => 'off', 'id' => 'name'])}}
                        </div>
                        <div class="form-group">
                            <label>休暇カウント</label>
                            {{Form::number('usecount', old('usecount', isset($employee) ? $employee->usecount : null), ['class' => errClass('usecount').' form-control', 'placeholder' => '5', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>メモ</label>
                            {{Form::text('memo', old('memo', isset($employee) ? $employee->memo : null), ['class' => errClass('memo').' form-control', 'autocomplete' => 'off', 'id' => 'memo'])}}
                        </div>
                        <div class="form-group">
                            <label>ソート</label>
                            {{Form::number('sort', old('sort', isset($employee) ? $employee->sort : null), ['class' => errClass('sort').' form-control', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-default mr-3" href="{{ route('employee.list', ['reload' => config('const.RELOAD_ON')]) }}">
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
