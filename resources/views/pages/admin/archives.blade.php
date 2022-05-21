@php
use App\Http\Controllers\AccountsController;
@endphp
@extends('layouts.app')

@section('header_scripts')
    <script>
        const search_url = '{{ route("inventory_archive_search") }}';
        const unarchive_inv_item_action = '{{ $unarchive_inv_item_action }}';        
    </script>
    <script src="{{ asset('js/scope/search.js') }}" defer></script>
    <script src="{{ asset('js/scope/archive_inv_item.js') }}" defer type="module"></script>
@endsection

@section('admin_content')
    <div class="row px-xl-5">
        @include('layouts.heading')
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-3">
                    @include('components.search')
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <table id="archive_inv_item_list" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col" class="text-end">Price</th>
                        <th scope="col" class="text-end">Max Stock</th>
                        <th scope="col" class="text-end">Stock</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Expiration</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('components.admin.archive_inv_item-list')
                </tbody>
            </table>
            <div id="pages">
                {{ $archive_inv_items->links() }}
            </div>
            @empty($archive_inv_items)
                @include('layouts.empty-table')
            @endempty
        </div>
    </div>
@endsection

@section('content')
    @include('components.admin.content')
@endsection
