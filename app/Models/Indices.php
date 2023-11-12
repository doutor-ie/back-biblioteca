<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Indices extends Model
{
    protected $table = 'indices';

    protected $fillable = [
        'livro_id', 'indice_pai_id', 'titulo', 'pagina',
    ];

    public function livro()
    {
        return $this->belongsTo(Livros::class);
    }

    public function subindicesRecursive()
    {
        return $this->hasMany(Indices::class, 'indice_pai_id')->with('subindicesRecursive');
    }
}
