<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true); // Cambia 'increments' por 'unsignedBigInteger'
            $table->string('ci')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('unidad')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('tipo_usuario', ['admin', 'user'])->default('user');
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
