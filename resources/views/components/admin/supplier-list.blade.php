@foreach ($suppliers as $supplier)
    <tr>
        <td>{{ $supplier->id }}</td>
        <td>{{ $supplier->vendor }}</td>
        <td>{{ $supplier->company_name }}</td>
        <td>{{ $supplier->contact_detail }}</td>
        <td>{{ $supplier->address }}</td>
        <td class="delete-cell d-flex">
            <a href="{{ "$edit_action?id=" . $supplier->id }}" title="Edit Supplier"><i class="fa-solid fa-pen fa-2x"></i></a>
            <form action="{{ $delete_action }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="page" value="{{ $suppliers->currentPage() }}">
                <input type="hidden" value="{{ $supplier->id }}" name="supplier_id">
                {{-- Need to pass url_params to set GET params after redirection from an action like delete --}}
                @isset($search)
                    <input type="hidden" name="search" value="{{ $search }}">
                @endisset
                <button type="submit" class="border-0 bg-transparent">
                    <i class="fa-solid fa-trash-can text-danger fa-2x" title="Delete Supplier"></i>
                </button>
            </form>
        </td>
    </tr>
@endforeach
