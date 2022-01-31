<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'bahan_baku';
    protected $guarded = [];

    const CREATED_AT = 'date_entry';
    const UPDATED_AT = 'date_out';
}
