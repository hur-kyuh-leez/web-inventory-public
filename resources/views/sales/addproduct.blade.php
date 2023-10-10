@extends('layouts.app', ['page' => __('Add Product'), 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add Product') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.show', [$sale->id]) }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.product.store', $sale) }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-product">{{ __('Product') }}</label>
                                    <select name="product_id" id="input-product" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
                                        @foreach ($products as $product)
                                            @if($product['id'] == old('product_id'))
                                                <option value="{{$product['id']}}" selected>[{{ $product->category->name }}] {{ $product->name }} - Base price: {{ $product->price }}$</option>
                                            @else
                                                <option value="{{$product['id']}}">[{{ $product->category->name }}] {{ $product->name }} - Base price: {{ $product->price }}$</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>

                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-price">{{ __('Price per Unit') }}</label>
                                    <input type="number" name="price" id="input-price" step=".01" class="form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="0" required>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>

                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-qty">{{ __('Quantity') }}</label>
                                    <input type="number" name="qty" id="input-qty" class="form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="1" required>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>
                                <div class="alert alert-primary" id="hidden_alert_input_product" hidden> {{ __('왜 안나오지...') }}</div>


                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-sale_category">{{ __('Sale Category') }}</label>
                                    <select name="sale_category" id="input-sale_category" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
                                        <option value="normal" selected>{{ __('Normal') }}</option>
                                        <option value="bonus">{{ __('Bonus') }}</option>
                                        <option value="gift">{{ __('Gift') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>

{{--                                @if($upgradable)--}}
{{--                                    <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">--}}
{{--                                        <label class="form-control-label" for="input-set_bool">{{ __('Upgrade Sale?') }}</label>--}}
{{--                                        <select name="set_bool" id="input-set_bool" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>--}}
{{--                                            <option value="1" >{{ __('Yes') }}</option>--}}
{{--                                            <option value="0" selected>{{ __('No') }}</option>--}}
{{--                                        </select>--}}
{{--                                        @include('alerts.feedback', ['field' => 'product_id'])--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                <div class="alert alert-primary" id="hidden_alert_set_bool" hide> {{ __('업그레이드 된 주문서는 세트로 인정 되지 않습니다. ') }}</div>--}}

                                    <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-total">{{ __('Total Amount') }}</label>
                                        <input type="text" name="total_amount" id="input-total" class="form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="₩0" disabled>
                                        @include('alerts.feedback', ['field' => 'product_id'])
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
@endsection

@push('js')
    <script>
        new SlimSelect({
            select: '.form-select'
        });
        new SlimSelect({
            select: '#input-sale_category'
        });

        new SlimSelect({
            select: '#input-set_bool'
        });
    </script>
    <script>
        let input_qty = document.getElementById('input-qty');
        let input_price = document.getElementById('input-price');
        let input_total = document.getElementById('input-total');
        input_qty.addEventListener('input', updateTotal);
        input_price.addEventListener('input', updateTotal);
        function updateTotal () {
            input_total.value = "₩" + (parseInt(input_qty.value) * parseFloat(input_price.value));

        }

        // 선물이나 보너스일 때 가격 0로 만들기
        let input_sales_category = document.getElementById('input-sale_category');
        input_sales_category.addEventListener('change', updatePrice);
        function updatePrice () {
            if(input_sales_category.value != 'normal')
            {
                input_price.value = 0;

                updateTotal();


            }
        }

        //
        let input_set_bool = document.getElementById('input-set_bool');
        let hidden_alert_set_bool = document.getElementById('hidden_alert_set_bool');
        input_set_bool.addEventListener('change', updateHiddenforSetBool);
        function updateHiddenforSetBool () {
            if(hidden_alert_set_bool.value == 0)
            {
                // hide 인 거 여기서 풀기 알림
                hidden_alert_set_bool.removeAttribute("hidden");

            }
            else{
                hidden_alert_set_bool.setAttribute("hidden");
            }
        }

        // 세트 추가 할 때 수량 자동으로 0으로 하기
        let input_product = document.getElementById('input-product');
        let hidden_alert_input_product = document.getElementById('hidden_alert_input_product');
        input_product.addEventListener('change', updateHiddenforInputProduct);
        function updateHiddenforInputProduct () {
            if(hidden_alert_input_product.value == 2) //세트 id가 64
            {
                // hidden 인 거 여기서 풀기 알림
                hidden_alert_input_product.removeAttribute("hidden");
                input_qty.value = 0
            }
            else{
                hidden_alert_input_product.setAttribute("hidden");

            }
        }







    </script>
@endpush
