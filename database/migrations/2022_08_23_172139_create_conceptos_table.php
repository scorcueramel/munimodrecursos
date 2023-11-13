<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptosTable extends Migration
{
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tipo_permiso_id');
            $table->foreign('tipo_permiso_id')->references('id')->on('tipo_permisos');
            $table->string('codigo_pdt');
            $table->string('descripcion');
            $table->boolean('estado')->nullable()->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conceptos');
    }
}
