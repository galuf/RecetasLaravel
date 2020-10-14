<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>'show']);
    }

    public function show(Perfil $perfil)
    {
        $recetas = Receta::where('user_id',$perfil->user_id)->paginate(2);
        return view('perfiles.show',compact('perfil','recetas'));
    }

    public function edit(Perfil $perfil)
    {   
        $this->authorize('view',$perfil);

        return view('perfiles.edit',compact('perfil'));
    }

    public function update(Request $request, Perfil $perfil)
    {
        $this->authorize('update',$perfil);

        $data = request()->validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);

        if($request['imagen']){
            $ruta_imagen = $request['imagen']->store('upload-perfiles','public');
            //Resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600,600);
            $img->save();

            $array_imagen = ['imagen' => $ruta_imagen];
        }

        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        unset($data['url']);
        unset($data['nombre']);

        auth()->user()->perfil()->update( array_merge(
            $data,
            $array_imagen ?? []
        ));
        return redirect()->action('RecetaController@index');
    }
}
