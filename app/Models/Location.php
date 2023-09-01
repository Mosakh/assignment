<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';

    public function shop()
    {
        return $this->belongsTo(Shop::class,'location','id');
    }
}
