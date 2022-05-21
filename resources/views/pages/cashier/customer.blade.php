@php
use App\Http\Controllers\AccountsController;
@endphp
@extends('layouts.app')

@section('header_scripts')
    <script>
        const search_url = '{{ route('customer_search_for_table') }}';
        const delete_action = '{{ $delete_action }}';
        const edit_action = '{{ $edit_action }}';
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/customer.js') }}" defer></script>
@endsection

@section('cashier_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="row">
                <div class="col-12 col-xl-3">
                    <a href="{{ route('add_customer') }}" class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary"><i
                            class="fa fa-plus-circle"></i> Add Customer</a>
                </div>
                <div class="col-xl-3 ms-auto">
                    @include('components.search')
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <table id="customer_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>                        
                        <th scope="col">Address</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.cashier.customer-list')
                </tbody>
            </table>
            <div id="pages">
                {{ $customers->links() }}
            </div>
            @empty($customers)
                @include('layouts.empty-table')
            @endempty
        </div>
    </div>
@endsection

@section('content')
    @include('components.cashier.content')
@endsection
