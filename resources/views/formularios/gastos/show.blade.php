@extends('adminlte::page')

@section('title', 'Depósitos')
@section('css')
    <style>
        .custom-file-input~.custom-file-label::after {
            content: "Buscar";
        }
    </style>
@stop
@section('content_header')
    <h1 class="m-0 text-dark text-center">Gasto</h1>
@stop
@section('content')
@php
    $roleUser=true;
    if(auth()->user()->hasRole('JEFATURA')){
        $roleUser=true;
    }
    if(auth()->user()->hasRole('CAJERO GASTOS')){
        $roleUser=false;
    }
    $gestado=$gasto->estado;
@endphp
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-xs-10">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>!Revise los campos!</strong><br>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="row">

                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="agencia-container" class="mb-3">
                                        <label for="agencia" class="form-label">Agencia</label>
                                        <input type="text" class="form-control" name="agencia" id="agencia" readonly
                                            value="{{ $gasto->agencia }}">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="detalle-container" class="mb-3 ">
                                        <label for="detalle" class="form-label">Detalle</label>
                                        <input type="text" class="form-control" name="detalle" id="detalle" readonly
                                            value="{{ $gasto->detalle }}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="valor-container" class="mb-3 ">
                                        <label for="valor" class="form-label">Valor</label>
                                        <input type="text" class="form-control" name="valor" id="valor" readonly
                                            value="{{ $gasto->valor }}">
                                    </div>
                                </div>
                            </div>
                                <div id="tipo-documento-container" class="mb-3 ">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6 col-sm-6">
                                            <div id="fecha-container" class="mb-3">
                                                <label for="fecha" class="form-label">Fecha de Comprobante</label>
                                                <input type="date" class="form-control" name="fecha" id="fecha"
                                                    readonly value="{{ $gasto->fecha }}">
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-md-6 col-sm-6">
                                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                            <select class="form-control" id="tipo_documento" name="tipo_documento" disabled>
                                                <option value="">Seleccione tipo de documento</option>
                                                <option value="numero_recibo"
                                                    {{ $gasto->tipo_documento == 'numero_recibo' ? 'selected' : '' }}>
                                                    Número de Recibo</option>
                                                <option value="numero_factura"
                                                    {{ $gasto->tipo_documento == 'numero_factura' ? 'selected' : '' }}>
                                                    Número de Factura</option>
                                                <option value="numero_nota_venta"
                                                    {{ $gasto->tipo_documento == 'numero_nota_venta' ? 'selected' : '' }}>
                                                    Número de nota de venta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 " id="numero-documento-container">
                                    <div class="col-xs-6 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label for="file">Comprobante</label>

                                            @if ($gasto->comprobante)
                                            <p>Archivo actual: <button type="button" class="btn btn-sm btn-link"
                                                    data-toggle="modal" data-target="#staticBackdrop">
                                                    Ver Documento
                                                </button>
                                                <a href="{{ Storage::url($gasto->comprobante) }}"
                                                    class="btn btn-sm btn-link" target="_blank">abrir</a>
                                            </p>
                                            @include('formularios.gastos.partial.modal')
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-6 col-sm-6">
                                        <div class="mb-3">
                                            <label for="numero_documento" class="form-label">Número de Documento</label>
                                            <input type="text" class="form-control" name="numero_documento"
                                                id="numero_documento" readonly value="{{ $gasto->numero_documento }}">
                                        </div>
                                    </div>
                                    <div id="factura_subtotal" class="col-xs-6 col-md-2 col-sm-6 ">
                                        <div class=" mb-3">
                                                <label for="subtotal" class="form-label">Valor IVA</label>
                                                <input type="text" class="form-control" name="subtotal"
                                                id="subtotal" readonly value="{{  $gasto->subtotal }}">
                                        </div>
                                    </div>
                                </div>
                            <!-- Campo Agencia -->
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="mb-3">
                                        <label for="concepto" class="form-label">Concepto</label>
                                        <select class="form-control" id="concepto" name="concepto" disabled>
                                            <option value="">Seleccione un concepto</option>
                                            <option value="gastos_varios"
                                                {{ $gasto->concepto == 'gastos_varios' ? 'selected' : '' }}>
                                                Gastos Varios</option>
                                            <option value="tramites_entidades"
                                                {{ $gasto->concepto == 'tramites_entidades' ? 'selected' : '' }}>
                                                Trámites Entidades</option>
                                            <option value="mantenimiento"
                                                {{ $gasto->concepto == 'mantenimiento' ? 'selected' : '' }}>
                                                Mantenimiento</option>
                                                <option value="movilizacion"
                                                {{ $gasto->concepto == 'movilizacion' ? 'selected' : '' }}>
                                                Movilización</option>
                                            <option value="suministros"
                                                {{ $gasto->concepto == 'suministros' ? 'selected' : '' }}>
                                                Suministros</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="tipo-tramite-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="tipo_tramite" class="form-label">Tipo de Trámite</label>
                                        <select class="form-control" id="tipo_tramite" name="tipo_tramite" disabled>
                                            <option value="">Seleccione tipo de trámite</option>
                                            <option value="municipios"
                                                {{ $gasto->tipo_tramite == 'municipios' ? 'selected' : '' }}>
                                                Municipios</option>
                                            <option value="ant"
                                                {{ $gasto->tipo_tramite == 'ant' ? 'selected' : '' }}>
                                                ANT</option>
                                            <option value="sri"
                                                {{ $gasto->tipo_tramite == 'sri' ? 'selected' : '' }}>
                                                SRI</option>
                                            <option value="fiscalia"
                                                {{ $gasto->tipo_tramite == 'fiscalia' ? 'selected' : '' }}>
                                                Fiscalía</option>
                                            <option value="notaria"
                                                {{ $gasto->tipo_tramite == 'notaria' ? 'selected' : '' }}>
                                                Notaría</option>
                                            <option value="ministerio_de_trabajo"
                                                {{ $gasto->tipo_tramite == 'ministerio_de_trabajo' ? 'selected' : '' }}>
                                                Ministerio del Trabajo</option>
                                            <option value="procuracion_judicial"
                                                {{ $gasto->tipo_tramite == 'procuracion_judicial' ? 'selected' : '' }}>
                                                Procuración judicial</option>
                                            <option value="registro_mercantil"
                                                {{ $gasto->tipo_tramite == 'registro_mercantil' ? 'selected' : '' }}>
                                                Registro Mercantil</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="nombre-tramite-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="nombre_tramite" class="form-label">Nombre del Trámite</label>
                                        <input type="text" class="form-control" id="nombre_tramite"
                                            name="nombre_tramite" readonly value="{{ $gasto->nombre_tramite }}">
                                    </div>
                                </div>
                                <div id="nombre-entidad-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="nombre_entidad" class="form-label">Nombre de la Entidad</label>
                                        <input type="text" class="form-control" id="nombre_entidad"
                                            name="nombre_entidad" readonly value="{{ $gasto->nombre_entidad }}">
                                    </div>
                                </div>
                                <div id="movilizacion-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="movilizacion_tipo" class="form-label">Tipo de Movilización</label>
                                        <select class="form-control" id="movilizacion_tipo" name="movilizacion_tipo"
                                            disabled>
                                            <option value="">Seleccione tipo de movilización</option>
                                            <option value="encomiendas"
                                                {{ $gasto->movilizacion_tipo == 'encomiendas' ? 'selected' : '' }}>
                                                Encomiendas</option>
                                            <option value="traslado_personal"
                                                {{ $gasto->movilizacion_tipo == 'traslado_personal' ? 'selected' : '' }}>
                                                Traslado del Personal</option>
                                            <option value="traslado_mercaderia"
                                                {{ $gasto->movilizacion_tipo == 'traslado_mercaderia' ? 'selected' : '' }}>
                                                Traslado de Mercadería</option>
                                            <option value="traslado_valores"
                                                {{ $gasto->movilizacion_tipo == 'traslado_valores' ? 'selected' : '' }}>
                                                Traslado de Valores</option>
                                            <option value="notificacion"
                                                {{ $gasto->movilizacion_tipo == 'notificacion' ? 'selected' : '' }}>
                                                Notificación</option>
                                            <option value="volanteo"
                                                {{ $gasto->movilizacion_tipo == 'volanteo' ? 'selected' : '' }}>
                                                Volanteo</option>
                                            <option value="viaticos"
                                                {{ $gasto->movilizacion_tipo == 'viaticos' ? 'selected' : '' }}>
                                                Viáticos</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="viaticos-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="viaticos" class="form-label">Viáticos</label>
                                        <select class="form-control" id="viaticos" name="viaticos" disabled>
                                            <option value="">Seleccione tipo de viático</option>
                                            <option value="peaje" {{ $gasto->viaticos == 'peaje' ? 'selected' : '' }}>
                                                Peaje
                                            </option>
                                            <option value="pasajes"
                                                {{ $gasto->viaticos == 'pasajes' ? 'selected' : '' }}>
                                                Pasajes</option>
                                            <option value="fletes" {{ $gasto->viaticos == 'fletes' ? 'selected' : '' }}>
                                                Fletes</option>
                                            <option value="movilizacion"
                                                {{ $gasto->viaticos == 'movilizacion' ? 'selected' : '' }}>
                                                Movilización</option>
                                            <option value="hospedaje"
                                                {{ $gasto->viaticos == 'hospedaje' ? 'selected' : '' }}>
                                                Hospedaje</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="combustible-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="combustible" class="form-label">Combustible</label>
                                        <input type="text" class="form-control" id="combustible" name="combustible"
                                            readonly value="{{ $gasto->combustible }}">
                                    </div>
                                </div>
                                <div id="destino-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="destino" class="form-label">Destino</label>
                                        <input type="text" class="form-control" id="destino" name="destino"
                                            readonly value="{{ $gasto->destino }}">
                                    </div>
                                </div>
                                <div id="asignado-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="asignado" class="form-label">Asignado a</label>
                                        <input type="text" class="form-control" id="asignado" name="asignado"
                                            readonly value="{{ $gasto->asignado }}">
                                    </div>
                                </div>
                                <div id="tipo-pasajes-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="tipo_pasajes" class="form-label">Tipo de Pasajes</label>
                                        <select class="form-control" id="tipo_pasajes" name="tipo_pasajes" disabled>
                                            <option value="">Seleccione tipo de pasajes</option>
                                            <option value="nacionales"
                                                {{ $gasto->tipo_pasajes == 'nacionales' ? 'selected' : '' }}>
                                                Nacionales</option>
                                            <option value="interprovincial"
                                                {{ $gasto->tipo_pasajes == 'interprovincial' ? 'selected' : '' }}>
                                                Interprovincial</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="subtipo-pasajes-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="subtipo_pasajes" class="form-label">Subtipo de Pasajes</label>
                                        <select class="form-control" id="subtipo_pasajes" name="subtipo_pasajes"
                                            disabled>
                                            <option value="">Seleccione subtipo de pasajes</option>
                                            <option value="taxis"
                                                {{ $gasto->subtipo_pasajes == 'taxis' ? 'selected' : '' }}>
                                                Taxis</option>
                                            <option value="buses"
                                                {{ $gasto->subtipo_pasajes == 'buses' ? 'selected' : '' }}>
                                                Buses</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="tipo-fletes-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="tipo_fletes" class="form-label">Tipo de Fletes</label>
                                        <select class="form-control" id="tipo_fletes" name="tipo_fletes" disabled>
                                            <option value="">Seleccione tipo de fletes</option>
                                            <option value="camionetas"
                                                {{ $gasto->tipo_fletes == 'camionetas' ? 'selected' : '' }}>
                                                Camionetas</option>
                                            <option value="autos"
                                                {{ $gasto->tipo_fletes == 'autos' ? 'selected' : '' }}>
                                                Autos</option>
                                            <option value="motos"
                                                {{ $gasto->tipo_fletes == 'motos' ? 'selected' : '' }}>
                                                Motos</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="inicio-flete-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="inicio_destino" class="form-label">Inicio de destino</label>
                                        <input type="text" class="form-control" id="inicio_destino"
                                            name="inicio_destino" value="{{ $gasto->inicio_destino }}">
                                    </div>
                                </div>
                                <div id="fin-flete-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="fin_destino" class="form-label">Fin de Destino</label>
                                        <input type="text" class="form-control" id="fin_destino"
                                            name="fin_destino" value="{{ $gasto->fin_destino }}">
                                    </div>
                                </div>
                                <div id="detalle-flete-container" class="col-xs-12 col-md-12 col-sm-12  d-none">
                                    <div class="mb-3">
                                        <label for="detalle_flete" class="form-label">Detalle del Flete</label>
                                        <textarea class="form-control" id="detalle_flete" name="detalle_flete" rows="3">{{ $gasto->detalle_flete }}</textarea>
                                    </div>
                                </div>
                                <div id="movilizacion-destino-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="movilizacion_destino" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="movilizacion_destino"
                                            name="movilizacion_destino" readonly
                                            value="{{ $gasto->movilizacion_destino }}">
                                    </div>
                                </div>
                                <div id="movilizacion-asignado-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="movilizacion_asignado" class="form-label">Asignado a</label>
                                        <input type="text" class="form-control" id="movilizacion_asignado"
                                            name="movilizacion_asignado" readonly
                                            value="{{ $gasto->movilizacion_asignado }}">
                                    </div>
                                </div>
                                <div id="movilizacion-detalle-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="movilizacion_detalle" class="form-label">Detalle</label>
                                        <textarea class="form-control" id="movilizacion_detalle" name="movilizacion_detalle" readonly rows="3">{{ $gasto->movilizacion_detalle }}</textarea>
                                    </div>
                                </div>
                                <div id="tipo-mantenimiento-container" class="col-xs-12 col-md-4 col-sm-4  d-none">
                                    <div class="mb-3">
                                        <label for="tipo_mantenimiento" class="form-label">Tipo de Mantenimiento</label>
                                        <select class="form-control" id="tipo_mantenimiento" name="tipo_mantenimiento">
                                            <option value="camionetas"
                                                {{ $gasto->tipo_mantenimiento == 'camionetas' ? 'selected' : '' }}>
                                                Camionetas</option>
                                            <option value="autos"
                                                {{ $gasto->tipo_mantenimiento == 'autos' ? 'selected' : '' }}>
                                                Autos</option>
                                            <option value="motos"
                                                {{ $gasto->tipo_mantenimiento == 'motos' ? 'selected' : '' }}>
                                                Motos</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->hasRole('TESORERIA HOLDING'))
                            {!! Form::model($gasto, ['url' => route('gastos.validar', $gasto->id), 'method' => 'POST']) !!}
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                                        @if ($gasto->user->agencia->nombre=="AREA")
                                        {!! Form::select('estado', [
                                            '' => 'Seleccione el estado',
                                            '1' => 'En Espera',
                                            '5' => 'Finalizar Transaccion',
                                            '6' => 'Rectificar Información',
                                        ], null, ['class' => 'form-control', 'id' => 'estado']) !!}
                                        @else
                                        {!! Form::select('estado', [
                                            '' => 'Seleccione el estado',
                                            '1' => 'En Espera',
                                            '2' => 'Aprobado Cargar Documentos',
                                            '3' => 'Solicitud Negada',
                                            '4' => 'Documentos Cargados',
                                            '5' => 'Finalizar Transaccion',
                                            '6' => 'Rectificar Documentos',
                                            //'7' => 'Gastos Departamentos' // Asegúrate de que este valor sea único
                                        ], null, ['class' => 'form-control', 'id' => 'estado']) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {!! Form::label('novedad', 'Novedad', ['class' => 'form-label']) !!}
                                        {!! Form::text('novedad', null, ['class' => 'form-control', 'id' => 'novedad']) !!}
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Solicitud</button>
                            {!! Form::close() !!}
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="mb-3">
                                                {!! Form::label('novedad', 'Novedad', ['class' => 'form-label']) !!}
                                                {!! Form::text('novedad', null, ['class' => 'form-control', 'id' => 'novedad']) !!}
                                            </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')

    <script>
        $('input, textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });
        $('#apellidos').on('input', function() {
            // Remueve todos los caracteres que no sean letras o espacios
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
        $('#num_documento').on('input', function() {
            // Remueve todos los caracteres que no sean números o caracteres especiales
            this.value = this.value.replace(/[^0-9!@#$%^&*(),.?":{}|<>-]/g, '');
        });
        $('.val-money').on('input', function() {
            // Remueve todos los caracteres que no sean números o caracteres especiales
            this.value = this.value.replace(/[^0-9!.]/g, '');
        });
    </script>
    <script>
        $(document).ready(function() {
            // Función para mostrar/ocultar los contenedores según el concepto seleccionado
            function toggleContainers() {
                var concepto = $('#concepto').val();

                // Ocultar todos los contenedores
                $('#tipo-tramite-container, #nombre-tramite-container, #nombre-entidad-container').addClass(
                    'd-none');

                // Mostrar contenedores según el concepto seleccionado
                if (concepto === 'tramites_entidades') {
                    $('#tipo-tramite-container').removeClass('d-none');
                    $('#nombre-tramite-container').removeClass('d-none');
                    $('#nombre-entidad-container').removeClass('d-none');
                }
            }

            function toggleMovilizacionFields() {

                const movilizacionContainer = document.getElementById('movilizacion-container');
                const movilizacionTipo = document.getElementById('movilizacion_tipo');
                const viaticosContainer = document.getElementById('viaticos-container');
                const destinoContainer = document.getElementById('destino-container');
                const asignadoContainer = document.getElementById('asignado-container');

                const selectedValue = movilizacionTipo.value;
                var concepto = $('#concepto').val();
                if (concepto === 'movilizacion') {
                    movilizacionContainer.classList.remove('d-none');
                } else if (concepto === 'mantenimiento'){
                    document.getElementById('tipo-mantenimiento-container').classList.remove('d-none');
                }


                if (['encomiendas', 'traslado_personal', 'traslado_mercaderia', 'traslado_valores',
                        'notificacion', 'volanteo'
                    ].includes(selectedValue)) {
                    document.getElementById('movilizacion-destino-container').classList.remove('d-none');
                    document.getElementById('movilizacion-asignado-container').classList.remove('d-none');
                    document.getElementById('movilizacion-detalle-container').classList.remove('d-none');
                    document.getElementById('inicio-flete-container').classList.remove('d-none');
                    document.getElementById('fin-flete-container').classList.remove('d-none');
                    if(selectedValue == "traslado_valores"){
                        document.getElementById('inicio-flete-container').classList.add('d-none');
                        document.getElementById('fin-flete-container').classList.add('d-none');
                    }
                } else if (selectedValue === 'viaticos') {
                    document.getElementById('viaticos-container').classList.remove('d-none');

                    var viaticos = $("#viaticos").val();
                    if (viaticos === 'peaje') {
                        document.getElementById('combustible-container').classList.remove('d-none');
                        //document.getElementById('destino-container').classList.remove('d-none');
                        document.getElementById('asignado-container').classList.remove('d-none');
                        document.getElementById('inicio-flete-container').classList.remove('d-none');
                        document.getElementById('fin-flete-container').classList.remove('d-none');
                    } else if (viaticos === 'pasajes') {
                        document.getElementById('tipo-pasajes-container').classList.remove('d-none');
                        //document.getElementById('destino-container').classList.remove('d-none');
                        document.getElementById('asignado-container').classList.remove('d-none');
                        document.getElementById('inicio-flete-container').classList.remove('d-none');
                        document.getElementById('fin-flete-container').classList.remove('d-none');
                        if ($("#tipo_pasajes").val() == 'nacionales') {
                            document.getElementById('subtipo-pasajes-container').classList.remove('d-none');
                        }
                    } else if (viaticos === 'fletes') {
                        document.getElementById('tipo-fletes-container').classList.remove('d-none');
                        document.getElementById('detalle-flete-container').classList.remove('d-none');
                        document.getElementById('detalle-container').classList.add('d-none');
                        document.getElementById('inicio-flete-container').classList.remove('d-none');
                        document.getElementById('fin-flete-container').classList.remove('d-none');
                    } else if(viaticos === 'movilizacion'){
                        document.getElementById('inicio-flete-container').classList.remove('d-none');
                        document.getElementById('fin-flete-container').classList.remove('d-none');
                    } else if(viaticos === 'hospedaje'){
                        document.getElementById('inicio-flete-container').classList.remove('d-none');
                        document.getElementById('fin-flete-container').classList.remove('d-none');
                    }

                }
            }
            // Llamar a la función al cargar la página
            toggleContainers();
            toggleMovilizacionFields();
            // Añadir un evento change para cuando se seleccione una opción diferente


            // Llamar a la función cuando se cambia la selección
            $('#concepto').change(function() {
                toggleContainers();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const roleUser = '{{ $roleUser}}'; // O 'true' dependiendo del tipo
            const gastoEstado = '{{ $gasto->estado }}';

            if (roleUser==true) {
                document.getElementById('tipo-documento-container').classList.remove('d-none');
                document.getElementById('numero-documento-container').classList.remove('d-none');
            } else {
                if (gastoEstado == 2 || gastoEstado == 6) {
                    document.getElementById('tipo-documento-container').classList.remove('d-none');
                    document.getElementById('numero-documento-container').classList.remove('d-none');
                } else {
                    document.getElementById('tipo-documento-container').classList.add('d-none');
                    document.getElementById('numero-documento-container').classList.add('d-none');
                }
            }
        });
    </script>
@stop
