<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class screenshot extends Model
{
    use HasFactory;

    public function work(){
        return $this->belongsTo(work::class);
    }
}
