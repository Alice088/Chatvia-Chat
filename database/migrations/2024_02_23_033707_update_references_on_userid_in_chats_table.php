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
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign("OWNER_ID_ONE_FK");
            $table->dropForeign("OWNER_ID_TWO_FK");

            $table
                ->foreign("OWNER_ID_ONE", "OWNER_ID_ONE_FK")
                ->on("users")
                ->references("USER_ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign("OWNER_ID_TWO", "OWNER_ID_TWO_FK")
                ->on("users")
                ->references("USER_ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign("OWNER_ID_ONE_FK");
            $table->dropForeign("OWNER_ID_TWO_FK");

            $table
                ->foreign("OWNER_ID_ONE", "OWNER_ID_ONE_FK")
                ->on("users")
                ->references("ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign("OWNER_ID_TWO", "OWNER_ID_TWO_FK")
                ->on("users")
                ->references("ID")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
