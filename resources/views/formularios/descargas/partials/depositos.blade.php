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

            <th>USUARIO</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($depositos as $deposito)
            <tr>
                <th>{{ $deposito->created_at }}</th>
                <th>{{ $deposito->agencia->nombre }}</th>
                <th>{{ $deposito->origen }}</th>
                <th>{{ $deposito->fecha }}</th>
                <th>{{ $deposito->apellidos  }}</th>
                <th>{{ $deposito->num_documento }}</th>
                <th>{!! $deposito->val_deposito !!}</th>
                <th>{{ asset(Storage::url($deposito->comprobante)) }}</th>
                <th>{{ $deposito->banco }}</th>
                <th>{{ $deposito->num_credito }}</th>
                <th>{{ $deposito->user->name }}</th>
                <th>{{ $deposito->tesoreria }}</th>
                <th>{{ $deposito->cajas }}</th>
                <th>{{ $deposito->baja }}</th>
                <th>{{ $deposito->novedad }}</th>
                <th>{{ $deposito->doc_banco }}</th>
                <th>{{ $deposito->usertesoreria->name ?? 'N/A' }}</th>
            </tr>
        @endforeach
    </tbody>
</table>
