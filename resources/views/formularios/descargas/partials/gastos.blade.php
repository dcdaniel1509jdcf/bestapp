<table>
    <thead>
        <tr>
            <th colspan="2">REPORTE DE CAJA CHICA</th>

        </tr>
        <tr>

            <th colspan="2">Fecha {{$dateIni.' a '.$dateFin}}</th>
        </tr>
    </thead>
</table>
@php
    $acum1=0;
    $acum2=0;
@endphp
<table>
    <thead>
        <tr>
            <th>AGENCIA</th>
            <th>CAJEROS BESTPC</th>
            <th>VALOR</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gastosBestPC as $gasto)
        <tr>
            <td>{{ $gasto->user->agencia->nombre }}</td>
            <td>{{ $gasto->user->name }}</td>
            <td>{{ number_format($gasto->valor_sumado, 2) }}</td>
            @php
                $acum1+=number_format($gasto->valor_sumado, 2);
            @endphp
        </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th> </th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th>AGENCIA</th>
            <th>CAJEROS DE HW</th>
            <th>VALOR</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gastosHarwest as $gasto)
        <tr>
            <td>{{ $gasto->user->agencia->nombre }}</td>
            <td>{{ $gasto->user->name }}</td>
            <td>{{ number_format($gasto->valor_sumado, 2) }}</td>
            @php
                $acum2+=number_format($gasto->valor_sumado, 2);
            @endphp
        </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>TOTAL:</td>
            <td>{{ $acum1+$acum2 }}</td>
        </tr>
    </tbody>
</table>
