@extends('dashboard')

@section('title', '顧客マスタ管理 新規登録')

@section('content_header')
<div class="row">
    <div class="col-sm-6">
        <h1 class="m-0">顧客マスタ管理<small>新規登録</small></h1>
    </div>
</div>

    <h1></h1>
@endsection

@section('content')
    {{ errors() }}
    <div class="card">
        <div class="card-body">
            {!! Form::open(['method' => 'post', 'url' => route('customer.store')]) !!}
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>種別<span class="status_label required">必須</span></label>
                            <div class="row">
                                @php $customerType = old('type', isset($customer) ? $customer->type : null); @endphp
                                @foreach(customerType() as $i => $type)
                                <div class="col-md-auto">
                                    <label for="type{{$i}}" class="label-normal">
                                    @if(isset($customerType))
                                    {!! Form::radio("type", $i, $i == $customerType ? true : false, ['id'=> "type{$i}", 'class' => errClass('type')]) !!}
                                    @else
                                    {!! Form::radio("type", $i, false, ['id'=> "type{$i}", 'class' => errClass('type')]) !!}
                                    @endif
                                    <span class="status_label {{$i}}">{{ $type }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>業種<span class="status_label required">必須</span></label>
                            <div class="row">
                                @php $customerTypeOfBusiness = old('type', isset($customer) ? $customer->type_of_business : null); @endphp
                                @foreach(customerTypeOfBusiness() as $i => $type_of_business)
                                <div class="col-md-auto">
                                    <label for="type_of_business{{$i}}" class="label-normal">
                                    @if(isset($customerTypeOfBusiness))
                                    {!! Form::radio("type_of_business", $i, $i == $customerTypeOfBusiness ? true : false, ['id'=> "type_of_business{$i}", 'class' => errClass('type_of_business')]) !!}
                                    @else
                                    {!! Form::radio("type_of_business", $i, false, ['id'=> "type_of_business{$i}", 'class' => errClass('type_of_business')]) !!}
                                    @endif
                                    <span class="status_label {{$i}}">{{ $type_of_business }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>GENESISS(ジェネシス)　得意先コード</label>
                            {{Form::text('genesiss_customer_code', old('genesiss_customer_code', isset($customer) ? $customer->genesiss_customer_code : null), ['class' => errClass('genesiss_customer_code').' form-control', 'placeholder' => '100000', 'autocomplete' => 'off'])}}
                        </div>
                    </div>
                </div>
                <div class="row h-adr">
                    <span class="p-country-name" style="display:none;">Japan</span>
                    <div class="col-md-6">
                        <div class="form_group_wrap">
                            <h5>顧客名</h5>
                            <div>
                                <div class="form-group">
                                    <label>顧客名<span class="status_label required">必須</span></label>
                                    {{Form::text('name', old('name', isset($customer) ? $customer->name : null), ['class' => errClass('name').' form-control', 'placeholder' => '山田歯科医院', 'autocomplete' => 'off', 'id' => 'name'])}}
                                </div>
                                <div class="form-group">
                                    <label>顧客名 フリガナ<span class="status_label required">必須</span></label>
                                    {{Form::text('name_furigana', old('name_furigana', isset($customer) ? $customer->name_furigana : null), ['class' => errClass('name_furigana').' form-control', 'placeholder' => 'ヤマダシカイイン', 'autocomplete' => 'off', 'id' => 'name_furigana'])}}
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
                                    {{Form::text('name_of_representative', old('name_of_representative', isset($customer) ? $customer->name_of_representative : null), ['class' => errClass('name_of_representative').' form-control', 'placeholder' => '山田 太郎', 'autocomplete' => 'off', 'id' => 'name_of_representative'])}}
                                </div>
                                <div class="form-group">
                                    <label>代表者名 フリガナ</label>
                                    {{Form::text('name_furigana_of_representative', old('name_furigana_of_representative', isset($customer) ? $customer->name_furigana_of_representative : null), ['class' => errClass('name_furigana_of_representative').' form-control', 'placeholder' => 'ヤマダ タロウ', 'autocomplete' => 'off', 'id' => 'name_furigana_of_representative'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>郵便番号<span class="status_label required">必須</span></label>
                            <div class="input_group_wrap postal">
                                {{Form::number('zip_code_before', old('zip_code_before', isset($customer) ? $customer->zip_code_before : null), ['class' => errClass('zip_code').' form-control p-postal-code', 'placeholder' => '000', 'autocomplete' => 'off', 'size' => '3', 'maxlength' => '3'])}}
                                <span>-</span>
                                {{Form::number('zip_code_after', old('zip_code_after', isset($customer) ? $customer->zip_code_after : null), ['class' => errClass('zip_code').' form-control p-postal-code', 'placeholder' => '0000', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group_wrap">
                            <h5>住所</h5>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>都道府県<span class="status_label required">必須</span></label>
                                            {!! prefectureSelect('s_prefecture_id', old('s_prefecture_id', isset($customer) ? $customer->s_prefecture_id : null), ['class' => 'form-control p-region-id ' . errClass('s_prefecture_id')]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>市区町村<span class="status_label required">必須</span></label>
                                            {{Form::text('address1', old('address1', isset($customer) ? $customer->address1 : null), ['class' => errClass('address1').' form-control  p-locality', 'placeholder' => '豊島区', 'autocomplete' => 'off', 'id' => 'address1'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>番地等<span class="status_label required">必須</span></label>
                                    {{Form::text('address2', old('address2', isset($customer) ? $customer->address2 : null), ['class' => errClass('address2').' form-control p-street-address', 'placeholder' => '巣鴨0-00-00', 'autocomplete' => 'off', 'id' => 'address2'])}}
                                </div>
                                <div class="form-group">
                                    <label>建物名・号室</label>
                                    {{Form::text('address3', old('address3', isset($customer) ? $customer->address3 : null), ['class' => errClass('address3').' form-control p-extended-address', 'placeholder' => 'ABCビル3階', 'autocomplete' => 'off', 'id' => 'address3'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group_wrap">
                            <h5>住所 フリガナ</h5>
                            <div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>市区町村 フリガナ</label>
                                            {{Form::text('address1_kana', old('address1_kana', isset($customer) ? $customer->address1_kana : null), ['class' => errClass('address1_kana').' form-control', 'placeholder' => 'トシマク', 'autocomplete' => 'off', 'id' => 'address1_kana'])}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>番地等 フリガナ</label>
                                    {{Form::text('address2_kana', old('address2_kana', isset($customer) ? $customer->address2_kana : null), ['class' => errClass('address2_kana').' form-control', 'placeholder' => 'スガモ', 'autocomplete' => 'off', 'id' => 'address2_kana'])}}
                                </div>
                                <div class="form-group">
                                    <label>建物名・号室 フリガナ</label>
                                    {{Form::text('address3_kana', old('address3_kana', isset($customer) ? $customer->address3_kana : null), ['class' => errClass('address3_kana').' form-control', 'placeholder' => 'エービーシービル', 'autocomplete' => 'off', 'id' => 'address3_kana'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>電話番号<span class="status_label required">必須</span></label>
                            <div class="input_group_wrap tel">
                                {{Form::number('telephone_number_before', old('telephone_number_before', isset($customer) ? $customer->telephone_number_before : null), ['class' => errClass('telephone_number').' form-control', 'placeholder' => '03', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                                <span>-</span>
                                {{Form::number('telephone_number_middle', old('telephone_number_middle', isset($customer) ? $customer->telephone_number_middle : null), ['class' => errClass('telephone_number').' form-control', 'placeholder' => '××××', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                                <span>-</span>
                                {{Form::number('telephone_number_after', old('telephone_number_after', isset($customer) ? $customer->telephone_number_after : null), ['class' => errClass('telephone_number').' form-control', 'placeholder' => '××××', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>FAX番号</label>
                            <div class="input_group_wrap tel">
                                {{Form::number('fax_number_before', old('fax_number_before', isset($customer) ? $customer->fax_number_before : null), ['class' => errClass('fax_number').' form-control', 'placeholder' => '03', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                                <span>-</span>
                                {{Form::number('fax_number_middle', old('fax_number_middle', isset($customer) ? $customer->fax_number_middle : null), ['class' => errClass('fax_number').' form-control', 'placeholder' => '××××', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                                <span>-</span>
                                {{Form::number('fax_number_after', old('fax_number_after', isset($customer) ? $customer->fax_number_after : null), ['class' => errClass('fax_number').' form-control', 'placeholder' => '××××', 'autocomplete' => 'off', 'size' => '4', 'maxlength' => '4'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>メールアドレス</label>
                            {{Form::text('e_mail_address', old('e_mail_address', isset($customer) ? $customer->e_mail_address : null), ['class' => errClass('e_mail_address').' form-control', 'placeholder' => 'info@example.com', 'autocomplete' => 'off', 'id' => 'e_mail_address'])}}
                        </div>
                        <div class="form-group">
                            <label>ホームページURL</label>
                            {{Form::text('website_url', old('website_url', isset($customer) ? $customer->website_url : null), ['class' => errClass('website_url').' form-control', 'placeholder' => 'https://example.com', 'autocomplete' => 'off', 'id' => 'website_url'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">タグ</label>
                            {!! customertagNameSelect('tag[]', old('tag', isset($customer->tag) ? $customer->tag : null), ['class' => 'form-control tagSelect2']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>発送の可否<span class="status_label required">必須</span></label>
                            <div class="toggle_switch">
                                @php $shipping_not_allowed = old('shipping_not_allowed', isset($customer) ? $customer->shipping_not_allowed : null); @endphp
                                <input type="hidden" name="shipping_not_allowed" value="1">
                                <input type="checkbox" name="shipping_not_allowed" id="shipping_not_allowed" value="0" {{ $shipping_not_allowed == 0 ? 'checked' : '' }}>
                                <label for="shipping_not_allowed">
                                    <p>
                                        <span>可</span>
                                        <span>不可</span>
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>備考</label>
                            {{Form::textarea('note', old('note', isset($customer) ? $customer->note : null), ['class' => 'form-control' . errClass('note'), 'id' => 'note', 'placeholder' => '', 'rows' => '6', 'autocomplete' => 'off'])}}
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-default mr-3" href="{{ route('customer.list', ['reload' => config('const.RELOAD_ON')]) }}">
                        <i class="fas fa-angle-left"></i> 一覧へ戻る
                    </a>
                    {{Form::button('<i class="far fa-save"></i> 登録', ['class'=> config('adminlte.classes_auth_btn').' w_110','type'=>'submit'])}}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('pageCss')
<link href="{{ mix('css/select2.css') }}" rel="stylesheet">
@stop

@section('pageJs')
<script>
    let tag = {{ Js::from(old('tag', isset($customer->tag) ? $customer->tag : null)) }};
</script>
<script src="{{ asset('/js/yubinbango_20220708.js') }}"></script>
<script src="{{ mix("js/tagSelect2.js") }}"></script>
<script src="{{ mix("js/customer_edit.js") }}"></script>
@stop

