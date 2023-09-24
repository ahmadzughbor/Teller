<table>
    <thead style="border:2px">
        <tr>
            <th>user name</th>
            <th>walletid</th>
            <th>balance_before</th>
            <th>balance_after</th>
            <th>amount_before</th>
            <th>amount_after</th>
            <th>tax_value</th>
            <th>date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->wallet->user->name  }}</td>
            <td>{{$item->wallet_id}}</td>
            <td>{{$item->balance_before}}</td>
            <td>{{$item->balance_after}}</td>
            <td>{{$item->amount_before }}</td>
            <td>{{$item->amount_after}}</td>
            <td>{{$item->tax_value}}</td>
            <td>{{$item->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>