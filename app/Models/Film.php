<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Film extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Filterable;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'age_limit',
    ];

    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\FilmFilter::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
