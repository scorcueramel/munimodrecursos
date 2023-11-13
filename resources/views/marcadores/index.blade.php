@extends('layouts.app')
@section('css')
    <style>
        td,
        a {
            font-size: 16px
        }
    </style>
@endsection
@section('title')
    Marcadores |
@endsection
@section('content')
    @if (session()->has('error'))
        {{ session()->get('error') }}
    @elseif (session()->has('success'))
        {{ session()->get('success') }}
    @endif
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Marcadores Registrados</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show alert-error" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @can('CREAR-MARCADORES')
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <h6>Crea nuevos marcadores y obten las marcaciones</h6>
                                    </div>
                                    <div class="col-md-4 col-sm-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-info mb-4" data-toggle="modal"
                                            data-target="#nuevoMarcador"><i class="fas fa-user-clock"></i> Nuevo
                                            marcador</button>
                                    </div>
                                </div>
                            @endcan
                            <table class="table table-striped mt-2" id="marcadores">
                                <thead class="bg-info">
                                    <th style="color: #fff">Dirección IP</th>
                                    <th style="color: #fff">Ubicación</th>
                                    <th style="color: #fff">Estado</th>
                                    @can('EDITAR-MARCADORES')
                                        <th style="color: #fff">Acciones</th>
                                    @endcan
                                </thead>
                                <tbody>
                                    @empty(!$marcadores[0])
                                        @foreach ($marcadores[0] as $m)
                                            @if ($m->mrcd_estado)
                                                <tr>
                                                    <td><i class="fas fa-train"></i> {{ $m->mrcd_ip }}
                                                    </td>
                                                    <td>{{ $m->mrcd_ubicacion }}</td>
                                                    <td class="text-success"><i class="fas fa-check-circle"></i>
                                                        <span>Activo</span>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <form action="{{ route('marcadores.change.status', $m->id) }}"
                                                                method="get" class="inactivar d-inline">
                                                                <button type="submit" class="btn btn-sm btn-warning"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Inactivar marcador">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                        &nbsp;
                                                        <span>
                                                            <button class="btn btn-sm btn-success editarmodal"
                                                                data-toggle="modal" data-target="#editarMarcador"
                                                                data-id="{{ $m->id }}" data-ip="{{ $m->mrcd_ip }}"
                                                                data-ubi="{{ $m->mrcd_ubicacion }}">
                                                                <i class="fas fa-pen-square" data-toggle="tooltip"
                                                                    data-placement="top" title="Editar marcador"></i>
                                                            </button>
                                                        </span>
                                                        &nbsp;
                                                        <span>
                                                            <form action="{{ route('marcadores.attendance', $m->id) }}"
                                                                method="get" class="onsubmit d-inline">
                                                                <button type="submit" class="btn btn-sm btn-primary obtdata"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Guardar las marcaciones de este dispositivo">
                                                                    <i class="fas fa-download"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                        &nbsp;
                                                        <span>
                                                            <button class="btn btn-sm btn-info desacargarmodal"
                                                                data-toggle="modal" data-target="#desacargarmodal"
                                                                data-id="{{ $m->id }}">
                                                                <i class="fas fa-file-excel" data-toggle="tooltip"
                                                                    data-placement="top" title="Descargar las marcaciones de este dispositivo"></i>
                                                            </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="text-danger"><i class="fas fa-train"></i> {{ $m->mrcd_ip }}
                                                    </td>
                                                    <td class="text-danger">{{ $m->mrcd_ubicacion }}</td>
                                                    <td class="text-danger"><i class="fas fa-times-circle"></i>
                                                        <span>Inactivo</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-success">
                                                            <form action="{{ route('marcadores.change.status', $m->id) }}"
                                                                method="get" class="activar d-inline">
                                                                <button type="submit" class="btn btn-sm btn-success activar"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Activar marcador">
                                                                    <i class="fas fa-check-circle"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                        &nbsp;
                                                        <span>
                                                            <form action="{{ route('marcadores.delete', $m->id) }}"
                                                                method="POST" class="frmDelete d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Eliminar marcador">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endempty
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('modales.crear-marcador-modal')
    @include('modales.editar-marcador-modal')
    @include('modales.descargar-marcaciones-modal')
@endsection

@section('scripts')
    <script>
        // Limpiar cajar al cancelar modal
        function limpiarCajas() {
            $('#ubicacion_mrcd').val('');
            $('#ip_mrcd').val('');
        }
        // Limpiar las cajas del modal crear
        $("#formulario").submit(function(e) {
            $('#cargando').removeAttr("hidden", "");
            $('#guardarMarcador').attr("hidden", "hidden");
        });
        // sweetAlert modal para eliminar
        $('.frmDelete').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Seguro de eliminar este marcador?',
                text: "Si eliminas este macador no podrás recuperarlo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: true,
                allowOutsideClick: false,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: "El marcador se elimino satisfactoriamente",
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        });
        // abrir y pasar datos a modal para editar
        $(document).on("click", ".editarmodal", function() {
            var idMarcador = $(this).data('id');
            var ipMarcador = $(this).data('ip');
            var ubiMarcador = $(this).data('ubi');

            $(".modaleditar").find('input[name="id_mrcd"]').val(idMarcador);
            $(".modaleditar").find('input[name="ip_mrcd"]').val(ipMarcador);
            $(".modaleditar").find('input[name="ubicacion_mrcd"]').val(ubiMarcador);
        });
        // abrir y pasar datos a modal para descargar las marcaciones
        $(document).on("click", ".desacargarmodal", function() {
            var idMarcador = $(this).data('id');

            $(".modaldesacargar").find('input[name="id_mrcd"]').val(idMarcador);
        });
        // carga de datatable con jquery
        $(document).ready(function() {


            $('#marcadores').DataTable({
                responsive: true,
                autoWidth: false,
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
                    "zeroRecords": "Aún no hay registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar: ",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            // alert error timer
            setTimeout(function() {
                $(".alert-error").fadeOut(2000);
            }, 2000);
        });
        // cambiar estado a marcador (Inhabilitar marcador)
        $('.inactivar').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Inhabilitar',
                text: "Desas inhabilitar el marcador, ten en cuenta que si procedes no podras realizar ciertas acciones.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: true,
                allowOutsideClick: false,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire({
                        title: 'Espere',
                        html: '<p>Inhabilitando el marcador...</p>',
                        icon: 'warning',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                }
            });
        });
        // habilitar marcador
        $('.activar').click(function(e) {
            e.preventDefault();
            this.submit();
            Swal.fire({
                title: 'Espere',
                html: '<p>Habilitando el marcador...</p>',
                icon: 'success',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            })
        });
        // guardar marcaciones en la base de datos
        $('.onsubmit').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Obtener Marcaciones',
                text: "Deses recuperar las marcaciones de este dispositivo?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCloseButton: false,
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick: false,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire({
                        title: 'Espere...',
                        html: '<p>Conectando con el dispositivo, aguarde mientras termina el proceso...</p>',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                }
            });
        });
    </script>
@endsection
