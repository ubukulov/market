<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMarketCategoryMargin extends Model
{
    use HasFactory;

    protected $table = 'user_market_category_margins';

    protected $fillable = [
        'user_id', 'category_id', 'marketplace_id', 'margin'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function marketplace()
    {
        return $this->belongsTo(MarketPlace::class);
    }
}
