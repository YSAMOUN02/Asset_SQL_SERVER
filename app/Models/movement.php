<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movement extends Model
{
    use HasFactory;
    protected $table = 'assets_transaction';
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
        'ref_movement',
        'purpose',
        'status_recieved',
        'to_ref',
        // backend-only columns
        'status',
        'variant',
        'last_varaint',
        'deleted',
        'deleted_at',
    ];



    public function images()
    {
        return $this->hasMany(Image::class, 'asset_id', 'assets_id');
    }
    public function files()
    {
        return $this->hasMany(File::class, 'asset_id', 'assets_id');
    }

    public function movements()
    {
        return $this->hasMany(movement::class, 'assets_id', 'assets_id');
    }
}
