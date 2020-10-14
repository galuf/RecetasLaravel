<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function show(CategoriaReceta $categoriaReceta){
        $recetas = Receta::where('categoria_id',$categoriaReceta->id)->paginate(1);

        return view('categorias.show',compact('recetas','categoriaReceta'));
    }
}
