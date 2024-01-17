@extends('adminlte::page')

@section('title', '【時間管理システム】月別作業時間一覧')

@section('content_header')
    <h1>月別作業時間一覧</h1>
@stop

@section('content')
{{ flashMessage() }}
    {{ Form::open(['method' => 'get', 'url' => route('month.list'), 'id' => 'search_form']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>年月</label>
                    {{Form::text('search[work_date_month]', $param['search']['work_date_month'] ?? '', ['class' => errClass('date').' form-control month', 'placeholder' => '', 'autocomplete' => 'off'])}}
                </div>
            </div>
        </div>
        <div class="text-center">
            {{Form::button('<i class="fas fa-redo"></i> リセット', ['class'=>'btn btn-default w_110 mr-3', 'onClick'=>"location.href='" . route('month.list') . "'"])}}
            {{Form::button('<i class="fas fa-search"></i> 検索', ['class'=> config('adminlte.classes_auth_btn').' w_110', 'type' => 'submit'])}}
        </div>
    {{ Form::close() }}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-1">
                    <h3 class="card-title">一覧</h3>
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
                            'employee_id' => ['name' => '社員名', 'not_sort' => 'true'],
                            'total_work_time' => ['name' => '時間', 'not_sort' => 'true'],
                        ]
                    );
                    @endphp
                    {!! $sortTableHelper->showTableHeader()!!}
                    </tr>
                </thead>
                <tbody>
                @forelse($lists as $times)
                    <tr>
                        <td>
                            <a href="{{ route('month.detail', ['employee_id' => $times->employee_id, 'month' => $times->work_date_month]) }}">
                                {{ optional($times->Employee)->name }}
                            </a>
                        </td>
                        <td>{{ $times->total_work_time }}</td>
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
