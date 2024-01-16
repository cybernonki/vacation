@extends('adminlte::page')

@section('title', '【時間管理システム】作業時間一覧')

@section('content_header')
    <h1>作業時間一覧</h1>
@stop

@section('content')
{{ flashMessage() }}
    {{ Form::open(['method' => 'get', 'url' => route('times.list'), 'id' => 'search_form']) }}
    {{ Form::close() }}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-1">
                    <h3 class="card-title">一覧</h3>
                </div>
                <div class="col-sm-11">
                    <div class="text-right">
                        <a href="{{ route('times.create') }}" class="{{ config('adminlte.classes_auth_btn') }}"><i class="fas fa-plus"></i> 新規登録</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                {{ $lists->appends($param)->links() }}
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    @php
                    $sortTableHelper = new SortTableHelper(
                        $param,
                        [
                            'project_id' => ['name' => '案件名'],
                            'employee_id' => ['name' => '社員名'],
                            'work_date' => ['name' => '日付'],
                            'work_time' => ['name' => '時間'],
                            'delete' => ['name' => '', 'not_sort' => 'true'],
                        ]
                    );
                    @endphp
                    {!! $sortTableHelper->showTableHeader()!!}
                    </tr>
                </thead>
                <tbody>
                @forelse($lists as $times)
                    <tr>
                        <td>{{ optional($times->Project)->name }}</td>
                        <td>{{ optional($times->Employee)->name }}</td>
                        <td>
                            <a href="{{ route('times.edit', ['times' => $times->id]) }}">
                                {{ $times->work_date->format('Y/m/d') }}
                            </a>
                        </td>
                        <td>{{ $times->work_time }}</td>
                        <td class="text-center">
                            {!! Form::open(['method' => 'DELETE', 'url' => route('times.delete', [$times->id]), 'class' => 'del_form']) !!}
                            {{Form::button('<i class="fas fa-trash"></i> 削除', ['class'=>'btn btn-danger w_110 delete_confirm','type'=>'submit'])}}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    {{ $sortTableHelper->showEmptyList() }}
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div>
        {{ $lists->appends($param)->links() }}
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
