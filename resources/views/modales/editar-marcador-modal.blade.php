<div class="modal fade modaleditar" id="editarMarcador" tabindex="-1" aria-labelledby="editarMarcadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMarcadorLabel">Editar Marcador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('marcadores.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id_mrcd" id="id_mrcd" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ubicacion_mrcd" class="col-form-label">Ubicación:</label>
                        <input type="text" class="form-control" name="ubicacion_mrcd" id="ubicacion_mrcd" placeholder="Dirección física del dispositivo" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="ip_mrcd" class="col-form-label">Dirección IP:</label>
                        <input type="text" class="form-control" name="ip_mrcd" id="ip_mrcd" placeholder="Dirección ip del dispositivo" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarCajas()"><i class="fas fa-times-circle"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="guardarMarcador"><i class="fas fa-save"></i> Guardar Marcador</button>
                    <p class="text-danger" id="cargando" hidden>
                        <span class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        Espere un momento porfavor...
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
