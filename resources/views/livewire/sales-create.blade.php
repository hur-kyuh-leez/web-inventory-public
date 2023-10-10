<div>
    <div class="container-fluid mt--7">
        @include('alerts.error')
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Register Sale') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">{{ __('Back to List') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('sales.store') }}" autocomplete="off">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">{{ __('Customer Information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Seller') }}</label>
                                        <select wire:model="current_seller_id" name="user_id" id="input-seller" class="form-select {{ $errors->has('user_id') ? 'is-invalid' : '' }}" required>
                                            <option value="">{{ __('Select your option') }}</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'user_id'])
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group{{ $errors->has('order_date') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-order_date">{{ __('Order Date') }}</label>
                                        <input wire:model="order_date" type="text" name="order_date" id="datepicker" class="datepicker-selector form-control form-control-alternative {{ $errors->has('order_date') ? 'is-invalid' : '' }}" placeholder="{{ __('Order Date') }}" value="{{ old('order_date') }}"  onchange="this.dispatchEvent(new InputEvent('input'))" required>
                                        @include('alerts.feedback', ['field' => 'order_date'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Client') }}</label>
                                        <select wire:model="client_id" name="client_id" id="input-client_id" class="form-select form-control-alternative{{ $errors->has('client_id') ? ' is-invalid' : '' }}" required>
                                            <option value="" disabled selected>{{ __('Select your option') }}</option>

                                             @foreach($clients as $client)
    {{--                                            lasted added client will be selected. this is on purpose since lasted add client most likely will be purchasing--}}
                                                @if($client['user_id'] == $current_seller_id and !is_null($client['id']))
                                                    <option {{$client['id']}}" value="{{$client['id']}}">{{$client['name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'client_id'])
                                    </div>
                                </div>

                                <div hidden>
                                    @foreach($sales as $sale)
                                        @if($sale->client_id == $client_id and !is_null($sale->order_date) and $sale->order_date==$order_date)
                                           {{ $hide_bool = true}}
                                        @endif
                                    @endforeach
                                </div>

                                @if($hide_bool!= true and !is_null($client_id))
                                    <div class="col-3">
                                        <div class="form-group{{ $errors->has('set_bool') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('세트 판매') }}</label>
                                            <select wire:model="set_bool" name="set_bool" id="input-set_bool" class="form-select form-control-alternative{{ $errors->has('set_bool') ? ' is-invalid' : '' }}" required>
                                                <option value="1">{{ __('Yes') }}</option>
                                                <option value="0">{{ __('No') }}</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'set_bool'])
                                        </div>
                                    </div>
                                    @if($set_bool == '0')
                                        <div class="col-3">
                                            <div class="form-group{{ $errors->has('upgraded_bool') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-name">{{ __('업그레이드 판매') }}</label>
                                                <select  name="upgraded_bool" id="input-upgraded_bool" class="form-select form-control-alternative{{ $errors->has('upgraded_bool') ? ' is-invalid' : '' }}" required>
                                                    <option value="1">{{ __('Yes') }}</option>
                                                    <option value="0">{{ __('No') }}</option>
                                                </select>
                                                @include('alerts.feedback', ['field' => 'upgraded_bool'])
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            </div>
                            <button type="submit" class="btn btn-success mt-4">{{ __('Continue') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>



        // livewire 문제니 일단 안쓰는 걸로
        // document.addEventListener('livewire:load', function () {
        //
        //     new SlimSelect({
        //         select: '#input-seller'
        //     })
        //     new SlimSelect({
        //         select: '#input-client_id'
        //     })
        // })
        //
        // document.addEventListener('livewire:update', function () {
        //
        //     new SlimSelect({
        //         select: '#input-seller'
        //     })
        //     new SlimSelect({
        //         select: '#input-client_id'
        //     })
        //
        //     var a = document.getElementById("input-set_bool")
        //     var b = document.getElementById("input-upgraded_bool")
        //
        //     // Your JS here.
        //     if (a) {
        //         new SlimSelect({
        //             select: '#input-set_bool'
        //         })
        //     }
        //     if (b) {
        //         new SlimSelect({
        //             select: '#input-set_bool'
        //         })
        //     }
        //
        //
        // })
    </script>
</div>

