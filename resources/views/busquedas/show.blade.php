@extends('layouts.app')

@section('content')
  <div class="container">
    <h2 class="titulo-categoria text-uppercase mt-5 mb-4">
      Resultados Busqueda: {{$busqueda}}
    </h2>
    <div class="row">
      @foreach ($recetas as $receta)
      <div class="col-md-4 mt-4">
        <div class="card shadow">
          <img src="/storage/{{$receta->imagen}}" class="card-img-top" alt="imagen receta">
          <div class="card-body">
            <h3 class="card-title">  {{$receta->titulo}} </h3>
            <div class="meta-receta d-flex justify-content-between">
              @php
                $fecha = $receta->created_at;
              @endphp
              <fecha-receta fecha=" {{$fecha}} "></fecha-receta>
              <p>
                {{count($receta->likes)}} Les gusto
              </p>
            </div>
            
            <p class="card-text">
              {{Str::words(strip_tags($receta->preparacion),20,'...')}}
            </p>
            
            <a href="{{route('recetas.show',['receta'=>$receta->id])}}" 
                class="btn btn-primary d-block btn-receta">
                Ver Receta
            </a>
          </div>
        </div>
      </div>
      @endforeach

    </div>
        <div class="d-flex justify-content-center mt-5">
          {{$recetas->links()}}
        </div>
  </div>
@endsection

