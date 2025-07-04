<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\VIPLevel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $fillable = [
        'username',
        'phone_number',
        'password',
        'withdrawal_password',
        'invitation_code',
        'referrer_id',
        'language',
        'vip_level_id',
        'balance',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'withdrawal_password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Who invited this user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // Who this user has referred
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function vipLevel()
    {
        return $this->belongsTo(VIPLevel::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }



}
