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
        Schema::create('mentors', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('metiers_id');
            $table->string('nom');
            $table->string('telephone');
            $table->string('email');
            $table->string('niveau_experience');
            $table->integer('nombre_mentores')->default(0);
            $table->string('specialite');
            $table->string('password');
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};
