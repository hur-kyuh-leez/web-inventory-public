@extends('layouts.app', ['page' => __('Register Client'), 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Client Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('clients.update', $client) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Client Information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $client->name) }}" required autofocus>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group{{ $errors->has('user_id') ? 'has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Seller') }}</label>
                                            <select name="user_id" id="form-select01" class="form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" required>
                                                @foreach ($users as $user)
                                                    @if($user['id'] == old('user_id', $client->user_id) or $user['id'] == $client->user_id)
                                                        <option value="{{$user['id']}}" selected>{{$user['name']}}</option>
                                                    @else
                                                        <option value="{{$user['id']}}">{{$user['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'user_id'])
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-phone">Telephone</label>
                                            <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Telephone') }}" value="{{ old('phone', $client->phone) }}" required>
                                            @include('alerts.feedback', ['field' => 'phone'])
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group{{ $errors->has('birthday') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-birthday">Birthday</label>
                                            <input type="text" name="birthday" id="datepicker" class="datepicker-selector form-control form-control-alternative{{ $errors->has('birthday') ? ' is-invalid' : '' }}" placeholder="{{ __('Birthday') }}" value="{{ old('birthday', $client->birthday) }}" required>
                                            @include('alerts.feedback', ['field' => 'birthday'])
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="text" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email ID') }}" value="{{ old('email', $client->email) }}" required>
                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="form-group{{ $errors->has('email_provider') ? 'has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email_provider">&nbsp</label>
                                            <select name="email_provider" id="input-email_provider" class="form-select form-control-alternative{{ $errors->has('email_provider') ? ' is-invalid' : '' }}" required>
                                                <option value="@">  I will type the address :)  </option>
                                                <option value="@hanmail.net">hanmail.net</option>
                                                <option value="@naver.com">naver.com</option>
                                                <option value="@nate.com">nate.com</option>
                                                <option value="@gmail.com">gmail.com</option>
                                                <option value="@yahoo.com">yahoo.com</option>

                                            </select>
                                            @include('alerts.feedback', ['field' => 'email_provider'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                            <input type="text" name="address_postcode" id="postcode" class="form-control form-control-alternative{{ $errors->has('address_postcode') ? ' is-invalid' : '' }}" placeholder="{{ __('Postal Code') }}" value="{{ old('address_postcode', $client->address_postcode) }}" required>
                                            @include('alerts.feedback', ['field' => 'address'])
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <input class="btn btn-success mt-4" type="button" onclick="execDaumPostcode()" value="우편번호 찾기"><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <input type="text" name="address_roadAddress" id="roadAddress" class="form-control form-control-alternative{{ $errors->has('address_general') ? ' is-invalid' : '' }}" placeholder="{{ __('Address by Street') }}" value="{{ old('address_roadAddress', $client->address_roadAddress) }}">
                                            @include('alerts.feedback', ['field' => 'address'])
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <input type="text" name="address_jibunAddress" id="jibunAddress" class="form-control form-control-alternative{{ $errors->has('address_jibunAddress') ? ' is-invalid' : '' }}" placeholder="{{ __('Address by Numbers') }}" value="{{ old('address_jibunAddress', $client->address_jibunAddress) }}">
                                            @include('alerts.feedback', ['field' => 'address'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <input type="text" name="address_detail" id="detailAddress" class="form-control form-control-alternative{{ $errors->has('address_detail') ? ' is-invalid' : '' }}" placeholder="{{ __('Details') }}" value="{{ old('address_detail', $client->address_detail) }}" required>
                                            @include('alerts.feedback', ['field' => 'address'])
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <input type="text" name="address_extraAddress" id="extraAddress" class="form-control form-control-alternative{{ $errors->has('address_extraAddress') ? ' is-invalid' : '' }}" placeholder="{{ __('Reference') }}" value="{{ old('address_extraAddress', $client->address_extraAddress) }}" required>
                                            @include('alerts.feedback', ['field' => 'address'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-control-label" for="input-note">{{ __('Note') }}</label>
                                        <input type="text" name="note" id="input-note" class="form-control form-control-alternative{{ $errors->has('note') ? ' is-invalid' : '' }}" placeholder="{{ __('Note') }}" value="{{ old('note',$client->note) }}">
                                        @include('alerts.feedback', ['field' => 'note'])
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
    {{--   다음 주소 api --}}
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>



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
                ,yearRange: '1900:2000'
            });

            //초기값을 오늘 날짜로 설정해줘야 합니다.
            $('#datepicker').datepicker('setDate', '1900-01-01'); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)
        });

        //slimselect
        new SlimSelect({
            select: '#form-select01'
        })
        new SlimSelect({
            select: '#input-email_provider'
        })

        // email input 하나에서 뒤 이메일 주소만 선택자로 바꾸기
        $( "#input-email_provider" ).change(function(){
            var email_id = $("#input-email").val().split('@', 1)[0]
            var email_provider = $("#input-email_provider").val()
            var full_email = email_id + email_provider
            $("#input-email").val(full_email);
        });


        {{--   다음 주소 api --}}
        //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
        function execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var roadAddr = data.roadAddress; // 도로명 주소 변수
                    var extraRoadAddr = ''; // 참고 항목 변수

                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraRoadAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraRoadAddr !== ''){
                        extraRoadAddr = ' (' + extraRoadAddr + ')';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('postcode').value = data.zonecode;
                    document.getElementById("roadAddress").value = roadAddr;
                    document.getElementById("jibunAddress").value = data.jibunAddress;

                    // 참고항목 문자열이 있을 경우 해당 필드에 넣는다.
                    if(roadAddr !== ''){
                        document.getElementById("extraAddress").value = extraRoadAddr;
                    } else {
                        document.getElementById("extraAddress").value = '';
                    }

                    var guideTextBox = document.getElementById("guide");
                    // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                    if(data.autoRoadAddress) {
                        var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                        guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                        guideTextBox.style.display = 'block';

                    } else if(data.autoJibunAddress) {
                        var expJibunAddr = data.autoJibunAddress;
                        guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                        guideTextBox.style.display = 'block';
                    } else {
                        guideTextBox.innerHTML = '';
                        guideTextBox.style.display = 'none';
                    }
                }
            }).open();
        }


    </script>
@endpush
