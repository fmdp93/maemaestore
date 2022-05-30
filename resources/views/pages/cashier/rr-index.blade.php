@php
use App\Http\Controllers\AccountsController;
@endphp
@extends('layouts.app')

@section('header_scripts')
    <script>
        const search_url = '{{ route("search_rr_pt_id") }}';
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/rr_index.js') }}" defer type="module"></script>
@endsection

@section('cashier_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="row">
                <div class="col-12 col-xl-3">
                    <a href="{{ route('rr_form') }}" class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary"><i
                            class="fa fa-plus-circle"></i> Return/Refund</a>
                </div>
                <div class="col-xl-3 ms-auto">
                    @include('components.search')
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <table id="return_refund_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Amount Paid</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Refunded Quantity</th>
                        <th scope="col">Refunded Amount</th>
                        <th scope="col">Remark</th>
                        <th scope="col">Refunded At</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.cashier.rr-list')
                </tbody>
            </table>
            <div id="pages">
                {{ $return_refunds->links() }}
            </div>
            @empty($return_refunds)
                @include('layouts.empty-table')
            @endempty
        </div>
    </div>
@endsection

@section('content')
    @include('components.cashier.content')
@endsection
