@php
use App\Http\Controllers\RRController;
use App\Http\Controllers\POSController;

@endphp

@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('header_scripts')
    <script defer>
        const MODE_CASH = {{ MODE_CASH }};
        const MODE_GCASH = {{ MODE_GCASH }};
        const MODE_CREDIT_CARD = {{ MODE_CREDIT_CARD }};
        let show_modal = false;
        @if ($errors->any())
            show_modal = true;
        @endif
    </script>
    <script src="{{ asset('js/scope/pos.js') }}" defer type="module"></script>
@endsection

@section("{$user}_content")
    <div class="row px-xl-5 mb-xl-3">
        @include('layouts.heading')
        <div class="col-xl-12">
            <a href="{{ route('rr_index') }}" id="btn-return-refund" class="btn btn-success text-white mb-xl-3" title="[Alt] + [R]">
                <i class="fa-solid fa-receipt"></i> Returns/Refunds
            </a>
            @if (Auth::user()->role_id == 1)
                <a href="{{ route('pos_finish') }}" id="btn-transactions" class="btn btn-success text-white mb-xl-3"
                    title="[Alt] + [T]">
                    <i class="fa-solid fa-file-invoice"></i> Transactions
                </a>
            @endif
            <a href="{{ route('pos_installments') }}" id="btn-installments" class="btn btn-success text-white mb-xl-3"
                title="">
                <i class="fa-solid fa-credit-card"></i> Installments
            </a>
        </div>
        <div class="col-xl-3">
            <form id="{{ $form = 'pos' }}" action="{{ action([POSController::class, 'checkout']) }}" method="POST">
                @csrf
                <label for="name">Item Name</label>
                <input name="name" id="name" class="form-control form-control-xl mb-xl-3" type="text" aria-label="name"
                    value="{{ old('name') }}" tabindex="1">

                <label for="item_code">Item Code</label>
                <input name="item_code" id="item_code" class="form-control form-control-xl mb-3" type="text"
                    aria-label="item_code" value="{{ old('item_code') }}">

                <div class="row align-items-end mb-3">
                    <div class="col-xl">
                        <label for="item_code">Scan Using Camera</label>
                        <select name="cam" id="cam" class="form-select mr-xl-3 d-inline-block align-middle"> --}}
                            <option>Loading camera...</option>
                        </select>
                    </div>
                    <div class="col-xl-auto">
                        <button id="scanner" class="btn btn-success"><i class="fa-solid fa-barcode"></i></button>
                    </div>
                </div>
                <button id="add-item" class="float-end btn btn-button text-primary py-xl-2 px-xl-5" type="submit"
                    title="[Alt] + [A]">Add
                    Item</button>
            </form>
        </div>
        <div class="col-xl-2">
            <label for="s_quantity">Quantity</label>
            <input name="s_quantity" id="s_quantity" class="form-control form-control-xl mb-xl-3" type="number"
                aria-label="s_quantity" tabindex="2" value="{{ old('s_quantity') }}" form="pos">

            <label for="s_total">Total</label>
            <input name="s_total" id="s_total" class="form-control form-control-xl mb-xl-3" type="text" readonly
                aria-label="s_total" value="{{ old('s_total') }}" form="pos">
            <p class="text-center m-0 p-0 fs-3">Pay Cash</p>
            <button id="pay-cash" type="submit" form="pos"
                class="bg-none bg-transparent border-0 border-none d-block mx-auto">
                <i class="btn btn-success d-block mx-auto fa-solid fa-peso-sign rounded-circle"></i><br />
            </button>
        </div>
        <div class="col-xl-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control form-control-xl mb-xl-3" readonly
                form="pos">{{ old('description') }}</textarea>

            <label for="s_price">Unit Price</label>
            <input name="s_price" id="s_price" class="form-control form-control-xl mb-xl-3" type="number" min="1"
                aria-label="s_price" readonly value="{{ old('s_price') }}" form="pos">

            <label for="s_stock">Stock</label>
            <input name="s_stock" id="s_stock" class="form-control form-control-xl mb-xl-3" type="number" min="1"
                aria-label="s_stock" readonly value="{{ old('s_stock') }}" form="pos">

        </div>
        <div class="col-xl-3">
            <div id="reader" class="me-auto"></div>
        </div>
        <div class="col-xl-12">
            <div class="d-flex align-items-end mb-3 w-50 ms-auto">
                <b class="fs-5 ms-auto" id="total">
                    <b class="fs-5 me-5">Total</b>
                    <input type="hidden" name="total" value="{{ old('total') ?? '0.00' }}" form="pos">
                    <span>{{ old('total') ?? '0.00' }}</span>
                </b>
                <button id="clear-table" class="btn btn-danger px-4 py-3 ms-auto" title="[Alt] + [C]">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Clear Table</button>

            </div>
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
        </div>
        <div id="pay-cash-modal">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pay Cash</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="pos-error" class="d-none rounded-1 bg-danger p-xl-3 text-primary mb-xl-2">

                            </div>

                            <label for="mode_of_payment">Mode of Payment</label>
                            <div class="input-group mb-3">
                                <select name="mode_of_payment" id="mode_of_payment" class="form-select" form="pos">
                                    <option value="{{ MODE_CASH }}"
                                        {{ old('mode_of_payment') == MODE_CASH ? 'selected' : '' }}>Cash</option>
                                    <option value="{{ MODE_GCASH }}"
                                        {{ old('mode_of_payment') == MODE_GCASH ? 'selected' : '' }}>GCash</option>
                                    <option value="{{ MODE_CREDIT_CARD }}"
                                        {{ old('mode_of_payment') == MODE_CREDIT_CARD ? 'selected' : '' }}>Credit Card
                                    </option>
                                </select>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="senior_discounted" id="senior_discounted" value="true"
                                    class="form-check-input" form="pos">
                                <input type="hidden" name="senior_discount" id="senior_discount"
                                    value="{{ $senior_discount }}" form="pos">
                                <label for="senior_discounted">Senior ({{ $senior_discount * 100 }}% off)</label>
                            </div>

                            <label for="amount_paid">Amount Paid</label>
                            <input name="amount_paid" id="amount_paid" class="form-control form-control-xl mb-xl-3"
                                type="number" min="1" aria-label="amount_paid" value="{{ old('amount_paid') }}"
                                form="pos">

                            <label for="change">Change</label>
                            <input name="change" id="change" class="form-control form-control-xl mb-xl-3" type="number"
                                min="1" aria-label="change" value="{{ old('change') }}" readonly form="pos">

                            <label for="customer_search">Search Customer</label>
                            <input type="text" name="customer_search" id="customer_search"
                                value="{{ old('customer_search') }}" class="form-control mb-3" form="pos"
                                autocomplete="off">
                            <input type="hidden" id="customer_id">

                            <label for="customer_name">Customer's Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                                class="form-control mb-3" form="pos" autocomplete="off">

                            <label for="customer_address">Customer's Address</label>
                            <input type="text" name="customer_address" id="customer_address"
                                value="{{ old('customer_address') }}" class="form-control mb-3" form="pos"
                                autocomplete="off">

                            <label for="customer_contact_detail">Customer's Contact #</label>
                            <input type="text" name="customer_contact_detail" id="customer_contact_detail"
                                value="{{ old('customer_contact_detail') }}" class="form-control mb-3" form="pos"
                                autocomplete="off">


                            <div class="d-none" id="gcash_inputs">
                                @error('gcash_name')
                                    @include('components.error-message')
                                @enderror
                                <label for="gcash_name">Account Name</label>
                                <input type="text" id="gcash_name" name="gcash_name" value="{{ old('gcash_name') }}"
                                    class="form-control mb-3" form="pos">
                                @error('gcash_num')
                                    @include('components.error-message')
                                @enderror
                                <label for="gcash_num">GCash Number</label>
                                <input type="number" id="gcash_num" name="gcash_num" value="{{ old('gcash_num') }}"
                                    class="form-control mb-3" form="pos">
                            </div>
                            <div class="d-none" id="cc_inputs">
                                @error('cc_name')
                                    @include('components.error-message')
                                @enderror
                                <label for="cc_name">Account Name</label>
                                <input type="text" id="cc_name" name="cc_name" value="{{ old('cc_name') }}"
                                    class="form-control mb-3" form="pos">
                                @error('cc_num')
                                    @include('components.error-message')
                                @enderror
                                <label for="cc_num">Credit Card Number</label>
                                <input type="number" id="cc_num" name="cc_num" value="{{ old('cc_num') }}"
                                    class="form-control mb-3" form="pos">

                                @error('cc_payment_term')
                                    @include('components.error-message')
                                @enderror
                                <p class="my-0">Term</p>
                                <input type="radio" class="form-check-input" name="cc_payment_term"
                                    {{ old('cc_payment_term') == TERM_1_WEEK ? 'checked' : '' }} id="term-1-week"
                                    value="{{ TERM_1_WEEK }}" form="pos">
                                <label for="term-1-week">1 week</label>
                                <input type="radio" class="form-check-input ms-3" name="cc_payment_term"
                                    {{ old('cc_payment_term') == TERM_15_DAYS ? 'checked' : '' }} id="term-15-days"
                                    value="{{ TERM_15_DAYS }}" form="pos">
                                <label for="term-15-days">15 days</label>
                                <input type="radio" class="form-check-input ms-3" name="cc_payment_term"
                                    {{ old('cc_payment_term') == TERM_30_DAYS ? 'checked' : '' }} id="term-30-days"
                                    value="{{ TERM_30_DAYS }}" form="pos">
                                <label for="term-30-days">30 days</label>

                            </div>

                            <button id="submit_pos" class="form-control btn btn-button text-primary py-xl-2 px-xl-5"
                                type="submit" form="pos">Finish</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('components.pin-modal')
    </div>
@endsection


@section('content')
    @include("components.{$user}.content")
@endsection
