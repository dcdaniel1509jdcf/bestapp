<table>
    <thead>
        <tr>
            <th colspan="2">REPORTE GENERAL DE GASTOS</th>
        </tr>
        <tr>
            <th colspan="2">Fecha {{ $dateIni . ' a ' . $dateFin }}</th>
        </tr>
    </thead>
</table>
@isset($getMovilizacion)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>AGENCIA</th>
                <th>USUARIO</th>
                <th>DETALLE</th>
                <th>VALOR</th>
                <th>FECHA DEL COMPROBANTE</th>
                <th>TIPO DOCUMENTO</th>
                <th>NUMERO DOCUMENTO</th>
                <th>DOCUMENTO</th>
                <th>CONCEPTO</th>
                <th>VALOR IVA</th>
                <th>CREADO EL</th>
                <th>ESTADO</th>
                <th>NOVEDAD</th>

                <th>TIPO DE MOVILIZACION</th>
                <th>INICIO DE DESTINO</th>
                <th>FIN DE DESTINO</th>
                <th>DIRECCION</th>
                <th>ASIGNADO A</th>
                <th>HORA DE SALIDA</th>
                <th>HORA DE LLEGADA</th>
                <th>TIPO DE VIATICO</th>
                <th>COMBUSTIBLE</th>
                <th>TIPO DE PASAJES</th>
                <th>SUBTIPO DE PASAJES</th>
                <th>TIPO DE FLETES</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($getMovilizacion as $gasto)
                <tr>
                    <td>{{ $gasto->id }}</td>
                    <td>{{ $gasto->agencia }}</td>
                    <td>{{ $gasto->user->name }}</td>
                    <td>{{ $gasto->detalle }}</td>

                    <td>{{ $gasto->valor }}</td>
                    <td>{{ $gasto->fecha }}</td>
                    <td>{{ $gasto->tipo_documento }}</td>
                    <td>{{ $gasto->numero_documento }}</td>
                    <td>{{ $gasto->comprobante }}</td>
                    <td>{{ $gasto->concepto }}</td>
                    <td>{{ $gasto->subtotal }}</td>
                    <td>{{ $gasto->created_at }}</td>
                    <td>
                        @if ($gasto->estado == '1')
                            En Espera
                        @elseif ($gasto->estado == '2')
                            Aprobado Cargar Documentos
                        @elseif ($gasto->estado == '3')
                            Solicitud Negada
                        @elseif ($gasto->estado == '4')
                            Documentos Cargados
                        @elseif ($gasto->estado == '5')
                            Finalizar Transacción
                        @elseif ($gasto->estado == '6')
                            Rectificar Información
                        @elseif ($gasto->estado == '7')
                            Gastos Departamentos
                        @else
                            Estado Desconocido
                        @endif
                    </td>
                    <td>{{ $gasto->novedad }}</td>

                    <td>{{ $gasto->movilizacion_tipo }}</td>
                    <td>{{ $gasto->inicio_destino }}</td>
                    <td>{{ $gasto->fin_destino }}</td>
                    <td>{{ $gasto->movilizacion_destino }}</td>
                    <td>{{ $gasto->movilizacion_asignado }}</td>
                    <td>{{ $gasto->hora_salida }}</td>
                    <td>{{ $gasto->hora_llegada }}</td>
                    <td>{{ $gasto->viaticos }}</td>
                    <td>{{ $gasto->combustible }}</td>
                    <td>{{ $gasto->tipo_pasajes }}</td>
                    <td>{{ $gasto->subtipo_pasajes }}</td>
                    <td>{{ $gasto->tipo_fletes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset


@isset($getTramitesEntidades)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>AGENCIA</th>
                <th>USUARIO</th>
                <th>DETALLE</th>
                <th>VALOR</th>
                <th>FECHA DEL COMPROBANTE</th>
                <th>TIPO DOCUMENTO</th>
                <th>NUMERO DOCUMENTO</th>
                <th>DOCUMENTO</th>
                <th>CONCEPTO</th>
                <th>VALOR IVA</th>
                <th>CREADO EL</th>
                <th>ESTADO</th>
                <th>NOVEDAD</th>

                <th>TIPO DE TRAMITE</th>
                <th>NOMBRE DE TRAMITE</th>
                <th>NOMBRE DE LA ENTIDAD</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($getTramitesEntidades as $gasto)
                <tr>
                    <td>{{ $gasto->id }}</td>
                    <td>{{ $gasto->agencia }}</td>
                    <td>{{ $gasto->user->name }}</td>
                    <td>{{ $gasto->detalle }}</td>

                    <td>{{ $gasto->valor }}</td>
                    <td>{{ $gasto->fecha }}</td>
                    <td>{{ $gasto->tipo_documento }}</td>
                    <td>{{ $gasto->numero_documento }}</td>
                    <td>{{ $gasto->comprobante }}</td>
                    <td>{{ $gasto->concepto }}</td>
                    <td>{{ $gasto->subtotal }}</td>
                    <td>{{ $gasto->created_at }}</td>
                    <td>
                        @if ($gasto->estado == '1')
                            En Espera
                        @elseif ($gasto->estado == '2')
                            Aprobado Cargar Documentos
                        @elseif ($gasto->estado == '3')
                            Solicitud Negada
                        @elseif ($gasto->estado == '4')
                            Documentos Cargados
                        @elseif ($gasto->estado == '5')
                            Finalizar Transacción
                        @elseif ($gasto->estado == '6')
                            Rectificar Información
                        @elseif ($gasto->estado == '7')
                            Gastos Departamentos
                        @else
                            Estado Desconocido
                        @endif
                    </td>
                    <td>{{ $gasto->novedad }}</td>

                    <td>{{ $gasto->tipo_tramite }}</td>
                    <td>{{ $gasto->nombre_tramite }}</td>
                    <td>{{ $gasto->nombre_entidad }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endisset
@isset($getGastosVarios)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>AGENCIA</th>
                <th>USUARIO</th>
                <th>DETALLE</th>
                <th>VALOR</th>
                <th>FECHA DEL COMPROBANTE</th>
                <th>TIPO DOCUMENTO</th>
                <th>NUMERO DOCUMENTO</th>
                <th>DOCUMENTO</th>
                <th>CONCEPTO</th>
                <th>VALOR IVA</th>
                <th>CREADO EL</th>
                <th>ESTADO</th>
                <th>NOVEDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getGastosVarios as $gasto)
                <tr>
                    <td>{{ $gasto->id }}</td>
                    <td>{{ $gasto->agencia }}</td>
                    <td>{{ $gasto->user->name }}</td>
                    <td>{{ $gasto->detalle }}</td>

                    <td>{{ $gasto->valor }}</td>
                    <td>{{ $gasto->fecha }}</td>
                    <td>{{ $gasto->tipo_documento }}</td>
                    <td>{{ $gasto->numero_documento }}</td>
                    <td>{{ $gasto->comprobante }}</td>
                    <td>{{ $gasto->concepto }}</td>
                    <td>{{ $gasto->subtotal }}</td>
                    <td>{{ $gasto->created_at }}</td>
                    <td>
                        @if ($gasto->estado == '1')
                            En Espera
                        @elseif ($gasto->estado == '2')
                            Aprobado Cargar Documentos
                        @elseif ($gasto->estado == '3')
                            Solicitud Negada
                        @elseif ($gasto->estado == '4')
                            Documentos Cargados
                        @elseif ($gasto->estado == '5')
                            Finalizar Transacción
                        @elseif ($gasto->estado == '6')
                            Rectificar Información
                        @elseif ($gasto->estado == '7')
                            Gastos Departamentos
                        @else
                            Estado Desconocido
                        @endif
                    </td>
                    <td>{{ $gasto->novedad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset
@isset($getSuministros)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>AGENCIA</th>
                <th>USUARIO</th>
                <th>DETALLE</th>
                <th>VALOR</th>
                <th>FECHA DEL COMPROBANTE</th>
                <th>TIPO DOCUMENTO</th>
                <th>NUMERO DOCUMENTO</th>
                <th>DOCUMENTO</th>
                <th>CONCEPTO</th>
                <th>VALOR IVA</th>
                <th>CREADO EL</th>
                <th>ESTADO</th>
                <th>NOVEDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getSuministros as $gasto)
                <tr>
                    <td>{{ $gasto->id }}</td>
                    <td>{{ $gasto->agencia }}</td>
                    <td>{{ $gasto->user->name }}</td>
                    <td>{{ $gasto->detalle }}</td>

                    <td>{{ $gasto->valor }}</td>
                    <td>{{ $gasto->fecha }}</td>
                    <td>{{ $gasto->tipo_documento }}</td>
                    <td>{{ $gasto->numero_documento }}</td>
                    <td>{{ $gasto->comprobante }}</td>
                    <td>{{ $gasto->concepto }}</td>
                    <td>{{ $gasto->subtotal }}</td>
                    <td>{{ $gasto->created_at }}</td>
                    <td>
                        @if ($gasto->estado == '1')
                            En Espera
                        @elseif ($gasto->estado == '2')
                            Aprobado Cargar Documentos
                        @elseif ($gasto->estado == '3')
                            Solicitud Negada
                        @elseif ($gasto->estado == '4')
                            Documentos Cargados
                        @elseif ($gasto->estado == '5')
                            Finalizar Transacción
                        @elseif ($gasto->estado == '6')
                            Rectificar Información
                        @elseif ($gasto->estado == '7')
                            Gastos Departamentos
                        @else
                            Estado Desconocido
                        @endif
                    </td>
                    <td>{{ $gasto->novedad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset
@isset($getMantenimiento)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>AGENCIA</th>
                <th>USUARIO</th>
                <th>DETALLE</th>
                <th>VALOR</th>
                <th>TIPO DE MANTENIMIENTO</th>
                <th>FECHA DEL COMPROBANTE</th>
                <th>TIPO DOCUMENTO</th>
                <th>NUMERO DOCUMENTO</th>
                <th>DOCUMENTO</th>
                <th>CONCEPTO</th>
                <th>VALOR IVA</th>
                <th>CREADO EL</th>
                <th>ESTADO</th>
                <th>NOVEDAD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($getMantenimiento as $gasto)
                <tr>
                    <td>{{ $gasto->id }}</td>
                    <td>{{ $gasto->agencia }}</td>
                    <td>{{ $gasto->user->name }}</td>
                    <td>{{ $gasto->detalle }}</td>

                    <td>{{ $gasto->valor }}</td>
                    <td>{{ $gasto->tipo_mantenimiento }}</td>
                    <td>{{ $gasto->fecha }}</td>
                    <td>{{ $gasto->tipo_documento }}</td>
                    <td>{{ $gasto->numero_documento }}</td>
                    <td>{{ $gasto->comprobante }}</td>
                    <td>{{ $gasto->concepto }}</td>
                    <td>{{ $gasto->subtotal }}</td>
                    <td>{{ $gasto->created_at }}</td>
                    <td>
                        @if ($gasto->estado == '1')
                            En Espera
                        @elseif ($gasto->estado == '2')
                            Aprobado Cargar Documentos
                        @elseif ($gasto->estado == '3')
                            Solicitud Negada
                        @elseif ($gasto->estado == '4')
                            Documentos Cargados
                        @elseif ($gasto->estado == '5')
                            Finalizar Transacción
                        @elseif ($gasto->estado == '6')
                            Rectificar Información
                        @elseif ($gasto->estado == '7')
                            Gastos Departamentos
                        @else
                            Estado Desconocido
                        @endif
                    </td>
                    <td>{{ $gasto->novedad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endisset
