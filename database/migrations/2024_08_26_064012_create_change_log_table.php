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
        Schema::create('change_log', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // created, updated, deleted
            $table->unsignedBigInteger('record_id')->nullable();// assets_id or user_id
            $table->string('record_no')->nullable(); //asset no or user no
            $table->unsignedBigInteger('user_id')->nullable(); // Who did the action
            $table->string('change_by')->nullable()->after('action');
            $table->string('section')->nullable();
            $table->json('old_values')->nullable(); // Data before change
            $table->json('new_values')->nullable(); // Data after change
            $table->string('reason')->nullable(); // Optional: why change was made
            $table->timestamps(); // when it happened
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_log');
    }
};
