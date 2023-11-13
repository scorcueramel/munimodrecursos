@extends('layouts.app')
@section('title')
    Vista General |
@endsection
@section('css')
    <style>
        .acordeon{
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .boton-acordeon {
            background: transparent;
            border: 0;
        }

        .boton-acordeon .card-header h2,
        .boton-acordeon .card-header .icono{
            font-size: 18px
        }

        .card-body p {
            font-size: 18px
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
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <h4>Campos de Búsqueda</h4>
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="card acordeon">
                                    <button class="boton-acordeon text-white btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <div class="card-header bg-info" id="headingOne" data-toggle="tooltip" data-placement="top" title="Clic aquí para enconger o expandir esta sección">
                                            <h2 class="mb-0">
                                                <i class="fas fa-exclamation-triangle mr-2 icono"></i> Antes de continuar <i
                                                    class="fas fa-exclamation"></i>
                                            </h2>
                                        </div>
                                    </button>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>
                                                <strong>> Recuerda : </strong> Todas las condiciones <strong>(campos)</strong>
                                                para la búqueda o exportación son obligatorias, evita posibles contratiempos
                                                rellenandolas correctamente.
                                            </p>
                                            <p>
                                                <strong>> Recuerda : </strong> Verificar que <strong>(campos)</strong> contengan información correcta y sin errores, de ese modo lograras agilizar tu búsqueda.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <form class="mb-3" method="POST" action="{{ route('general.consultar') }}" id="formulario">
                                @csrf --}}
                                <div class="form-row my-2">
                                    <div class="col-md-3">
                                        <label for="dni">DOCUMENTO</label>
                                        <input type="number" class="form-control" placeholder="DOCUMENTO" id="dni"
                                            name="dni" minlength="8" onkeyup="activaAcciones()" required>
                                        <span class="text-danger" style="display: none" id="errordoc">Revisa el documento
                                            de identidad ingresado porfavor</span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="paterno">AÑO INICIAL</label>
                                        <input type="number" id="min" name="min" class="form-control"
                                            placeholder="EJ: 2020" minlength="4" onkeyup="activaAcciones()" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="materno">AÑO FINAL</label>
                                        <input type="number" id="max" name="max" class="form-control"
                                            placeholder="EJ: 2025" minlength="4" onkeyup="activaAcciones()" required>
                                    </div>
                                    <div class="col-md-3 mt-2 d-flex justify-content-end">
                                        <button type="button" class="btn btn-warning my-4 boton dropdown-toggle"
                                            id="btnacciones" onclick="validarNumericos();" data-toggle="dropdown"
                                            aria-expanded="false" disabled="disabled">
                                            Acciones
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" id="buscar"><i class="fas fa-search mr-2"></i>
                                                Buscar</a>
                                            <a class="dropdown-item" href="#" id="exportar"><i class="fas fa-download mr-2"></i>
                                                Exportar Excel</a>
                                        </div>
                                        <p class="text-info pt-4" id="cargando" hidden>
                                            <span class="spinner-border spinner-border-sm mr-2" role="status"
                                                aria-hidden="true"></span>
                                            Buscando, porfavor espere ...
                                        </p>
                                    </div>
                                </div>
                            {{-- </form> --}}
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <h4>Resultados de la Búsqueda</h4>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover" id="personal">
                                <thead class="bg-info">
                                    <th style="color: #fff">DOC.</th>
                                    <th style="color: #fff">NOMBRES</th>
                                    <th style="color: #fff">TOTAL DE DÍAS</th>
                                </thead>
                                <tbody>
                                    @if ($respuesta = Session::get('resp'))
                                        @foreach ($respuesta as $resp)
                                            <tr>
                                                <td>{{ $resp['CODIGO'] }}</td>
                                                <td>{{ $resp['DOC_IDENTIDAD'] }}</td>
                                                <td>{{ $resp['NOMBRE_COMPLETO'] }}</td>
                                                <td>{{ $resp['TIPO_TRABAJADOR'] }}</td>
                                                <td>{{ $resp['CENTROCOSTO'] }}</td>
                                                <td>{{ $resp['FEC_INGRESO'] }}</td>
                                                @if ($resp['FEC_CESE'] == '')
                                                    <td>
                                                        LABORANDO
                                                    </td>
                                                @else
                                                    <td>{{ $resp['FEC_CESE'] }}</td>
                                                @endif
                                                @if ($resp['ESTADO'] == 'INACTIVO')
                                                    <td>
                                                        <span class="badge badge-danger">
                                                            {{ $resp['ESTADO'] }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('registro.edit', $resp['CODIGO']) }}"><i
                                                                class="fas fa-user-plus"></i></a>
                                                    </td>
                                                @elseif ($resp['ESTADO'] == 'ACTIVO')
                                                    <td>
                                                        <span class="badge badge-success">
                                                            {{ $resp['ESTADO'] }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('registro.edit', $resp['CODIGO']) }}"><i
                                                                class="fas fa-user-plus"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function activaAcciones() {
            if ($('#dni').val() != "" && $('#min').val() != "" && $('#max').val() != "") {
                $('#btnacciones').removeAttr("disabled");
            }
        }

        $("#buscar").on('click',()=> {
            console.log('Clic en buscar');
        });

        $("#exportar").on('click',()=>{
            console.log('Clic en exportar');
        });

        function validarNumericos() {
            if ($('#codigo').val() > 999999) {
                $('#errorcode').css("display", "block");
                $('#codigo').css("border", "1px solid red");
                $('#codigo').focus();
                event.preventDefault();
                return false;
            } else if ($('#dni').val() > 9999999999999) {
                $('#errordoc').css("display", "block");
                $('#dni').css("border", "1px solid red");
                $('#dni').focus();
                event.preventDefault();
                return false;
            } else {
                if ($('#codigo').val() != "" && $('#dni').val() == "") {
                    $('#errorcode').css("display", "none");
                    $('#codigo').css("border", "");
                } else if ($('#codigo').val() == "" && $('#dni').val() != "") {
                    $('#errordoc').css("display", "none");
                    $('#dni').css("border", "");
                }
                return true;
            }
        }

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
    </script>
@endsection
