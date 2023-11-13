<div class="modal fade modaldesacargar" id="desacargarmodal" tabindex="-1" aria-labelledby="desacargarmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="desacargarmodalLabel">Descargar Marcaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('marcaciones.downloads') }}" method="POST">
                @csrf
                <input type="hidden" name="id_mrcd" id="id_mrcd" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <div class="col-md-6 col-sm-12">
                                <label for="ubicacion_mrcd" class="col-form-label">Fecha inicio:</label>
                                <input type="date" class="form-control" name="fec_iniciio" id="min" value="<?php echo date('Y-m-d'); ?>" min="2023-01-01" max="2030-12-31" required>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="ubicacion_mrcd" class="col-form-label">Fecha fin:</label>
                                <input type="date" class="form-control" name="fec_final" id="max" value="<?php echo date('Y-m-d'); ?>" min="2023-01-01" max="2030-12-31" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarCajas()"><i class="fas fa-times-circle"></i> Cancelar</button>
                    <button type="submit" class="btn btn-info" id="guardarMarcador"><i class="fas fa-file-download"></i> Descargar</button>
                    <p class="text-danger" id="cargando" hidden>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Espere un momento porfavor...
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
