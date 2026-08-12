<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
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
        'payload' => 'array',
        'sync' => 'boolean',
        'total' => 'decimal:3',
    ];
}
