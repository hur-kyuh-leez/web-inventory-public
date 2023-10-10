@extends('layouts.app', ['page' => __('New Transaction'), 'pageSlug' => 'clients', 'section' => 'transactions'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('New Transaction') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-primary">{{ __('Back to Client') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('transactions.store') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                            <h6 class="heading-small text-muted mb-4">{{ __('Transaction Information') }}</h6>
                            <div class="pl-lg-4">

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-method">{{ __('Transaction Type') }}</label>
                                            <select name="type" id="input-method" class="form-control form-control-alternative{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
                                                @foreach (['income' => __('Payment Received'), 'expense' => __('Returned Paid')] as $type => $title)
                                                    @if($type == old('type'))
                                                        <option value="{{$type}}" selected>{{ $title }}</option>
                                                    @else
                                                        <option value="{{$type}}">{{ $title }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'payment_method_id'])
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group{{ $errors->has('payment_method_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-method">{{ __('Payment Method') }}</label>
                                            <select name="payment_method_id" id="input-method" class="form-select form-control-alternative{{ $errors->has('payment_method_id') ? ' is-invalid' : '' }}" required>
                                                @foreach ($payment_methods as $payment_method)
                                                    @if($payment_method['id'] == old('payment_method_id'))
                                                        <option value="{{$payment_method['id']}}" selected>{{$payment_method['name']}}</option>
                                                    @else
                                                        <option value="{{$payment_method['id']}}">{{$payment_method['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'payment_method_id'])
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Amount') }}</label>
                                            <input type="number" step=".01" name="amount" id="input-amount" class="form-control form-control-alternative" placeholder="{{ __('Amount') }}" value="{{ old('amount') }}" required>
                                            @include('alerts.feedback', ['field' => 'amount'])
                                        </div>
                                    </div>

                               </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group{{ $errors->has('selected_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-selected_date">{{ __('Date') }}</label>
                                            <input type="text" name="selected_date" id="datepicker" class="datepicker-selector form-control form-control-alternative{{ $errors->has('selected_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Date') }}" value="{{ old('selected_date') }}" required>
                                            @include('alerts.feedback', ['field' => 'selected_date'])
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-reference">{{ __('Reference') }}</label>
                                            <input type="text" name="reference" id="input-reference" class="form-control form-control-alternative{{ $errors->has('reference') ? ' is-invalid' : '' }}" placeholder="{{ __('Reference')}}" value="{{ old('reference') }}">
                                            @include('alerts.feedback', ['field' => 'reference'])
                                        </div>
                                    </div>
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
    </script>
@endpush('js')
