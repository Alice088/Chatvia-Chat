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
            $table->longText("SALT");
            $table->longText("REMEMBER_TOKEN")->unique();
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