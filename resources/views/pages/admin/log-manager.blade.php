@php
use App\Http\Controllers\LogManagerController;
@endphp

@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/search.js') }}" defer></script>    
    <script src="{{ asset('js/scope/log-manager.js') }}" defer></script>    
@endsection

@section('admin_content')
    <div class="row vh-100">
        <div class="col-xl-12 px-xl-5 text-center">            
            <div class="align-items-end d-flex h-25">
                @include('layouts.heading')    
            </div>            
            <div id="log-manager" class="d-flex text-center justify-content-center">                                
                <a class="p-3 d-block" href="{{ action([LogManagerController::class, 'product']) }}">
                    <div class="icon-container rounded-circle mx-auto text-center">
                        <i class="fa-solid fa-clipboard-list align-middle"></i>
                    </div>
                    <span>PRODUCT</span>
                </a>
    
                <a class="p-3 d-block " href="{{ action([LogManagerController::class, 'inventory']) }}">
                    <div class="icon-container rounded-circle mx-auto text-center">
                        <i class="fa-solid fa-box align-middle"></i>
                    </div>
                    <span>INVENTORY</span>
                </a>
    
                <a class="p-3 d-block " href="{{ action([LogManagerController::class, 'account']) }}">
                    <div class="icon-container rounded-circle mx-auto text-center">
                        <i class="fa-solid fa-user align-middle"></i>
                    </div>
                    <span>ACCOUNT</span>
                </a>
                <a class="p-3 d-block" href="{{ action([LogManagerController::class, 'login']) }}">
                    <div class="icon-container rounded-circle mx-auto text-center">
                        <i class="fa-solid fa-tags align-middle"></i>
                    </div>
                    <span>LOGIN</span>
                </a>
            </div>
            

        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
