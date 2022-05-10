@php
use App\Http\Controllers\POSController;
@endphp

@extends('layouts.app')

@section('title')
    Purchase Order
@endsection

@section('cashier_content')
    @include('layouts.heading')
    <div class="row">
        <div class="col-12">
            <a href="{{ action([POSController::class, 'index']) }}" class="btn btn-success mb-xl-3 text-primary"><i
                    class="fa fa-plus-circle"></i> Make another transaction</a>
            <a href="{{ action([POSController::class, 'receipt'], ['transaction_id' => $transaction_id]) }}"
                class="btn btn-success mb-xl-3 text-primary"><i class="fa fa-print"></i> Print Receipt</a>
        </div>
    </div>
@endsection


@section('content')
    @include('components.cashier.content')
@endsection
