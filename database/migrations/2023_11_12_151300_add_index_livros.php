<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexLivros extends Migration
{
    public function up()
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->index('titulo');
        });
    }

    public function down()
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->dropIndex('livros_titulo_index');
        });
    }
}
