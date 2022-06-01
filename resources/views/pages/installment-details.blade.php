@php
use App\Http\Controllers\SalesReportController;
@endphp

@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('/js/scope/installment-details.js') }}" type="module" defer></script>
@endsection

@section("{$user}_content")
    <div class="row">
        <div class="col-xl-12 px-xl-5">
            <div class="row">
                @include('layouts.heading')
                <div class="col-12 mt-3">                    
                </div>
                <div class="col-xl-12">
                    <h5>Transaction #{{ $transaction_id }}</h5>
                    <table id="products_list" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_items = $total_price = 0;
                                $count = 1;
                            @endphp
                            @foreach ($pos_transaction2products->get() as $item)
                                @php
                                    $total_items += $item->pt2p_quantity;
                                    $total_price += $item->pt2p_price * $item->pt2p_quantity;
                                @endphp
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->p_name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->pt2p_quantity }}</td>
                                    <td>{{ $item->pt2p_price }}</td>
                                    <td>{{ sprintf('%.2f', $item->pt2p_price * $item->pt2p_quantity) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>                
            </div>
            <div class="row">
                <div class="col-xl-4 ms-auto">
                    <table class="table border">
                        <tbody>
                            <tr>
                                <td class="fs-5">Total Items</td>
                                <td class="fs-5 text-end"> {{ $total_items }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5">Total Price</td>
                                <td class="fs-5 text-end"> {{ $total_price }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5">Amount Paid</td>
                                <td class="fs-5 text-end"> {{ number_format($item->amount_paid, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5">Remaining Balance</td>
                                <td class="fs-5 text-end"> {{ number_format(negativeToZero($total_price - $item->amount_paid), 2) }}</td>
                            </tr>
                            <tr>
                                <td class="fs-5"><label for="pay_amount" form="cc_payment">Pay Amount</label></td>
                                @php
                                    $total_sales = $item->amount_paid - $total_price;
                                @endphp
                                <td class="fs-5 text-end">
                                    <form action="{{ route('pay_balance') }}" id="cc_payment" name="cc_payment" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $transaction_id }}" name="transaction_id">
                                        <input type="number" name="pay_amount" id="pay_amount" class="form-control">
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Pay" class="form-control" name="submit" form="cc_payment">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include("components.{$user}.content")
@endsection
