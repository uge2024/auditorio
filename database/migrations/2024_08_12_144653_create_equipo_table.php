<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoTable extends Migration
{

        public function up()
        {
            Schema::create('equipo', function (Blueprint $table) {
                $table->id('id_equipo'); // Primary key
                $table->string('nombre');
                $table->string('codigo');
                $table->string('imagen')->nullable();
                $table->string('descripcion')->nullable();
                $table->foreignId('id_auditorio')->constrained('auditorio', 'id_auditorio')->onDelete('cascade');

                $table->timestamps();
            });
        }


    public function down()
    {
        Schema::dropIfExists('equipo');
    }
}
