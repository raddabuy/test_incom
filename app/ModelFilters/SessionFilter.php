<?php

namespace App\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class SessionFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function film($value)
    {
        if ($value) {
            return $this->where('film_id',(int)$value);
        }
    }

    public function date($value)
    {
        if ($value) {
            $date = \Illuminate\Support\Carbon::parse($value)->format('Y-m-d');
            return $this->whereDate('session_datetime',$date);
        }
    }


}
