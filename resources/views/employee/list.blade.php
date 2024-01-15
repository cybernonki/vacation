@extends('adminlte::page')

@section('title', '【時間管理システム】特別休暇一覧')

@section('content_header')
    <h1>特別休暇一覧</h1>
@stop

@section('content')
{{ flashMessage() }}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-1">
                    <h3 class="card-title">一覧</h3>
                </div>
                <div class="col-sm-11">
                    <div class="text-right">
                        <a href="{{ route('employee.create') }}" class="{{ config('adminlte.classes_auth_btn') }}"><i class="fas fa-plus"></i> 新規登録</a>
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
                            'name' => ['name' => '名前'],
                            'usecount' => ['name' => '残り'],
                            'name' => ['name' => 'メモ'],
                            'delete' => ['name' => '', 'not_sort' => 'true'],
                        ]
                    );
                    @endphp
                    {!! $sortTableHelper->showTableHeader()!!}
                    </tr>
                </thead>
                <tbody>
                @forelse($lists as $employee)
                    <tr>
                        <td>
                            <a href="{{ route('employee.edit', ['employee' => $employee->id]) }}">
                                {{ $employee->name }}
                            </a>
                        </td>
                        <td>{{ $employee->usecount }}</td>
                        <td>{{ $employee->memo }}</td>
                        <td class="text-center">
                            <a href="{{ route('employee.delete', ['id' => $employee->id]) }}" class="{{ config('adminlte.classes_auth_btn_danger') }}"><i class="fas fa-plus"></i> 削除</a>
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
