<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    protected $hidden = [
        'types_id',
        'units_id'       
    ];

    public $timestamps = false;
    const CREATED_AT = 'date_entry';
    const UPDATED_AT = 'date_out';

    public function type() {
        return $this->hasOne(Type::class, 'id', 'types_id');
    }

    public function unit() {
        return $this->hasOne(Unit::class, 'id', 'units_id');
    }

    public function histories() {
        return $this->hasMany(History::class, 'items_id', 'id');
    }
}
