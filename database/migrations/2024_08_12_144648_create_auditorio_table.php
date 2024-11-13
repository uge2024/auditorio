<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditorioTable extends Migration
{
    public function up()
    {
        Schema::create('auditorio', function (Blueprint $table) {
            $table->id('id_auditorio');
            $table->string('nombre');
            $table->string('ubicacion')->nullable();
            $table->string('imagen')->nullable();
            $table->integer('capacidad');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditorio');
    }
}
