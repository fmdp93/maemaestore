@php
use App\Http\Controllers\AccountsController;
@endphp
@extends('layouts.app')

@section('header_scripts')
    <script>
        const search_url = '{{ route('search_order_history') }}';
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/order_history.js') }}" defer type="module"></script>
@endsection

@section('admin_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="row">
                <div class="col-12 col-xl-3">
                    <a href="{{ route('orders') }}" class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary"><i
                            class="fa fa-list"></i> View Orders</a>
                    <a href="{{ url('/inventory/purchase-order') }}"
                        class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary">
                        <i class="fa fa-plus-circle"></i> Purchase Order</a>
                </div>
                <div class="col-xl-3 ms-auto">
                    @include('components.search')
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <table id="product_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item Code</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Base Price</th>
                        <th scope="col">Markup</th>
                        <th scope="col">Selling Price</th>
                        <th scope="col">Expiration Date</th>
                        <th scope="col">Received Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.admin.order-history-list')
                </tbody>
            </table>
            <div id="pages">
                {{ $products->links() }}
            </div>
            @empty($products)
                @include('layouts.empty-table')
            @endempty
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
