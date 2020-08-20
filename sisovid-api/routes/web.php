<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return 'API JALISCO';
});

$router->post('auth/login', 
    [
       'uses' => 'AuthController@authenticate'
    ]
);

$router->get('storage', 'StorageController@download');

$router->group(['middleware' => array('jwt.auth','cors')], function () use ($router) {
    $router->get('test','TestController@index');

    $router->group(['prefix' => 'init'], function ($router) {
        $router->get('catalogs', 'CatalogsController@index');
    });

    $router->group(['prefix' => 'users'], function ($router) {
        $router->put('new', 'UsersController@updateDefaultValues');
        $router->get('', 'UsersController@index');
        $router->post('', 'UsersController@store');
        $router->delete('{id}', 'UsersController@delete');
        $router->get('{id}', 'UsersController@get');
        $router->put('{id}', 'UsersController@update');     
    });

    $router->group(['prefix' => 'files'], function ($router) {
        $router->post('', 'FilesController@store');
        $router->get('','FilesController@index');
        $router->delete('{id}', 'FilesController@delete');
        $router->get('{id}', 'FilesController@get');
        $router->put('{id}', 'FilesController@update');
        $router->post('media/victim-image', 'FilesMediaController@saveVictimImage');
        $router->delete('media/{id}', 'FilesMediaController@delete');
    });

    $router->group(['prefix' => 'roles'], function ($router) {
        $router->get('', 'RolesController@index');
        $router->post('', 'RolesController@store');
        $router->delete('{id}', 'RolesController@delete');
        $router->get('{id}', 'RolesController@get');
        $router->put('{id}', 'RolesController@update');
    });

    $router->group(['prefix' => 'direcciones'], function ($router) {
        $router->get('', 'DirectionsController@index');
        $router->post('', 'DirectionsController@store');
        $router->delete('{id}', 'DirectionsController@delete');
        $router->get('{id}', 'DirectionsController@get');
        $router->put('{id}', 'DirectionsController@update');
        $router->get('{id}/areas', 'AreasController@index');
    });

    $router->group(['prefix' => 'areas'], function ($router) {
        $router->post('', 'AreasController@store');
        $router->delete('{id}', 'AreasController@delete');
        $router->get('{id}', 'AreasController@get');
        $router->put('{id}', 'AreasController@update');
    });
});

$router->group(['middleware' => array('cors')], function () use ($router) {
    $router->group(['prefix' => '/users'], function ($router) {
        $router->post('password/reset', 'UsersController@createRequestUser');
        $router->get('password/reset/{token}', 'UsersController@validateRequestUser');        
        $router->put('password/reset/{token}', 'UsersController@updatePassword');        
    });
});
