<?php
//esta es la migración de la tabla pivote entre actores y película
//para esta relacion NO necesito crear un modelo y un control
//los conecto usando belongsToMany en los modelos de actor y pelicula
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
        Schema::create('actor_pelicula', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelicula_id')->constrained('peliculas')->cascadeOnDelete(); //ESTO LO NECESITO PARA RELACIONAR LAS TABLAS
            $table->foreignId('actor_id')->constrained('actors')->cascadeOnDelete(); //ESTO LO NECESITO PARA RELACIONAR LAS TABLAS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_pelicula');
    }
};
