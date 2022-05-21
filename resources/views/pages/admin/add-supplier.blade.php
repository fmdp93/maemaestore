@php
use App\Http\Controllers\AccountsController;
@endphp

@extends('layouts.app')

@section('header_scripts')
@endsection

@section('admin_content')
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-5">
            <a href="{{ route('suppliers') }}" class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary"><i
                    class="fa-solid fa-building"></i> Suppliers</a>
            <a href="{{ url('/inventory/purchase-order') }}" class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary">
                <i class="fa fa-plus-circle"></i> Purchase Order
            </a>
            <form action="{{ route('add_supplier_submit') }}" method="POST">
                @csrf
                @error('vendor')
                    @include('components.error-message')
                @enderror
                <label for="vendor">Vendor</label>
                <input name="vendor" id="vendor" class="form-control form-control-xl mb-xl-3" type="text" aria-label="vendor"
                    value="{{ old('vendor') }}">

                @error('company_name')
                    @include('components.error-message')
                @enderror
                <label for="company_name">Company Name</label>
                <input name="company_name" id="company_name" class="form-control form-control-xl mb-xl-3" type="text"
                    aria-label="company_name" value="{{ old('company_name') }}">

                @error('address')
                    @include('components.error-message')
                @enderror
                <label for="address">Address</label>
                <input name="address" id="address" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="San Jose City, Nueva Ecija" aria-label="address" value="{{ old('address') }}">

                @error('contact_num')
                    @include('components.error-message')
                @enderror
                <label for="contact_num">Contact #</label>
                <input name="contact_num" id="contact_num" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="0912-345-6789" aria-label="contact_num" value="{{ old('contact_num') }}">

                <input type="submit" class="float-end btn btn-button text-primary py-xl-2 px-xl-5" value="Add Supplier">
            </form>
        </div>
        <div class="col-xl-4">
            <div id="reader" class="w-75"></div>
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
