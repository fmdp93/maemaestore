@php
use App\Http\Controllers\SalesReportController;
@endphp

@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
@endsection

@section('admin_content')
    <div class="row">
        <div class="col-xl-12 px-xl-5">
            <div class="row">
                @include('layouts.heading')
                <div class="col-12 mt-3">
                    <a href="{{ route('sales_report') }}" class="btn btn-success text-white mb-xl-3">
                        <i class="fa-solid fa-tag"></i> Sales Report
                    </a>
                    <a href="{{ route('inventory_report') }}" class="btn btn-success text-white mb-xl-3">
                        <i class="fa-solid fa-box"></i> Inventory Report
                    </a>
                </div>
                <div class="ms-auto col-xl-5">
                    <form class="d-flex align-middle" action="{{ route('inventory_report') }}" method="GET">
                        @csrf
                        <label for="from" class="my-auto me-1">From</label>
                        <input class="form-control my-auto me-xl-3" type="text" id="from" name="from" autocomplete="off"
                            value="{{ request()->input('from') }}">
                        <label for="to" class="my-auto me-1">To</label>
                        <input class="form-control my-auto" type="text" id="to" name="to" autocomplete="off"
                            value="{{ request()->input('to') }}">
                        <input type="submit" class="btn btn-primary px-4 my-auto" value="Filter">
                    </form>
                    <a href="{{ route('print_inventory_report', 
                            ['from'=>request()->input('from'), 'to' => request()->input('to')]
                        ) }}"
                        class="btn btn-success text-white mt-3 float-end">
                        <i class="fa-solid fa-print"></i> Print</a>
                </div>
                <div class="col-xl-12">
                    <table id="products_list" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Trans. #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Stock Remaining</th>
                                <th scope="col">Returns</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('components.admin.inventory-report-list')
                        </tbody>
                    </table>
                    <div id="pages">
                        {{ $products->links() }}
                    </div>
                    @empty($products)
                        @include('layouts.empty-table')
                    @endempty
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
