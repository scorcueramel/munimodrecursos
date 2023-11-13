@extends('layouts.app')
@section('title')
Aislamientos |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Personal Con Aislamientos Registrados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-2 mt-2">
                                <h4>Exportar Por Fechas</h6>
                            </div>
                            <div class="col-6">
                                <form action="{{route('aislamientos.export')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <input type="date" id="min" name="min" class="form-control">
                                        </div>
                                        <div class="col">
                                            <input type="date" id="max" name="max" class="form-control">
                                        </div>
                                        <div class="col mt-1">
                                            <button type="submit" class="btn btn-success" id="btnexportar" disabled="disabled"><i class="fas fa-file-excel"></i> Exportar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table mt-2" id="aislamientos">
                                    <thead class="bg-info">
                                        <!-- {{--                                        <th style="color: #fff">COD</th>--}} -->
                                        <th style="color: #fff">DOCUMENTO IDENTIDAD</th>
                                        <th style="color: #fff">NOMBRES</th>
                                        <!-- {{--                                        <th style="color: #fff">REG. LAB.</th>--}}
                                        {{--                                        <th style="color: #fff">UNI. ORG</th>--}} -->
                                        <th style="color: #fff">F. INICIO</th>
                                        <th style="color: #fff">F. FIN</th>
                                        <th style="color: #fff">DIAS</th>
                                        <th style="color: #fff">PERIODO</th>
                                        <th style="color: #fff">DOCUMENTO</th>
                                        <th style="color: #fff">OBSERVACIÓN</th>
                                        @can('EDITAR-AISLAMIENTOS')
                                        <th style="color: #fff" colspan="2" class="text-center">OPCIONES</th>
                                        @endcan
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('modales.borrar-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#max').on('change', function () {
            if(minimo = $('#min').val() != "")
            {
                $('#btnexportar').removeAttr("disabled");
            }
         });

         $('#min').on('change', function () {
            if(minimo = $('#max').val() != "")
            {
                $('#btnexportar').removeAttr("disabled");
            }
         });


        $('#aislamientos').DataTable({
            proccesing: true,
            info: true,
            "order": [
                [0, "DESC"]
            ],
            responsive: true,
            autoWidth: false,
            processing: true,
            info: true,
            "pageLength": 5,
            "aLengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 15, "Todos"]
            ],
            "ajax": "{{route('tabla.aislamientos')}}",
            "columns": [
                // {data:'codigo_persona'},
                {
                    data: 'documento_persona'
                },
                {
                    data: 'nombre_persona'
                },
                // {data:'reglab_persona'},
                // {data:'uniorg_persona'},
                {
                    data: 'fecha_inicio'
                },
                {
                    data: 'fecha_fin'
                },
                {
                    data: 'inicial'
                },
                {
                    data: 'periodo'
                },
                {
                    data: 'docsus'
                },
                {
                    data: 'obs'
                },
                {
                    data: 'editar'
                },
                {
                    data: 'borrar'
                }
            ],
            "language": {
                "lengthMenu": "Mostrar " +
                    `<select class="custom-select custom-select-sm form-control form-control-sm">
                            <option value='5'>5</option>
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
        });

    });

    $(document).on('click', '#borrar', function() {
        var id = $(this).data('id');
        $('#delete').modal('show');
        $('#delete').find('input[name="id"]').val(id);
    });
</script>
@endsection
