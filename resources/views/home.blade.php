@extends('layouts.app')
@section('title')
Vista General |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Búsqueda de Personal</h3>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h4>Campos de Búsqueda</h4>
                            </div>
                            <div class="col-md-3 mb-3 d-flex justify-content-end">
                                <a class="btn btn-success" href="{{route('exportar.todos')}}"><i class="fas fa-file-excel"></i> Exportación
                                    General</a>
                            </div>
                            <!--<div class="col-md-3 mb-3 d-flex justify-content-end">
                                    <a href="{{route('cargamasiva')}}" class="btn btn-success">
                                        <i class="fas fa-file-upload"></i> Carga Masiva</a>
                                </div>-->

                        </div>
                        <form class="my-4" method="POST" action="{{ route('general.consultar') }}" id="formulario">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="codigo">CÓDIGO</label>
                                    <input type="number" class="form-control" placeholder="CÓDIGO" id="codigo" name="codigo" value="{{old('codigo')}}">
                                    <span class="text-danger" style="display: none" id="errorcode">Revisa el codigo que ingresaste porfavor</span>
                                </div>
                                <div class="col-md-2">
                                    <label for="dni">DOCUMENTO</label>
                                    <input type="number" class="form-control" placeholder="DOCUMENTO" id="dni" name="dni">
                                    <span class="text-danger" style="display: none" id="errordoc">Revisa el documento de identidad ingresado porfavor</span>
                                </div>
                                <div class="col-md-3">
                                    <label for="paterno">AP. PATERNO</label>
                                    <input type="text" class="form-control" placeholder="APELLIDO PATERNO" id="paterno" name="paterno" value={{old('paterno')}}>
                                </div>
                                <div class="col-md-3">
                                    <label for="materno">AP. MATERNO</label>
                                    <input type="text" class="form-control" placeholder="APELLIDO MATERNO" id="materno" name="materno" value={{ old('materno') }}>
                                </div>
                                <div class="col-md-2 mt-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning my-4 boton" onclick="validarNumericos();"><i class="fas fa-search"></i> Buscar
                                    </button>
                                    <p class="text-info pt-4" id="cargando" hidden>
                                        <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                                        Buscando, porfavor espere ...
                                    </p>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12 my-2">
                                <h4>Resultados de la Búsqueda</h4>
                            </div>
                        </div>

                        <table class="table table-bordered table-hover" id="personal">
                            <thead class="bg-info">
                                <th style="color: #fff">COD</th>
                                <th style="color: #fff">DOC.</th>
                                <th style="color: #fff">NOMBRES</th>
                                <th style="color: #fff">REG. LAB.</th>
                                <th style="color: #fff">UNI. ORG</th>
                                <th style="color: #fff">I. LABORES</th>
                                <th style="color: #fff">C. LABORES</th>
                                <th style="color: #fff">ESTADO</th>
                                <th style="color: #fff">OPCIONES</th>
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
                                        <a class="btn btn-primary" href="{{route('registro.edit',$resp['CODIGO'])}}"><i class="fas fa-user-plus"></i></a>
                                    </td>
                                    @elseif ($resp['ESTADO'] == 'ACTIVO')
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $resp['ESTADO'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('registro.edit',$resp['CODIGO'])}}"><i class="fas fa-user-plus"></i></a>
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
    $("#formulario").submit(function(e) {
        // e.preventDefault();
        $(".boton").attr("hidden", "hidden");
        $("#cargando").removeAttr("hidden");
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
        $('#codigo').focus();
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
