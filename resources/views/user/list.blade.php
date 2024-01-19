@extends('adminlte::page')

@section('title', '【時間管理システム】ユーザー一覧')

@section('content_header')
    <h1>ユーザー一覧</h1>
@stop

@section('content')
{{ flashMessage() }}
    {{ Form::open(['method' => 'get', 'url' => route('user.list'), 'id' => 'search_form']) }}
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
                            'name' => ['name' => '名前', 'not_sort' => 'true'],
                            'email' => ['name' => 'メール', 'not_sort' => 'true'],
                            'delete' => ['name' => '', 'not_sort' => 'true'],
                        ]
                    );
                    @endphp
                    {!! $sortTableHelper->showTableHeader()!!}
                    </tr>
                </thead>
                <tbody>
                @forelse($lists as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            {!! Form::open(['method' => 'DELETE', 'url' => route('user.delete', [$user->id]), 'class' => 'del_form']) !!}
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
