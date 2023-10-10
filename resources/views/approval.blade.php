@extends('layouts.app', ['pageSlug' => 'dashboard', 'page' => __('Dashboard'), 'section' => ''])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{ __('Waiting for Approval') }}</div>

                    <div class="card-body">
                        {{ __('Your account is waiting for our administrator approval') }}
                        <br />
                        {{ __('Please check back later') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
