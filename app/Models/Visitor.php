<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $table = 'visitors';

    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_code','code');
    }
}
