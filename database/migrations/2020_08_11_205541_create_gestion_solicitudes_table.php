<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateGestionSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuidTicket');
            $table->bigInteger('id_solicitud');
            $table->bigInteger('id_trabajador');
            $table->bigInteger('id_supervisor');
            $table->time('horaInicio');
            $table->time('horaCambiada')->nullable();
            $table->time('horaTermino');
            $table->date('fechaInicio');
            $table->date('fechaCambiada')->nullable();
            $table->date('fechaTermino');
            $table->bigInteger('diasEjecucion');
            $table->bigInteger('horasEjecucion');
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
        Schema::dropIfExists('gestion_solicitudes');
    }
}
