@php
use App\Http\Controllers\CategoryController;
@endphp

@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/add_product.js') }}" defer type="module"></script>
@endsection

@section('admin_content')
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-5">
            <a href="{{ action([CategoryController::class, 'index']) }}"
                class="btn btn-success py-xl-2 px-xl-3 mb-xl-3 text-primary"><i class="fa fa-plus-circle"></i> Add
                Category</a>
            <form action="{{ url('/product/add') }}" method="POST">
                @csrf
                @error('item_code')
                    @include('components.error-message')
                @enderror
                <div class="row align-items-end mb-3">
                    <div class="col-xl-5 pe-1">
                        <label for="item_code">Item Code</label>
                        <input name="item_code" id="item_code" class="form-control form-control-xl" type="text"
                            aria-label="item_code" value="{{ old('item_code') }}">
                    </div>
                    <div class="col-xl-1 px-0">
                        <button id="new_item_code" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></button>
                    </div>
                    <div class="col-xl-5 pe-1">
                        <label for="item_code">Scan Using Camera</label>
                        <select name="cam" id="cam" class="form-select mr-xl-3 d-inline-block align-middle"> --}}
                            <option>Loading camera...</option>
                        </select>
                    </div>
                    <div class="col-xl-1 px-0">
                        <button id="scanner" class="btn btn-success"><i class="fa-solid fa-barcode"></i></button>
                    </div>
                </div>


                @error('name')
                    @include('components.error-message')
                @enderror
                <label for="name">Item Name</label>
                <input name="name" id="name" class="form-control form-control-xl mb-xl-3" type="text" aria-label="name"
                    value="{{ old('name') }}">

                @error('description')
                    @include('components.error-message')
                @enderror
                <label for="description">Description</label>
                <textarea name="description" id="description"
                    class="form-control form-control-xl mb-xl-3">{{ old('description') }}</textarea>

                @error('category_id')
                    @include('components.error-message')
                @enderror
                <label for="category_id">Category</label>
                @if (count($categories) === 0)
                    <a href="{{ action([CategoryController::class, 'index']) }}"
                        class="d-block py-xl-3 text-decoration-underline text-danger"><i class="fa fa-plus-circle"></i> Add
                        Category first</a>
                @else
                    <select name="category_id" id="category_id" class="form-select mb-xl-3">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                @endif

                @error('price')
                    @include('components.error-message')
                @enderror
                <label for="price">Unit Price</label>
                <input name="price" id="price" class="form-control form-control-xl mb-xl-3" type="number" aria-label="price"
                    value="{{ old('price') }}" placeholder="e.g. 100.50">

                @error('unit')
                    @include('components.error-message')
                @enderror
                <label for="unit">Unit</label>
                <select name="unit" id="unit" class="form-select mb-xl-3">
                    <option value="piece" {{ old('unit') == 'piece' ? 'selected' : '' }}>Piece</option>
                    <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>Liter</option>
                    <option value="kilogram" {{ old('unit') == 'kilogram' ? 'selected' : '' }}>Kilogram</option>
                </select>

                @error('stock')
                    @include('components.error-message')
                @enderror
                <label for="stock">Max Stocks</label>
                <input name="stock" id="stock" class="form-control form-control-xl mb-xl-3" type="number"
                    placeholder="e.g. 100" aria-label="stock" value="{{ old('stock') }}">

                @error('expiration_date')
                    @include('components.error-message')
                @enderror
                <label for="expiration_date">Expiration Date</label>
                <input name="expiration_date" id="expiration_date" class="form-control form-control-xl mb-xl-3" type="text"
                    placeholder="2030-12-30" aria-label="expiration_date" value="{{ old('expiration_date') }}"
                    autocomplete="off">

                @error('inv_stock')
                    @include('components.error-message')
                @enderror
                <label for="inv_stock">Inventory Stocks (Optional)</label>
                <input name="inv_stock" id="inv_stock" class="form-control form-control-xl mb-xl-3" type="number"
                    placeholder="e.g. 100" aria-label="inv_stock" value="{{ old('inv_stock') }}">

                <button class="float-end btn btn-button text-primary py-xl-2 px-xl-5" type="submit"
                    @if (count($categories) === 0) disabled @endif>Add Item</button>
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
