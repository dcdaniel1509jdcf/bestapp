@extends('adminlte::page')

@section('title', 'Depósito')

@section('css')
<style>
    .custom-file-input ~ .custom-file-label::after {
        content: "Buscar";
    }
</style>
@stop
@section('content_header')
    <h1 class="m-0 text-dark text-center" >Depósitos</h1>
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
                                        {!! Form::label('agencia', auth()->user()->agencia->nombre, ['class' => 'form-control']) !!}
                                        {!! Form::hidden('agencia_id', auth()->user()->agencia_id, [null]) !!}

                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Origen:</label>

                                        {!! Form::select('origen', ['COBRO'=>'COBRO','VENTA'=>'VENTA'], null, ['class' => 'form-control','placeholder'=>'SELECCIONE']) !!}

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
                                        {!! Form::text('apellidos', null, ['class' => 'form-control','id'=>'apellidos']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero de Deposito:</label>
                                        {!! Form::text('num_documento', null, ['class' => 'form-control','id'=>'num_documento']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Valor del deposito o transferencia:</label>
                                        {!! Form::text('val_deposito', null, ['class' => 'form-control','id'=>'val_deposito','placeholder'=>'5432.10']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Banco:</label>

                                        {!! Form::select('banco', ['PICHINCHA BEST PC'=>'PICHINCHA BEST PC',
                                            'PICHINCHA HARD WEST'=>'PICHINCHA HARD WEST',
                                            'GUAYAQUIL BEST PC'=>'GUAYAQUIL BEST PC',
                                            'GUAYAQUIL HW'=>'GUAYAQUIL HW',
                                            'ALIANZA BEST PC'=>'ALIANZA BEST PC',
                                            'ALIANZA HARD WEST'=>'ALIANZA HARD WEST'], null, ['class' => 'form-control','placeholder'=>'Seleccione']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero del factura:</label>
                                        {!! Form::text('num_credito', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="file">Cargar comprobante</label>
                                        <div class="custom-file">
                                            <input type="file" name="comprobante" class="custom-file-input" id="file" required>
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
    </script>
@stop
