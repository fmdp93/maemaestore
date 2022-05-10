@php
    use App\Http\Controllers\AccountsController;
    use App\Http\Controllers\CashierAccountsController;
@endphp

@extends('layouts.app')

@section('header_scripts')
@endsection

@section($user_content)
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-5">
            <form action="{{ action([$action_class, 'editAccountSave']) }}" method="POST">
                @csrf
                @error('username')
                    @include('components.error-message')
                @enderror
                <label for="username">Username</label>
                <input name="username" id="username" class="form-control form-control-xl mb-xl-3" type="text"
                    aria-label="username" value="{{ old('username') ?? $user->username }}">

                @error('old_pw')
                    @include('components.error-message')
                @enderror
                <label for="old_pw">Old Password</label>
                <input name="old_pw" id="old_pw" class="form-control form-control-xl mb-xl-3" type="password"
                    aria-label="old_pw">

                @error('new_pw')
                    @include('components.error-message')
                @enderror
                <label for="new_pw">New Password</label>
                <input name="new_pw" id="new_pw" class="form-control form-control-xl mb-xl-3" type="password"
                    aria-label="new_pw">

                @error('first_name')
                    @include('components.error-message')
                @enderror
                <label for="first_name">First Name</label>
                <input name="first_name" id="first_name" class="form-control form-control-xl mb-xl-3" type="text"
                    aria-label="price" value="{{ old('first_name') ?? $user->first_name }}" placeholder="John">

                @error('last_name')
                    @include('components.error-message')
                @enderror
                <label for="last_name">Last Name</label>
                <input name="last_name" id="last_name" class="form-control form-control-xl mb-xl-3" type="text"
                    aria-label="price" value="{{ old('last_name') ?? $user->last_name }}" placeholder="Smith">

                @error('address')
                    @include('components.error-message')
                @enderror
                <label for="address">Address</label>
                <input name="address" id="address" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="San Jose City, Nueva Ecija" aria-label="address"
                    value="{{ old('address') ?? $user->address }}">

                @error('contact_num')
                    @include('components.error-message')
                @enderror
                <label for="contact_num">Contact #</label>
                <input name="contact_num" id="contact_num" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="0912-345-6789" aria-label="contact_num"
                    value="{{ old('contact_num') ?? $user->contact_num }}">

                @error('age')
                    @include('components.error-message')
                @enderror
                <label for="age">Age</label>
                <input name="age" id="age" class="form-control form-control-xl mb-xl-3" type="number" placeholder="18"
                    aria-label="age" value="{{ old('age') ?? $user->age }}" min="5">

                <input type="submit" class="float-end btn btn-button text-primary py-xl-2 px-xl-5" value="Update Account">
            </form>
        </div>
        <div class="col-xl-4">
            <div id="reader" class="w-75"></div>
        </div>
    </div>
@endsection

@section('content')
    @include($include_content)
@endsection
