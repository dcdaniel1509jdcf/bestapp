<div class="modal fade" id="staticBackdrop"  data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Documento Cargado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $filePath = Storage::url($deposito->comprobante);
                    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                @endphp

                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                    <img src="{{ $filePath }}" alt="Comprobante" style="max-width: 100%; height: auto;">
                @elseif($fileExtension === 'pdf')
                    <iframe src="{{ $filePath }}" style="width: 100%; height: 600px;" frameborder="0"></iframe>
                @else
                    <p>Tipo de archivo no soportado para previsualización.</p>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
