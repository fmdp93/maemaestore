@php
use App\Http\Controllers\SalesReportController;
@endphp

@extends('layouts.app')

@section('admin_content')
    <div class="row">
        <div class="col-xl-12 px-xl-5">
            <div class="row">
                @include('layouts.heading')
                <div class="col-12 mt-3">
                </div>
                <div class="col-xl-12">
                    <h5>Transaction #{{ $transaction_id }}</h5>
                    <a href="{{ route('print_inventory_report_details', ['id'=>$transaction_id]) }}"
                        class="btn btn-success text-white mt-3">
                        <i class="fa-solid fa-print"></i> Print</a>
                    @include('components.admin.inventory-report-details-table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
