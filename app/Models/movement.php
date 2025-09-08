<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movement extends Model
{
    use HasFactory;
    protected $table = 'assets_transaction'; // your table name
    protected $primaryKey = 'assets_id';     // custom PK
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
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
        'transaction_date' => 'datetime',
        'dr_date'          => 'datetime',
        'invoice_date'     => 'datetime',

        'cost' => 'decimal:2',
        'vat'  => 'decimal:2',
    ];

    public $timestamps = true;  // so updated_at works

    public function images()
    {
        return $this->hasMany(Image::class, 'asset_id', 'assets_id');
    }
    public function files()
    {
        return $this->hasMany(File::class, 'asset_id', 'assets_id');
    }

    public function assets_variant()
    {
        return $this->hasMany(Asset_variant::class, 'assets_id', 'assets_id');
    }
}
