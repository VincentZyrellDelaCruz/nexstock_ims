<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'description',
        'proof_image',
        'quantity_affected',
        'reported_by',
        'status',
        'action_taken',
        'reviewed_by'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}