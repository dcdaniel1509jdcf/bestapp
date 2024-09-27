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

                            {!! Form::model($gasto, ['url' => route('gastos.update', $gasto->id), 'method' => 'PUT', 'files' => true]) !!}
                            @csrf
                            <div class="row">

                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="agencia-container" class="mb-3">
                                        <label for="agencia" class="form-label">Agencia</label>
                                        <input type="text" class="form-control" name="agencia" id="agencia"
                                            value="{{ old('agencia', $gasto->agencia) }}" @if( ( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="valor-container" class="mb-3 ">
                                        <label for="valor" class="form-label">Valor</label>
                                        <input type="text" class="form-control" name="valor" id="valor" required
                                            value="{{ old('valor', $gasto->valor) }}" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif>
                                    </div>
                                </div>
                                <div id="detalle-container" class="col-xs-12 col-md-12 col-sm-12">
                                    <div  class="mb-3 ">
                                        <label for="detalle" class="form-label">Detalle</label>
                                        <input type="text" class="form-control" name="detalle" id="detalle" required
                                            value="{{ old('detalle', $gasto->detalle) }}" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif>
                                    </div>
                                </div>
                            </div>

                            <div id="tipo-documento-container" class="mb-3 ">
                                <div class="row">
                                    <div class="col-xs-6 col-md-6 col-sm-6">
                                        <div id="fecha-container" class="mb-3">
                                            <label for="fecha" class="form-label">Fecha de Comprobante</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha"
                                                value="{{ old('fecha', $gasto->fecha) }}" >
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-md-6 col-sm-6">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                        <select class="form-control" id="tipo_documento" name="tipo_documento">
                                            <option value="">Seleccione tipo de documento</option>
                                            <option value="numero_recibo"
                                                {{ old('tipo_documento', $gasto->tipo_documento) == 'numero_recibo' ? 'selected' : '' }}>
                                                Número de Recibo</option>
                                            <option value="numero_factura"
                                                {{ old('tipo_documento', $gasto->tipo_documento) == 'numero_factura' ? 'selected' : '' }}>
                                                Número de Factura</option>
                                            <option value="numero_nota_venta"
                                                {{ old('tipo_documento', $gasto->tipo_documento) == 'numero_nota_venta' ? 'selected' : '' }}>
                                                Número de nota de venta</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 " id="numero-documento-container">
                                <div class="col-xs-6 col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label for="file">Cargar comprobante</label>
                                        <div class="custom-file">
                                            <input type="file" name="comprobante" class="custom-file-input"
                                                id="file">
                                            <label class="custom-file-label" for="file">Elegir</label>
                                        </div>
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
                                            id="numero_documento" placeholder="000-000-0000123"
                                            value="{{ old('numero_documento', $gasto->numero_documento) }}">
                                    </div>
                                </div>
                                <div id="factura_subtotal" class="col-xs-6 col-md-2 col-sm-6 ">
                                    <div class=" mb-3">
                                            <label for="subtotal" class="form-label">Subtotal</label>
                                            <input type="text" class="form-control" name="subtotal"
                                            id="subtotal" readonly value="{{ old('subtotal', $gasto->subtotal) }}">
                                    </div>
                                </div>
                            </div>
                            <!-- Campo Agencia -->
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="mb-3">
                                        <label for="concepto" class="form-label">Concepto</label>
                                        <select class="form-control" id="concepto" name="concepto"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
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
                                        <select class="form-control" id="tipo_tramite" name="tipo_tramite"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
                                            <option value="">Seleccione tipo de trámite</option>
                                            <option value="municipios"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'municipios' ? 'selected' : '' }}>
                                                Municipios</option>
                                            <option value="ant"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'ant' ? 'selected' : '' }}>
                                                ANT</option>
                                            <option value="sri"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'sri' ? 'selected' : '' }}>
                                                SRI</option>
                                            <option value="fiscalia"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'fiscalia' ? 'selected' : '' }}>
                                                Fiscalía</option>
                                            <option value="notaria"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'notaria' ? 'selected' : '' }}>
                                                Notaría</option>
                                            <option value="ministerio_de_trabajo"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'ministerio_de_trabajo' ? 'selected' : '' }}>
                                                Ministerio del Trabajo</option>
                                            <option value="procuracion_judicial"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'procuracion_judicial' ? 'selected' : '' }}>
                                                Procuración judicial</option>
                                            <option value="registro_mercantil"
                                                {{ old('tipo_tramite', $gasto->tipo_tramite) == 'registro_mercantil' ? 'selected' : '' }}>
                                                Registro Mercantil</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="nombre-tramite-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="nombre_tramite" class="form-label">Nombre del Trámite</label>
                                        <input type="text" class="form-control" id="nombre_tramite"
                                            name="nombre_tramite" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('nombre_tramite', $gasto->nombre_tramite) }}">
                                    </div>
                                </div>
                                <div id="nombre-entidad-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="nombre_entidad" class="form-label">Nombre de la Entidad</label>
                                        <input type="text" class="form-control" id="nombre_entidad"
                                            name="nombre_entidad" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('nombre_entidad', $gasto->nombre_entidad) }}">
                                    </div>
                                </div>
                                <div id="movilizacion-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="movilizacion_tipo" class="form-label">Tipo de Movilización</label>
                                        <select class="form-control" id="movilizacion_tipo" name="movilizacion_tipo"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
                                            <option value="">Seleccione tipo de movilización</option>
                                            <option value="encomiendas"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'encomiendas' ? 'selected' : '' }}>
                                                Encomiendas</option>
                                            <option value="traslado_personal"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'traslado_personal' ? 'selected' : '' }}>
                                                Traslado del Personal</option>
                                            <option value="traslado_mercaderia"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'traslado_mercaderia' ? 'selected' : '' }}>
                                                Traslado de Mercadería</option>
                                            <option value="traslado_valores"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'traslado_valores' ? 'selected' : '' }}>
                                                Traslado de Valores</option>
                                            <option value="notificacion"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'notificacion' ? 'selected' : '' }}>
                                                Notificación</option>
                                            <option value="volanteo"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'volanteo' ? 'selected' : '' }}>
                                                Volanteo</option>
                                            <option value="viaticos"
                                                {{ old('movilizacion_tipo', $gasto->movilizacion_tipo) == 'viaticos' ? 'selected' : '' }}>
                                                Viáticos</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="viaticos-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="viaticos" class="form-label">Viáticos</label>
                                        <select class="form-control" id="viaticos" name="viaticos"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
                                            <option value="">Seleccione tipo de viático</option>
                                            <option value="peaje"
                                                {{ old('viaticos', $gasto->viaticos) == 'peaje' ? 'selected' : '' }}>Peaje
                                            </option>
                                            <option value="pasajes"
                                                {{ old('viaticos', $gasto->viaticos) == 'pasajes' ? 'selected' : '' }}>
                                                Pasajes</option>
                                            <option value="fletes"
                                                {{ old('viaticos', $gasto->viaticos) == 'fletes' ? 'selected' : '' }}>
                                                Fletes</option>
                                            <option value="movilizacion"
                                                {{ old('viaticos', $gasto->viaticos) == 'movilizacion' ? 'selected' : '' }}>
                                                Movilización</option>
                                            <option value="hospedaje"
                                                {{ old('viaticos', $gasto->viaticos) == 'hospedaje' ? 'selected' : '' }}>
                                                Hospedaje</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="combustible-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="combustible" class="form-label">Combustible</label>
                                        <input type="text" class="form-control" id="combustible" name="combustible"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('combustible', $gasto->combustible) }}">
                                    </div>
                                </div>
                                <div id="destino-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="destino" class="form-label">Destino</label>
                                        <input type="text" class="form-control" id="destino" name="destino"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('destino', $gasto->destino) }}">
                                    </div>
                                </div>
                                <div id="asignado-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="asignado" class="form-label">Asignado a</label>
                                        <input type="text" class="form-control" id="asignado" name="asignado"
                                        placeholder="Nombre de la persona a cargo" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('asignado', $gasto->asignado) }}">
                                    </div>
                                </div>
                                <div id="tipo-pasajes-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="tipo_pasajes" class="form-label">Tipo de Pasajes</label>
                                        <select class="form-control" id="tipo_pasajes" name="tipo_pasajes"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
                                            <option value="">Seleccione tipo de pasajes</option>
                                            <option value="nacionales"
                                                {{ old('tipo_pasajes', $gasto->tipo_pasajes) == 'nacionales' ? 'selected' : '' }}>
                                                Nacionales</option>
                                            <option value="interprovincial"
                                                {{ old('tipo_pasajes', $gasto->tipo_pasajes) == 'interprovincial' ? 'selected' : '' }}>
                                                Interprovincial</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="subtipo-pasajes-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="subtipo_pasajes" class="form-label">Subtipo de Pasajes</label>
                                        <select class="form-control" id="subtipo_pasajes" name="subtipo_pasajes"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
                                            <option value="">Seleccione subtipo de pasajes</option>
                                            <option value="taxis"
                                                {{ old('subtipo_pasajes', $gasto->subtipo_pasajes) == 'taxis' ? 'selected' : '' }}>
                                                Taxis</option>
                                            <option value="buses"
                                                {{ old('subtipo_pasajes', $gasto->subtipo_pasajes) == 'buses' ? 'selected' : '' }}>
                                                Buses</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="tipo-fletes-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="tipo_fletes" class="form-label">Tipo de Fletes</label>
                                        <select class="form-control" id="tipo_fletes" name="tipo_fletes"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) disabled @endif >
                                            <option value="">Seleccione tipo de fletes</option>
                                            <option value="camionetas"
                                                {{ old('tipo_fletes', $gasto->tipo_fletes) == 'camionetas' ? 'selected' : '' }}>
                                                Camionetas</option>
                                            <option value="autos"
                                                {{ old('tipo_fletes', $gasto->tipo_fletes) == 'autos' ? 'selected' : '' }}>
                                                Autos</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="inicio-flete-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="inicio_destino" class="form-label">Inicio de destino</label>
                                        <input type="text" class="form-control" id="inicio_destino"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            name="inicio_destino" value="{{ old('inicio_destino', $gasto->inicio_destino) }}">
                                    </div>
                                </div>
                                <div id="fin-flete-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="fin_destino" class="form-label">Fin de Destino</label>
                                        <input type="text" class="form-control" id="fin_destino"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            name="fin_destino" value="{{ old('fin_destino', $gasto->fin_destino) }}">
                                    </div>
                                </div>
                                <div id="detalle-flete-container" class="col-xs-12 col-md-12 col-sm-12  d-none">
                                    <div class="mb-3">
                                        <label for="detalle_flete" class="form-label">Detalle del Flete</label>
                                        <textarea class="form-control" id="detalle_flete" name="detalle_flete" rows="3"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif >{{ old('detalle_flete', $gasto->detalle_flete) }}</textarea>
                                    </div>
                                </div>
                                <div id="movilizacion-destino-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="movilizacion_destino" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="movilizacion_destino"
                                            name="movilizacion_destino" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('movilizacion_destino', $gasto->movilizacion_destino) }}">
                                    </div>
                                </div>
                                <div id="movilizacion-asignado-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="movilizacion_asignado" class="form-label">Asignado a</label>
                                        <input type="text" class="form-control" id="movilizacion_asignado" placeholder="Nombre de la persona a cargo"
                                            name="movilizacion_asignado" @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                            value="{{ old('movilizacion_asignado', $gasto->movilizacion_asignado) }}">
                                    </div>
                                </div>
                                <div id="movilizacion-detalle-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="movilizacion_detalle" class="form-label">Detalle</label>
                                        <textarea class="form-control" id="movilizacion_detalle"
                                        @if(( $roleUser == false ) && ($gestado == 2 || $gestado == 6)) readonly @endif
                                        name="movilizacion_detalle" rows="3">{{ old('movilizacion_detalle', $gasto->movilizacion_detalle) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="mb-3">
                                        <label for="novedad" class="form-label">Novedad</label>
                                        <input type="text" class="form-control" id="novedad" readonly name="novedad"

                                            value="{{ $gasto->novedad }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Solicitud</button>
                            {!! Form::close() !!}
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
                //document.getElementById('detalle-container').classList.remove('d-none');
                const selectedValue = movilizacionTipo.value;
                var concepto = $('#concepto').val();
                if (concepto === 'movilizacion') {
                    movilizacionContainer.classList.remove('d-none');
                }


                if (['encomiendas', 'traslado_personal', 'traslado_mercaderia', 'traslado_valores',
                        'notificacion', 'volanteo'
                    ].includes(selectedValue)) {
                    document.getElementById('movilizacion-destino-container').classList.remove('d-none');
                    document.getElementById('movilizacion-asignado-container').classList.remove('d-none');
                    //document.getElementById('movilizacion-detalle-container').classList.remove('d-none');
                } else if (selectedValue === 'viaticos') {
                    document.getElementById('viaticos-container').classList.remove('d-none');

                    var viaticos = $("#viaticos").val();
                    if (viaticos === 'peaje') {
                      //  document.getElementById('combustible-container').classList.remove('d-none');
                        document.getElementById('destino-container').classList.remove('d-none');
                        document.getElementById('asignado-container').classList.remove('d-none');
                    } else if (viaticos === 'pasajes') {
                        document.getElementById('tipo-pasajes-container').classList.remove('d-none');
                        document.getElementById('destino-container').classList.remove('d-none');
                        document.getElementById('asignado-container').classList.remove('d-none');
                        if ($("#tipo_pasajes").val() == 'nacionales') {
                            document.getElementById('subtipo-pasajes-container').classList.remove('d-none');
                        }
                    } else if (viaticos === 'fletes') {
                        document.getElementById('tipo-fletes-container').classList.remove('d-none');
                        document.getElementById('detalle-flete-container').classList.remove('d-none');
                        document.getElementById('detalle-container').classList.add('d-none');
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
        document.getElementById('tipo_documento').addEventListener('change', function() {
            if (this.value) {
                document.getElementById('numero-documento-container').classList.remove('d-none');
            } else {
                document.getElementById('numero-documento-container').classList.add('d-none');
            }
        });
        document.getElementById('concepto').addEventListener('change', function() {
            var concepto = this.value;

            // Reset y ocultar todos los campos dinámicos

            document.getElementById('tipo-tramite-container').classList.add('d-none');
            document.getElementById('nombre-tramite-container').classList.add('d-none');
            document.getElementById('nombre-entidad-container').classList.add('d-none');
            document.getElementById('viaticos-container').classList.add('d-none');
            document.getElementById('combustible-container').classList.add('d-none');
            document.getElementById('destino-container').classList.add('d-none');
            document.getElementById('asignado-container').classList.add('d-none');
            document.getElementById('tipo-pasajes-container').classList.add('d-none');
            document.getElementById('subtipo-pasajes-container').classList.add('d-none');
            document.getElementById('tipo-fletes-container').classList.add('d-none');
            document.getElementById('detalle-flete-container').classList.add('d-none');
            document.getElementById('inicio-flete-container').classList.add('d-none');
            document.getElementById('fin-flete-container').classList.add('d-none');
            document.getElementById('movilizacion-container').classList.add('d-none');
            document.getElementById('movilizacion-destino-container').classList.add('d-none');
            document.getElementById('movilizacion-asignado-container').classList.add('d-none');
            document.getElementById('movilizacion-detalle-container').classList.add('d-none');
            //
            document.getElementById('detalle-container').classList.remove('d-none');

            if (concepto === 'gastos_varios' || concepto === 'suministros') {
                // Campos por defecto
            } else if (concepto === 'tramites_entidades') {
                document.getElementById('tipo-tramite-container').classList.remove('d-none');

                document.getElementById('tipo_tramite').addEventListener('change', function() {
                    if (this.value) {
                        document.getElementById('nombre-tramite-container').classList.remove('d-none');
                        document.getElementById('nombre-entidad-container').classList.remove('d-none');
                    } else {
                        document.getElementById('nombre-tramite-container').classList.add('d-none');
                        document.getElementById('nombre-entidad-container').classList.add('d-none');
                    }
                });

            } else if (concepto === 'movilizacion') {
                document.getElementById('movilizacion-container').classList.remove('d-none');

                document.getElementById('movilizacion_tipo').addEventListener('change', function() {
                    var movilizacion_tipo = this.value;

                    // Ocultar todos los campos relacionados
                    document.getElementById('combustible-container').classList.add('d-none');
                    document.getElementById('destino-container').classList.add('d-none');
                    document.getElementById('asignado-container').classList.add('d-none');
                    document.getElementById('tipo-pasajes-container').classList.add('d-none');
                    document.getElementById('subtipo-pasajes-container').classList.add('d-none');
                    document.getElementById('tipo-fletes-container').classList.add('d-none');
                    document.getElementById('detalle-flete-container').classList.add('d-none');
                    document.getElementById('inicio-flete-container').classList.add('d-none');
                    document.getElementById('fin-flete-container').classList.add('d-none');
                    document.getElementById('viaticos-container').classList.add('d-none');
                    document.getElementById('movilizacion-destino-container').classList.add('d-none');
                    document.getElementById('movilizacion-asignado-container').classList.add('d-none');
                    document.getElementById('movilizacion-detalle-container').classList.add('d-none');
                    //
                    document.getElementById('detalle-container').classList.remove('d-none');

                    if (['encomiendas', 'traslado_personal', 'traslado_mercaderia', 'traslado_valores',
                            'notificacion', 'volanteo'
                        ].includes(movilizacion_tipo)) {
                        document.getElementById('movilizacion-destino-container').classList.remove('d-none');
                        document.getElementById('movilizacion-asignado-container').classList.remove('d-none');
                        //document.getElementById('movilizacion-detalle-container').classList.remove('d-none');
                    } else if (movilizacion_tipo === 'viaticos') {
                        document.getElementById('viaticos-container').classList.remove('d-none');

                        document.getElementById('viaticos').addEventListener('change', function() {
                            var viaticos = this.value;

                             document.getElementById('combustible-container').classList.add('d-none');
                            document.getElementById('destino-container').classList.add('d-none');
                            document.getElementById('asignado-container').classList.add('d-none');
                            document.getElementById('tipo-pasajes-container').classList.add('d-none');
                            document.getElementById('subtipo-pasajes-container').classList.add('d-none');
                            document.getElementById('tipo-fletes-container').classList.add('d-none');
                            document.getElementById('detalle-flete-container').classList.add('d-none');
                            //fletes
                            document.getElementById('inicio-flete-container').classList.add('d-none');
                            document.getElementById('fin-flete-container').classList.add('d-none');
                            //
                            document.getElementById('detalle-container').classList.remove('d-none');

                            if (viaticos === 'peaje') {
                            //    document.getElementById('combustible-container').classList.remove('d-none');
                                document.getElementById('destino-container').classList.remove('d-none');
                                document.getElementById('asignado-container').classList.remove('d-none');
                            } else if (viaticos === 'pasajes') {
                                document.getElementById('tipo-pasajes-container').classList.remove('d-none');
                                document.getElementById('destino-container').classList.remove('d-none');
                                document.getElementById('asignado-container').classList.remove('d-none');
                                document.getElementById('tipo_pasajes').addEventListener('change',
                                    function() {
                                        if (this.value === 'nacionales') {
                                            document.getElementById('subtipo-pasajes-container')
                                                .classList.remove('d-none');
                                        } else {
                                            document.getElementById('subtipo-pasajes-container')
                                                .classList.add('d-none');
                                        }
                                    });
                            } else if (viaticos == 'fletes') {
                                document.getElementById('tipo-fletes-container').classList.remove('d-none');
                                document.getElementById('detalle-container').classList.add('d-none');
                                document.getElementById('tipo_fletes').addEventListener('change',
                                    function() {
                                        if (this.value) {
                                            document.getElementById('detalle-flete-container').classList.remove('d-none');
                                            document.getElementById('inicio-flete-container').classList.remove('d-none');
                                            document.getElementById('fin-flete-container').classList.remove('d-none');
                                        } else {
                                            document.getElementById('detalle-flete-container').classList.add('d-none');
                                            document.getElementById('inicio-flete-container').classList.add('d-none');
                                            document.getElementById('fin-flete-container').classList.add('d-none');

                                        }
                                    });
                            }
                        });
                    }
                });
            }
        });
    </script>
    <script>
        // Mostrar el nombre del archivo seleccionado
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("file").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        });
    </script>

    <script>
        document.getElementById('tipo_documento').addEventListener('change', function() {
            var selectedValue = this.value;
            var documentLabel = document.querySelector('label[for="numero_documento"]');
            var documentLabelFile = document.querySelector('label[for="file"]');

            if (selectedValue === 'numero_factura') {
                documentLabel.textContent = 'Número de Factura';
                documentLabelFile.textContent = 'Cargar comprobante de Factura';

            } else if (selectedValue === 'numero_recibo') {
                documentLabel.textContent = 'Número de Recibo';
                documentLabelFile.textContent = 'Cargar comprobante de Recibo';

            } else if (selectedValue === 'numero_nota_venta') {
                documentLabel.textContent = 'Número de nota de venta';
                documentLabelFile.textContent = 'Cargar comprobante de Nota de venta';
            } else {
                documentLabel.textContent = 'Número de Documento'; // Default label
                documentLabelFile.textContent = 'Cargar comprobante';
            }
        });
    </script>
    <script>
        $('#tipo_documento').change(function() {
            var valor = parseFloat($('#valor').val()) || 0;
            if ($(this).val() === 'numero_factura') {
                var subtotal = valor * 0.15;
                $('#subtotal').val(subtotal.toFixed(2));
            } else {
                $('#subtotal').val('0');
            }
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
