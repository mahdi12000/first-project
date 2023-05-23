<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $table='tables';
    protected $fillable=['placeNumber'];
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'id_Restaurant');
    }
}
