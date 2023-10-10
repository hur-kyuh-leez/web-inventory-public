@extends('layouts.app', ['page' => __('List of Products'), 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Products') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">{{ __('New Product') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">{{ __('Category') }}</th>
                                <th scope="col">{{ __('Product') }}</th>
                                <th scope="col">{{ __('Received') }}</th>
                                <th scope="col">{{ __('Total Sold') }}</th>

                                {{--                                <th scope="col">{{ __('Base Price') }}</th>--}}
                                <th scope="col">{{ __('Stock') }}</th>
{{--                                <th scope="col">{{ __('Future Stock') }}</th>--}}
{{--                                <th scope="col">{{ __('Faulty') }}</th>--}}
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></td>
                                        <td>{{ $product->name }}</td>

                                        <td>{{ $product->receiveds->sum('stock') }}</td>
                                        <td>{{ $product->solds->sum('qty') }}</td>

                                        {{--                                        <td>{{ format_money($product->price) }}</td>--}}
{{--                                        <td>{{ $product->stock }}</td>--}}
                                        <td>{{ $product->receiveds->sum('stock') - $product->solds->sum('qty') }}</td>
{{--                                        <td>{{ $product->stock_defective }}</td>--}}

                                        <td class="td-actions text-right">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('More Details') }}">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('Edit Product') }}">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('Delete Product') }}" onclick="confirm('{{ __('Are you sure you want to remove this product? The records that contain it will continue to exist.') }}') ? this.parentElement.submit() : ''">
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
                    <nav class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
