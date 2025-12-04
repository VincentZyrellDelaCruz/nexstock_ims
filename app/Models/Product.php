<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'category_id', 'description', 'price', 'status'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function defects()
    {
        return $this->hasMany(Defect::class);
    }

    public function restockConfirmations()
    {
        return $this->hasMany(RestockConfirmation::class);
    }
}
