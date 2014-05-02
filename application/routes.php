<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', function()
{
	return View::make('home.index');
});

// Auth
Route::get('login', array('before' => 'auth', 'uses' => 'auth@login'));
Route::post('login', array('before' => 'auth|csrf', 'uses' => 'auth@login'));
Route::get('logout', function(){ return User::logout(); });
Route::get('register', array('before' => 'auth', 'uses' => 'auth@register'));
Route::post('register', array('before' => 'auth', 'uses' => 'auth@register'));

// Tags
Route::get('tag', 'tags@index'); // Add form
Route::get('tag/(:any)', 'tags@show'); // Display Tag
Route::post('tag/suggestions', 'tags@suggestions'); // Get suggestions based on string (optional: exclude filter)
Route::post('tag', 'tags@create'); // Create a new tag
// Route::get('tag/attach/(:num)', 'tags@attach');

// tags/{thing}/{num}/{start_spectrum}/{end_spectrum}
// Route::get('tags/(:any?)/(:any?)/(:any?)/(:any?)/(:any?).*', 'tags@tags');
// 
Route::get('search', 'search@index');


// Things
Route::get('thing', 'things@index'); // Add form
Route::get('thing/(:num)', 'things@show'); // Display thing
Route::post('thing', 'things@create'); // Create a thing
Route::put('thing/(:num)', 'things@update'); // Display thing
Route::post('thing/(:num)/link', 'links@create'); // Create and attach a link to a thing

// Voting
Route::post('thing/(:num)/vote/(:any)', 'things@vote');

// Links
Route::post('link', 'links@create'); // Add form

// Comments
Route::get('comments/(:num)', 'comments@index'); // Display comments based on relationship id
Route::post('comments/(:num)', 'comments@create'); // Create a new comment on a relationship

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
    if ($success = Session::get('success'))
    {
        View::share('success', $success);
    }

    if ($user = User::current_user())
    {
        View::share('user', $user);
    }
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
    // dd($response); 
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
    // If the user is already logged in, redirect to homepage
    if (User::current_user())
    {
        return Redirect::to('/');
    }
});


/*
|--------------------------------------------------------------------------
| View Composers
|--------------------------------------------------------------------------
*/
View::composer('auth.register.form', function($view)
{
    View::share('user_count', User::count());
});

View::composer('tags.top_tags', function($view)
{
    View::share('tags', Tag::top_tags());
});