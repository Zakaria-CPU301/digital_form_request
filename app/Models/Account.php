<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function overwork() {
        return $this->hasMany(Overwork::class);
    }

    public function leave() {
        return $this->hasMany(Leave::class);
    }
}
