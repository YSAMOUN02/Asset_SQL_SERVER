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
        
            $table->smallInteger('user_read');
            $table->smallInteger('user_write');
            $table->smallInteger('user_delete');
            $table->smallInteger('user_update');
            $table->smallInteger('assets_read');
            $table->smallInteger('assets_write');
            $table->smallInteger('assets_update');
            $table->smallInteger('assets_delete');

            $table->smallInteger('transfer_read');
            $table->smallInteger('transfer_write');
            $table->smallInteger('transfer_update');
            $table->smallInteger('transfer_delete');

            $table->smallInteger('quick_read');
            $table->smallInteger('quick_write');
            $table->smallInteger('quick_update');
            $table->smallInteger('quick_delete');
            $table->timestamps();
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
