<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPlace extends Model
{
    use HasFactory;

    protected $table = 'marketplaces';

    protected $fillable = [
        'name', 'logo'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
