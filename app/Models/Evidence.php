<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    /** @use HasFactory<\Database\Factories\EvidenceFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'overwork_id',
    ];

    public function overwork()
    {
        return $this->belongsTo(Overwork::class);
    }
}
