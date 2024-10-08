@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Depósito N# {{ $deposito->id }}</h1>
@stop
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-10">
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

                            {!! Form::model($deposito, [
                                'route' => ['depositos.update.adm', $deposito->id],
                                'method' => 'PATCH',
                                'enctype' => 'multipart/form-data',
                            ]) !!}

                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="agencia_id">Agencia:</label>
                                        {!! Form::select('agencia_id', $agencias, $deposito->agencia_id, ['class' => 'form-control']) !!}

                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="origen">Origen:</label>
                                        @php
                                            $array = ['VENTA' => 'VENTA', 'COBRO' => 'COBRO'];
                                        @endphp

                                        {!! Form::select('origen', $array, $deposito->origen, [
                                            'class' => 'form-control',
                                            'placeholder' => 'SELECCIONE',
                                            'id' => 'origen',
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha del comprobante:</label>
                                        {!! Form::date('fecha', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Apellidos y Nombres del cliente:</label>
                                        {!! Form::text('apellidos', null, ['class' => 'form-control', 'id' => 'apellidos']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero de Deposito:</label>
                                        {!! Form::text('num_documento', null, ['class' => 'form-control', 'id' => 'num_documento']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Valor del deposito o transferencia:</label>
                                        {!! Form::text('val_deposito', null, [
                                            'class' => 'form-control',
                                            'id' => 'val_deposito',
                                            'placeholder' => '5432.10',
                                            'required',
                                            'readonly',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Banco:</label>
                                        {!! Form::select(
                                            'banco',
                                            [
                                                'PICHINCHA BEST PC' => 'PICHINCHA BEST PC',
                                                'PICHINCHA HARD WEST' => 'PICHINCHA HARD WEST',
                                                'GUAYAQUIL BEST PC' => 'GUAYAQUIL BEST PC',
                                                'GUAYAQUIL HW' => 'GUAYAQUIL HW',
                                                'ALIANZA BEST PC' => 'ALIANZA BEST PC',
                                                'ALIANZA HARD WEST' => 'ALIANZA HARD WEST',
                                            ],
                                            $deposito->banco,
                                            ['class' => 'form-control', 'placeholder' => 'Seleccione'],
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <div id="facturasContainer">
                                            @if ($deposito->num_credito)
                                                @foreach (unserialize($deposito->num_credito) as $index => $factura)
                                                    <div class="factura-group">
                                                        <div class="row mb-2">
                                                            <div class="col-md-6">
                                                                <input type="text"
                                                                    name="facturas[{{ $index }}][factura]"
                                                                    value="{{ $factura['factura'] }}" class="form-control"
                                                                    required placeholder="Factura">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text"
                                                                    name="facturas[{{ $index }}][valor]"
                                                                    value="{{ $factura['valor'] }}"
                                                                    class="form-control dineroCamp valor" required
                                                                    placeholder="Valor">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger removeButton">X</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <br>
                                        <button type="button" class="btn btn-sm btn-success" id="addButton">Añadir Numero
                                            del
                                            factura</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="comprobante">Cargar Comprobante</label>
                                        <div class="custom-file">
                                            {!! Form::file('comprobante', ['class' => 'custom-file-input', 'id' => 'file']) !!}
                                            {!! Form::label('file', 'Elegir archivo', ['class' => 'custom-file-label']) !!}
                                        </div>
                                        @if ($deposito->comprobante)
                                            <p>Archivo actual: <button type="button" class="btn btn-sm btn-link"
                                                    data-toggle="modal" data-target="#staticBackdrop">
                                                    Ver Documento
                                                </button>
                                                <a href="{{ Storage::url($deposito->comprobante) }}"
                                                    class="btn btn-sm btn-link" target="_blank">abrir</a>
                                            </p>
                                            @include('formularios.depositos.partial.modal')
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="tesoreria">Tesoreria:</label>

                                        {!! Form::select('tesoreria', ['CONFIRMADO' => 'CONFIRMADO', 'NEGADO' => 'NEGADO'], $deposito->tesoreria, [
                                            'class' => 'form-control',
                                            'placeholder' => 'EN PROCESO',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="baja">Dado de baja:</label>
                                        {!! Form::select('baja', ['REMOVER'=>'REMOVER DADO DE BAJA','DADO DE BAJA' => 'DADO DE BAJA'], $deposito->baja, [
                                            'class' => 'form-control',
                                            'placeholder' => 'SELECCIONE',
                                            'required',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label for="novedad">Novedades:</label>
                                        {!! Form::text('novedad', $deposito->novedad, ['class' => 'form-control mayuscula']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="cajas">Cajas:</label>
                                        {!! Form::text('cajas', $deposito->cajas, ['class' => 'form-control mayuscula']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="doc_banco">Numero documento en banco:</label>
                                        {!! Form::text('doc_banco', $deposito->doc_banco, ['class' => 'form-control mayuscula']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    <a href="{{ route('depositos.search') }}" class="btn btn-secondary">Atras</a>
                                </div>
                            </div>
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
        $(document).ready(function() {
            let index = {{ isset($deposito->num_credito) ? count(unserialize($deposito->num_credito)) : 0 }};

            $('#addButton').click(function() {
                $('#facturasContainer').append(`
                <div class="factura-group">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="text" name="facturas[${index}][factura]" class="form-control" required placeholder="Factura">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="facturas[${index}][valor]" class="form-control dineroCamp valor"  required placeholder="Valor">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-danger removeButton">X</button>
                        </div>
                    </div>
                </div>
            `);
                index++;
                updateSum();
            });

            $(document).on('click', '.removeButton', function() {
                $(this).closest('.factura-group').remove();
                updateSum();
            });
            $(document).on('input', '.valor', function() {
                updateSum();
            });

            function updateSum() {
                let sum = 0;
                $('.valor').each(function() {
                    let val = parseFloat($(this).val());
                    if (!isNaN(val)) {
                        sum += val;
                    }
                });
                $('#val_deposito').val(sum.toFixed(2));
            }

            $('#origen').change(function() {
                if ($(this).val() === 'VENTA') {
                    $('#val_deposito').prop('readonly', false);
                } else {
                    $('#val_deposito').prop('readonly', true).val('');
                }
            });
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
        $('#apellidos').on('input', function() {
            // Remueve todos los caracteres que no sean letras o espacios
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
        //validaciones formulario
        $('input, textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        $('#num_documento').on('input', function() {
            // Remueve todos los caracteres que no sean números o caracteres especiales
            this.value = this.value.replace(/[^0-9!@#$%^&*(),.?":{}|<>]/g, '');
        });
        $('#val_deposito').on('input', function() {
            // Remueve todos los caracteres que no sean números o caracteres especiales
            this.value = this.value.replace(/[^0-9!.]/g, '');
        });
        $('.dineroCamp').on('input', function() {
            // Remueve todos los caracteres que no sean números o caracteres especiales
            this.value = this.value.replace(/[^0-9!.]/g, '');
        });
    </script>

@stop
