<div class="modal fade" id="delete" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLabel" style="color:#fff; font-size:28px">Borrar El Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:#fff;">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('desactivar.registro')}}">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <br>
                    <div class="form-group">
                        <label style="font-size: 20px;">Documento Sustentatorio:</label>
                        <input type="text" class="form-control" id="comentario" name="comentario" required>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-danger mr-4" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info">Sí, Borrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
