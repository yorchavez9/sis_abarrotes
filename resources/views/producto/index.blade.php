@extends('template')

@section('title','Productos')


@push('css')
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<style>
    .small-text {
        font-size: smaller;
    }
</style>

@endpush

@section('content')

@if (session('success'))
<script>
    let message = "{{ session('success') }}";
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "success",
        title: message
    });
</script>
@endif
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Productos</li>
    </ol>
    <div class="mb-4">
        <a href="{{ route('productos.create') }}"><button type="button" class="btn btn-primary">Añadir nuevo
                registro</button></a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla productos
        </div>
        <div class="card-body">
            <table class="table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Presentación</th>
                        <th>Categorías</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $item)
                    <tr>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->marca->caracteristica->nombre }}</td>
                        <td>{{ $item->presentacione->caracteristica->nombre }}</td>
                        <td>
                            @foreach ($item->categorias as $category )
                            <div class="container">
                                <div class="row">
                                    <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center small-text">
                                        {{ $category->caracteristica->nombre }}
                                    </span>

                                </div>
                            </div>
                            @endforeach
                        </td>
                        <td>
                            @if ($item->estado ==1)
                            <span class="fw-bolder rounded p-1 bg-success text-white small-text">
                                Activo
                            </span>
                            @else
                            <span class="fw-bolder rounded p-1 bg-danger text-white small-text">
                                Desactivado
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div>
                                    <form action="{{ route('productos.edit',['producto'=>$item]) }}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#verModal-{{ $item->id }}">Ver</button>

                                    @if ($item->estado == 1)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal-{{ $item->id }}">Eliminar</button>
                                    @else
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal-{{ $item->id }}">Restaurar</button>
                                    @endif


                                </div>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal ver --}}
                    <div class="modal fade" id="verModal-{{ $item->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del producto</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="descripcion"><span class="fw-bolder">Descripción: </span>{{
                                            $item->descripcion }}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Fecha_vencimiento"><span class="fw-bolder">Fecha de vencimiento:
                                            </span>{{ $item->fecha_vencimiento==''? 'No tiene' :
                                            $item->fecha_vencimiento }}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="stock"><span class="fw-bolder">Stock: </span>{{ $item->stock
                                            }}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="">Imagen:</label>
                                        <div>
                                            @if ($item->img_path != null)
                                            <img src="{{ Storage::url('public/productos/'.$item->img_path) }}"
                                                alt="{{ $item->nombre }}"
                                                class="img-fluid img-thumbnail border border-4 rounded">
                                            @else
                                            <span>No tiene imagen</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal eliminar-->
                    <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $item->estado == 1 ? '¿Segúro que quieres eliminar el producto?' : '¿Segúro que
                                    quieres restaurar el producto?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('productos.destroy',['producto'=>$item->id]) }}"
                                        method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

@endpush