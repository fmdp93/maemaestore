<table id="inventory_list" class="table">
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
            @if ($show_action)
                <th scope="col">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @include('components.inventory-list')
    </tbody>
</table>
<div id="pages">
    {{ $products->links() }}
</div>
@include('layouts.empty-table')
