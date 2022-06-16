@extends('layouts.app')

@section('infile_style')
    <link rel="stylesheet" href="css/app.css">

    <style>
        body {
            background: #fff;
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
    <div class="row px-xl-5">
        <div class="col-xl-12">
            <p class="pdf-heading">{{ $heading }}</p>    
            <p class="fs-5">List from: {{ $from }} to {{ $to }}</p>        
            <table id="product_list" class="table">
                <thead>
                    <tr>
                        <th class="pe-3 text-end" scope="col">ID</th>
                        <th class="pe-3 text-end" scope="col">Item Code</th>
                        <th scope="col">Product Name</th>
                        <th class="pe-3 text-end" scope="col">Base Price</th>
                        <th class="pe-3 text-end" scope="col">Markup</th>
                        <th class="pe-3 text-end" scope="col">Selling Price</th>
                        <th scope="col">Expiration Date</th>
                        <th class="pe-3 text-end" scope="col">Received Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="pe-3 text-end">{{ $product->io2p_id }}</td>
                            <td class="pe-3 text-end">{{ $product->item_code }}</td>
                            <td>{{ $product->p_name }}</td>
                            <td class="pe-3 text-end">{{ $product->base_price }}</td>
                            <td class="pe-3 text-end">{{ $product->markup }}%</td>
                            <td class="pe-3 text-end">{{ $product->price }}</td>
                            <td>{{ $product->expiration_date }}</td>
                            <td class="pe-3 text-end">{{ $product->received_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection