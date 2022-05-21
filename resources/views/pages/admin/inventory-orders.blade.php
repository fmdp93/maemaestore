@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/inventory-orders.js') }}" defer></script>
    {{-- <script src="{{ asset('js/scope/inventory.js') }}" defer></script> --}}
@endsection

@section('admin_content')
    <div id="inventory_orders" class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <table id="inventory_order_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">Company</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Address</th>
                        <th scope="col" class="text-end">Tax</th>
                        <th scope="col" class="text-end">Shipping Fee</th>
                        <th scope="col" class="text-end">Total</th>
                        <th scope="col">Leading Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventory_orders as $io)
                        <tr>
                            <td>{{ $io->io_id }}</td>
                            <td>{{ $io->vendor }}</td>
                            <td>{{ $io->company_name }}</td>
                            <td>{{ $io->contact_detail }}</td>
                            <td>{{ $io->address }}</td>
                            <td class="text-end">{{ sprintf('%.2f', $io->tax) }}</td>
                            <td class="text-end">{{ sprintf('%.2f', $io->shipping_fee) }}</td>
                            <td class="text-end">
                                {{ sprintf('%.2f', $io->io2p_total_price + $io->shipping_fee + $io->tax) }}</td>
                            <td>{{ $io->eta }}</td>
                            <td class="text-nowrap">
                                <div class="d-flex justify-content-around">
                                    <form action="{{ url('/inventory/order-received') }}" method="POST"
                                        class="px-1">
                                        @csrf
                                        <input type="hidden" name="io_id" value="{{ $io->io_id }}">
                                        <button type="submit" class="order-received btn btn-success">Order Received</button>
                                    </form>
                                    <button class="view-details btn btn-success px-1" data-io-id={{ $io->io_id }}
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">View Details</button>
                                    <form action="{{ route('purchase_order_cancel') }}" method="POST"
                                        class="px-1">
                                        @csrf
                                        <input type="hidden" value="{{ $io->io_id }}" name="io_id">
                                        {{-- Need to pass url_params to set GET params after redirection from an action like delete --}}

                                        <button type="submit" class="btn btn-danger text-primary">
                                            Cancel
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="details-modal">
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Products List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Item Code</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @empty(count($inventory_orders))
                @include('layouts.empty-table')
            @endempty
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
