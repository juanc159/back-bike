<table>
    <thead>
    <tr>
        <th>Nombre</th> 
        <th>Referencia fábrica</th> 
        <th>Estado</th> 
        <th>Impuesto cargo</th> 
        <th>Descripción larga</th> 
    </tr>
    </thead>
    <tbody> 
    @foreach($data as $value)
        <tr>
            <td>{{ $value->name }}</td> 
            <td>{{ $value->factoryReference }}</td> 
            <td>{{ $value->state==1 ? "Activo" : "Inactivo" }}</td> 
            <td>{{ $value->taxCharge?->name }}</td> 
            <td>{{ $value->description }}</td>  
        </tr>
    @endforeach
    </tbody>
</table>