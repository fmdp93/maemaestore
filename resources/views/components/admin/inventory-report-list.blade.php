@foreach ($products as $product)
    <tr>
        <td>{{ $product->pos_transaction_id }}</td>
        <td>{{ $product->p_name }}</td>
        <td>{{ $product->updated_quantity }}</td>
        <td>{{ Str::limit($product->returns, 80) }}</td>
        <td><a href="{{ route('inventory_report_details', ['id' => $product->pos_transaction_id]) }}"
                class="btn btn-success text-white">View Details</a></td>
    </tr>
@endforeach
