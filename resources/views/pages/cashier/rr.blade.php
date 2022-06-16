@php
use App\Http\Controllers\RRController;
@endphp

@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('header_scripts')
    <script src="{{ asset('js/scope/rr.js') }}" defer type="module"></script>
    <script>
        // if(last_location != 'this_location')){
        //     window.location.href = "/pos/return-refund";
        // }
    </script>
@endsection

@section("{$user}_content")
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        {{-- <div class="col-xl-3">            
            
                @csrf
                <input type="text" value="0" class="d-none" id="initial_load" name="initial_load">
                <label for="name">Item Name</label>
                <input name="name" id="name" class="form-control form-control-xl mb-xl-3" type="text" aria-label="name"
                    value="{{ old('name') }}" tabindex="1">

                <label for="item_code">Item Code</label>
                <input name="item_code" id="item_code" class="form-control form-control-xl mb-3" type="text"
                    aria-label="item_code" value="{{ old('item_code') }}">
                <label for="s_quantity">Quantity</label>
                <input name="s_quantity" id="s_quantity" class="form-control form-control-xl mb-xl-3" type="number"
                    aria-label="s_quantity" tabindex="2" value="{{ old('s_quantity') }}" form="{{ $form }}">

                <label for="s_total">Total</label>
                <input name="s_total" id="s_total" class="form-control form-control-xl mb-xl-3" type="text" readonly
                    aria-label="s_total" value="{{ old('s_total') }}" form="{{ $form }}">

                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control form-control-xl mb-xl-3" readonly
                    form="{{ $form }}">{{ old('description') }}</textarea>

                <label for="s_price">Unit Price</label>
                <input name="s_price" id="s_price" class="form-control form-control-xl mb-xl-3" type="number" min="1"
                    aria-label="s_price" readonly value="{{ old('s_price') }}" form="{{ $form }}">
                <button id="add-item" class="float-end btn btn-button-submit text-white py-xl-2 px-xl-5" type="submit">Add
                    Item</button>
            </form>
        </div> --}}
        <div class="col-xl-12">
            <div class="row mb-3">
                <div class="col-xl-3 me-auto">
                    <form id="{{ $form }}" action="{{ action([RRController::class, 'store']) }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            @error('transaction_id')
                                @include('components.error-message')
                            @enderror
                        </div>
                        <label for="transaction_id">Transaction ID</label>

                        <div class="input-group">
                            <input type="text" name="transaction_id" id="transaction_id"
                                value="{{ old('transaction_id') }}" class="form-control" form="{{ $form }}"
                                autocomplete="off">
                            <input type="submit" value="Search" class="btn" id="transaction_search">
                        </div>
                    </form>
                </div>

                <div class="col-xl-6 d-flex align-items-end ms-auto">
                    <b class="fs-5 ms-auto" id="total">
                        <b class="fs-5 me-5">Total</b>
                        <input type="hidden" name="total" value="{{ old('total') ?? '0.00' }}" form="{{ $form }}">
                        <span>{{ old('total') ?? '0.00' }}</span>
                    </b>
                    <button id="clear-table" class="btn btn-danger px-4 py-3 ms-auto">
                        <i class="fa-solid fa-circle-xmark"></i>
                        Clear Table</button>

                </div>
            </div>
            @if ($errors->any())
                @php
                    // var_dump($errors->all());
                    $message = 'Please Fix the errors below';
                @endphp
                @include('components.error-message')
            @endif
            @error('product_id')
                @include('components.error-message')
            @enderror
            @error('quantity')
                @include('components.error-message')
            @enderror
            @error('price')
                @include('components.error-message')
            @enderror
            <table id="products_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        echo $tbody_content;
                    @endphp
                </tbody>
            </table>
            @include('layouts.empty-table')
            <div class="row">
                <div class="col-xl-3 ms-auto">
                    <div class="mt-3">
                        @error('type')
                            @include('components.error-message')
                        @enderror
                    </div>
                    <input type="radio" id="return" name="type" value="return"
                        {{ old('type') == 'return' ? 'checked' : '' }} form="{{ $form }}">
                    <label for="return">Return</label>

                    <input type="radio" id="refund" name="type" value="refund"
                        {{ old('type') == 'refund' ? 'checked' : '' }} class="ms-4"
                        form="{{ $form }}">
                    <label for="refund">Refund</label>

                    <div class="mt-3">
                        <label for="remark">Remark</label>
                        <select name="remark" id="remark" class="form-select" form="{{ $form }}">
                            <option value="Spoilage" {{ old('remark') == 'Spoilage' ? 'selected' : '' }}>Spoilage
                            </option>
                            <option value="Damaged" {{ old('remark') == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                        </select>
                    </div>
                    <button type="submit" class="form-control mt-3 btn btn-danger" form="{{ $form }}">Submit
                        Return/Refund</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    @include("components.{$user}.content")
@endsection
