<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements UserInterface
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'is_admin' => false,
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
    public function isCustomer(): bool
    {
        return !$this->is_admin;
    }

    public function rentBooks()
    {
        return $this->belongsToMany(Book::class, 'rent_details', 'user_id', 'book_id')->withTimestamps();
    }
    public function purchaseBooks()
    {
        return $this->belongsToMany(Book::class, 'purchase_details', 'user_id', 'book_id')->withTimestamps();
    }
}
