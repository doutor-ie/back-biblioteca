<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivrosTable extends Migration
{
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_publicador_id');
            $table->string('titulo');
            $table->timestamps();
            $table->foreign('usuario_publicador_id')->references('id')->on('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('livros');
    }
}
