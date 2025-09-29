<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overwork extends Model
{
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function evidance()
    {
        return $this->hasMany(Evidance::class);
    }
}
