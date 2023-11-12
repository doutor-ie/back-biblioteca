<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Livros extends Model
{
    protected $table = 'livros';

    protected $fillable = [
        'usuario_publicador_id', 'titulo',
    ];

    public function indices()
    {
        return $this->hasMany(Indices::class,'livro_id','id')->orderBy('id','asc');
    }

    public function usuario_publicador()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_publicador_id','id')->select('id','name as nome');
    }
}
