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
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   // 🔑 Foreign key to users

            $table->boolean('user_read')->default(0);
            $table->boolean('user_write')->default(0);
            $table->boolean('user_update')->default(0);
            $table->boolean('user_delete')->default(0);

            $table->boolean('assets_read')->default(0);
            $table->boolean('assets_write')->default(0);
            $table->boolean('assets_update')->default(0);
            $table->boolean('assets_delete')->default(0);

            $table->boolean('transfer_read')->default(0);
            $table->boolean('transfer_write')->default(0);
            $table->boolean('transfer_update')->default(0);
            $table->boolean('transfer_delete')->default(0);

            $table->boolean('quick_read')->default(0);
            $table->boolean('quick_write')->default(0);
            $table->boolean('quick_update')->default(0);
            $table->boolean('quick_delete')->default(0);

            $table->timestamps();

            // 🔗 Relationship with users

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
