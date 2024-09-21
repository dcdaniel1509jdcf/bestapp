@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1 class="m-0 text-dark">Gastos</h1>
@stop
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10 col-xs-10">
                    <div class="card">
                        <div class="card-body">
                            @if ($saldos->isEmpty())
                                <div class="alert alert-warning">No hay registros de saldos.</div>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo de Saldo</th>
                                            <th>Monto Asignado</th>
                                            <th>Fecha Comprobante</th>
                                            <th>Número de Recibo/Factura</th>
                                            <th>Valor</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($saldos as $saldo)
                                            <tr>
                                                <td>{{ $saldo->id }}</td>
                                                <td>{{ $saldo->tipo_saldo }}</td>
                                                <td>{{ $saldo->monto_asignado }}</td>
                                                <td>{{ $saldo->fecha_comprobante }}</td>
                                                <td>{{ $saldo->numero_recibo_factura }}</td>
                                                <td>{{ $saldo->valor }}</td>
                                                <td>
                                                    <a href="{{ route('saldos.edit', $saldo->id) }}"
                                                        class="btn btn-warning">Editar</a>
                                                    <form action="{{ route('saldos.destroy', $saldo->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este saldo?');">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $("#tableIni").DataTable();
            $('input, textarea').on('input', function() {
                this.value = this.value.toUpperCase();
            });
            $(".form-eliminar").submit(function(e) {
                e.preventDefault(); // Previniendo el comportamiento predeterminado del botón
                Swal.fire({
                    title: "¿Está seguro?",
                    text: "Se va a eliminar un registro!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Sí, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, envía el formulario
                        this.submit();
                    }
                });
            });
        });
    </script>

@endsection
