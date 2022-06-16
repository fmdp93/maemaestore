@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection


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
    <div class="row">
        <div class="col-xl-12 px-xl-5">
            <div class="row">                
                <div class="col-xl-12">
                    <p class="pdf-heading">{{ $heading }}</p>
                    <p>Report for: {{ $from }} to {{ $to }}</p>
                    <table id="products_list" class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="pe-3 text-end">Trans. #</th>
                                <th scope="col" class="pe-3">Name</th>
                                <th scope="col" class="pe-3 text-end">Stock Remaining</th>
                                <th scope="col">Returns</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="pe-3 text-end">{{ $product->pos_transaction_id }}</td>
                                    <td class="pe-3">{{ $product->p_name }}</td>
                                    <td class="pe-3 text-end">{{ $product->updated_quantity }}</td>
                                    <td>{{ Str::limit($product->returns, 80) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
