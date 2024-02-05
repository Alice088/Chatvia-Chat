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
        Schema::create('users_to_chats', function (Blueprint $table) {
            $table->unsignedBigInteger("USER_ID")->index();
            $table->unsignedBigInteger("CHAT_ID")->index();

            $table
                ->foreign("USER_ID", "USER_ID_FK")
                ->on("users")
                ->references("ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign("CHAT_ID", "CHAT_ID_FK")
                ->on("chats")
                ->references("CHAT_ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_to_chats');
    }
};
