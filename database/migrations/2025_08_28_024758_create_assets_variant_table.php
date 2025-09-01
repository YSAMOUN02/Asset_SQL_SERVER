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
        Schema::create('assets_variant', function (Blueprint $table) {
            $table->id();
               // ASSET INFO
            $table->string('assets_id'); // primary key
            $table->string('reference')->nullable();
            $table->string('assets1');
            $table->string('assets2')->nullable();

            $table->string('fa_no')->nullable();
            $table->string('item')->nullable();
            $table->date('transaction_date')->nullable()->default('1990-01-01');
            $table->string('initial_condition')->nullable();
            $table->string('specification')->nullable();
            $table->text('item_description')->nullable();
            $table->string('asset_group')->nullable();
            $table->text('remark_assets')->nullable();

            // HOLDER INFO
            $table->string('asset_holder')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('position')->nullable();
            $table->string('location')->nullable();
            $table->string('department')->nullable();
            $table->string('company')->nullable();
            $table->text('remark_holder')->nullable();

            // INTERNAL DOC INFO
            $table->string('grn')->nullable();
            $table->string('po')->nullable();
            $table->string('pr')->nullable();
            $table->string('dr')->nullable();
            $table->string('dr_requested_by')->nullable();
            $table->date('dr_date')->nullable()->default('1990-01-01');
            $table->text('remark_internal_doc')->nullable();

            // ERP DATA
            $table->string('asset_code_account')->nullable();
            $table->date('invoice_date')->nullable()->default('1990-01-01');
            $table->string('invoice_no')->nullable();
            $table->string('fa')->nullable();
            $table->string('fa_class')->nullable();
            $table->string('fa_subclass')->nullable();
            $table->string('depreciation')->nullable();
            $table->string('fa_type')->nullable();
            $table->string('fa_location')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->text('description')->nullable();
            $table->text('invoice_description')->nullable();
            $table->string('vendor')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // MOVEMENT INFO
            $table->string('ref_movement')->nullable();
            $table->text('purpose')->nullable();
            $table->string('status_recieved')->nullable();
            $table->string('to_ref')->nullable();
            $table->string('old_code')->nullable();

            // BACKEND STATE
            $table->tinyInteger('status')->default(1);
            $table->integer('variant')->default(0);
            $table->integer('last_varaint')->default(0);
            $table->tinyInteger('deleted')->default(0);
            $table->date('deleted_at')->nullable()->default('1990-01-01');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_variant');
    }
};
