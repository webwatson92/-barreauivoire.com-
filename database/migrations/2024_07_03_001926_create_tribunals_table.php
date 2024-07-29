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
        Schema::create('tribunals', function (Blueprint $table) {
            $table->id();
            $table->string('nom_tribunal', 100);
            // $table->foreignId('ville_id')
            //     ->constrained()
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tribunals');
    }
};
