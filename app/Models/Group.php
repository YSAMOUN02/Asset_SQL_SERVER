<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section; 
class Group extends Model
{
    use HasFactory;

        protected $table = 'group';
    protected $fillable = ['section_id', 'code', 'name'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
