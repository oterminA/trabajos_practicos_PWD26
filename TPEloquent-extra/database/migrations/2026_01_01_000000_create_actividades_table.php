<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) { //estos son los datos que tienen que llenarse con las migratios
            $table->id();
            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedInteger('cupo');
            $table->decimal('precio', 10, 2)->default(0);
            $table->string('imagen')->nullable();
            $table->enum('estado', ['ACTIVA', 'CANCELADA', 'FINALIZADA'])->default('ACTIVA');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');

    }
};
