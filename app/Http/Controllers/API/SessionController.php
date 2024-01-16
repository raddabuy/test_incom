<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionCreateRequest;
use App\Http\Requests\SessionUpdateRequest;
use App\Http\Resources\AdminResources\SessionAdminResource;
use App\Models\Film;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Session::class);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request){
        $sessions = Session::filter($request->all())->orderBy('session_datetime','ASC')->offset($request->offset ?? 0)->limit($request->limit ?? 20)->get();

        if ($request->has('withFilm')) {
            $sessions->load('film');
        }
        return SessionAdminResource::collection($sessions);
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param Session $session
     * @return SessionAdminResource
     */
    public function show(Request $request, Session $session){

        if ($request->has('withFilm')) {
            $session->load('film');
        }
        return new SessionAdminResource($session);
    }

    /**
     *  Store a newly created resource in storage.
     * @param SessionCreateRequest $request
     * @return SessionAdminResource
     */
    public function store(SessionCreateRequest $request){

        $sessionDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->session_datetime);

        $from = $sessionDatetime->subMinutes(29)->format('Y-m-d H:i:s');
        $to = $sessionDatetime->addMinutes(29)->format('Y-m-d H:i:s');

        abort_if(Session::whereBetween('session_datetime', [$from, $to])
            ->where('film_id', $request->film_id)
            ->exists(),
            400,
            'Session datetime is too close to existing sessions');

        $session = Session::create($request->all());
        return new SessionAdminResource($session);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SessionUpdateRequest $request
     * @param Session $session
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SessionUpdateRequest $request, Session $session){
        $session->update($request->all());
        return response()->json($session);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Session $session
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Session $session){
        $session->delete();
        return response()->json(null, 204);
    }

    /**
     *  Display a listing of the resource in public route.
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function publicIndex(Request $request)
    {
        $sessions = Session::orderBy('session_datetime','ASC')->filter($request->all())->get();

        if ($request->has('withFilm')) {
            $sessions->load('film');
        }
        return SessionAdminResource::collection($sessions);
    }


}
