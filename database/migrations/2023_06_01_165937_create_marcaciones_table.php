<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcaciones', function (Blueprint $table) {
            $table->id();
            $table->string('usr_identi');
            $table->string('usr_clave');
            $table->integer('usr_estado');
            $table->string('usr_fecha_hora');
            $table->foreignId('mrcd_id')->constrained('marcadores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcaciones');
    }
}
