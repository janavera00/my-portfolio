<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    use HasFactory;

    public function technologies(){
        return $this->belongsToMany(technology::class);
    }

    public function screenshots(){
        return $this->hasMany(screenshot::class);
    }
}
