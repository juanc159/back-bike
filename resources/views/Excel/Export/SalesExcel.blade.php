<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Tipo de vehículo</th>
            <th>Referencia</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Placa</th>
            <th>Sitio Matricula</th>
            <th>Valor Retoma</th>
            @foreach ($thirds as $key => $value)
            <td>{{ $value->name }}</td>
            @endforeach
            <th>Total</th>
            <th>Utilidades</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $value)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $value->inventory?->vehicleType }}</td>
                <td>{{ $value->inventory?->reference }}</td>
                <td>{{ $value->inventory?->brand }}</td>
                <td>{{ $value->inventory?->model }}</td>
                <td>{{ $value->inventory?->color }}</td>
                <td>{{ $value->inventory?->plate }}</td>
                <td>{{ $value->inventory?->registrationSite }}</td>
                <td>{{ $value->inventory?->value }}</td>

                @foreach ($thirds as $key2 => $value2)
                    @if (in_array($value2->id, array_column($value->thirds->toArray(), 'id')))
                        @foreach ($value->thirds as $key3 => $value3)
                            @if ($value3->id == $value2->id) 
                                <td>{{ $value3->pivot->amount }}</td>
                            @endif 
                        @endforeach
                    @else
                        <td>0</td>
                    @endif
                @endforeach
                <td>{{ $value->total }}</td>
                <td>{{ $value->utilities }}</td>


            </tr>
        @endforeach

    </tbody>
</table>
