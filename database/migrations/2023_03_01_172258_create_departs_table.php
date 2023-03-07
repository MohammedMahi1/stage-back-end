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
        Schema::create('departs', function (Blueprint $table) {
            $table->id('numero');
            $table->date('date_de_fichier');
            $table->string('objectif');
            $table->string('expediteur');
            $table->string('type_de_class');
            $table->string('interet');
            $table->string('employere');
            $table->string('type_de_courier');
            $table->date('date_de_commission');
            $table->date('date_specifiee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departs');
    }
};
