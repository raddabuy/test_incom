<?php

Route::namespace('API')->group(
    function () {
        Route::post('/login', 'UserController@login')->name('login');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::post('logout', 'UserController@logout')->name('logout');
            Route::get('test', 'UserController@test');

            Route::resource('films', 'FilmController')->except(['create', 'edit']);
            Route::post('films/{film}/add_media', 'FilmController@addMedia');
            Route::post('films/{film}/delete_media/{media}', 'FilmController@deleteMedia');

            Route::resource('sessions', 'SessionController')->except(['create', 'edit']);

        });
    });




