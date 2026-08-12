<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'close_date',
        'type',
        'status',
        'total',
        'user',
        'payload',
        'attempts',
        'message',
        'sync',
    ];

    protected $casts = [
        'close_date' => 'date',
        'payload' => 'array',
        'sync' => 'boolean',
        'total' => 'decimal:3',
    ];
}
