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
        Schema::create('movement', function (Blueprint $table) {
            $table->id();

            $table->string('movement_no');
            $table->date('movement_date')->nullable();
            $table->string('reference')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_department')->nullable();
            $table->string('from_location')->nullable();
            $table->string('given_by')->nullable();
            $table->string('from_remark')->nullable();
            $table->string('to_name')->nullable();
            $table->string('to_department')->nullable();
            $table->string('to_location')->nullable();
            $table->string('received_by')->nullable();
            $table->date('received_date')->nullable();
            $table->longText('condition')->nullable();
            $table->longText('purpose')->nullable();
            $table->string('verify_by')->nullable();
            $table->string('authorized_by')->nullable();
            $table->string('assets_id');
            $table->string('assets_no');
            $table->string('varaint');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement');
    }
};
