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
                                    <td>{{ Str::limit($item->description, 40) }}</td>
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
                                <td class="fs-5">Change:</td>
                                @php
                                    $total_sales = $item->amount_paid - $total_price;
                                @endphp
                                <td class="fs-5 text-end"> {{ number_format(negativeToZero($total_sales), 2) }}</td>
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
