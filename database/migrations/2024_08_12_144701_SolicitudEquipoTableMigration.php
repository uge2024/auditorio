<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SolicitudEquipoTableMigration extends Migration
{
    public function up()
    {
        Schema::create('solicitud_equipo', function (Blueprint $table) {
            $table->id('id_solicitud_equipo');
            $table->foreignId('id_solicitud')->constrained('solicitud', 'id_solicitud')->onDelete('cascade');
            $table->foreignId('id_equipo')->constrained('equipo', 'id_equipo')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'asignado', 'devuelto'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_equipo');
    }
}
