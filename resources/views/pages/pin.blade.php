@php
use App\Http\Controllers\PINController;
@endphp

@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('header_scripts')
    <script src="{{ asset('js/scope/rr.js') }}" defer type="module"></script>
@endsection

@section($content)
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-3">
            @isset($initial_message)
                @php
                    $message = $initial_message
                @endphp
                @include('components.error-message')
            @endisset            
            @error('pin')
                @include('components.error-message')
            @enderror
            <form action="{{ action([PINController::class, 'submitPin']) }}" method="POST">
                @csrf
                <label for="pin">PIN</label>
                <input type="password" class="form-control mb-3" id="pin" name="pin" autofocus>
                <input type="hidden" value="{{ Request::input('referrer') }}" name="referrer">
                <input type="submit" value="Authenticate" class="btn btn-primary px-4 py-3 form-control">
            </form>
        </div>
    </div>
@endsection


@section('content')
    @include($include_content)
@endsection
