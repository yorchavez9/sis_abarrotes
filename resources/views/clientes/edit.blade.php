@extends('template')

@section('title','Editar clientes')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>

    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
        <li class="breadcrumb-item active">Editar cliente</li>
    </ol>

    <div class="container w-100 border border-1  border-primary rounded p-4 mt-3">
        <form action="{{ route('clientes.update',['cliente'=>$cliente]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                
                <div class="col-md-6">
                    <label for="tipo_persona" class="form-label">Tipo de cliente: <span class="fw-bold">{{ strtoupper($cliente->persona->tipo_persona) }}</span></label>
                </div>
                <div id="box-razon-social" class="col-md-12 mb-2">
                    @if ($cliente->persona->tipo_persona == 'natural')
                    <label id="label-natural" for="razon_social" class="form-label">Nombres y apellidos</label>
                    @else
                    <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa</label>
                    @endif
                    <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_social',$cliente->persona->razon_social) }}">
                    @error('razon_social')
                        <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>
                <div class="col-md-12 mb-2">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion',$cliente->persona->direccion) }}">
                    @error('direccion')
                        <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="documento_id" class="form-label">Tipo de documento:</label>
                    <select name="documento_id" id="documento_id" class="form-select">
                        @foreach ($documentos as $item)
                            @if($cliente->persona->documento_id == $item->id)
                                <option selected value="{{ $item->id }}" {{ old('documento_id')==$item->id }}>{{ $item->tipo_documento }}</option>
                            @else
                                <option value="{{ $item->id }}" {{ old('documento_id')==$item->id }}>{{ $item->tipo_documento }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('documento_id')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="numero_documento" class="form-label">Número de documento:</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento',$cliente->persona->numero_documento) }}">
                    @error('numero_documento')
                        <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>

    </script>
@endpush