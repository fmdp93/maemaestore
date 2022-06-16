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
            <form action="{{ action([AccountsController::class, 'addCashierSubmit']) }}" method="POST">
                @csrf
                @error('username')
                    @include('components.error-message')
                @enderror
                <label for="username">Username</label>
                <input name="username" id="username" class="form-control form-control-xl mb-xl-3" type="text" aria-label="username"
                    value="{{ old('username') }}">

                @error('password')
                    @include('components.error-message')
                @enderror
                <label for="password">Password</label>
                <input name="password" id="password" class="form-control form-control-xl mb-xl-3" type="password"
                    aria-label="password">

                @error('first_name')
                    @include('components.error-message')
                @enderror
                <label for="first_name">First Name</label>
                <input name="first_name" id="first_name" class="form-control form-control-xl mb-xl-3" type="text"
                    aria-label="price" value="{{ old('first_name') }}" placeholder="John">

                @error('last_name')
                    @include('components.error-message')
                @enderror
                <label for="last_name">Last Name</label>
                <input name="last_name" id="last_name" class="form-control form-control-xl mb-xl-3" type="text"
                    aria-label="price" value="{{ old('last_name') }}" placeholder="Smith">

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

                @error('age')
                    @include('components.error-message')
                @enderror
                <label for="age">Age</label>
                <input name="age" id="age" class="form-control form-control-xl mb-xl-3" type="number" placeholder="18"
                    aria-label="age" value="{{ old('age') }}" min="5">

                <input type="submit" class="float-end btn btn-button-submit text-white py-xl-2 px-xl-5" value="Add Cashier">
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
