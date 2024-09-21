@extends('adminlte::page')

@section('title', 'Gestion Gastos')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Gestión</h1>
@stop
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-xs-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>Editar Saldo</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>¡Revise los campos!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {!! Form::model($saldo, [
                                'route' => ['saldos.update', $saldo->id],
                                'method' => 'PUT',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                            @csrf

                            <div class="mb-3">
                                <label for="tipo_saldo" class="form-label">Tipo de Saldo</label>
                                <select id="tipo_saldo" name="tipo_saldo" class="form-control" required>
                                    <option value="saldo_a_favor"
                                        {{ $saldo->tipo_saldo == 'saldo_a_favor' ? 'selected' : '' }}>Saldo a Favor</option>
                                    <option value="saldo_a_devolver"
                                        {{ $saldo->tipo_saldo == 'saldo_a_devolver' ? 'selected' : '' }}>Saldo a Devolver
                                    </option>
                                </select>
                            </div>

                            <div id="campos_saldo_a_favor"
                                style="{{ $saldo->tipo_saldo == 'saldo_a_favor' ? 'display:block;' : 'display:none;' }}">
                                <div class="mb-3">
                                    <label for="monto_asignado" class="form-label">Monto Asignado</label>
                                    <input type="text" id="monto_asignado" name="monto_asignado" class="form-control"
                                        value="{{ old('monto_asignado', $saldo->monto_asignado) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_comprobante" class="form-label">Fecha Comprobante</label>
                                    <input type="date" id="fecha_comprobante" name="fecha_comprobante"
                                        class="form-control"
                                        value="{{ old('fecha_comprobante', $saldo->fecha_comprobante) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="numero_recibo_factura" class="form-label">Número de Recibo/Factura</label>
                                    <select id="numero_recibo_factura" name="numero_recibo_factura" class="form-control"
                                        required>
                                        <option value="numero_recibo"
                                            {{ $saldo->numero_recibo_factura == 'numero_recibo' ? 'selected' : '' }}>Número
                                            de Recibo</option>
                                        <option value="numero_factura"
                                            {{ $saldo->numero_recibo_factura == 'numero_factura' ? 'selected' : '' }}>Número
                                            de Factura</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="file">Cargar Comprobante</label>
                                    <div class="custom-file">
                                        <input type="file" name="comprobante" class="custom-file-input" id="file">
                                        <label class="custom-file-label" for="file">Elegir</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control"
                                        value="{{ old('valor', $saldo->valor) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="numero_factura" class="form-label">Número de Factura</label>
                                    <input type="text" id="numero_factura" name="numero_factura" class="form-control"
                                        value="{{ old('numero_factura', $saldo->numero_factura) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="subtotal" class="form-label">IVA</label>
                                    <input type="text" id="subtotal" name="subtotal" class="form-control"
                                        value="{{ old('subtotal', $saldo->subtotal) }}" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
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
            $('#tipo_saldo').change(function() {
                var tipo = $(this).val();
                if (tipo === 'saldo_a_favor') {
                    $('#campos_saldo_a_favor').show();
                } else {
                    $('#campos_saldo_a_favor').show();
                }
            });

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
@stop
