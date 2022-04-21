<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    
    protected $hidden = [
        'items_id',       
    ];
    public $timestamps = false;
    
    public function item(){
       return $this->hasOne(Item::class, 'id', 'items_id');
    }

    
}
