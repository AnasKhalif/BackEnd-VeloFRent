<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function motorcycles()
    {
        return $this->hasMany(Motorcycle::class);
    }
}
