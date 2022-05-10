@php
    use App\Http\Controllers\CashierProductsController;
@endphp
@extends('layouts.app')

@section('title')
    Products
@endsection

@section('header_scripts')
    <script>
        const product_search_url = '{{ CashierProductsController::$product_search_url}}';
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/products.js') }}" defer type="module"></script>
@endsection

@section('cashier_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="row mb-xl-4">
                <div class="col-xl-2">
                    <label for="search">Search Product</label>
                    @include('components.search')                    
                </div>
                <div class="col-xl-2">
                    <label for="cam" class="w-100">Use Camera</label>                    
                    <select name="cam" id="cam" class="form-select d-inline-block align-middle w-75">
                        <option>Loading camera...</option>
                    </select>
                    <button id="scanner" class="btn btn-success"><i class="fa-solid fa-barcode"></i></button>                                        
                </div>
                <div class="col-xl-3">
                    <div id="reader" class="mt-3"></div>
                </div>
                <div class="col-xl-3 ms-auto">
                    <label for="category_id">Filter By Category</label>
                    <select name="category_id" id="category_id" class="form-select" form="{{ $form_id }}">
                        <option value="0">All</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table id="products_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Expiration</th>                        
                    </tr>
                </thead>
                <tbody>
                    @include('components.cashier.products-list')
                </tbody>
            </table>
            <div id="pages">
                {{ $products->links() }}
            </div>
            @include('layouts.empty-table')
        </div>
    </div>
@endsection

@section('content')
    @include('components.cashier.content')
@endsection
