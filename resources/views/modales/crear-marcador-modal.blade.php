<div class="modal fade" id="nuevoMarcador" tabindex="-1" aria-labelledby="nuevoMarcadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoMarcadorLabel">Nuevo Marcador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('marcadores.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ubicacion_mrcd" class="col-form-label">Ubicación:</label>
                        <input type="text" class="form-control" name="ubicacion_mrcd" id="ubicacion_mrcd" placeholder="Dirección física del dispositivo" required>
                    </div>
                    <div class="form-group">
                        <label for="ip_mrcd" class="col-form-label">Dirección IP:</label>
                        <input type="text" class="form-control" name="ip_mrcd" id="ip_mrcd" placeholder="Dirección ip del dispositivo" required>
                    </div>
                    <div class="form-group">
                        <label for="ip_mrcd" class="col-form-label">Asignar A:</label>
                        <select name="responsable" id="responsable" class="form-control" required>
                            <option value="0" selected disabled>Asignar Responsable</option>
                            @foreach ($marcadores[1] as $mu)
                                <option value="{{ $mu->id }}">{{ $mu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarCajas()"><i class="fas fa-times-circle"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="guardarMarcador"><i class="fas fa-save"></i> Crear Marcador</button>
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
