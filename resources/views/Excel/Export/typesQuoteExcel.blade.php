<table>
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th> 
    </tr>
    </thead>
    <tbody>
    @foreach($data as $value)
        <tr>
            <td>{{ $value->voucherCode }}</td>
            <td>{{ $value->voucherName }}</td> 
        </tr>
    @endforeach
    </tbody>
</table>