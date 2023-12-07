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
            $table->string('nom');
            $table->string('telephone');
            $table->string('photo_profil');
            $table->integer('nombre_annee_experience');
            $table->integer('nombre_mentores')->default(0);
            $table->string('role')->default('mentor');
            $table->boolean('est_archive')->default(false);
            $table->string('email');
            $table->string('password');
            $table->unsignedBigInteger('article_id');
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
