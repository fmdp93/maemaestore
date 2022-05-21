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
                <div class="col-12 mt-3"></div>
                <div class="col-xl-5">
                    <div class="d-flex">
                        <a class="text-center me-3" href="{{ action([SalesReportController::class, 'index']) }}">
                            <i class="fa-solid fa-calendar-days fa-2x"></i>
                            <p>Overall</p>
                        </a>
                        <a class="text-center mx-3"
                            href="{{ action([SalesReportController::class, 'index']) }}?date_filter=daily">
                            <i class="fa-solid fa-calendar fa-2x"></i>
                            <p>Daily</p>
                        </a>
                        <a class="text-center mx-3"
                            href="{{ action([SalesReportController::class, 'index']) }}?date_filter=weekly">
                            <i class="fa-solid fa-calendar-check fa-2x"></i>
                            <p>Weekly</p>
                        </a>
                        <a class="text-center mx-3"
                            href="{{ action([SalesReportController::class, 'index']) }}?date_filter=monthly">
                            <i class="fa-solid fa-calendar-plus fa-2x"></i>
                            <p>Monthly</p>
                        </a>
                        <a class="text-center mx-3"
                            href="{{ action([SalesReportController::class, 'index']) }}?date_filter=yearly">
                            <i class="fa-solid fa-calendar-week fa-2x"></i>
                            <p>Yearly</p>
                        </a>
                    </div>
                </div>
                <div class="ms-auto col-xl-5">
                    <form class="d-flex align-middle" action="{{ action([SalesReportController::class, 'index']) }}"
                        method="GET">
                        @csrf
                        <label for="from" class="my-auto me-1">From</label>
                        <input class="form-control my-auto me-xl-3" type="text" id="from" name="from" autocomplete="off">
                        <label for="to" class="my-auto me-1">To</label>
                        <input class="form-control my-auto" type="text" id="to" name="to" autocomplete="off">
                        <input type="submit" class="btn btn-primary px-4 my-auto" value="Filter">
                    </form>
                </div>
                <div class="col-xl-12">
                    <table id="products_list" class="table table-striped text-nowrap">
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
                            @include('components.admin.sales-report-table')
                        </tbody>
                    </table>
                    <div id="pages">
                        {{ $transactions->links() }}
                    </div>
                    @empty($transactions)
                        @include('layouts.empty-table')
                    @endempty
                </div>
            </div>
            <div class="row pb-5 pt-5">
                <div class="col-xl-8">
                    @switch(request()->input('date_filter'))
                        @case('daily')
                            <p class="fs-5">List for: {{ $from }}</p>
                        @break

                        {{-- @case('weekly')
                            <p class="fs-5">List for: this week</p>
                        @break --}}
                        @case('monthly')
                            <p class="fs-5">List for: {{ date('F', strtotime($from)) }}
                                {{ date('Y', strtotime($to)) }}</p>
                        @break

                        @case('yearly')
                            <p class="fs-5">List for: {{ date('Y', strtotime($to)) }}</p>
                        @break

                        @default
                            <p class="fs-5">List from: {{ $from }} to {{ $to }}</p>
                    @endswitch
                </div>
                <div class="col-xl-4">
                    <table class="table border">
                        <tbody>
                            <tr>
                                <td class="fs-5">Total Items</td>
                                <td class="fs-5 text-end"> {{ $total_items }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5">Total Sales:</td>
                                <td class="fs-5 text-end"> {{ number_format($total_sales, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5">Total Price:</td>
                                <td class="fs-5 text-end"> {{ number_format($total_price, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5">Profit:</td>
                                <td class="fs-5 text-end"> {{ number_format($profit, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
