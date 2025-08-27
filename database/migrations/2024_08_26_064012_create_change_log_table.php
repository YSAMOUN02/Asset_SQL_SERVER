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
            $table->unsignedBigInteger('record_id')->nullable(); // assets_id or user_id
            $table->text('record_no')->nullable(); // asset no or user no, allow long text
            $table->unsignedBigInteger('user_id')->nullable(); // Who did the action
            $table->text('change_by')->nullable(); // allow long text
            $table->text('section')->nullable(); // allow long text
            $table->longText('old_values')->nullable(); // Data before change, now as long text
            $table->longText('new_values')->nullable(); // Data after change, now as long text
            $table->text('reason')->nullable(); // Optional: why change was made, allow long text
            $table->timestamps(); // when it happened
        });
    }

    /**
     * Reverse the migrations.
     * 
     */
    public function down(): void
    {
        Schema::dropIfExists('change_log');
    }
};
