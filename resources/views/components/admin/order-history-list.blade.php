@foreach ($products as $product)
    <tr>
        <td>{{ $product->io2p_id }}</td>
        <td>{{ $product->item_code }}</td>
        <td>{{ $product->p_name }}</td>
        <td>{{ $product->base_price }}</td>
        <td>{{ $product->markup }}%</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->expiration_date }}</td>
        <td>{{ $product->received_quantity }}</td>
    </tr>
@endforeach
