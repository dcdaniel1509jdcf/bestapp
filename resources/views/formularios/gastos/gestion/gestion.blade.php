@extends('adminlte::page')

@section('title', 'Gestion Gastos')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Gestión</h1>
@stop
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-xs-10">
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
                            {!! Form::open(['route' => 'saldos.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            @csrf
                            <div class="mb-3">
                                <label for="tipo_saldo" class="form-label">Tipo de Saldo</label>
                                <select id="tipo_saldo" name="tipo_saldo" class="form-control" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="saldo_a_favor">Saldo a Favor</option>
                                    <option value="saldo_a_devolver">Saldo a Devolver</option>
                                </select>
                            </div>

                            <div id="campos_saldo_a_favor">
                                <div class="mb-3">
                                    <label for="monto_asignado" class="form-label">Monto Asignado</label>
                                    <input type="text" id="monto_asignado" name="monto_asignado" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_comprobante" class="form-label">Fecha Comprobante</label>
                                    <input type="date" id="fecha_comprobante" name="fecha_comprobante"
                                        class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="numero_recibo_factura" class="form-label">Número de Recibo/Factura</label>
                                    <select id="numero_recibo_factura" name="numero_recibo_factura" class="form-control"
                                        required>
                                        <option value="">Seleccione</option>
                                        <option value="numero_recibo">Número de Recibo</option>
                                        <option value="numero_factura">Número de Factura</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="file">Cargar comprobante</label>
                                        <div class="custom-file">
                                            <input type="file" name="comprobante" class="custom-file-input"
                                                id="file" required>
                                            <label class="custom-file-label" for="file">Elegir</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="numero_documento" class="form-label">Número de Documento</label>
                                    <input type="text" id="numero_documento" name="numero_factura"
                                        class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="subtotal" class="form-label">IVA</label>
                                    <input type="text" id="subtotal" name="subtotal" class="form-control" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">Enviar</button>
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
            // Función para mostrar/ocultar campos según la selección del select
            /*
                $('#tipo_saldo').change(function() {
                    var tipo = $(this).val();
                    if (tipo === 'saldo_a_favor') {
                        $('#campos_saldo_a_favor').show();
                    } else {
                        $('#campos_saldo_a_favor').show();
                    }
                });
            */
            // Función para calcular el subtotal
            $('#numero_recibo_factura').change(function() {
                var valor = parseFloat($('#valor').val()) || 0;
                if ($(this).val() === 'numero_factura') {
                    var subtotal = valor * 0.15;
                    $('#subtotal').val(subtotal.toFixed(2));
                } else {
                    $('#subtotal').val('');
                }
            });
            $('#valor').change(function() {
                var valor = parseFloat($('#valor').val()) || 0;
                if ($('#numero_recibo_factura').val() === 'numero_factura') {
                    var subtotal = valor * 0.15;
                    $('#subtotal').val(subtotal.toFixed(2));
                } else {
                    $('#subtotal').val('');
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
        document.getElementById('numero_recibo_factura').addEventListener('change', function() {
            var selectedValue = this.value;
            var documentLabel = document.querySelector('label[for="numero_documento"]');
            var documentLabelFile = document.querySelector('label[for="file"]');

            if (selectedValue === 'numero_factura') {
                documentLabel.textContent = 'Número de Factura';
                documentLabelFile.textContent = 'Cargar comprobante de Factura';

            } else if (selectedValue === 'numero_recibo') {
                documentLabel.textContent = 'Número de Recibo';
                documentLabelFile.textContent = 'Cargar comprobante de recibo';
            } else {
                documentLabel.textContent = 'Número de Documento'; // Default label
                documentLabelFile.textContent = 'Cargar comprobante';
            }
        });
    </script>
@stop
