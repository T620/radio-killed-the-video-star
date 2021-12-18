# Hello

This is a tech test for radio.co. The task is to create an API which does the following:

## Intro

-   List the number of downloads for a given `episode` resource, for the last seven days, aggregated by day of week.
-   Download a `episode` resource (using a mechanism of my choosing).
-   Use a moden techstack/framework.
-   The `episode_downloads` resource should have at a minimum:
    -   An Event relation
    -   A Podcast relation
    -   A Episode relation
    -   an `occurred_at` field which uses the ISO8601 date format
    -   relations use foriegn keys and must use UUID types (not ints)
-   Makes use of some tests

## Background/Tech

I'm using laravel as an API. All of the controllers are API namespaced and versioned. Meaning, all requests to the data start with `api/v1/`.
There is a 'front-end', only because I've forgotton to remove the web endpoints.
There's no session management or authentication because it was outside the scope of the task but laravel supports this and is easily implementable with packages like Breeze.
I didn't have time to dockerise the application and everything I needed to run on my machine I had installed already so it was really quick for me to setup.

The applications deployed to: https://radio.tangosixtwenty.dev. I used Deployer to deploy it, cerbot for a SSL cert (needed to run any web application on a .dev domain), nginx as the webserver and mysql to persist the data.

## Things I missed/did poorly

I really struggled with the `Events` resource. I could not figure out a way to link an event to any resource with the exception of `Playlists`.
The requirement to store the event UUID in the `episode_downloads` table has been met to an extent but not fully since I wasn't sure how the relations were supposed to work. In my opinion, this should either have been clearer in the task spec, or omitted entirely.

The tests suck, nothing works well in the test environment. I struggled to get data to create and persist, and the event and listener just did not play ball at all.

Everything works (except the events stuff) in the endpoints themselves.

If I had a bit more time, I would've used Sail to dockerise the application, spent a bit more time on the tests and added user authentication. I also would have added the 'Playlists' endpoint that you can see in Radio.co's University area in the site. The resource in general looks quite fun to build. I would also have liked to have implemented `raml` as a means of endpoint specification.

## Setup

1. Clone the repo
2. Install everything if you don't already have it:

-   php-mysql, php-zip, php-redis, redis, mysql_server and composer.

3. Create a mysql database, `radio_api` with a user of your choice.
4. Copy `env.example` to `.env` (`cat .env.example > .env`).
5. Specify the database username and password in your `.env` file.
6. `php artisan migrate && php db:seed` to get some data.
7. `php artisan serve` to spin up the dev server.
8. Access any of the endpoints below for some example data.

## Endpoints

I draw your attention to the task specific endpoints.

1. To 'download' an episode:
   `api/v1/episodes/{id}/download`

2. To retrieve stats for a downloaded episode:
   `api/v1/analytics/episodes/{episode}/downloads` (where `episode` is an `episode id`)

I also created some other small endpoints just to beef it up a bit:

```bash
+--------+----------+-----------------------------------------------+------+----------------------------------------------------------------+------------+
| Domain | Method   | URI                                           | Name | Action                                                         | Middleware |
+--------+----------+-----------------------------------------------+------+----------------------------------------------------------------+------------+
|        | GET|HEAD | /                                             |      | Closure                                                        | web        |
|        | GET|HEAD | api/v1/analytics/episodes/{episode}/downloads |      | App\Http\Controllers\API\Analytics\EpisodeController@downloads | api        |
|        | GET|HEAD | api/v1/episodes                               |      | App\Http\Controllers\API\EpisodeController@index               | api        |
|        | GET|HEAD | api/v1/episodes/{id}                          |      | App\Http\Controllers\API\EpisodeController@show                | api        |
|        | GET|HEAD | api/v1/episodes/{id}/download                 |      | App\Http\Controllers\API\EpisodeController@download            | api        |
|        | GET|HEAD | api/v1/podcasts                               |      | App\Http\Controllers\API\PodcastController@index               | api        |
|        | GET|HEAD | api/v1/podcasts/{id}                          |      | App\Http\Controllers\API\PodcastController@show                | api        |
|        | GET|HEAD | sanctum/csrf-cookie                           |      | Laravel\Sanctum\Http\Controllers\CsrfCookieController@show     | web        |
+--------+----------+-----------------------------------------------+------+----------------------------------------------------------------+------------+
```

I've also added the endpoint data from Insomnia so you don't need to dick about typing in your browser. Check the .insomnia directory. I understand that there's a better way to share endpoints but for a tech test, this should suffice. If you do use a browser, use Firefox, it formats the JSON much neater than Chrome.

## Filters

As a wee bonus, I've added some search filters on the `downloaded episodes` endpoint. Here's the request validation which describes what you can do with it:

```php
 'period' => [
    Rule::in(['days', 'weeks', 'months', 'years']),
        'nullable'
    ],
    'interval' => ['digits_between:1,365', 'nullable']
```

As you can see, both params are optional and the controller will default to 7 days (the original task requirement). Any parameter outside the scope of the block in there will result in a `422` response. Any parameter not called `period` or `interval` will be ignored.

You'll struggle to see every 'day' in a response, seeding data like this was time-consuming and generally quite tricky. I suggest altering some of the `occurred_at` fields in the `downloaded_episodes` table. Also, see the `DownloadedEpisodesSeeder` for some more notes on the randomised data.

✌️
