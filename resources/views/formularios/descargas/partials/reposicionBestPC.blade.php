<table>
    <thead>
        <tr>
            <th colspan="5">REPOSICION DE CAJAS CHICAS AGENCIAS BESTPC</th>
        </tr>
        <tr>
            <th colspan="5">Fecha {{$dateIni.' a '.$dateFin}}</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>AGENCIA</th>
            <th>PA</th>
            <th>NUMERO</th>
            <th>USD</th>
            <th>VALOR</th>
            <th>CTA</th>
            <th>AHO</th>
            <th>CUENTA</th>
            <th>DETALLE</th>
            <th>C</th>
            <th>CEDULA</th>
            <th>NOMBRE</th>
            <th>CODIGO</th>
            <th>BANCO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gastosBestPC as $key => $gasto)
            <tr>

                <td>{{ $gasto->agencia }}</td>
                <td>{{ 'PA' }}</td>
                <td>{{ $key }}</td>
                <td>{{ 'USD' }}</td>
                <td>{{ number_format($gasto->valor_sumado, 2) }}</td>
                <td>{{ 'CTA' }}</td>
                <td>{{ 'AHO' }}</td>
                <td>
                    @if ($gasto->user->profile)
                        {{ $gasto->user->profile->numero_cuenta }}
                    @endif
                </td>
                <td>REPOSICION CAJA CHICA</td>
                <td>C</td>
                <td>{{ $gasto->user->profile->cedula }}</td>
                <td>{{ $gasto->user->name }}</td>
                <td>{{ '10' }}</td>
                <td></td>


                @php
                    //$acum1 += number_format($gasto->valor_sumado, 2);
                @endphp
            </tr>
        @endforeach
    </tbody>
</table>
