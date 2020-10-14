<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function update(Request $request, Receta $receta)
    {
        //
        return auth()->user()->meGusta()->toggle($receta);
    }

}
