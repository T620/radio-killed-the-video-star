<?php

namespace App\Http\Controllers\API;

use App\Events\EpisodeDownloadedEvent;
use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['episodes' => Episode::with('podcast')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Use eager loads when we have some models
        $episode = Episode::with(['podcast'])->findOrFail($id);

        return response(['episode' => $episode]);
    }

    /**
     * Provides the user with a download_url to download the episode
     *
     * Stores a downloaded_episodes record too
     */
    public function download($id)
    {
        // Use eager loads when we have some models
        $episode = Episode::with(['podcast'])->findOrFail($id);

        /*
            dispatch the event. Post-processing will be handled
            by the listener and job.
            we do this bc we need to return the response to the user
            quickly, so push any work that can wait to a queue to
            be handled on a seperate process (in this case, redis)
        */
        EpisodeDownloadedEvent::dispatch($episode);

        // if we had more time, imagine there's some sort of S3 bucket interaction here instead of a pre-generated URL.
        return response([
            'download_link' => $episode->downloadLink()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
