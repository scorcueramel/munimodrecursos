<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoPermisosTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_permisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');
            $table->boolean('flag_export')->nullable()->default(0);
            $table->boolean('estado')->nullable()->default(1);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('tipo_permisos');
    }
}
