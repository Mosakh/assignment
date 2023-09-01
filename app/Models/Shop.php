<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $teble  = 'shops';

    public function locations()
    {
        return $this->hasOne(Location::class,'id','location');
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class,'shop_code','code');
    }
}
