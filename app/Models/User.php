<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'no_hp',
        'role',
        'no_ktp',
        'no_rm',
        'poli_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function pasiens(): HasMany
    {
        return $this->hasMany(Periksa::class, 'id_pasien');
    }
    public function dokters(): HasMany
    {
        return $this->hasMany(Periksa::class, 'id_dokter');
    }

    // ONE TO MANY
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    // GNEERATED FOORMATING NO REKAM MEDIS
    public static function generateNoRmFromId($id)
    {
        $now = now();
        $prefix = $now->format('Ym');
        return $prefix . '-' . $id;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->no_rm = self::generateNoRmFromId($user->id);
            $user->save();
        });
    }
}
