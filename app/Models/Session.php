<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use Filterable;
    protected $fillable = [
        'film_id',
        'session_datetime',
        'cost',
    ];

    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\SessionFilter::class);
    }

    public function film(){
        return $this->belongsTo(Film::class);
    }
}
