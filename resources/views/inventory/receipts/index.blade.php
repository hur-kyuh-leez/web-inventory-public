@extends('layouts.app', ['page' => __('Receipts'), 'pageSlug' => 'receipts', 'section' => 'inventory'])

@section('content')
    @include('alerts.success')
    <div class="row">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">{{ __('Receipts') }}</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('receipts.create') }}"
                           class="btn btn-sm btn-primary">{{ __('New Receipt') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table">
                        <thead>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Provider') }}</th>
                        <th>{{ __('Products') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th>{{ __('Defective Stock') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->received_date) ?? date('Y-m-d', strtotime($receipt->created_at) }} </td>
                                <td style="max-width:150px">{{ $receipt->title }}</td>
                                <td>
                                    @if($receipt->provider_id)
                                        <a href="{{ route('providers.show', $receipt->provider) }}">{{ $receipt->provider->name }}</a>
                                    @else
                                        {{ __('N/A') }}
                                    @endif
                                </td>
                                <td>{{ $receipt->products->count() }}</td>
                                <td>{{ $receipt->products->sum('stock') }}</td>
                                <td>{{ $receipt->products->sum('stock_defective') }}</td>
                                <td>
                                    @if($receipt->finalized_at)
                                        {{ __('FINALIZED') }}
                                    @else
                                        <span style="color:red; font-weight:bold;">{{ __('TO FINALIZE') }}</span>
                                    @endif
                                </td>
                                <td class="td-actions text-right">
                                    @if($receipt->finalized_at)
                                        <a href="{{ route('receipts.show', ['receipt' => $receipt]) }}"
                                           class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                           title="{{ __('More Details') }}">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('receipts.show', ['receipt' => $receipt]) }}"
                                           class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                           title="{{ __('Edit Receipt') }}">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                    @endif

                                    <form action="{{ route('receipts.destroy', $receipt) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-link" data-toggle="tooltip"
                                                data-placement="bottom" title="{{ __('Delete Receipt') }}"
                                                onclick="confirm('정말 영수증을 지우겠습니까? 다시 못돌립니다.') ? this.parentElement.submit() : ''">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $receipts->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
