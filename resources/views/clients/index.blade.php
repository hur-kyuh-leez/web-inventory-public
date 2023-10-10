@extends('layouts.app', ['page' => __('Clients'), 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Clients') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('clients.create') }}" class="btn btn-sm btn-primary">{{ __('Add Client') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">

                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Total Purchases') }}</th>
                                <th>{{ __('Total Payment') }}</th>
                                <th>{{ __('Last Purchase') }}</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                        <td>
                                            <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                                            <br>
                                            {{ $client->phone }}
                                        </td>
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
                                        <td>
                                            @if(!empty($client->sales->selected_date))
                                                {{ ($client->sales->sortByDesc('selected_date')->first()) ? $client->sales->sortByDesc('selected_date')->first()->selected_date : 'N/A' }}
                                            @else
                                                {{ ($client->sales->sortByDesc('created_at')->first()) ? date('Y-m-d', strtotime($client->sales->sortByDesc('created_at')->first()->created_at)) : 'N/A' }}
                                            @endif


                                        </td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('clients.show', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('More Details') }}">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('Edit Client') }}">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('clients.destroy', $client) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="{{ __('Delete Client') }}" onclick="confirm('{{ __('Do you wish to delete this client info? All transactions and payments related to this client will NOT be deleted.') }}') ? this.parentElement.submit() : ''">
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
                        {{ $clients->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
