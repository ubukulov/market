<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMarketplaceSetting extends Model
{
    use HasFactory;

    protected $table = 'user_marketplace_settings';

    protected $fillable = [
        'user_id', 'marketplace_id', 'client_id', 'client_secret', 'api', 'access_token', 'refresh_token', 'token_type',
        'expires_date'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function marketplace()
    {
        return $this->belongsTo(MarketPlace::class);
    }
}
