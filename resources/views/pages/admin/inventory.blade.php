@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/inventory.js') }}" defer type="module"></script>
@endsection

@section('admin_content')
    @include('components.inventory-modal')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="col-12">
                <a id="btn-deliveries" href="{{ url('/inventory/orders') }}" class="btn btn-success mb-xl-3 text-primary" title="[Alt] + [V]">
                    <i class="fa fa-list"></i> View Orders
                </a>
                <a href="{{ url('/inventory/purchase-order') }}" class="btn btn-success mb-xl-3 text-primary">
                    <i class="fa fa-plus-circle"></i> Purchase Order
                </a>
            </div>
            <div class="row align-items-center mb-xl-4">
                <div class="col-xl-3">
                    @include('components.search')
                </div>
                <div class="col-xl-auto ps-5">
                    <input type="hidden" name="stock_filter" value="{{ request()->input('stock_filter') }}">
                    <button id="normal-stock" data-filter="normal" class="btn btn-button px-4 py-3">
                        <i class="fa-solid fa-circle-check"></i>
                        Normal Stock
                    </button>
                    <button id="half-stock" data-filter="half" class="btn btn-half px-4 py-3">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        Half Stock
                    </button>
                    <button id="low-stock" data-filter="low" class="btn btn-low px-4 py-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Low Stock
                    </button>
                </div>
                <div class="col-xl-auto ms-auto px-0">
                    <label for="category_id">Filter By Category</label>
                </div>
                <div class="col-xl-2">
                    <select name="category_id" id="category_id" class="form-select" form="{{ $form_id ?? '' }}">
                        <option value="0">All</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table id="inventory_list" class="table">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-end">Max Stock</th>
                        <th scope="col" class="text-end">Stock</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Expiration</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.inventory-list')
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
    @include('components.admin.content')
@endsection
