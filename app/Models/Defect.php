<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    use HasFactory;

    // protected $table = 'defects';

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
}

