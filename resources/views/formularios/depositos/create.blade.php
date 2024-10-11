@extends('adminlte::page')

@section('title', 'Depósito')

@section('css')
    <style>
        .custom-file-input~.custom-file-label::after {
            content: "Buscar";
        }
    </style>
@stop
@section('content_header')
    <h1 class="m-0 text-dark text-center">Depósitos</h1>
@stop

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
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
                            {!! Form::open(['route' => 'depositos.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            @csrf

                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Agencia:</label>

                                        {!! Form::select('agencia_id', $agencias, null, ['class' => 'form-control']) !!}

                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Origen:</label>

                                        @php
                                            $array = [];
                                        @endphp
                                        @role('COBRADOR DEPOSITOS')
                                            @php
                                                $array = ['COBRO' => 'COBRO'];
                                            @endphp
                                        @endrole
                                        @role('CAJERO DEPOSITOS')
                                            @php
                                                $array = ['VENTA' => 'VENTA'];
                                            @endphp
                                        @endrole
                                        @isset(auth()->user()->profile->departamento)
                                            @if (auth()->user()->profile->departamento == "COMERCIAL")
                                                @php
                                                $array =['COBRO' => 'COBRO', 'VENTA' => 'VENTA'];
                                                @endphp
                                            @endif
                                        @endisset
                                        @role('TESORERIA')
                                            @php
                                            $array =['COBRO' => 'COBRO', 'VENTA' => 'VENTA'];
                                            @endphp
                                        @endrole
                                        {!! Form::select('origen', $array, null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'SELECCIONE',
                                            'required',
                                            'id' => 'origen',
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Fecha del comprobante:</label>
                                        {!! Form::date('fecha', now()->format('Y-m-d'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Apellidos y Nombres del cliente:</label>
                                        {!! Form::text('apellidos', null, ['class' => 'form-control', 'id' => 'apellidos', 'required']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero de Deposito:</label>
                                        {!! Form::text('num_documento', null, ['class' => 'form-control', 'id' => 'num_documento', 'required']) !!}
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
                                            null,
                                            ['class' => 'form-control', 'placeholder' => 'Seleccione', 'required'],
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <!--
                                                            <div class="form-group">
                                                                <label for="name">Numero del factura:</label>
                                                                {!! Form::text('num_credito', null, ['class' => 'form-control']) !!}
                                                            </div>
                                                        -->
                                    <div id="facturasContainer">
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-sm btn-success" id="addButton">Añadir Numero del
                                        factura</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="file">Cargar comprobante</label>
                                        <div class="custom-file">
                                            <input type="file" name="comprobante" class="custom-file-input"
                                                id="file" required>
                                            <label class="custom-file-label" for="file">Elegir</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    <a href="{{ route('depositos.index') }}" class="btn btn-secondary">Atras</a>
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
            let index = 0;

            $('#addButton').click(function() {
                $('#facturasContainer').append(`
                <div class="factura-group">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="text" name="facturas[${index}][factura]" class="form-control " required placeholder="Factura">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="facturas[${index}][valor]" class="form-control dineroCamp valor" required placeholder="Valor">
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
