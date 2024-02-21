<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id("ID");
            $table->string("USERNAME", 20);
            $table->longText("PASSWORD");
            $table->string("EMAIL", 40);
            $table->string("REMEMBER_TOKEN",  1000)->unique('remember_token_unique')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
