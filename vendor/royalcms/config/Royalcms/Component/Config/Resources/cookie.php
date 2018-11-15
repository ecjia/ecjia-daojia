<?php

return array(


	/*
	|--------------------------------------------------------------------------
	| Cookie Lifetime
	|--------------------------------------------------------------------------
	|
	| Here you may specify the number of minutes that you wish the session
	| to be allowed to remain idle before it expires. If you want them
	| to immediately expire on the browser closing, set that option.
	|
	| Unit: minute
	|
	*/

	'lifetime' => 60,

	/*
	|--------------------------------------------------------------------------
	| Cookie Path
	|--------------------------------------------------------------------------
	|
	| The session cookie path determines the path for which the cookie will
	| be regarded as available. Typically, this will be the root path of
	| your application but you are free to change this when necessary.
	|
	*/

	'path' => '/',

	/*
	|--------------------------------------------------------------------------
	| Cookie Domain
	|--------------------------------------------------------------------------
	|
	| Here you may change the domain of the cookie used to identify a session
	| in your application. This will determine which domains the cookie is
	| available to in your application. A sensible default has been set.
	|
	*/

	'domain' => null,

	/*
	|--------------------------------------------------------------------------
	| HTTPS Only Cookies
	|--------------------------------------------------------------------------
	|
	| By setting this option to true, session cookies will only be sent back
	| to the server if the browser has a HTTPS connection. This will keep
	| the cookie from being sent to you if it can not be done securely.
	|
	*/

	'secure' => false,
    
    'httponly' => false,

    /*
    |--------------------------------------------------------------------------
    | Cookie Prefix
    |--------------------------------------------------------------------------
    */
    'prefix' => null,

);
