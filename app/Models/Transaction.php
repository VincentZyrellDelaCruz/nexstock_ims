<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // include `date` in fillable so mass assignment (e.g. Transaction::create($request->all()))
    // will correctly insert the `date` column into DB
    protected $fillable = ['product_id','quantity','type','date','status'];
    // cast `date` to a date instance so Eloquent handles conversions
    protected $casts = [
        'date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

