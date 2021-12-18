<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';


    // TODO: once they're built

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    // public function events(): HasMany
    // {
    //     return $this->hasMany(Event::class);
    // }
}
