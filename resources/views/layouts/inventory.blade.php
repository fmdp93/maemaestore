@extends('layouts.app')

@section('header_scripts')
    <script>
        const product_search_url = '{{ $product_search_url }}'
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/inventory.js') }}" defer type="module"></script>
    @yield('layout_header_scripts')
@endsection

@section($content)    
    @yield('inventory_modal')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            @yield('inventory_headings')
            @include('components.inventory-list-table')
        </div>
    </div>
@endsection

@section('content')
    @include($components_content)
@endsection
