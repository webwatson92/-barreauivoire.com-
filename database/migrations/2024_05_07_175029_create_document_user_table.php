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
        Schema::create('document_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignUuid('user_id_2')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');//experideur c'est l'utilisateur qui envoi donc user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_user');
    }
};
