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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumb()
    {
        return $this->hasMany(ProductImage::class)->where('thumbs', 1);
    }

    public function getThumb()
    {
        $thumbs = $this->thumb;
        if(isset($thumbs[0])) {
            return $thumbs[0]->path;
        }
        return false;
    }

    public function getQuantity()
    {
        $quantity = str_replace('>', '', $this->quantity);
        $quantity = str_replace('<', '', $quantity);
        return (int) $quantity;
    }
}
