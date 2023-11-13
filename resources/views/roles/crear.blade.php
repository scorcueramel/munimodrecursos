@extends('layouts.app')
@section('title')
Crear Rol |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Nuevo Rol</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Alerta validacion --}}
                        @if ($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-danger">{{ $error }}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <h6>ASIGNAR PERMISOS PARA EL ROL</h6>
                                </div>
                            </div>
                        </div>
                        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-5">
                                <div class="form-group">
                                    <label for="name">Nombre del rol</label>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombra el rol']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12 mb-3">
                                <h6>ASIGNAR PERMISOS AL ROL</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Roles</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'ROLES'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Usuarios</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'USUARIOS'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Vacaciones</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'VACACIONES'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Suspensiones</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'SUSPENSIONES'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Licencias</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'LICENCIAS'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Desansos Médicos</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'DESCANSOS-MEDICOS'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="card" style="border:1px solid #3ABAF4;">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title text-info">Gestión de Aislamientos</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($permission as $item)
                                            @if (str_contains($item->name, 'AISLAMIENTOS'))
                                            <div class="custom-control custom-switch d-block">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" name="permission[]" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="customSwitch{{ $item->id }}">{{$item->name}}</label>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('roles.index')}}" class="btn btn-danger" style="padding-bottom: -40px;"><i class="fas fa-undo-alt"></i> Volver</a>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
