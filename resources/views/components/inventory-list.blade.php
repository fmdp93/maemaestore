@php
    use App\Http\Controllers\InventoryController;
@endphp
@foreach ($products as $product)
@php
    $percentage = ($product->sum_i_stock / $product->p_stock) * 100;
    $tr_bg = '';
    if($percentage > 50){
        $tr_bg = '';
    }else if($percentage >= 30 && $percentage <= 50){
        $tr_bg = 'bg-half';        
    }else if($percentage < 30){
        $tr_bg = 'bg-low';        
    }
@endphp
    <tr class='{{ $tr_bg }}'>
        <td>
            {{ $product->item_code }}
        </td>
        <td>
            {{ $product->p_name }}
        </td>
        <td>
            {{ $product->vendor }}
        </td>
        <td>
            {{ $product->company_name }}
        </td>
        <td>
            {{ Str::limit($product->description, 40) }}
        </td>
        <td>
            {{ $product->c_name }}
        </td>
        <td  class="text-end">
            {{ $product->price }}
        </td>
        <td  class="text-end">
            {{ $product->p_stock }}
        </td>
        </td>
        <td  class="text-end">
            {{ $product->i_stock }}
        </td>
        <td>
            {{ $product->unit }}
        </td>
        <td>
            {{ $product->expiration_date }}
        </td>
        @if($show_action)
            <td>
                <div class="d-flex">
                    <form action="{{ $archive_action }}" method="POST" class="d-inline-block">
                        @csrf                    
                        <input type="hidden" value="{{ $product->i_id }}" name="inventory_id">
                        {{-- Need to pass url_params to set GET params after redirection from an action like delete--}}
                        @isset($url_params)
                            <input type="hidden" name="url_params" value="{{ $url_params }}">
                        @endisset
                        <button type="submit" class="border-0 bg-transparent">
                            <i class="fa-solid fa-box-archive text-danger fa-2x" title="Archive Product"></i>
                        </button>
                    </form>
                </div>
            </td>
        @endif
    </tr>
@endforeach
