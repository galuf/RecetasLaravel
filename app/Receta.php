<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes','imagen', 'categoria_id'
    ];

    public function categoria(){
        return $this->belongsTo(CategoriaReceta::class);
    }
    
    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }

    //Likes que ha recibido una receta
    public function likes(){
        return $this->belongsToMany(User::class,'likes_receta');
    }
}
