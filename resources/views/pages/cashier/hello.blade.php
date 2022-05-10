<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="css/app.css">
    <style>
        *{
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>
<body>    
    <div class="container-fluid">
    <div class="row">
        <div class="col-xl-2 mx-auto pt-5 px-3 bg-light" style="min-height: 50vh">            
            <div class="text-center">
                <b>
                    <img src="{{ 'img/icon.png' }}"> 
                    MAE-MAE'S STORE</b>
            </div>
            <p class="p-0 m-0 pt-3">Transaction ID: {{ $transaction_id }}</p>
            <p class="p-0 m-0">Date: {{ date('Y-m-d H:i', strtotime($items[0]->created_at)) }}</p>
            <table class="table">
                <thead>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($items as $item)
                        <tr>
                            <td class="p-0 m-0">{{ $item->p_name }} x {{ $item->quantity }}</td>
                            <td class="text-end p-0 m-0">{{ $item->price * $item->quantity }}</td>
                        </tr>
                        @php
                            $total += $item->price * $item->quantity;
                        @endphp
                    @endforeach
                    <tr>
                        <td class="pt-5 p-0 m-0">Total:</td>
                        <td class="text-end pt-5 p-0 m-0">{{ sprintf('%.2f', $total) }}</td>
                    </tr>
                    <tr>
                        <td class="p-0 m-0">Amount Paid:</td>
                        <td class="text-end p-0 m-0">{{ sprintf('%.2f', $item->amount_paid) }}</td>                        
                    </tr>
                    <tr>
                        <td class="pt-3 p-0 m-0">Change: </td>
                        <td class="pt-3 text-end p-0 m-0">{{ $item->amount_paid - $total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</body>
</html>