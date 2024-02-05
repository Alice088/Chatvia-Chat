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
        Schema::create('chats', function (Blueprint $table) {
            $table->id("CHAT_ID");
            $table->string("TITLE", 50);
            $table->unsignedBigInteger("OWNER_ID_ONE");
            $table->unsignedBigInteger("OWNER_ID_TWO");

            $table
                ->foreign("OWNER_ID_ONE", "OWNER_ID_ONE_FK")
                ->on("users")
                ->references("ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign("OWNER_ID_TWO", "OWNER_ID_TWO_FK")
                ->references("ID")
                ->on("users")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
