@php
use App\Http\Controllers\LogManagerController;
@endphp

@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/log-manager.js') }}" defer></script>    
@endsection

@section('admin_content')
    <div class="row vh-100">
        <div class="col-xl-12 px-xl-5">
            @include('layouts.heading')
            <table id="products" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->item_code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ date("F j, Y H:i:s", strtotime($product->date_and_time)) }}</td>
                            <td>{{ $product->action_name }}</td>
                        </tr>
                    @endforeach
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
@endsection

@section('content')
    @include('components.admin.content')
@endsection
