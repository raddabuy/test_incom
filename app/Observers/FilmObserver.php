<?php

namespace App\Observers;

use App\Models\Film;

class FilmObserver
{
    /**
     * Handle the Film "deleting" event.
     *
     * @param  \App\Models\Film  $film
     * @return void
     */
    public function deleting(Film $film)
    {
        $film->sessions()->delete();

        if ($film->getMedia('film_image')->count() > 0) {
            $film->getMedia('film_image')->each(
                function ($media) {
                    $media->delete();
                }
            );
        }
    }
}
