<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'reference_id',
        'created_by',
        'status',
        'message',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function defect()
    {
        return $this->belongsTo(Defect::class, 'reference_id')->where('type', 'defect');
    }

    public function restockConfirmation()
    {
        return $this->belongsTo(RestockConfirmation::class, 'reference_id')->where('type', 'restock');
    }

    public function reference()
    {
        if ($this->type === 'defect') {
            return $this->belongsTo(Defect::class, 'reference_id');
        } elseif ($this->type === 'restock') {
            return $this->belongsTo(RestockConfirmation::class, 'reference_id');
        }
        return null;
    }

    // Helper method to get the related model
    public function getReferenceAttribute()
    {
        if ($this->type === 'defect') {
            return Defect::with(['product', 'reporter', 'reviewer', 'supplier'])->find($this->reference_id);
        } elseif ($this->type === 'restock') {
            return RestockConfirmation::with(['product', 'warehouse', 'requester', 'supplier', 'reviewer'])->find($this->reference_id);
        }
        return null;
    }
}

