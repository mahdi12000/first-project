<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table='menu';
    protected $fillable=[
        'plat',
        'description',
        'main_image',
        'price',
        'currency'
    ];



    public function Restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function images(){
        return $this->hasMany(ImgMenu::class);
    }
}
