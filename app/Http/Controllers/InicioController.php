<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index(){

        //Obtener las recetas mas nuevas
        //$nuevas = Receta::orderBy('created_at','DESC')->get();
        $nuevas = Receta::latest()->take(5)->get();

        //Obtener todas las categorias
        $categorias = CategoriaReceta::all();

        //agrupar las recetas por categorias
        $recetas = [];
        foreach($categorias as $categoria){
            $recetas[Str::slug($categoria->nombre)][] = Receta::where('categoria_id',$categoria->id)->take(3)->get();
        }

        return view('inicio.index',compact('nuevas','recetas'));
    }
}
