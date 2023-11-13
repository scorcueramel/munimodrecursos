@extends('layouts.app')
@section('title')
Editar Registro |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Registro</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- TOASTR -->
                        @if(session()->has('error'))
                        {{ session()->get('error') }}
                        @elseif (session()->has('success'))
                        {{ session()->get('success') }}
                        @endif
                        <form action="{{route('update',$tp->id)}}" method="GET">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-2 mb-6">
                                    <label for="codigo">Código</label>
                                    <input type="text" class="form-control" id="codigo" value="{{ $tp->codigo_persona }}" name="codigo" required readonly>
                                </div>
                                <div class="col-md-2 mb-6">
                                    <label for="documento_persona">Documento</label>
                                    <input type="text" class="form-control" id="documento_persona" value="{{ $tp->documento_persona }}" name="documento_persona" required readonly>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label for="nombres">Nombres y Apellidos</label>
                                    <input type="text" class="form-control" id="nombres" value="{{ $tp->nombre_persona }}" name="nombres" required readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="reglaboral">Regimen Laboral</label>
                                    <input type="text" class="form-control" id="reglaboral" value="{{ $tp->reglab_persona }}" name="reglaboral" required readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-6">
                                    <label for="uniorg">Unidad Orgánica</label>
                                    <input type="text" class="form-control" id="uniorg" value="{{ $tp->uniorg_persona }}" name="uniorg" required readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="ingreso">Ingreso Labores</label>
                                    <input type="text" class="form-control" id="ingreso" value="{{ $tp->fecha_inicio_persona }}" name="ingreso" required readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="estado">Estado</label>
                                    <input type="text" class="form-control" id="estado" value="{{ $tp->estado_persona }}" name="estado" required readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="tpermiso">Tipo de Permiso</label>
                                    <select class="form-control" name="tpermiso" id="tpermiso" readonly>
                                        <option selected value="{{ $tp->tipo_permiso_id }}">{{ $tp->descripcion}}</option>
                                    </select>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label for="concepto">Concepto</label>
                                    <select class="form-control" id="concepto" name="concepto">
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecinicio">Inicio Permiso</label>
                                    <input type="date" class="form-control" name="fecinicio" id="fecinicio" value="{{ $tp->fecha_inicio }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecfin">Fin Permiso</label>
                                    <input type="date" class="form-control" name="fecfin" id="fecfin" value="{{ $tp->fecha_fin }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label for="diaspersonal">Días</label>
                                    <input type="text" class="form-control" name="diaspersonal" id="diaspersonal" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="anioperiodo">Año Periodo</label>
                                    <input type="text" class="form-control" name="anioperiodo" id="anioperiodo" value="{{ $tp->anio_periodo }}">
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label for="observaciones">Observaciones</label>
                                    <input type="text" class="form-control" name="observaciones" id="observaciones" value="{{ $tp->comentario }}" maxlength="60">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="documento_ref">Documento Sustentario</label>
                                    <input type="text" class="form-control" name="documento_ref" id="documento_ref" value="{{ $tp->documento }}" maxlength="40">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <a href="{{route('general')}}" class="btn btn-danger" style="padding-bottom: -40px;"><i class="fas fa-undo-alt"></i> Volver</a>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button class="btn btn-primary mt-2" type="submit"><i class="fas fa-save"></i> Editar Registro
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(() => {
        //Calculo de días automatico
        var f1, f2, r1, r2, t, tf, resp;
        const anio = 1000 * 60 * 60 * 24;
        $('#concepto').focus();
        f1 = new Date($('#fecinicio').val());
        r1 = f1.getTime();
        f2 = new Date($('#fecfin').val());
        r2 = f2.getTime();
        t = r2 - r1;
        tf = Math.floor(t / anio);
        resp = tf + 1;

        $('#fecinicio').change(function() {
            f1 = new Date($('#fecinicio').val());
            r1 = f1.getTime();
            t = r2 - r1;
            tf = Math.floor(t / anio);
            resp = tf + 1;
            if(isNaN(resp))
            {
                $('#diaspersonal').val(0);
            }else{
                $('#diaspersonal').val(resp);
            }
        });

        $('#fecfin').change(function() {
            f2 = new Date($('#fecfin').val());
            r2 = f2.getTime();
            t = r2 - r1;
            tf = Math.floor(t / anio);
            resp = tf + 1;
            $('#diaspersonal').val(resp);
        });

        $.ajax({
            type: 'GET',
            url: '{{ route("conceptos.todos") }}',
            dataType: 'json',
            success: function(data) {
                let obj = @json($tp);
                $('#tpermiso').on('click', () => {
                    $("#concepto").empty();
                })
                if ($('#tpermiso').val() == 1) {
                    $.each(data, (key, value) => {
                        $("#concepto").append('<option value="' + value[0][11].id + '">' + value[0][11].descripcion + '</option>');
                    });
                }
                else if ($('#tpermiso').val() == 2) {
                    $.each(data, function(key, value) {
                        for (var i = 0; i < 3; i++) {
                            $("#concepto").append('<option value="' + value[0][i].id + '"'+(obj.concepto_id == value[0][i].id ? 'selected="selected"' : '')+'>' + value[0][i].descripcion + '</option>');
                        }
                    });
                }
                else if ($('#tpermiso').val() == 3) {
                    $.each(data, function(key, value) {
                        for (var i = 3; i < 11; i++) {
                            $("#concepto").append('<option value="' + value[0][i].id + '"'+(obj.concepto_id == value[0][i].id ? 'selected="selected"' : '')+'>' + value[0][i].descripcion + '</option>');
                        }
                    });
                } else if ($('#tpermiso').val() == 4) {
                    $.each(data, (key, value) => {
                        $("#concepto").append('<option value="' + value[0][12].id + '">' + value[0][12].descripcion + '</option>');
                    });
                } else if ($('#tpermiso').val() == 5) {
                    $.each(data, (key, value) => {
                        $("#concepto").append('<option value="' + value[0][13].id + '">' + value[0][13].descripcion + '</option>');
                    });
                }
            }
        });

        $('#diaspersonal').val(resp);
        //cargar tipos de permiso en base al rol del usuario
        $.ajax({
            type: 'GET',
            url: '{{ route("conceptos.todos") }}',
            dataType: 'json',
            success: function(data) {
                // console.log(data.conceptos);
                for (let i = 0; i < 5; ++i) {
                    if (data.conceptos[1][0] == 'superadmin') {
                        // console.log(data.conceptos[2][i]['descripcion']);
                        // console.log(data.conceptos[3][i]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][i]['id'] + '">' + data.conceptos[3][i]['descripcion'] + '</option>');

                    }
                    if (data.conceptos[1][0] == 'Técnico Aislamientos') {
                        // console.log(data.conceptos[3][3]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][3]['id'] + '">' + data.conceptos[3][3]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Técnico Descansos Médicos') {
                        // console.log(data.conceptos[3][1]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][1]['id'] + '">' + data.conceptos[3][1]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Técnico Licencias') {
                        // console.log(data.conceptos[3][2]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][2]['id'] + '">' + data.conceptos[3][2]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Técnico Suspensiones') {
                        // console.log(data.conceptos[3][4]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][4]['id'] + '">' + data.conceptos[3][4]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Técnico Vacaciones') {
                        // console.log(data.conceptos[3][0]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][0]['id'] + '">' + data.conceptos[3][0]['descripcion'] + '</option>');
                        break;
                    }
                }
            }
        });

    });
</script>
@endsection
