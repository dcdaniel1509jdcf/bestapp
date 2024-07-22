<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Agencia</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Valor</th>
            <th>Detalle</th>
            <th>Número de Factura</th>
            <th>Tipo de Movilizacion</th>
            <th>Destino</th>
            <th>Asignado A</th>
            <th>Estado</th>
            <th>Comprobante</th>
            <th>Novedad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gastos as $gasto)
            <tr>
                <td>{{ $gasto->id }}</td>
                <td>{{ $gasto->agencia ? $gasto->agencia->nombre : 'No disponible' }}</td>
                <td>{{ $gasto->user->name }}</td>
                <td>{{ $gasto->fecha }}</td>
                <td>{{ ucfirst($gasto->concepto) }}</td>
                <td>{{ $gasto->valor }}</td>
                <td>{{ $gasto->detalle }}</td>
                <td>{{ $gasto->numero_factura }}</td>
                <td>{{ ucfirst($gasto->tipo_movilizacion) }}</td>
                <td>{{ $gasto->destino }}</td>
                <td>{{ $gasto->asignado_a }}</td>
                <td>{{ $gasto->estado }}</td>
                <td>
                    @if ($gasto->comprobante)
                        <a href="{{ asset(Storage::url($gasto->comprobante)) }}" target="_blank">Ver comprobante</a>
                    @else
                        No disponible
                    @endif
                </td>
                <td>{{ $gasto->novedad }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
