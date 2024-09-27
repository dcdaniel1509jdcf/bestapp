@extends('adminlte::page')

@section('title', 'Gastos')

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
                            {!! Form::open(['route' => 'gastos.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            @csrf
                            <div class="row">

                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="agencia-container" class="mb-3">
                                        <label for="agencia" class="form-label">Agencia / Departamento</label>
                                        <input type="text" class="form-control" readonly name="agencia" value="{{ $agencia }}" id="agencia">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div id="valor-container" class="mb-3 ">
                                        <label for="valor" class="form-label">Valor</label>
                                        <input type="text" class="form-control" name="valor" id="valor" required>
                                    </div>
                                </div>
                            </div>

<!--
                            <div id="tipo-documento-container" class="mb-3 ">
                                <div class="row">
                                    <div class="col-xs-6 col-md-6 col-sm-6">
                                        <div id="fecha-container" class="mb-3">
                                            <label for="fecha" class="form-label">Fecha de Comprobante</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-md-6 col-sm-6">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                        <select class="form-control" id="tipo_documento" name="tipo_documento">
                                            <option value="">Seleccione tipo de documento</option>
                                            <option value="numero_recibo">Número de Recibo</option>
                                            <option value="numero_factura">Número de Factura</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 d-none" id="numero-documento-container">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="file">Cargar comprobante</label>
                                        <div class="custom-file">
                                            <input type="file" name="comprobante" class="custom-file-input"
                                                id="file" >
                                            <label class="custom-file-label" for="file">Elegir</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento</label>
                                        <input type="text" class="form-control" name="numero_documento"
                                            id="numero_documento" placeholder="000-000-000123">
                                    </div>
                                </div>
                            </div>
                        -->
                            <!-- Campo Agencia -->
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="mb-3">
                                        <label for="concepto" class="form-label">Concepto</label>
                                        <select class="form-control" id="concepto" name="concepto">
                                            <option value="">Seleccione un concepto</option>
                                            <option value="gastos_varios">Gastos Varios</option>
                                            <option value="suministros">Suministros</option>
                                            <option value="movilizacion">Movilización</option>
                                            <option value="mantenimiento">Mantenimiento</option>
                                            <option value="tramites_entidades">Trámites Entidades</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="tipo-tramite-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="tipo_tramite" class="form-label">Tipo de Trámite</label>
                                        <select class="form-control" id="tipo_tramite" name="tipo_tramite">
                                            <option value="">Seleccione tipo de trámite</option>
                                            <option value="municipios">Municipios</option>
                                            <option value="ant">ANT</option>
                                            <option value="sri">SRI</option>
                                            <option value="fiscalia">Fiscalía</option>
                                            <option value="notaria">Notaría</option>
                                            <option value="ministerio_de_trabajo">Ministerio del Trabajo</option>
                                            <option value="procuracion_judicial">Procuración judicial</option>
                                            <option value="registro_mercantil" >Registro Mercantil</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="nombre-tramite-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="nombre_tramite" class="form-label">Nombre del Trámite</label>
                                        <input type="text" class="form-control" id="nombre_tramite"
                                            name="nombre_tramite">
                                    </div>
                                </div>
                                <div id="nombre-entidad-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="nombre_entidad" class="form-label">Nombre de la Entidad</label>
                                        <input type="text" class="form-control" id="nombre_entidad"
                                            name="nombre_entidad">
                                    </div>
                                </div>
                                <div id="movilizacion-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="movilizacion_tipo" class="form-label">Tipo de Movilización</label>
                                        <select class="form-control" id="movilizacion_tipo" name="movilizacion_tipo">
                                            <option value="">Seleccione tipo de movilización</option>
                                            <option value="encomiendas">Encomiendas</option>
                                            <option value="traslado_personal">Traslado del Personal</option>
                                            <option value="traslado_mercaderia">Traslado de Mercadería</option>
                                            <option value="traslado_valores">Traslado de Valores</option>
                                            <option value="notificacion">Notificación</option>
                                            <option value="volanteo">Volanteo</option>
                                            <option value="viaticos">Viáticos</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="viaticos-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="viaticos" class="form-label">Viáticos</label>
                                        <select class="form-control" id="viaticos" name="viaticos">
                                            <option value="">Seleccione tipo de viático</option>
                                            <option value="peaje">Peaje</option>
                                            <option value="pasajes">Pasajes</option>
                                            <option value="fletes">Fletes</option>
                                            <option value="movilizacion">Movilización</option>
                                            <option value="hospedaje">Hospedaje</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="combustible-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div  class="mb-3">
                                        <label for="combustible" class="form-label">Combustible</label>
                                        <input type="text" class="form-control" id="combustible" name="combustible">
                                    </div>
                                </div>
                                <div id="destino-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="destino" class="form-label">Destino</label>
                                        <input type="text" class="form-control" id="destino" name="destino">
                                    </div>
                                </div>
                                <div id="asignado-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="asignado" class="form-label">Asignado a</label>
                                        <input type="text" class="form-control" id="asignado" name="asignado" placeholder="Nombre de la persona a cargo">
                                    </div>
                                </div>
                                <div id="tipo-pasajes-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="tipo_pasajes" class="form-label">Tipo de Pasajes</label>
                                        <select class="form-control" id="tipo_pasajes" name="tipo_pasajes">
                                            <option value="">Seleccione tipo de pasajes</option>
                                            <option value="nacionales">Nacionales</option>
                                            <option value="interprovincial">Interprovincial</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="subtipo-pasajes-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="subtipo_pasajes" class="form-label">Subtipo de Pasajes</label>
                                        <select class="form-control" id="subtipo_pasajes" name="subtipo_pasajes">
                                            <option value="">Seleccione subtipo de pasajes</option>
                                            <option value="taxis">Taxis</option>
                                            <option value="buses">Buses</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="tipo-fletes-container" class="col-xs-12 col-md-4 col-sm-4  d-none">
                                    <div class="mb-3">
                                        <label for="tipo_fletes" class="form-label">Tipo de Fletes</label>
                                        <select class="form-control" id="tipo_fletes" name="tipo_fletes">
                                            <option value="">Seleccione tipo de fletes</option>
                                            <option value="camionetas">Camionetas</option>
                                            <option value="autos">Autos</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="inicio-flete-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="inicio_destino" class="form-label">Inicio de destino</label>
                                        <input type="text" class="form-control" id="inicio_destino"
                                            name="inicio_destino">
                                    </div>
                                </div>
                                <div id="fin-flete-container" class="col-xs-12 col-md-4 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="fin_destino" class="form-label">Fin de Destino</label>
                                        <input type="text" class="form-control" id="fin_destino"
                                            name="fin_destino">
                                    </div>
                                </div>
                                <div id="detalle-flete-container" class="col-xs-12 col-md-12 col-sm-12  d-none">
                                    <div class="mb-3">
                                        <label for="detalle_flete" class="form-label">Detalle del Flete</label>
                                        <textarea class="form-control" id="detalle_flete" name="detalle_flete" rows="3"></textarea>
                                    </div>
                                </div>
                                <div id="movilizacion-destino-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="movilizacion_destino" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="movilizacion_destino"
                                            name="movilizacion_destino">
                                    </div>
                                </div>
                                <div id="movilizacion-asignado-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3">
                                        <label for="movilizacion_asignado" class="form-label">Asignado a</label>
                                        <input type="text" class="form-control" id="movilizacion_asignado" placeholder="Nombre de la persona a cargo"
                                            name="movilizacion_asignado">
                                    </div>
                                </div>
                                <div id="movilizacion-detalle-container" class="col-xs-6 col-md-6 col-sm-6  d-none">
                                    <div class="mb-3 ">
                                        <label for="movilizacion_detalle" class="form-label">Detalle</label>
                                        <textarea class="form-control" id="movilizacion_detalle" name="movilizacion_detalle" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="detalle-container" >
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="mb-3 ">
                                        <label for="detalle" class="form-label">Detalle de solicitud</label>
                                        <input type="text" class="form-control" name="detalle" id="detalle" >
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
        /*
        document.getElementById('tipo_documento').addEventListener('change', function() {
            if (this.value) {
                document.getElementById('numero-documento-container').classList.remove('d-none');
            } else {
                document.getElementById('numero-documento-container').classList.add('d-none');
            }
        });*/
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

            //nuevos campos inicio fin fletes

            document.getElementById('inicio-flete-container').classList.add('d-none');
            document.getElementById('fin-flete-container').classList.add('d-none');
            //
            document.getElementById('movilizacion-container').classList.add('d-none');
            document.getElementById('movilizacion-destino-container').classList.add('d-none');
            document.getElementById('movilizacion-asignado-container').classList.add('d-none');
            document.getElementById('movilizacion-detalle-container').classList.add('d-none');
            //document.getElementById('detalle-container').classList.add('d-none');
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
                    //
                    document.getElementById('inicio-flete-container').classList.add('d-none');
                    document.getElementById('fin-flete-container').classList.add('d-none');
                    //
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
                            //
                            document.getElementById('inicio-flete-container').classList.add('d-none');
                            document.getElementById('fin-flete-container').classList.add('d-none');
                            //
                            document.getElementById('detalle-container').classList.remove('d-none');

                            if (viaticos === 'peaje') {
                                //document.getElementById('combustible-container').classList.remove('d-none');
                                document.getElementById('destino-container').classList.remove(
                                    'd-none');
                                document.getElementById('asignado-container').classList.remove(
                                    'd-none');
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
                            } else if (viaticos === 'fletes') {
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

@stop
