<table>
    <thead>
        <tr>
            <th>TIMESTAMP</th>
            <th>AGENCIA</th>
            <th>ORIGEN</th>
            <th>FECHA DEPOSITO</th>
            <th>APELLIDOS Y NOMBRES</th>
            <th>NUMERO DE DOCUMENTO</th>
            <th>VALOR DEPOSITO O TRANSFERENCIA</th>
            <th>COMPROBANTE</th>
            <th>BANCO</th>
            <th>NUMERO DE DEPOSITO</th>
            <th>USUARIO</th>
            <th>TESORERIA</th>
            <th>CAJAS</th>
            <th>BAJA</th>
            <th>NOVEDAD</th>
            <th>Num. Doc en Banco</th>
            <th>USUARIO TESORERIA</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($depositos as $deposito)
            <tr>
                <td>{{ $deposito->created_at }}</td>
                <td>{{ $deposito->agencia->nombre }}</td>
                <td>{{ $deposito->origen }}</td>
                <td>{{ $deposito->fecha }}</td>
                <td>{{ $deposito->apellidos }}</td>
                <td>{{ $deposito->num_documento }}</td>
                <td>{!! $deposito->val_deposito !!}</td>
                <td><a href="{{ asset(Storage::url($deposito->comprobante)) }}" target="_blank">Ver comprobante</a></td>
                <td>{{ $deposito->banco }}</td>
                <td>

                    @foreach (unserialize($deposito->num_credito) as $factura)
                        <p>{{ $factura['factura'] }} Valor: {{ $factura['valor'] }} </p>
                        <br>
                    @endforeach

                </td>
                <td>{{ $deposito->user->name }}</td>
                <td>{{ $deposito->tesoreria }}</td>
                <td>{{ $deposito->cajas }}</td>
                <td>{{ $deposito->baja }}</td>
                <td>{{ $deposito->novedad }}</td>
                <td>{{ $deposito->doc_banco }}</td>
                <td>{{ $deposito->usertesoreria->name ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
