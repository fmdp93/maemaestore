@foreach ($customers as $customer)
    <tr>
        <td>{{ $customer->id }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->address }}</td>
        <td>{{ $customer->contact_detail }}</td>
        <td class="delete-cell d-flex">
            <a href="{{ "$edit_action?id=" . $customer->id }}" title="Edit Customer"><i class="fa-solid fa-pen fa-2x"></i></a>
            <form action="{{ $delete_action }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="page" value="{{ $customers->currentPage() }}">
                <input type="hidden" value="{{ $customer->id }}" name="customer_id">
                {{-- Need to pass url_params to set GET params after redirection from an action like delete --}}
                @isset($search)
                    <input type="hidden" name="search" value="{{ $search }}">
                @endisset
                <button type="submit" class="border-0 bg-transparent">
                    <i class="fa-solid fa-trash-can text-danger fa-2x" title="Delete Customer"></i>
                </button>
            </form>
        </td>
    </tr>
@endforeach
