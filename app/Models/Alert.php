<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'related_type', // 'product', 'inventory', 'defect', 'restock'
        'related_id',
        'severity', // 'low', 'medium', 'high', 'critical'
        'status', // 'unread', 'read', 'resolved'
        'user_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

