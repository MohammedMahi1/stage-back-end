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
        Schema::create('arrivers', function (Blueprint $table) {
            $table->id('numero');
            $table->date('date_de_fichier')->nullable(null);
            $table->string('objectif');
            $table->string('expediteur');
            $table->string('destinataire');
            $table->string('interet');
            $table->string('employere');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrivers');
    }
};
