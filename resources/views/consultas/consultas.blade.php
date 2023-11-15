@extends('layouts.app')
@section('title')
    Vista General |
@endsection
@section('css')
    <style>
        .acordeon {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .boton-acordeon {
            background: transparent;
            border: 0;
        }

        .boton-acordeon .card-header h2 {
            font-size: 18px
        }

        .card-body p {
            font-size: 18px
        }

        .contenedor-recomendaciones {
            border: 1px solid #fefefe
        }

        #alert {
            background: salmon;
        }

        .mensaje {
            font-size: 18px;
        }

        .btn-info {
            font-size: 17px !important;
        }

        tr {
            font-size: 18px;
        }
    </style>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Apartado de Consultas</h3>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion" id="accordionExample">
                                <div class="card acordeon">
                                    {{-- Consultar cantidad de días --}}
                                    <button class="boton-acordeon text-white btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <div class="card-header bg-info" id="headingOne" data-toggle="tooltip"
                                            data-placement="top" title="Clic aquí para enconger o expandir esta sección">
                                            <h2 class="mb-0">
                                                Consultar Cantidad de Días de Descando Médico
                                            </h2>
                                        </div>
                                    </button>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="mb-4">
                                                        <span data-toggle="tooltip" data-placement="top"
                                                            title="Clic para (mostrar / ocultar) las recomendaciones">
                                                            <a class="btn btn-lg btn-info" data-toggle="collapse"
                                                                href="#collapseExample" role="button" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <i class="fas fa-lightbulb mr-2"></i> Recomendaciones
                                                            </a>
                                                        </span>
                                                    </p>
                                                    <div class="collapse mb-3" id="collapseExample">
                                                        <div class="card card-body text-justify">
                                                            <p>
                                                                <strong>> Recuerda : </strong> Todas las condiciones
                                                                <strong>(campos)</strong>
                                                                para la búqueda o exportación son obligatorias, evita
                                                                posibles
                                                                contratiempos
                                                                rellenandolas correctamente.
                                                            </p>
                                                            <p>
                                                                <strong>> Recuerda : </strong> Verificar que
                                                                <strong>(campos)</strong>
                                                                contengan información correcta y sin errores, de ese modo
                                                                lograras
                                                                agilizar tu búsqueda.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-consulta mt-3">
                                                @if ($mensaje = Session::get('msg'))
                                                    <div class="alert mb-4" role="alert" id="alert">
                                                        {{-- <MARQUEE DIRECTION=LEFT SCROLLAMOUNT=20><h6>{{ $mensaje }}</h6></MARQUEE> --}}
                                                        <p class="mensaje">{{ $mensaje }}</p>
                                                    </div>
                                                @endif
                                                <form class="my-3" method="POST"
                                                    action="{{ route('consulta.totaldias') }}" id="formulario">
                                                    @csrf
                                                    <div class="row mb-4">
                                                        <div class="col-md-auto">
                                                            <h5>Parametros de consulta</h5>
                                                        </div>
                                                    </div>
                                                    <div class="form-row my-2">
                                                        <div class="col-md-3">
                                                            <label for="dni">DOCUMENTO</label>
                                                            <input type="number" class="form-control"
                                                                placeholder="DOCUMENTO" id="dni" name="dni"
                                                                onkeyup="activaAcciones();validarDocumento();" required
                                                                value="{{ old('dni') }}">
                                                            <span class="text-danger" style="display: none"
                                                                id="errordoc">La <b>longitud</b> del documento
                                                                de identidad ingresado <b>excede</b> los <b>13
                                                                    caracteres</b> permitidos.</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="paterno">AÑO INICIAL</label>
                                                            <input type="number" id="min" name="min"
                                                                class="form-control" placeholder="EJ: 2020" minlength="4"
                                                                onkeyup="activaAcciones();validarAnio();" required
                                                                value="{{ old('min') }}">
                                                            <span class="text-danger" style="display: none"
                                                                id="errormin">Ingresa <b>solo 4 digitos</b> para el año
                                                                inicial.</span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="materno">AÑO FINAL</label>
                                                            <input type="number" id="max" name="max"
                                                                class="form-control" placeholder="EJ: 2025" minlength="4"
                                                                onkeyup="activaAcciones();validarAnio()" required
                                                                value="{{ old('max') }}">
                                                            <span class="text-danger" style="display: none"
                                                                id="errormax">Ingresa <b>solo 4 digitos</b> para el año
                                                                final.</span>
                                                        </div>
                                                        <div class="col-md-3 mt-2 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-warning my-4 boton"
                                                                id="btnbuscar" disabled="disabled">
                                                                <i class="fas fa-search mr-2"></i>Buscar
                                                            </button>
                                                            <p class="text-info pt-4" id="cargando" hidden>
                                                                <span class="spinner-border spinner-border-sm mr-2"
                                                                    role="status" aria-hidden="true"></span>
                                                                Buscando, porfavor espere ...
                                                            </p>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if ($respuesta = Session::get('resp'))
                                                    <div class="row">
                                                        <div class="col-md-12 my-2">
                                                            <h4>Resultados de la Búsqueda</h4>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered table-hover" id="personal">
                                                        <thead class="bg-info">
                                                            <th style="color: #fff">DOCUMENTO</th>
                                                            <th style="color: #fff">NOMBRES Y APELLIDOS</th>
                                                            <th style="color: #fff">ESTADO ACTUAL</th>
                                                            <th style="color: #fff">TOTAL DE DÍAS</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($respuesta as $resp)
                                                                <tr>
                                                                    <td>{{ $resp->DOCUMENTO }}</td>
                                                                    <td>{{ $resp->NOMBRE }}</td>
                                                                    @if ($resp->ESTADO == 'INACTIVO')
                                                                        <td>
                                                                            <span class="badge badge-danger">
                                                                                YA NO LABORA EN LA ENTIDAD
                                                                            </span>
                                                                        </td>
                                                                    @elseif ($resp->ESTADO == 'ACTIVO')
                                                                        <td>
                                                                            <span class="badge badge-success">
                                                                                LABORANDO EN LA ENTIDAD
                                                                            </span>
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ $resp->TOTALDIAS }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Consultar para exportar a excel --}}
                                    <button class="boton-acordeon text-white btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <div class="card-header bg-info" id="headingTwo" data-toggle="tooltip"
                                            data-placement="top" title="Clic aquí para enconger o expandir esta sección">
                                            <h2 class="mb-0">
                                                Consultar Rango de Fechas para Exportar a Excel
                                            </h2>
                                        </div>
                                    </button>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @if ($mensaje = Session::get('msg-success'))
                                                <div class="alert mb-4" role="alert" id="alert">
                                                    {{-- <MARQUEE DIRECTION=LEFT SCROLLAMOUNT=20><h6>{{ $mensaje }}</h6></MARQUEE> --}}
                                                    <p class="mensaje">{{ $mensaje }}</p>
                                                </div>
                                            @endif
                                            <h5 class="mb-3">Parametros de consulta</h5>
                                            <form action="{{ route('consultas.export') }}" method="post"
                                                id="frm_exportar">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="fecha_min">FECHA INICIAL</label>
                                                        <input type="date" id="fecha_min" name="fecha_min"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="fecha_max">FECHA FINAL</label>
                                                        <input type="date" id="fecha_max" name="fecha_max"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="tipo_permiso">TIPO DE PERMISO</label>
                                                        <select class="form-control" name="tipo" id="tipo_permiso">
                                                            <option disabled value="" selected>Selecciona Tipo
                                                            </option>
                                                            @foreach ($tipo_permisos as $tp)
                                                                <option value="{{ $tp->id }}">
                                                                    {{ $tp->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 d-flex justify-content-end">
                                                        <div class="row mt-2">
                                                            <div class="col-auto mt-4">
                                                                <button type="submit" class="btn btn-success boton"
                                                                    id="btnexportar" disabled="disabled"><i
                                                                        class="fas fa-file-excel"></i>
                                                                    Exportar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // consulta cantidad de días
        function activaAcciones() {
            if ($('#dni').val() != "" && $('#min').val() != "" && $('#max').val() != "") {
                $('#btnbuscar').removeAttr("disabled");
            }
        }
        $("#formulario").submit(function(e) {
            $(".boton").attr("hidden", "hidden");
            $("#cargando").removeAttr("hidden");
        });
        //  validacion de campo númerico
        function validarDocumento() {
            if ($('#dni').val() > 9999999999999) {
                $('#errordoc').css("display", "block");
                $('#dni').css("border", "1px solid red");
                $('#dni').focus();
                return false;
            }
        }
        // valicacion de campo anios
        function validarAnio() {
            if ($('#min').val() > 9999) {
                $('#errormin').css("display", "block");
                $('#min').css("border", "1px solid red");
                $('#min').focus();
                return false;
            }
            if ($('#max').val() > 9999) {
                $('#errormax').css("display", "block");
                $('#max').css("border", "1px solid red");
                $('#max').focus();
                return false;
            }
        }
        // creacion de tabla consulta cantidad de días
        $(document).ready(function() {
            $('#dni').focus();
            $('#personal').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='5' selected>5</option>
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='25'>25</option>
                            <option value='-1'>Todos</option>
                        </select>` +
                        " registros por página",
                    "zeroRecords": "Sin Resultados Actualmente",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin Resultados",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar: ",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "order": [
                    [0, "DESC"]
                ],
            });
        });
        // Aler errores consulta cantidad de días
        jQuery(function($) {
            // para etiqueta marque
            // $('#alert').fadeIn(1000);
            // $('#alert').fadeOut(25000);
            $('#alert').fadeIn(1500);
            $('#alert').fadeOut(1500);
            $('#alert').fadeIn(1500);
            $('#alert').fadeIn(1500);
            $('#alert').fadeOut(1500);
            $('#alert').fadeIn(500);
            $('#alert').delay(3500);
            $('#alert').fadeOut(2000);
        })

        // consulta para exportación
        $('#tipo_permiso').on('change', function() {
            if ($('#fecha_min').val() != "" && $('#fecha_max').val() != "") {
                $('#btnexportar').removeAttr("disabled");
            }
        });
    </script>
@endsection
