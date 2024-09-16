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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            // Asset Info
            $table->bigInteger('assets_id');
            $table->string('varaint')->default(0);
            $table->string('document')->nullable(); // ref
            $table->string('assets1'); // asset_code1
            $table->string('assets2'); // asset_code2
            $table->string('fa_no')->nullable(); // fa_no
            $table->string('item')->nullable(); // item
            $table->date('issue_date')->nullable(); // issue_date
            $table->string('initial_condition')->nullable(); // initial_condition
            $table->string('specification')->nullable(); // specification
            $table->string('item_description')->nullable(); // item_description
            $table->string('asset_group')->nullable(); // asset_group
            $table->string('remark_assets')->nullable(); // remark_assets

            //  Asset  Holder
            $table->string('asset_holder')->nullable(); // asset_holder
            $table->string('holder_name')->nullable(); // holder_name
            $table->string('position')->nullable(); // position
            $table->string('location')->nullable(); // department
            $table->string('department')->nullable(); // department
            $table->string('company')->nullable(); // company  
            $table->string('remark_holder')->nullable(); // company 

            // Internal Document
            $table->string('grn')->nullable(); // grn
            $table->string('po')->nullable(); // po
            $table->string('pr')->nullable(); // pr
            $table->string('dr')->nullable(); // dr
            $table->string('dr_requested_by')->nullable(); // dr_requested_by
            $table->date('dr_date')->nullable(); // dr_date
            $table->string('remark_internal_doc')->nullable(); // remark_internal_doc



            // ERP Invoice
            $table->string('asset_code_account')->nullable(); // asset_code_account
            $table->date('invoice_date')->nullable(); // invoice_posting_date
            $table->string('invoice_no')->nullable(); // invoice
            $table->string('fa')->nullable(); // fa
            $table->string('fa_class')->nullable(); // fa_class
            $table->string('fa_subclass')->nullable(); // fa_subclass
            $table->string('depreciation')->nullable(); // depreciation_book_code
            $table->string('fa_type')->nullable(); // fa_type
            $table->string('fa_location')->nullable(); // fa_location
            $table->decimal('cost', 10, 2)->nullable(); // cost
            $table->string('currency')->nullable(); // currency
            $table->string('vat')->nullable(); // vat
            $table->longText('description')->nullable(); // description
            $table->longText('invoice_description')->nullable(); // invoice_description

            // Vendor 
            $table->string('vendor')->nullable(); // vendor
            $table->string('vendor_name')->nullable(); // vendor_name
            $table->string('address')->nullable(); // address
            $table->string('address2')->nullable(); // address2
            $table->string('contact')->nullable(); // contact
            $table->string('phone')->nullable(); // phone
            $table->string('email')->nullable(); // email

            // State  Asset
            $table->date('deleted_at')->nullable();
            $table->integer('deleted')->default(0); // Delete Status
            $table->string('last_varaint')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
