<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        // 'email',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'img',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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
            // 'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship with Toko
    public function toko()
    {
        return $this->hasOne(Toko::class, 'id_seller', 'id');
    }

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'id_seller', 'id');
    }

    // Event: Handle the deletion process
    protected static function booted()
    {
        static::deleting(function ($user) {
            // Check if the user has the 'seller' role
            if ($user->hasRole('seller')) {
                // Delete related products and toko
                $user->products()->delete();
                $user->toko()->delete();
                
                // Optionally, reset the user's roles
                $user->syncRoles([]); // Remove all roles or assign a default role if necessary
            }
        });
    }
}
