@extends('layouts.app')

@section('header_scripts')
@endsection

@section('cashier_content')
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-5">
            <a href="{{ route('customer') }}" class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary"><i
                    class="fa-solid fa-building"></i> Customers</a>
            </a>
            <form action="{{ route('edit_customer_submit') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                @error('name')
                    @include('components.error-message')
                @enderror
                <label for="name">Name</label>
                <input name="name" id="name" class="form-control form-control-xl mb-xl-3" type="text" aria-label="name"
                    value="{{ $name }}">

                @error('address')
                    @include('components.error-message')
                @enderror
                <label for="address">Address</label>
                <input name="address" id="address" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="San Jose City, Nueva Ecija" aria-label="address" value="{{ $address }}">

                @error('contact_num')
                    @include('components.error-message')
                @enderror
                <label for="contact_num">Contact #</label>
                <input name="contact_num" id="contact_num" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="0912-345-6789" aria-label="contact_num" value="{{ $contact_num }}">

                <input type="submit" class="float-end btn btn-button-submit text-white py-xl-2 px-xl-5" value="Update Customer">
            </form>
        </div>
        <div class="col-xl-4">
            <div id="reader" class="w-75"></div>
        </div>
    </div>
@endsection

@section('content')
    @include('components.cashier.content')
@endsection
