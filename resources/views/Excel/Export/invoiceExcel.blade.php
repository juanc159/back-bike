<table>
    <thead>
        <tr> 
          <th>
            Tipo
          </th>
          <th>
            Cliente
          </th>
          <th>
            Vendedor
          </th>
          <th>
            Moneda
          </th>
          <th>
            Fecha
          </th>
          <th>
            Numero
          </th>
          <th>
            total bruto
          </th>
          <th>
            descuento
          </th>
          <th>
            subtotal
          </th>
          <th>
            Total neto
          </th>
        </tr>
      </thead>
    <tbody>
    @foreach($data as $value)
        <tr>
            <td>{{ $value->typesReceiptInvoice?->voucherName }}</td>
            <td>{{ $value->third?->name, }}</td>
            <td>{{ $value->user?->name }}</td>
            <td>{{ $value->currency?->name }}</td>
            <td>{{ $value->date_elaboration }}</td>
            <td>{{ $value->number }}</td>
            <td>{{ $value->gross_total }}</td>
            <td>{{ $value->discount }}</td>
            <td>{{ $value->subtotal }}</td>
            <td>{{ $value->net_total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>