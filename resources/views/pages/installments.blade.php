@php
use App\Http\Controllers\AccountsController;
@endphp
@extends('layouts.app')

@section('header_scripts')
    <script>
        const search_url = '{{ route('search_installment') }}';
        const view_action = '{{ $view_action }}';
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/installment.js') }}" defer type="module"></script>
@endsection

@section("{$user}_content")
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-3 ms-auto">
                    @include('components.search')
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <table id="installment_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Trans. #</th>
                        <th scope="col">Date</th>
                        <th scope="col">Item</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Amount Paid</th>
                        <th scope="col">Change</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.installment-list')
                </tbody>
            </table>
            <div id="pages">
                {{ $installments->links() }}
            </div>

            @include('layouts.empty-table')
        </div>
    </div>
@endsection

@section('content')
    @include("components.{$user}.content")
@endsection
