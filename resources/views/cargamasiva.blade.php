@extends('layouts.app')

@section('title')
Carga Masiva |
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Carga Masiva</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4>Subir el Archivo</h4>
                            </div>
                        </div>
                        <!-- TOASTR -->
                        @if(session()->has('error'))
                        {{ session()->get('error') }}
                        @elseif (session()->has('success'))
                        {{ session()->get('success') }}
                        @endif
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-10">
                                    <input type="file" name="file" class="form-control" value="">
                                </div>
                                <div class="col-md-2 mt-1 d-flex justify-content-end">
                                    <button class="btn btn-success">
                                        <i class="fas fa-file-upload"></i> Carga masiva
                                    </button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="row mt-4 d-flex justify-content-start">
                            <a href="{{url('manual/FormatoCargaMasiva.xlsx')}}" class="btn btn-primary ml-3 mr-4">Descarga el formato</a>
                            <a href="{{url('manual/ManualMasiva.pdf')}}" class="btn btn-primary ml-4">Manual para carga masiva</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
