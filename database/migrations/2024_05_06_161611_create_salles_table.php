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
        Schema::create('salles', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('nom');
            $table->longText('description');
            $table->string('capacite');
            $table->string('lieu');
            $table->string('disponiblite')->default('oui');
            $table->double('cout');
            $table->foreignId('etat_qualificatif_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');//pour savoir si la salle est occupé ou pas 
            $table->foreignUuid('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};
