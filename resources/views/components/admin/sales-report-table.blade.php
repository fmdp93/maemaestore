@foreach($transactions as $transaction)
    <tr>
        <td>{{ $transaction->t_id }}</td>
        <td>{{ date("F j, Y", strtotime($transaction->t_date)) }}</td>
        <td>{{ $transaction->p_name }}</td>
        <td>{{ Str::limit($transaction->description, 40) }}</td>
        <td>{{ $transaction->pt2p_quantities }}</td>
        <td>{{ sprintf("%.2f", $transaction->pt2p_price_total) }}</td>
        <td>{{ sprintf("%.2f", $transaction->amount_paid ) }}</td>  
        @php
            $change = $transaction->amount_paid - $transaction->pt2p_price_total;
        @endphp      
        <td>{{ sprintf("%.2f", negativeToZero($change)) }}</td>
        <td><a class="btn btn-success text-white" href="{{ route('pos_transaction2product', $transaction->t_id) }}">View Details</a></td>
    </tr>
@endforeach