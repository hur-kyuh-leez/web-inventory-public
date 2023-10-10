
@extends('layouts.app', ['pageSlug' => 'dashboard', 'page' => __('Dashboard'), 'section' => ''])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Not Authorized</div>

                    <div class="card-body">
                        You not Authorized to do such action.

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
