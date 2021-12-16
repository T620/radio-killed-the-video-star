<?php

namespace App\Http\Controllers\API\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DownloadedEpisode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use App\Models\Episode;

/**
 * generic stat controller for episode resource
 * will be filled out when I get the other half of the test done
 * (storing downloads)
 */
class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Measures how many times a episode of a podcast
     * has been downloaded over a given time period
     *
     * Tech test asks for last seven days so that's the default.
     *
     * @param Request $request
     * @param Episode $episode
     *
     * @return Repsonse
     *
     */
    public function downloads(Request $request, Episode $episode)
    {
        if ($episode->id === null) {
            abort(404);
        }

        // setup some defaults in case the user hasn't provided any
        // filter params
        $defaults = [
            'period' => 'days',
            'interval' => 7
        ];

        /**
         * Validation Rules:
         * period:
         *      must be one of 'daily', 'weekly' 'monthly' or 'yearly'
         * interval:
         *      must be a whole number between 1 and 365
         *
         * Both are optional since this is default
         * period: 'daily',
         * interval: 7
         */

        // lazily tack on any get params to the request body
        $request->merge(
            [
                'period' => $request->get('period'),
                'interval' => $request->get('interval')
            ]
        );

        // create a custom validator to make validaing our request
        // easier.
        $validator = Validator::make($request->all(), [
            'period' => [
                Rule::in(['daily', 'weekly', 'monthly', 'yearly']),
                'nullable'
            ],
            'interval' => ['digits_between:1,365', 'nullable']
        ]);


        // first up, perform some basic validation

        if ($validator->fails()) {
            return response(['error' => 'Invalid params'], 422);
        }

        $validated = $validator->validated();

        $period = $validated['period'] ?? $defaults['period'];
        $interval = $validated['interval'] ?? $defaults['interval'];


        /**
         * Now we can do the query, show your working: psuedomysql
         * Select * from downloaded_episodes
         * join podcast
         * where episode_id = $episode->id
         * and created_at within (interval, period)
         * aggregate by day
         */

        // todays date minus 7 days
        $ocurredAtDate = Carbon::now()->sub($interval, $period);

        // start with the basic query so we can count how many there are in total
        $downloadedEpisodes = DownloadedEpisode::with('podcast')
            ->where('episode_id', $episode->id)
            ->where('created_at', '>=', $ocurredAtDate)
            ->orderBy('created_at')
            ->get();

        $count = count($downloadedEpisodes);

        // continue the query by aggregating the data
        // by day of week. No need to sort
        $downloadedEpisodes = $downloadedEpisodes->groupBy(function($record) {

                // using the short english day of week
                // because it will be easier for frontend to create
                // chart labels (less text, more to fit in a smaller area)
                return Carbon::parse($record->created_at)
                    ->shortEnglishDayOfWeek;
            })->all();

        return response([
            'downloaded_episodes' => $downloadedEpisodes,
            'filter_period'       => $period,
            'filter_interval'     => $interval,
            'total_count'         => $count
        ]);
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
        //
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
