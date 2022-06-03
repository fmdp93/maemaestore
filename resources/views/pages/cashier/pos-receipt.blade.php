@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection


@section('infile_style')
    <link rel="stylesheet" href="css/app.css">

    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: 'Courier New', Courier, monospace;
            color: #5a4d61;
        }

        .gutter {
            padding: 12px;
        }

        #header {
            line-height: 1;
            vertical-align: middle;
        }

        .icon {
            height: 17px;
            width: 20px;
            display: inline;
            line-height: 1;
            vertical-align: middle;
        }

        .icon+b {
            line-height: 1;
            vertical-align: middle;
        }

    </style>
@endsection

@section('content')
    <div class="col-xl-2 mx-auto px-4 bg-white text-black" style="min-height: 50vh">
        <br>
        <div id="header" class="text-center align-middle">
            <img src="img/icon.png" class="icon"> <b>MAE-MAE'S STORE</b>
            <br>
            <small class="p-0 m-0 mt-1 d-block">AH26 Maharlika highway, Abar 1st San Jose City, Nueva Ecija</small>
        </div>
        <small class="p-0 m-0 pt-3 d-block">Transaction ID: {{ $transaction_id }}</small>
        <small class="p-0 m-0 d-block">Date: {{ date('Y-m-d H:i', strtotime($items[0]->created_at)) }}</small>
        <small class="p-0 m-0 d-block">Cashier: {{ $cashier_name }}</small>
        <br>
        <small class="p-0 m-0 d-block">Customer: {{ $customer->customer_name }}</small>
        <small class="p-0 m-0 d-block">Address: {{ $customer->customer_address }}</small>
        <small class="p-0 m-0 d-block">Contact Detail: {{ $customer->customer_contact_detail }}</small>
        <div class="py-3 my-0">
            <hr class="my-0 py-0 pb-1">
        </div>
        <table class="table my-0">
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($items as $item)
                    <tr>
                        <td class="p-0 m-0">{{ $item->p_name }} x {{ $item->quantity }}</td>
                        <td class="text-end p-0 m-0">{{ $item->selling_price * $item->quantity }}</td>
                    </tr>
                    @php
                        $total += $item->selling_price * $item->quantity;
                    @endphp
                @endforeach
                <tr>
                    <td class="pt-5 p-0 m-0">Total:</td>
                    <td class="text-end pt-5 p-0 m-0">{{ sprintf('%.2f', $total) }}</td>
                </tr>
                @php
                    $discount = $total * $item->senior_discount;
                    $discounted_total = $total - $discount;
                @endphp
                @if ($item->senior_discount)
                    <tr>
                        <td class="pt-3 p-0 m-0">Senior Discount: </td>
                        <td class="pt-3 text-end p-0 m-0">
                            {{ sprintf('%.2f', negativeToZero($discount)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-5 p-0 m-0">Discounted Total:</td>
                        <td class="text-end pt-5 p-0 m-0">{{ sprintf('%.2f', $discounted_total) }}</td>
                    </tr>
                @endif
                
                <tr>
                    <td class="p-0 m-0">Amount Paid:</td>
                    <td class="text-end p-0 m-0">{{ sprintf('%.2f', $item->amount_paid) }}</td>
                </tr>
                <tr>
                    <td class="pt-3 p-0 m-0">Change: </td>
                    <td class="pt-3 text-end p-0 m-0">{{ sprintf('%.2f', negativeToZero($item->amount_paid - $discounted_total)) }}
                    </td>
                </tr>                
            </tbody>
        </table>
    </div>
@endsection
