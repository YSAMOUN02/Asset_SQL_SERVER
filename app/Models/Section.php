<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Division;
use App\Models\Group;
class Section extends Model
{
    use HasFactory;


    protected $table = 'section';
    protected $fillable = ['division_id', 'code', 'name'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
