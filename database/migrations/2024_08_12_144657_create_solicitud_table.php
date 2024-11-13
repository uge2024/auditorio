<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTable extends Migration
{
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id('id_solicitud');
            $table->foreignId('id_usuario')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('id_auditorio')->constrained('auditorio', 'id_auditorio')->onDelete('cascade');
            $table->date('fecha_uso');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('actividad', 255);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'finalizada', 'cancelado'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}