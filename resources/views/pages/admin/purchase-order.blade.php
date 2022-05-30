@php
use App\Http\Controllers\InventoryController;
@endphp

@extends('layouts.app')

@section('title')
    Purchase Order
@endsection

@section('header_scripts')
    <script src="{{ asset('js/scope/purchase-order.js') }}" defer type="module"></script>
@endsection

@section('admin_content')
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-12">
            <a id="btn-deliveries" href="{{ url('/inventory/orders') }}" class="btn btn-success mb-xl-3 text-primary"
                title="[Alt] + [V]">
                <i class="fa fa-list"></i> View Orders
            </a>
        </div>
        <div class="col-xl-3">
            <form id="{{ $form = 'purchase-order' }}" action="{{ action([InventoryController::class, 'store']) }}"
                method="POST">
                @csrf
                <label for="supplier_search">Search Supplier</label>
                <input type="text" name="supplier_search" id="supplier_search" value="{{ old('supplier_search') }}"
                    class="form-control mb-3" form="purchase-order" autocomplete="off">
                <input type="hidden" name="supplier_search_id" id="supplier_search_id" value="{{ old('supplier_search_id') }}">

                @error('vendor')
                    @include('components.error-message')
                @enderror
                <label for="vendor">Vendor</label>
                <input type="text" name="vendor" id="vendor" value="{{ old('vendor') }}" class="form-control mb-3"
                    form="purchase-order" autocomplete="off">

                @error('company')
                    @include('components.error-message')
                @enderror
                <label for="company">Company</label>
                <input type="text" name="company" id="company" value="{{ old('company') }}" class="form-control mb-3"
                    form="purchase-order" autocomplete="off">
                @error('contact')
                    @include('components.error-message')
                @enderror
                <label for="contact">Contact Details</label>
                <input type="text" name="contact" id="contact" value="{{ old('contact') }}" class="form-control mb-3"
                    form="purchase-order" autocomplete="off">
                @error('address')
                    @include('components.error-message')
                @enderror
                <label for="address">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control mb-3"
                    form="purchase-order" autocomplete="off">
                @error('eta')
                    @include('components.error-message')
                @enderror
                <label for="eta">Leading Time</label>
                <input type="text" name="eta" id="eta" value="{{ old('eta') }}" class="form-control mb-3"
                    form="purchase-order" autocomplete="off">
            </form>
        </div>
        <div class="col-xl-3">
            @error('shipping_fee')
                @include('components.error-message')
            @enderror
            <label for="shipping_fee">Shipping Fee</label>
            <input type="number" name="shipping_fee" id="shipping_fee" value="{{ old('shipping_fee') }}"
                class="form-control mb-3" form="purchase-order" autocomplete="off">
            @error('tax')
                @include('components.error-message')
            @enderror
            <label for="tax">Tax</label>
            <input type="number" name="tax" id="tax" class="form-control mb-3" value="{{ old('tax') }}"
                form="purchase-order" autocomplete="off">
            <hr>
            <div>
                <b class="fs-5">Total</b>
                <b class="fs-5 float-end" id="total">
                    <input type="hidden" name="total" value="{{ old('total') ?? '0.00' }}" form="purchase-order">
                    <span>{{ old('total') ?? '0.00' }}</span>
                </b>
            </div>
            <input type="submit" value="Checkout" class="form-control btn btn-primary px-3 py-3 ms-auto mt-5"
                form="purchase-order">
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
