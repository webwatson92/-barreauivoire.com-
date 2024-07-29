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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 191)->unique()->nullable();
            $table->string('matricule', 191)->unique()->nullable();
            $table->string('name');
            $table->string('prenom')->nullable();
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('date_naissance')->nullable();
            $table->string('sexe')->nullable();
            $table->string('telephone')->nullable();
            $table->string('lieu_structure')->nullable();
            $table->string('login');
            $table->string('role')->default('user');
            $table->string('date_prestation')->nullable();
            $table->string('expertise')->nullable();
            $table->integer('compte_reinitialise')->default(0);
            $table->integer('compte_valide')->default(0);
            $table->dateTime('password_change_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('two_factor_code')->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->string('pass')->default('monbarreau');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 100)->primary();
            $table->string('token', 200);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};