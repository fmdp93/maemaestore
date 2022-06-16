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
                <div class="col-12 mt-3">
                    <p class="pdf-heading">{{ $heading }}</p>
                </div>
                <div class="col-xl-12">
                    <h5>Transaction #{{ $transaction_id }}</h5>
                    <table id="products_list" class="table {{ $table_striped }}">
                        <thead>
                            <tr>
                                <th class="pe-3" scope="col">#</th>
                                <th class="pe-3"scope="col">Item Code</th>
                                <th class="pe-3"scope="col">Name</th>
                                <th class="pe-3 text-end"scope="col">Quantity</th>
                                <th class="pe-3 text-end"scope="col">Stock Remaining</th>
                                <th scope="col">Returns</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($products->get() as $item)
                                <tr>
                                    <td class="pe-3">{{ $count++ }}</td>
                                    <td class="pe-3">{{ $item->item_code }}</td>
                                    <td class="pe-3">{{ $item->p_name }}</td>                                    
                                    <td class="pe-3 text-end">{{ $item->pt2p_quantity }}</td>
                                    <td class="pe-3 text-end">{{ $item->updated_quantity }}</td>
                                    <td>
                                        @if(!empty($item->refunded_quantity))
                                        {{ $item->refunded_quantity . "x - " .$item->remark }}</td>
                                        @endif
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
@endsection