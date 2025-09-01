<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_variant extends Model
{
    use HasFactory;

    protected $table = 'assets_variant';
    protected $primaryKey = 'id';     // custom PK
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
         'assets_id',
        'reference',
        'assets1',
        'assets2',
        'fa_no',
        'item',
        'transaction_date',
        'initial_condition',
        'specification',
        'item_description',
        'asset_group',
        'remark_assets',

        'asset_holder',
        'holder_name',
        'position',
        'location',
        'department',
        'company',
        'remark_holder',

        'grn',
        'po',
        'pr',
        'dr',
        'dr_requested_by',
        'dr_date',
        'remark_internal_doc',

        // 🔹 ERP DATA
        'asset_code_account',
        'invoice_date',
        'invoice_no',
        'fa',
        'fa_class',
        'fa_subclass',
        'depreciation',
        'fa_type',
        'fa_location',
        'cost',
        'vat',
        'currency',
        'description',
        'invoice_description',
        'vendor',
        'vendor_name',
        'address',
        'address2',
        'contact',
        'phone',
        'email',

        // Movement
        'ref_movement',
        'purpose',
        'status_recieved',
        'to_ref',
        'old_code',

        // Backend state
        'status',
        'variant',
        'last_varaint',
        'deleted',
        'deleted_at'

    ];
    protected $casts = [
        'transaction_date' => 'date',
        'dr_date'          => 'date',
        'invoice_date'     => 'date',
        'deleted_at'       => 'date',

        'cost' => 'decimal:2',
        'vat'  => 'decimal:2',
    ];
    public $timestamps = true;  // so updated_at works
}
