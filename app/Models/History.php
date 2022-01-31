<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class History extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'History';
    protected $guarded = [];

    protected $dateFormat = 'Y-m-d H:i:s'; 
    protected $casts = [
        'date_entry' => 'datetime:Y-m-d H:i:s',
    ];
}
