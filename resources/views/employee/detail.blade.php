@extends('dashboard')

@section('title', '顧客マスタ管理 詳細')

@section('content_header')
<div class="row">
    <div class="col-sm-6">
        <h1 class="m-0">顧客マスタ管理<small>詳細</small></h1>
    </div>
    <div class="col-sm-6">
        {!! Form::open(['method' => 'DELETE', 'url' => route('customer.delete', [$customer->id]), 'class' => 'del_form']) !!}
        {{Form::button('<i class="fas fa-trash"></i> 削除', ['class'=>'btn btn-danger w_110 delete_confirm float-sm-right','type'=>'submit'])}}
        {!! Form::close() !!}
    </div>
</div>


    <h1></h1>
@endsection

@section('content')
    {{ flashMessage() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>種別</label>
                        <span class="form_show">
                            <span class="status_label {{ $customer->type }}">{{ $customer->type_name }}</span>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>業種</label>
                        <span class="form_show">
                            <span class="status_label {{ $customer->type_of_business }}">{{ $customer->type_of_business_name }}</span>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>GENESISS(ジェネシス)　得意先コード</label>
                        <span class="form_show">{{ $customer->genesiss_customer_code }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group_wrap">
                        <h5>顧客名</h5>
                        <div>
                            <div class="form-group">
                                <label>顧客名</label>
                                {!! Form::open(['method' => 'GET', 'url' => route('customer.list'), 'id' => 'duplicate_form', 'target' => '_blank']) !!}
                                    {{ Form::hidden('search[telephone_number_no_hyphen]', str_replace('-', '', $customer->telephone_number)) }}
                                    <span class="form_show">
                                        {{ $customer->name }}
                                        @if ($countDuplicateTelephoneNumber->count > 1)
                                            <a href="javascript:duplicate_form.submit()">
                                                <strong class="badge {{ $countDuplicateTelephoneNumber->min_id == $customer->id ? 'bg-lightblue' : 'bg-gray' }}">
                                                    <span class="comma">{{ $countDuplicateTelephoneNumber->count }}</span>
                                                </strong>
                                            </a>
                                        @endif
                                    </span>
                                {!! Form::close() !!}
                            </div>
                            <div class="form-group">
                                <label>顧客名 フリガナ</label>
                                <span class="form_show">{{ $customer->name_furigana }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group_wrap">
                        <h5>代表者名</h5>
                        <div>
                            <div class="form-group">
                                <label>代表者名</label>
                                <span class="form_show">{{ $customer->name_of_representative }}</span>
                            </div>
                            <div class="form-group">
                                <label>代表者名 フリガナ</label>
                                <span class="form_show">{{ $customer->name_furigana_of_representative }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>郵便番号</label>
                        <span class="form_show">{{ $customer->zip_code }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group_wrap">
                        <h5>住所</h5>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>都道府県</label>
                                        <span class="form_show">{{ optional($customer->Prefecture)->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>市区町村</label>
                                        <span class="form_show">{{ $customer->address1 }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>番地等</label>
                                <span class="form_show">{{ $customer->address2 }}</span>
                            </div>
                            <div class="form-group">
                                <label>建物名・号室</label>
                                <span class="form_show">{{ $customer->address3 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group_wrap">
                        <h5>住所 フリガナ</h5>
                        <div>
                            <div class="form-group">
                                <label>市区町村 フリガナ</label>
                                <span class="form_show">{{ $customer->address1_kana }}</span>
                            </div>
                            <div class="form-group">
                                <label>番地等 フリガナ</label>
                                <span class="form_show">{{ $customer->address2_kana }}</span>
                            </div>
                            <div class="form-group">
                                <label>建物名・号室 フリガナ</label>
                                <span class="form_show">{{ $customer->address3_kana }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>電話番号</label>
                        <span class="form_show">{{ $customer->telephone_number }}</span>
                    </div>
                    <div class="form-group">
                        <label>FAX番号</label>
                        <span class="form_show">{{ $customer->fax_number }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>メールアドレス</label>
                        <span class="form_show">{{ $customer->e_mail_address }}</span>
                    </div>
                    <div class="form-group">
                        <label>ホームページURL</label>
                        <span class="form_show">{{ $customer->website_url }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>タグ</label>
                        <span class="form_show tags_wrap">
                            @foreach ($customer->CustomerTag as $customerTag)
                                @if (isset($customerTag->Tag))
                                <span class="tags">
                                    <span>
                                        <a href="{{ route('tag.detail', ['tag' => $customerTag->Tag->id]) }}" title="{{ $customerTag->Tag->note }}" target="_blank">
                                            {{ $customerTag->Tag->name }}
                                        </a>
                                    </span>
                                </span>
                                @endif
                            @endforeach
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>発送の可否</label>
                        <span class="form_show">{{ $customer->shipping_not_allowed_name }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>備考</label>
                        <span class="form_show">{!! nl2br(e($customer->note)) !!}</span>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a class="btn btn-default mr-3" href="{{ route('customer.list', ['reload' => config('const.RELOAD_ON')]) }}">
                    <i class="fas fa-angle-left"></i> 一覧へ戻る
                </a>
                <a href="{{ route('customer.edit', ['customer' => $customer->id]) }}" class="{{ config('adminlte.classes_auth_btn') }} w_110">
                    <i class="fas fa-pen"></i> 編集
                </a>
            </div>
            <div class="text-right mt-3">
                <span class="updaters">
                    {{ updateInformations($customer) }}
                </span>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">検索条件</h3>
        </div>
        <div class="card-body">
            {{ Form::open(['method' => 'get', 'url' => route('customer.detail', ['customer' => $customer->id, '#list_line']), 'id' => 'search_form']) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>顧客対応日</label>
                            <div class="row">
                                <div class="col-md-auto">
                                    <div class="input-group w_160">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {{Form::text('search[customer_facing_date_from]', $detail['search']['customer_facing_date_from'] ?? '', ['class' => 'form-control date', 'autocomplete' => 'off'])}}
                                    </div>
                                </div>
                                <div class="col-md-auto">
                                    <span class="unit p-0">～</span>
                                </div>
                                <div class="col-md-auto">
                                    <div class="input-group w_160">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        {{Form::text('search[customer_facing_date_to]', $detail['search']['customer_facing_date_to'] ?? '', ['class' => errClass('date').' form-control date', 'placeholder' => '', 'autocomplete' => 'off'])}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="m_tag_id_in">タグ</label>
                            {!! custmerTagSelect('search[m_tag_id_in][]', $detail['search']['m_tag_id_in'] ?? '', ['class' => 'form-control custmerTagSelect2']) !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="free_word">フリーワード</label>
                            {{Form::text('search[free_word]', $detail['search']['free_word'] ?? '', ['class' => 'form-control', 'id' => 'free_word', 'autocomplete' => 'off'])}}
                            <small class="gray">
                                ・検索の対象は、顧客対応内容、タグ名、タグ備考です。<br>
                                ・スペース区切りで複数のキーワードを入力するとAND検索が可能です。<br>
                                ・カタカナと英数字は半角と全角を区別せず検索が可能です。
                            </small>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    {{Form::button('<i class="fas fa-redo"></i> リセット', ['class'=>'btn btn-default w_110 mr-3', 'onClick'=>"window.location.href='" . route('customer.detail', ['customer' => $customer->id]) . "'"])}}
                    {{Form::button('<i class="fas fa-search"></i> 検索', ['class'=> config('adminlte.classes_auth_btn').' w_110', 'type' => 'submit'])}}
                </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="card card-primary card-outline" id="list_line">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">顧客対応履歴 一覧</h3>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        <a href="{{ route('customer_facing.create', ['customer' => $customer->id]) }}" class="{{ config('adminlte.classes_auth_btn') }}"><i class="fas fa-plus"></i> 新規登録</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                {{ $lists->appends($detail)->fragment('list_line')->links() }}
            </div>
            <table class="table table-bordered table-striped has_ellipsis">
                <thead>
                    <tr>
                    @php
                    $sortTableHelper = new SortTableHelper(
                        $detail,
                        [
                            'updated_at' => ['name' => '最終更新日時','class' => 'w_160'],
                            'updated_by' => ['name' => '最終更新者','class' => 'w_200'],
                            'date' => ['name' => '日付','class' => 'w_100'],
                            'content' => ['name' => '内容'],
                        ]
                    );
                    @endphp
                    {!! $sortTableHelper->showTableHeader()!!}
                    </tr>
                </thead>
                <tbody>
                @forelse($lists as $customerFacing)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('customer_facing.detail', ['customerFacing' => $customerFacing->id]) }}">
                                {{ $customerFacing->updated_at }}
                            </a>
                        </td>
                        <td>
                            {{ updateByName($customerFacing) }}
                        </td>
                        <td class="text-center">
                            @if ($customerFacing->date) 
                                {{ $customerFacing->date->format('Y/m/d') }}
                            @endif
                        </td>
                        <td>
                            <p class="ellipsis" title="{{ $customerFacing->content }}">{{ $customerFacing->content }}</p>
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
        {{ $lists->appends($detail)->fragment('list_line')->links() }}
    </div>
@endsection

@section('pageCss')
<link href="{{ mix('css/select2.css') }}" rel="stylesheet">
<link href="{{ mix('css/daterangepicker.css') }}" rel="stylesheet">
@stop
@section('pageJs')
<script>
    let tag = {{ Js::from($detail['search']['m_tag_id_in'] ?? null) }};
</script>
<script src="{{ mix("js/select2.js") }}"></script>
<script src="{{ mix("js/customerDetailSelect2.js") }}"></script>
<script src="{{ mix("js/daterangepicker.js") }}"></script>
@stop
