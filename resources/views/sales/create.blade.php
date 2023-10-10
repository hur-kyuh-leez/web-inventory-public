@extends('layouts.app', ['page' => __('Register Sale'), 'pageSlug' => 'sales-create', 'section' => 'transactions'])

@section('content')
    @livewire('sales-create')

{{--    <div class="container-fluid mt--7">--}}
{{--    @include('alerts.error')--}}
{{--            <div class="col-xl-12 order-xl-1">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <div class="row align-items-center">--}}
{{--                            <div class="col-8">--}}
{{--                                <h3 class="mb-0">{{ __('Register Sale') }}</h3>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 text-right">--}}
{{--                                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <form method="post" action="{{ route('sales.store') }}" autocomplete="off">--}}
{{--                            @csrf--}}

{{--                            <h6 class="heading-small text-muted mb-4">{{ __('Customer Information') }}</h6>--}}
{{--                            <div class="pl-lg-4">--}}
{{--                                <row>--}}
{{--                                    <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">--}}
{{--                                        <label class="form-control-label" for="input-name">{{ __('Seller') }}</label>--}}
{{--                                        <select name="user_id" id="input-seller" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}" required>--}}
{{--                                            <option value="{{Auth::id()}}">{{ Auth::user()->name }}</option>--}}
{{--                                            @foreach ($users as $user)--}}
{{--                                                @if($user->id != Auth::id())--}}
{{--                                                    @if($user->id == old('id'))--}}
{{--                                                        <option value="{{$user->id}}" selected>{{$user->name}}</option>--}}
{{--                                                    @else--}}
{{--                                                        <option value="{{$user->id}}">{{$user->name}}</option>--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @include('alerts.feedback', ['field' => 'client_id'])--}}
{{--                                    </div>--}}
{{--                                </row>--}}
{{--                                <row>--}}

{{--                                    <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">--}}
{{--                                        <label class="form-control-label" for="input-name">{{ __('Client') }}</label>--}}
{{--                                        <select name="client_id" id="input-client_id" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}" required>--}}
{{--                                                @foreach ($clients as $client)--}}
{{--                                                        @if($client['id'] == old('client'))--}}
{{--                                                            <option value="{{$client['id']}}" selected>{{$client['name']}}</option>--}}
{{--                                                        @else--}}
{{--                                                            <option value="{{$client['id']}}">{{$client['name']}}</option>--}}
{{--                                                        @endif--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @include('alerts.feedback', ['field' => 'client_id'])--}}
{{--                                    </div>--}}
{{--                                </row>--}}

{{--                                <button type="submit" class="btn btn-success mt-4">{{ __('Continue') }}</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@push('js')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{--   다음 주소 api --}}
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
            $('#datepicker').datepicker(); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)
        });
    </script>


    <script>
        // var a = document.getElementById("input-seller")
        // var b = document.getElementById("input-client_id")
        //
        // // Your JS here.
        // if(a)
        // {
        //     new SlimSelect({
        //         select: '#input-seller'
        //     })
        // }
        // if(b)
        // {
        //     new SlimSelect({
        //         select: '#input-client_id'
        //     })
        // }


        // new SlimSelect({
        //     select: '#input-seller'
        // })
        // new SlimSelect({
        //     select: '#input-client_id'
        // })
    </script>
@endpush
