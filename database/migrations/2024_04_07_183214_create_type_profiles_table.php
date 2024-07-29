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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string("libelle", 100)->nullable();
            $table->boolean("statut")->default(0);
            $table->longText("route")->nullable();
            $table->string("prenom", 100)->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('sexe', 1)->nullable()->nullable();
            $table->string('telephone')->nullable();
            $table->string('lieu_structure', 100)->nullable();
            $table->string('login', 100);
            // $table->string('role')->default('user');
            $table->string('date_prestation', 100)->nullable();
            $table->string('expertise', 100)->nullable();
            $table->foreignId('etat_qualificatif_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('profils');
    }
};
