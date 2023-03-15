<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'article', 'name', 'full_name', 'brand', 'sort', 'price1', 'price2', 'price', 'quantity', 'isnew',
        'ishit', 'ispromo', 'article_pn', 'active', 'description'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
