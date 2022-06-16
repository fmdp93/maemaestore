@foreach($installments as $installment)
    <tr>
        <td>{{ $installment->t_id }}</td>
        <td>{{ date("F j, Y", strtotime($installment->t_date)) }}</td>
        <td>{{ $installment->p_name }}</td>
        <td>{{ Str::limit($installment->description, 40) }}</td>
        <td>{{ $installment->pt2p_quantities }}</td>
        <td>{{ sprintf("%.2f", $installment->pt2p_price_total) }}</td>
        <td>{{ sprintf("%.2f", $installment->amount_paid ) }}</td>  
        @php
            $change = $installment->amount_paid - $installment->pt2p_price_total;
        @endphp      
        <td>{{ sprintf("%.2f", negativeToZero($change)) }}</td>
        <td><a class="btn btn-success text-white" href="{{ $view_action . '/' . $installment->t_id }}">View Details</a></td>
    </tr>
@endforeach