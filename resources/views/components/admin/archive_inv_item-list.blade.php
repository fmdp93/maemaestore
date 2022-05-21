@foreach ($archive_inv_items as $archive_inv_item)
    <tr>
        <td>
            {{ $archive_inv_item->item_code }}
        </td>
        <td>
            {{ $archive_inv_item->p_name }}
        </td>
        <td>
            {{ $archive_inv_item->description }}
        </td>
        <td>
            {{ $archive_inv_item->c_name }}
        </td>
        <td  class="text-end">
            {{ $archive_inv_item->price }}
        </td>
        <td  class="text-end">
            {{ $archive_inv_item->p_stock }}
        </td>
        </td>
        <td  class="text-end">
            {{ $archive_inv_item->i_stock }}
        </td>
        <td>
            {{ $archive_inv_item->unit }}
        </td>
        <td>
            {{ $archive_inv_item->expiration_date }}
        </td>
        <td class="delete-cell">            
            <form action="{{ $unarchive_inv_item_action }}" method="POST">
                @csrf
                <input type="hidden" name="page" value="{{ $archive_inv_items->currentPage() }}">
                <input type="hidden" value="{{ $archive_inv_item->i_id }}" name="archive_inv_item_id">
                {{-- Need to pass url_params to set GET params after redirection from an action like delete --}}
                @isset($search)
                    <input type="hidden" name="search" value="{{ $search }}">
                @endisset
                <button type="submit" class="border-0 bg-transparent">
                    <i class="fa-solid fa-arrow-rotate-right fa-2x" title="Unarchive"></i>
                </button>
            </form>
        </td>
    </tr>
@endforeach
