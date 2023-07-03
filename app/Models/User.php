<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Fortify\Features;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'pictureLink',
        'cardNumber',
        'city',
        'country',
        'neighborhood',
        'building',
        'apartment',
        'other_specif',
        'code',
        'usertype',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'cardNumber',
        'code',
        'active',
        'usertype'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function Commande()
    {
        return $this->hasMany(Commande::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function updateProfilePhoto($photo)
    {
        $filename = $photo->storePublicly(
            'images', // dossier de stockage des photos de profil
            ['disk' => 'public'] // stockage sur le disque "public"
        );
        

        $this->forceFill([
            'pictureLink' => "storage/".$filename,
        ])->save();
    }
}
