@php
    use App\Http\Controllers\ProductsController;
@endphp

@foreach ($products as $product)
    <tr>
        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
        <td>
            {{ $product->item_code }}
            <input type="hidden" name="item_code" value="{{ $product->item_code }}">
        </td>
        <td>
            {{ $product->p_name }}
            <input type="hidden" name="p_name" value="{{ $product->p_name }}">
        </td>
        <td>
            {{ $product->description }}
            <input type="hidden" name="description" value="{{ $product->description }}">
        </td>
        <td>
            {{ $product->c_name }}
            <input type="hidden" name="c_name" value="{{ $product->c_name }}">
        </td>
        <td>
            {{ $product->price }}
            <input type="hidden" name="price" value="{{ $product->price }}">
        </td>
        <td>
            {{ $product->stock }}
            <input type="hidden" name="stock" value="{{ $product->stock }}">
        </td>
        <td>
            {{ $product->unit }}
            <input type="hidden" name="unit" value="{{ $product->unit }}">
        </td>
        <td>
            {{ $product->expiration_date }}
            <input type="hidden" name="expiration_date" value="{{ $product->expiration_date }}">
        </td>
        @if (Auth::user()->role_id == 1)
            <td class="delete-cell">
                <div class="d-flex">
                    <form action="{{ $action }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('delete')
                        <input type="hidden" value="{{ $product->p_id }}" name="product_id">
                        <button type="submit" class="border-0 bg-transparent">
                            <i class="fa-solid fa-trash-can text-danger fa-2x" title="Delete Product"></i>
                        </button>
                    </form>
                    <a href="{{ action([ProductsController::class, 'printBarcode']) . '?item_code=' . $product->item_code }}">
                        <i class="fa-solid fa-print fa-2x" title="Print Barcode"></i>
                    </a>
                </div>
            </td>
        @endif
    </tr>
@endforeach
