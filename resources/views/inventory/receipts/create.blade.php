@extends('layouts.app', ['page' => __('New Receipt'), 'pageSlug' => 'receipts', 'section' => 'inventory'])

@section('content')
    <div class="container-fluid mt--7">
    @include('alerts.error')
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0"> {{ __('New Receipt') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('receipts.index') }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('receipts.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Receipt Information') }}</h6>
                            <div class="pl-lg-4">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                            <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title') }}" required autofocus>
                                            @include('alerts.feedback', ['field' => 'title'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group{{ $errors->has('received_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-received_date">{{ __('Received Date') }}</label>
                                            <input type="text" name="received_date" id="datepicker" class="datepicker-selector form-control form-control-alternative{{ $errors->has('received_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Received Date') }}" value="{{ old('received_date') }}" required>
                                            @include('alerts.feedback', ['field' => 'received_date'])
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-provider">{{ __('Provider') }}</label>
                                            <select name="provider_id" id="input-provider" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}">
                                                <option value="{{ $providers[0]->id }}" selected>{{ $providers[0]->name }}</option>
                                                @foreach ($providers as $provider)
                                                    @if($provider['id']== 1)
                                                        @continue;
                                                    @else
                                                        @if($provider['id'] == old('provider_id'))
                                                            <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                                        @else
                                                            <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'client_id'])
                                        </div>
                                    </div>
                                </div>

                                </div>





                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Continue') }}</button>
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
@endpush
