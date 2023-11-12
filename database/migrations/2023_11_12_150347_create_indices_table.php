<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicesTable extends Migration
{
    public function up()
    {
        Schema::create('indices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livro_id');
            $table->unsignedBigInteger('indice_pai_id')->nullable();
            $table->string('titulo');
            $table->integer('pagina');
            $table->timestamps();

            $table->foreign('livro_id')->references('id')->on('livros');
            $table->foreign('indice_pai_id')->references('id')->on('indices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('indices');
    }
}
