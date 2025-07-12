<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Baris ini mungkin perlu di-uncomment jika Anda menggunakan fitur verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Pastikan ini ada jika Anda menggunakan Spatie Permissions

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Pastikan HasRoles ada jika Anda menggunakannya

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'address', // BARU: Tambahkan 'address' di sini
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     * Digunakan untuk menetapkan peran 'buyer' secara otomatis saat user baru dibuat.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->assignRole('buyer');
        });
    }

    /**
     * Definisikan relasi one-to-many dengan model Order.
     * Seorang user bisa memiliki banyak order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}