@extends('layouts.app')

@section('header_scripts')
    <script src="{{ asset('js/scope/inventory-orders.js') }}" defer type="module"></script>
@endsection

@section('admin_content')
    <div id="inventory_orders" class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <a href="{{ url('/inventory/purchase-order') }}" class="btn btn-success mb-xl-3 text-primary">
                <i class="fa fa-plus-circle"></i> Purchase Order
            </a>
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
                        <th scope="col">Leading Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.admin.inventory-orders-list');
                </tbody>
            </table>
            {{-- <input type="text" name="expiration_date[]" class="expiration_date form-control ms-auto">
            <input type="text" name="expiration_date[]" class="expiration_date form-control ms-auto">
            <input type="text" name="expiration_date[]" class="expiration_date form-control ms-auto"> --}}
            <div id="details-modal">
                <div class="modal fade" id="detailsModalContent" tabindex="-1"
                    aria-labelledby="detailsModalContentLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalContentLabel" class="d-block">Products
                                    List</h5>
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
                                        <th class="fit">Quantity</th>
                                        <th class="">Expiration</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Action</th>
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
