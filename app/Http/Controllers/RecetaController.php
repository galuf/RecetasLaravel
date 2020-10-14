<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['show','search']]);
    }

    public function index()
    {
        $usuario = auth()->user();
        $recetas = Receta::where('user_id',$usuario->id)->paginate(2);

        return view('recetas.index')
                ->with('recetas',$recetas)
                ->with('usuario',$usuario);
    }

    public function create()
    {
        //Obtener las categorias sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');
        
        //Usando modelo
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.create')->with('categorias',$categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image'
        ]);

        $ruta_imagen = $request['imagen']->store('upload-recetas','public');
        //Resize de la imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,550);
        $img->save();

        // almacenar en la base de datos con modelo
        $receta = new Receta;
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->imagen = $ruta_imagen;
        $receta->user_id = auth()->user()->id;
        $receta->categoria_id = $data['categoria'];

        $receta->save();
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        $like = (auth()->user()) ? auth()->user()->meGusta->contains($receta->id) :false;
        
        $likes = $receta->likes->count();

        return view('recetas.show',compact('receta','like','likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $this->authorize('view',$receta);
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit',compact('categorias','receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        $this->authorize('update',$receta);
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
        ]);

        if(request('imagen')){
            $ruta_imagen = $request['imagen']->store('upload-recetas','public');
            //Resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,550);
            $img->save();
            $receta->imagen = $ruta_imagen;
        }

        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];
        $receta->save();

        return redirect()->action('RecetaController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        $this->authorize('delete',$receta);
        $receta->delete();
        return redirect()->action('RecetaController@index');
    }
    public function search(Request $request){

        $busqueda = $request['buscar'];
        $recetas = Receta::where('titulo','like','%'. $busqueda . '%')->paginate(1);
        $recetas->appends(['busacar'=>$busqueda]);
        return view('busquedas.show',compact('recetas','busqueda'));
    }
}
