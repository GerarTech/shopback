<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VIPLevel extends Model
{
    protected $table = 'vip_levels'; // ✅ Add this line to fix the table name

    protected $fillable = ['name', 'min_investment', 'profit_rate', 'max_tasks'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
