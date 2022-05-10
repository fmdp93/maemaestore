@foreach ($io_products as $product)
    <tr>
        <td>{{ $product->p_item_code }}</td>
        <td>{{ $product->p_name }}</td>
        <td>{{ $product->c_name }}</td>
        <td>{{ $product->p_desc }}</td>
        <td class="text-end">{{ $product->io2p_quantity }}</td>
        <td class="text-end">{{ sprintf("%.2f", $product->io2p_price) }}</td>
        <td class="text-end">{{ sprintf("%.2f", $product->io2p_price * $product->io2p_quantity) }}</td>
    </tr>
@endforeach


