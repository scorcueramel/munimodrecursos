@extends('layouts.app')
@section('title')
Nuevo Registro |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Registro</h3>
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
                        <form action="{{route('store')}}" method="POST" id="formulario">
                            @csrf
                            @foreach ( $resp as $r)
                            <div class="form-row">
                                <div class="col-md-2 mb-6">
                                    <label for="codigo">Código</label>
                                    <input type="text" class="form-control" id="codigo" value="{{ $r['CODIGO'] }}" name="codigo" required readonly>
                                </div>
                                <div class="col-md-2 mb-6" style="display: none;">
                                    <label for="tipo_documento_persona">Tipo Documento</label>
                                    <input type="text" class="form-control" id="tipo_documento_persona" value="{{ $r['DOC_CODIGO'] }}" name="tipo_documento_persona" required readonly>
                                </div>
                                <div class="col-md-2 mb-6">
                                    <label for="documento_persona">Documento</label>
                                    <input type="text" class="form-control" id="documento_persona" value="{{ $r['DOC_IDENTIDAD'] }}" name="documento_persona" required readonly>
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label for="nombres">Nombres y Apellidos</label>
                                    <input type="text" class="form-control" id="nombres" value="{{ $r['NOMBRE_COMPLETO'] }}" name="nombres" required readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="reglaboral">Regimen Laboral</label>
                                    <input type="text" class="form-control" id="reglaboral" value="{{ $r['REGIMEN_LABORAL'] }}" name="reglaboral" required readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-6">
                                    <label for="uniorg">Unidad Orgánica</label>
                                    <input type="text" class="form-control" id="uniorg" value="{{ $r['CENTROCOSTO'] }}" name="uniorg" required readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="ingreso">Ingreso Labores</label>
                                    <input type="text" class="form-control" id="ingreso" value="{{ $r['FEC_INGRESO'] }}" name="ingreso" required readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="estado">Estado</label>
                                    <input type="text" class="form-control" id="estado" value="{{ $r['ESTADO'] }}" name="estado" required readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="tpermiso">Tipo de Permiso</label>
                                    <select class="form-control" name="tpermiso" id="tpermiso">
                                        <option selected value="">SELECCIONAR</option>
                                    </select>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label for="concepto">Concepto</label>
                                    <select class="form-control" id="concepto" name="concepto">
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecinicio">Inicio Permiso</label>
                                    <input type="date" class="form-control" name="fecinicio" id="fecinicio" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="fecfin">Fin Permiso</label>
                                    <input type="date" class="form-control" name="fecfin" id="fecfin" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 mb-3">
                                    <label for="diaspersonal">Días</label>
                                    <input type="text" class="form-control" name="diaspersonal" id="diaspersonal" placeholder="0" readonly>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="anioperiodo">Año Periodo</label>
                                    <input type="text" class="form-control" name="anioperiodo" id="anioperiodo">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="observaciones">Observaciones</label>
                                    <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="60">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="documento_ref">Documento Sustentario</label>
                                    <input type="text" class="form-control" name="documento_ref" id="documento_ref" maxlength="40">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="numero_contacto">Número de Contacto</label>
                                    <input type="text" class="form-control" name="numero_contacto" id="numero_contacto" maxlength="9">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-danger botones" style="padding-bottom: -40px;" onclick="history.back()"><i class="fas fa-undo-alt"></i> Volver</a>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button class="btn btn-primary mt-2 botones" type="submit" id="guardarRegistro"><i class="fas fa-save"></i> Crear Registro
                                    </button>
                                    <p class="text-danger" id="cargando" hidden>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Espere un momento porfavor...
                                    </p>
                                </div>
                            </div>
                            @endforeach
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
    $("#formulario").submit(function(e) {
        // e.preventDefault();
        $(".botones").attr("hidden", "hidden");
        $("#cargando").removeAttr("hidden");
    });
    $(document).ready(() => {
        // console.log({!! auth()->user()->can('EDITAR-VACACIONES') !!});
        // cargar tipos de permiso en base al rol del usuario
        $.ajax({
            type: 'GET',
            url: '{{ route("conceptos.todos") }}',
            dataType: 'json',
            success: function(data) {
                for (let i = 0; i < 5; ++i) {
                    if (data.conceptos[1][0] == 'superadmin') {
                        $('#tpermiso').append('<option value="' + data.conceptos[3][i]['id'] + '">' + data.conceptos[3][i]['descripcion'] + '</option>');
                    }
                    if (data.conceptos[1][0] == 'Tecnico Aislamientos') {
                        console.log(data.conceptos[3][3]['descripcion']);
                        $('#tpermiso').append('<option value="' + data.conceptos[3][3]['id'] + '">' + data.conceptos[3][3]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Tecnico Descansos Medicos') {
                        $('#tpermiso').append('<option value="' + data.conceptos[3][1]['id'] + '">' + data.conceptos[3][1]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Tecnico Licencias') {
                        $('#tpermiso').append('<option value="' + data.conceptos[3][2]['id'] + '">' + data.conceptos[3][2]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Tecnico Suspensiones') {
                        $('#tpermiso').append('<option value="' + data.conceptos[3][4]['id'] + '">' + data.conceptos[3][4]['descripcion'] + '</option>');
                        break;
                    }
                    if (data.conceptos[1][0] == 'Tecnico Vacaciones') {
                        $('#tpermiso').append('<option value="' + data.conceptos[3][0]['id'] + '">' + data.conceptos[3][0]['descripcion'] + '</option>');
                        break;
                    }
                }
            }
        });

        function limpiarConceptos() {
            $('#concepto').empty();
        }
        //cargar conceptos segun permiso
        $("#tpermiso").change(function() {
            var tipoconcepto_id = $(this).val();
            limpiarConceptos();
            if (tipoconcepto_id) {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("conceptos.todos") }}',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        if ($('#tpermiso').val() == 1) {
                            $.each(data, (key, value) => {
                                $("#concepto").append('<option value="' + value[0][11].id + '">' + value[0][11].descripcion + '</option>');
                            });
                        } else if ($('#tpermiso').val() == 2) {
                            $.each(data, function(key, value) {

                                for (var i = 0; i < 3; i++) {
                                    $("#concepto").append('<option value="' + value[0][i].id + '">' + value[0][i].descripcion + '</option>');
                                }
                            });
                        } else if ($('#tpermiso').val() == 3) {
                            $.each(data, function(key, value) {
                                for (var i = 3; i < 11; i++) {
                                    $("#concepto").append('<option value="' + value[0][i].id + '">' + value[0][i].descripcion + '</option>');
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
            }
        });

        // Calculo de días automatico
        var f1, f2, r1, r2, t, tf, resp;
        const anio = 1000 * 60 * 60 * 24;
        $('#tpermiso').focus();

        $('#fecinicio').change(function() {
            f1 = new Date($('#fecinicio').val());
            r1 = f1.getTime();
            t = r2 - r1;
            tf = Math.floor(t / anio);
            resp = tf + 1;
            if (isNaN(resp)) {
                $('#diaspersonal').val(0);
            } else {
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

        //Bloquear las fechas anteriores a la actual
        // var fecha = new Date();
        // var anio = fecha.getFullYear();
        // var dia = fecha.getDate();
        // var _mes = fecha.getMonth();//viene con valores de 0 al 11
        // _mes = _mes + 1;//ahora lo tienes de 1 al 12
        // if (_mes < 10)//ahora le agregas un 0 para el formato date
        // { var mes = "0" + _mes;}
        // else
        // { var mes = _mes.toString;}
        // document.getElementById("fecinicio").min = anio+'-'+mes+'-'+dia;
        // document.getElementById("fecfin").min = anio+'-'+mes+'-'+dia;
    });
</script>
@endsection
