@extends('layouts.app', ['page' => __('Manage Receipt'), 'pageSlug' => 'receipts', 'section' => 'inventory'])



@section('content')
    @include('alerts.success')
    @include('alerts.error')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Receipt Summary') }}</h4>
                        </div>
                        @if (!$receipt->finalized_at)
                            <div class="col-4 text-right">
                                @if ($receipt->products->count() === 0)
                                    <form action="{{ route('receipts.destroy', $receipt) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            {{ __('Delete Receipt') }}
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-primary"
                                            onclick="confirm('ATTENTION: At the end of this receipt you will not be able to load more products in it.') ? window.location.replace('{{ route('receipts.finalize', $receipt) }}') : ''">
                                        {{ __('Finalize Receipt') }}
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Provider') }}</th>
                        <th>{{ __('Products') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th>{{ __('Defective Stock') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th></th>

                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $receipt->id }}</td>
                            <td> {{ $receipt->received_date ?? date('Y-m-d', strtotime($receipt->created_at)) }}  </td>
                            <td style="max-width:150px;">{{ $receipt->title }}</td>
                            <td>{{ $receipt->user->name }}</td>
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
                            @if($receipt->finalized_at)
                                <td>{{ __('FINALIZED') }}</td>
                            @else
                                <td>
                                    <span style="color:red; font-weight:bold;">{{ __('TO FINALIZE') }}</span>
                                    {{--                                    여기서 라우트 바꿔야 함--}}
                                    <a href="{{ route('receipts.edit', ['receipt' => $receipt]) }}"
                                        class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                        title="{{ __('Edit Receipt') }}">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                </td>
                            @endif


                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Products') }}: {{ $receipt->products->count() }}</h4>
                        </div>
                        @if (!$receipt->finalized_at)
                            <div class="col-4 text-right">
                                <a href="{{ route('receipts.product.add', ['receipt' => $receipt]) }}"
                                   class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th>{{ __('Defective Stock') }}</th>
                        <th>{{ __('Total Stock') }}</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach ($receipt->products as $received_product)
                            <tr>
                                <td>
                                    <a href="{{ route('categories.show', $received_product->product->category) }}">{{ $received_product->product->category->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $received_product->product) }}">{{ $received_product->product->name }}</a>
                                </td>
                                <td>{{ $received_product->stock }}</td>
                                <td>{{ $received_product->stock_defective }}</td>
                                <td>{{ $received_product->stock + $received_product->stock_defective }}</td>
                                <td class="td-actions text-right">
                                    @if(!$receipt->finalized_at)
                                        <a href="{{ route('receipts.product.edit', ['receipt' => $receipt, 'receivedproduct' => $received_product]) }}"
                                           class="btn btn-link" data-toggle="tooltip" data-placement="bottom"
                                           title="{{ __('Edit Product') }}">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                        <form
                                            action="{{ route('receipts.product.destroy', ['receipt' => $receipt, 'receivedproduct' => $received_product]) }}"
                                            method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip"
                                                    data-placement="bottom" title="{{ __('Delete Product') }}"
                                                    onclick="confirm('Do you wish to delete this product?') ? this.parentElement.submit() : ''">
                                                <i class="tim-icons icon-simple-remove"></i>
                                            </button>
                                        </form>
                                    @endif
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
    <script src="{{ asset('assets') }}/js/sweetalerts2.js"></script>
@endpush