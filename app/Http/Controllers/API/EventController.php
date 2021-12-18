<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Response;

use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    /**
     * Lists all the events we have
     *
     * @return Response
     */
    public function index(): Response
    {
        $events = Event::all();

        return response(['events' => EventResource::collection(Event::all())]);
    }
}
