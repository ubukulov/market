<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'category_id', 'article', 'name', 'slug', 'full_name', 'brand', 'sort', 'price1', 'price2', 'price', 'quantity', 'isnew',
        'ishit', 'ispromo', 'article_pn', 'active', 'description'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

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
    }

    public function getQuantity()
    {
        $quantity = str_replace('>', '', $this->quantity);
        $quantity = str_replace('<', '', $quantity);
        return (int) $quantity;
    }

    public function getRelatedProducts()
    {
        //$products = Product::where(['category_id' => $this->category_id, ''])
    }

    public function getPriceFormatter($price)
    {
        return number_format($price, 0, ',', ' ');
    }

    public function getLink()
    {
        return route('product.page', ['slug' => $this->slug]);
    }
}
