<table>
    <thead>
    <tr>
        <th>Nombre tercero</th>
        <th>Tipo de identificación</th>
        <th>Identificación Digito verificación</th>
        <th>sucursal</th>
        <th>Tipo de régimen IVA</th>
        <th>Dirección</th>
        <th>cuidad</th>
        <th>teléfono</th>
        <th>nombre contacto</th>
        <th>estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $value)
        <tr>
            <td>{{ $value->name }}</td>
            <td>{{ $value->typeIdentificaction?->name }}</td>
            <td>{{ $value->identifications }}</td>
            <td>{{ $value->branch_code }}</td>
            <td>{{ $value->TypeRegimenIva?->name }}</td>
            <td>{{ $value->address }}</td>
            <td>{{ $value->city }}</td>
            <td>{{ $value->phone_fac }}</td>
            <td>{{ $value->contact_name }}</td>
            <td>
                @if($value->state == 1)
                    Activo
                @else
                    Inactivo
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>