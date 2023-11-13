<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_persona',6)->nullable(false);
            $table->string('tipo_documento_persona',2)->nullable(false);
            $table->string('documento_persona')->nullable(false);
            $table->string('nombre_persona')->nullable(false);
            $table->string('reglab_persona')->nullable(false);
            $table->string('uniorg_persona')->nullable(false);
            $table->date('fecha_inicio_persona')->nullable(false);
            $table->string('estado_persona')->nullable(false);
            $table->unsignedBigInteger('tipo_permiso_id');
            $table->foreign('tipo_permiso_id')->references('id')->on('tipo_permisos')->nullable();
            $table->unsignedBigInteger('concepto_id')->nullable();
            $table->foreign('concepto_id')->references('id')->on('conceptos');
            $table->date('fecha_inicio')->nullable(false);
            $table->date('fecha_fin')->nullable(false);
            $table->string('documento',40)->nullable();
            $table->string('anio_periodo')->nullable();
            $table->string('comentario')->nullable();
            $table->string('usuario_creador')->nullable();
            $table->string('usuario_editor')->nullable();
            $table->string('ip_usuario')->nullable();
            $table->boolean('estado')->nullable()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}
