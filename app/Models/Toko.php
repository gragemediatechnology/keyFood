<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'toko';

    // Primary key
    protected $primaryKey = 'id_toko';

    // Fillable fields
    protected $fillable = [
        'id_seller',
        'nama_toko',
        'alamat_toko',
        'foto_profile_toko',
    ];

    // Timestamps
    public $timestamps = true;

    // Relationship with User (Seller)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_seller', 'id');
    }

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'id_seller', 'id');
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Event: Handle the deletion process
    protected static function booted()
    {
        static::deleting(function ($store) {
            // Get the associated seller (user)
            $user = $store->user;

            if ($user) {
                // Remove the 'seller' role from the user
                if ($user->hasRole('seller')) {
                    $user->syncRoles([]); // Remove all roles or set to default role
                }

                // Delete all products associated with this user
                $user->products()->delete();
            }
        });
    }
}
