@extends('layouts.app')

@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.0/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" />
@endsection

@section('botones')
  <a href=" {{route('recetas.index')}} " class="btn btn-primary mr-2 text-white">Volver</a>
@endsection

@section('content')
  <h1 class="text-center">Editar mi Perfil</h1>
  <div class="row justify-content-center mt-5">
    <div class="col-md-10 bg-white p-3">
      <form action=" {{route('perfiles.update',['perfil'=> $perfil->id])}} "
            method="POST"
            enctype="multipart/form-data"
            >
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="nombre">Nombre</label>

          <input type="text" 
                  name="nombre" 
                  class="form-control @error('nombre') is-invalid @enderror" 
                  id="nombre" 
                  placeholder="Tu Nombre"
                  value="{{ $perfil->usuario->name }}">
          @error('nombre')

            <span class="invalid-feedback d-block" role="alert">
              <strong> {{$message}} </strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="url">Sitio Web</label>

          <input type="text" 
                  name="url" 
                  class="form-control @error('url') is-invalid @enderror" 
                  id="url" 
                  placeholder="Tu Sitio Web"
                  value="{{ $perfil->usuario->url }}">
          @error('url')

            <span class="invalid-feedback d-block" role="alert">
              <strong> {{$message}} </strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-3">
          <label for="biografia">Biografia</label>
          <input id="biografia" type="hidden" name="biografia" value=" {{$perfil->biografia}} ">
          <trix-editor input="biografia"
                      class="form-control @error('biografia') is-invalid @enderror">
          </trix-editor>

          @error('biografia')
            <span class="invalid-feedback d-block" role="alert">
              <strong> {{$message}} </strong>
            </span>
          @enderror
        </div>

        <div class="form-group mt-3">
          <label for="imagen">Tu Imagen:</label>

          <input id="imagen" 
                type="file"
                class="form-control @error('imagen') is-invalid @enderror"
                name="imagen">

          @if ($perfil->imagen)
            <div class="mt-4">
              <p>Imagen Actual:</p>
              <img src="/storage/{{$perfil->imagen}}" style="width:300px">
            </div>

            @error('imagen')
              <span class="invalid-feedback d-block" role="alert">
                <strong> {{$message}} </strong>
              </span>
            @enderror
          @endif
        </div>

        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Actualizar Perfil">
        </div>

      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.0/trix-core.min.js" integrity="sha512-6C0JJHOrwdlZ6YMongpJax0kXCfu23TIbEETNjBpoCHJVSw+2NL8eE/CQ0ZNdPbdzrJ/T0HgXhUbBtJl1jyEXQ==" crossorigin="anonymous" defer></script>
@endsection