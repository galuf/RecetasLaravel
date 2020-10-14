@extends('layouts.app')

@section('styles')
    
@endsection

@section('hero')
  <div class="hero-categorias">
    <form action=" {{route('buscar.show')}} " class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-md-4 texto-buscar">
          <p class="display-4">
            Encuentra una receta para tu proxima comida
          </p>
          <input type="search"
                  name="buscar"
                  class="form-control"
                  placeholder="Buscar Receta">
        </div>
      </div>
    </form>
  </div>
@endsection

@section('content')

    <div class="container nuevas-recetas">
      <h2 class="titulo-categoria text-uppercase mt-5 mb-4">
        Ultimas Recetas
      </h2>
      <div class="row">
        @foreach ($nuevas as $nueva)
          <div class="col-md-4">
            <div class="card">
              <img src="/storage/{{$nueva->imagen}}" class="card-img-top" alt="imagen receta">

              <div class="card-body">
                <h3>{{ Str::title($nueva->titulo)}}</h3>

                <p> {{ Str::words(strip_tags($nueva->preparacion),20) }} </p>
                <a href=" {{route('recetas.show',['receta'=>$nueva->id])}} " 
                  class="btn btn-primary d-block font-weight-bold text-uppercase">
                  Ver Receta
                </a>
              </div>

            </div>
          </div>
        @endforeach
      </div>
    </div>
    @foreach ($recetas as $key=>$grupo)
      <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4">
          {{ str_replace('-',' ',$key)}}
        </h2>
        <div class="row">
          @foreach ($grupo as $recetas)
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
          @endforeach
        </div>
      </div>
    @endforeach
@endsection