@foreach($transactions as $transaction)
    <tr>
        <td>{{ $transaction->t_id }}</td>
        <td>{{ date("F j, Y", strtotime($transaction->t_date)) }}</td>
        <td>{{ $transaction->p_name }}</td>
        <td>{{ $transaction->description }}</td>
        <td>{{ $transaction->pt2p_quantity }}</td>
        <td>{{ sprintf("%.2f", $transaction->pt2p_price) }}</td>
        <td>{{ sprintf("%.2f", $transaction->pt2p_price * $transaction->pt2p_quantity) }}</td>
    </tr>
@endforeach