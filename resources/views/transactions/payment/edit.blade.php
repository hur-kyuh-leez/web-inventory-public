@extends('layouts.app', ['page' => __('Edit Payment'), 'pageSlug' => 'payments', 'section' => 'transactions'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('New Payment') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('transactions.type', ['type' => 'payment']) }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('transactions.update', $transaction) }}" autocomplete="off">
                            @csrf
                            @method('put')
                            <input type="hidden" name="type" value="{{ $transaction->type }}">
                            <input type="hidden" name="user_id" value="{{ $transaction->user_id }}">
                            <h6 class="heading-small text-muted mb-4">{{ __('Payment Information') }}</h6>
                            <div class="pl-lg-4">

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                            <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title', $transaction->title) }}" required autofocus>
                                            @include('alerts.feedback', ['field' => 'title'])
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group{{ $errors->has('selected_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-selected_date">{{ __('Date') }}</label>
                                            <input type="text" name="selected_date" id="datepicker" class="datepicker-selector form-control form-control-alternative{{ $errors->has('selected_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Date') }}" value="{{ old('selected_date', $transaction->selected_date) }}" required>
                                            @include('alerts.feedback', ['field' => 'selected_date'])
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-provider">{{ __('Provider') }}</label>
                                    <select name="provider_id" id="input-provider" class="form-select form-control-alternative{{ $errors->has('provider_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($providers as $provider)
                                            @if($provider['id'] == old('provider') or $provider['id'] ==  $transaction->provider_id)
                                                <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                            @else
                                                <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'provider_id'])
                                </div>

                                <div class="form-group{{ $errors->has('payment_method_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-method">{{ __('Payment Method') }}</label>
                                    <select name="payment_method_id" id="input-method" class="form-select2 form-control-alternative{{ $errors->has('payment_method_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($payment_methods as $payment_method)
                                            @if($payment_method['id'] == old('payment_method_id') or $payment_method['id'] == $transaction->payment_method_id)
                                                <option value="{{$payment_method['id']}}" selected>{{$payment_method['name']}}</option>
                                            @else
                                                <option value="{{$payment_method['id']}}">{{$payment_method['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'payment_method_id'])
                                </div>

                                <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-amount">{{ __('Amount') }}</label>
                                    <input type="number" step=".01" name="amount" id="input-amount" class="form-control form-control-alternative" placeholder="{{ __('Total Amount') }}" value="{{ old('amount', abs($transaction->amount)) }}" min="0" required>
                                    @include('alerts.feedback', ['field' => 'amount'])

                                </div>

                                <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-reference">{{ __('Reference') }}</label>
                                    <input type="text" name="reference" id="input-reference" class="form-control form-control-alternative{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="{{ __('Reference') }}" value="{{ old('reference', $transaction->reference) }}">
                                    @include('alerts.feedback', ['field' => 'reference'])
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        // datepicker
        $(function() {
            //input을 datepicker로 선언
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd' //달력 날짜 형태
                ,formatSubmit: 'yyyy-mm-dd'
                ,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
                ,showMonthAfterYear:true // 월- 년 순서가아닌 년도 - 월 순서
                ,changeYear: true //option값 년 선택 가능
                ,changeMonth: true //option값  월 선택 가능
                // ,showOn: "both" //button:버튼을 표시하고,버튼을 눌러야만 달력 표시 ^ both:버튼을 표시하고,버튼을 누르거나 input을 클릭하면 달력 표시
                ,buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif" //버튼 이미지 경로
                ,buttonImageOnly: true //버튼 이미지만 깔끔하게 보이게함
                ,buttonText: "선택" //버튼 호버 텍스트
                ,yearSuffix: "년" //달력의 년도 부분 뒤 텍스트
                ,monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 텍스트
                ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 Tooltip
                ,dayNamesMin: ['일','월','화','수','목','금','토'] //달력의 요일 텍스트
                ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] //달력의 요일 Tooltip
                // ,minDate: "-99Y" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
                // ,maxDate: "-18y" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)
                ,yearRange: '-1Y:'
            });

            //초기값을 오늘 날짜로 설정해줘야 합니다.
            $('#datepicker').datepicker("setDate", "now"); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)
        });
        new SlimSelect({
            select: '.form-select'
        })
        new SlimSelect({
            select: '.form-select2'
        })
    </script>
@endpush('js')
