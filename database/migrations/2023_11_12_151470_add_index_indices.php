<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexIndices extends Migration
{
    public function up()
    {
        Schema::table('indices', function (Blueprint $table) {
            $table->index('titulo');
            $table->index(['livro_id', 'indice_pai_id']);
        });
    }

    public function down()
    {
        Schema::table('indices', function (Blueprint $table) {
            $table->dropIndex('indices_titulo_index');
            $table->dropIndex('indices_livro_id_index');
            $table->dropIndex('indices_indice_pai_id_index');

        });
    }
}
