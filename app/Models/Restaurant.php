<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Restaurant extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'restaurants';
    protected $guard='Restaurant';
    protected $provider = 'restaurants';
    protected $email = 'email'; 
    protected $password = 'password';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'numberPhone',
        'timeOpen',
        'timeClose',
        'small_Presentation',
        'mainPicture',
        'coins',
        'country',
        'city',
        'neighborhood',
        'other'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'code',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tables(){
        return $this->hasMany(Table::class,'id_Restaurant');
    }

    public function menus(){
        return $this->hasMany(Menu::class,'id_Restaurant');
    }
}
