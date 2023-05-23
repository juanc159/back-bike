<table>
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Titulo para visualización</th>
        <th>Número de resolución</th>
        <th>Estado de resolución</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $value)
        <tr>
            <td>{{ $value->voucherCode }}</td>
            <td>{{ $value->voucherName }}</td>
            <td>{{ $value->titleForDisplay }}</td>
            <td>{{ $value->resolutionNumberDian }}</td>
            <td>
                @if ($value->endDateValidity < date('Y-m-d'))
                    No vigente
                @else
                    Vigente
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>