@extends('adminlte::page')

@section('title', '【時間管理システム】月別作業時間詳細')

@section('content_header')
    <h1>月別作業時間詳細</h1>
@stop

@section('content')
{{ flashMessage() }}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-2">
                    <h3 class="card-title">{{ $param['month'] }}の詳細</h3>
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
                            'work_date' => ['name' => '日付', 'not_sort' => 'true'],
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
                            <a href="{{ route('month.days', ['employee_id' => $times->employee_id, 'date' => $times->work_date->format('Y-m-d')]) }}">
                                {{ optional($times->Employee)->name }}
                            </a>
                        </td>
                        <td>{{ $times->work_date->format('Y/m/d') }}</td>
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
    <div class="text-center">
        <a class="btn btn-default mr-3" href="{{ route('month.list', ['reload' => config('const.RELOAD_ON')]) }}">
            <i class="fas fa-angle-left"></i> 一覧へ戻る
        </a>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
