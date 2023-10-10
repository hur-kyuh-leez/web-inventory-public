@extends('layouts.app', ['page' => __('Client Information'), 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
    @include('alerts.error')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Client Information') }}</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Telephone') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Balance') }}</th>
                            <th>{{ __('Purchases') }}</th>
                            <th>{{ __('Total Payment') }}</th>
                            <th>{{ __('Last Purchase') }}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->email }}</td>
                                <td hidden>{{ $balance = $client->transactions->sum('amount') - $client->sales->sum('total_amount') }}</td>
                                <td>

                                    @if ($balance > 0)
                                        <span class="text-success">{{ format_money($balance) }}</span>
                                    @elseif ($balance < 0.00)
                                        <span class="text-danger">{{ format_money($balance) }}</span>
                                    @else
                                        {{ format_money($balance) }}
                                    @endif
                                </td>
                                <td>{{ $client->sales->count() }}</td>
                                <td>{{ format_money($client->transactions->sum('amount')) }}</td>
                                <td>{{ (empty($client->sales)) ? date('Y-m-d', strtotime($client->sales->reverse()->first()->created_at)) : __('N/A') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Latest Transactions') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('clients.transactions.add', $client) }}" class="btn btn-sm btn-primary">{{ __('New Transaction') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Method') }}</th>
                            <th>{{ __('Amount') }}</th>
                        </thead>
                        <tbody>
                            @foreach ($client->transactions->reverse()->take(25) as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->selected_date ??date('Y-m-d', strtotime($transaction->created_at)) }}</td>
                                    <td><a href="{{ route('methods.show', $transaction->method) }}">{{ $transaction->method->name }}</a></td>
                                    <td>{{ format_money($transaction->amount) }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('Edit Income') }}">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ __('Latest Purchases') }}</h4>
                        </div>

{{--       여기서는 추가 못하게 하기                 --}}
{{--                        <div class="col text-right">--}}
{{--                            <form method="post" action="{{ route('sales.store') }}">--}}
{{--                            @csrf--}}
{{--                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">--}}
{{--                                <input type="hidden" name="client_id" value="{{ $client->id }}">--}}
{{--                                <div class="float-right">--}}
{{--                                    <input type="text" name="order_date" id="datepicker" class="text-center datepicker-selector form-control form-control-alternative{{ $errors->has('order_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Date') }}" value="{{ old('order_date') }}" required>--}}
{{--                                    @include('alerts.feedback', ['field' => 'order_date'])--}}
{{--                                    <button type="submit" class="btn btn-sm btn-primary">{{ __('New Purchase') }}</button>--}}
{{--                                </div>--}}

{{--                            </form>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Products') }}</th>
                            <th>{{ __('Stock') }}</th>
                            <th>{{ __('Total Amount') }}</th>
                            <th>{{ __('State') }}</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($client->sales->reverse()->take(25) as $sale)
                                <tr>
                                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->id }}</a></td>
                                    <td>{{ $sale->order_date ?? date('Y-m-d', strtotime($sale->created_at)) }}</td>
                                    <td>{{ $sale->products->count() }}</td>
                                    <td>{{ $sale->products->sum('qty') }}</td>
                                    <td>{{ format_money($sale->products->sum('total_amount')) }}</td>
                                    <td>{{ ($sale->finalized_at) ? __('FINISHED') : __('ON HOLD') }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('More Details') }}">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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

    </script>
@endpush()
