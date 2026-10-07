<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resenia_peliculas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreUsuario', 120);
            $table->text('comentario');
            $table->unsignedSmallInteger('puntaje');
            $table->foreignId('pelicula_id')->constrained('peliculas')->cascadeOnDelete();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenia_peliculas');
    }
};
