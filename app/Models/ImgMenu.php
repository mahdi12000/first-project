<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgMenu extends Model
{
    use HasFactory;
    protected $table='img_menus';
    protected $fillable=['link'];

    public function menus(){
        return $this->belongsTo(Menu::class);
    }
}
