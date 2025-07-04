<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'product_name', 'amount', 'profit', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

