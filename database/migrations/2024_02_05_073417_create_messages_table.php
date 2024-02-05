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
        Schema::create('messages', function (Blueprint $table) {
            $table->unsignedBigInteger("FROM_CHAT_ID");
            $table->unsignedBigInteger("FROM_USER_ID");
            $table->bigInteger("PLACE_INDEX");
            $table->string("TEXT", 256)->nullable()->default("Message not found");
            $table->bigInteger("CREATED_AT");

            $table
                ->foreign("FROM_CHAT_ID", "FROM_CHAT_ID_FK")
                ->on("chats")
                ->references("CHAT_ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign("FROM_USER_ID", "FROM_USER_ID_FK")
                ->on("users")
                ->references("ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
