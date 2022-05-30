@foreach ($return_refunds as $return_refund)
    <tr>
        <td>{{ $return_refund->pt_id }}</td>
        <td>{{ $return_refund->created_at }}</td>
        <td>{{ $return_refund->customer_name }}</td>
        <td>{{ $return_refund->amount_paid }}</td>
        <td>{{ $return_refund->p_name }}</td>
        <td>{{ $return_refund->pt2p_price }}</td>
        <td>{{ $return_refund->refunded_quantity }}</td>
        <td>{{ sprintf("%.2f", $return_refund->refunded_quantity * $return_refund->pt2p_price) }}</td>
        <td>{{ $return_refund->remark }}</td>
        <td>{{ $return_refund->refunded_at }}</td>
    </tr>
@endforeach