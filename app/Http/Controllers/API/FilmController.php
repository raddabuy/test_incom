<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Requests\FilmCreateRequest;
use App\Http\Resources\AdminResources\FilmAdminResource;
use App\Models\Film;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FilmController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Film::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $films = Film::filter($request->all())->offset($request->offset ?? 0)->limit($request->limit ?? 20)->get();

        if ($request->has('withSessions')) {
            $films->load('sessions');
        }

        return FilmAdminResource::collection($films);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FilmCreateRequest $request
     * @return FilmAdminResource
     */
    public function store(FilmCreateRequest $request)
    {
        $film = Film::create($request->all());

        if($request->hasFile('image')){
            $film->addMediaFromRequest('image')->toMediaCollection('film_image');
        }
        return new FilmAdminResource($film);
    }

    /**
     * Display the specified resource.
     *
     * @param Film $film
     * @return FilmAdminResource
     */
    public function show(Request $request, Film $film)
    {
        if ($request->has('withSessions')) {
            $film->load('sessions');
        }

        return new FilmAdminResource($film);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Film $film
     * @return FilmAdminResource
     */
    public function update(Request $request, Film $film)
    {
        $film->update($request->all());
        return new FilmAdminResource($film);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Film $film
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return response()->json('ok', 204);
    }

    /**
     * Adds media to the film.
     *
     * @param Request $request The request object.
     * @param Film $film The film object.
     * @return FilmAdminResource The film admin resource.
     */
    public function addMedia(Request $request,Film $film)
    {
        if($request->hasFile('image')){
            $film->addMediaFromRequest('image')->toMediaCollection('film_image');
        }

        return new FilmAdminResource($film);
    }

    /**
     * Deletes a media from a film.
     *
     * @param Request $request The HTTP request object.
     * @param Film $film The film from which the media will be deleted.
     * @param Media $media The media to be deleted.
     * @return FilmAdminResource The updated film resource.
     */
    public function deleteMedia(Request $request,Film $film, Media $media)
    {
        $media->delete();

        return new FilmAdminResource($film);
    }
}
