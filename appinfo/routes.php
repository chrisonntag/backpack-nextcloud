<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Backpack\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return ['routes' => [
    // page
    ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
    // links
    ['name' => 'links#index', 'url' => '/links', 'verb' => 'GET'],
    ['name' => 'links#get', 'url' => '/links/{id}', 'verb' => 'GET'],
    ['name' => 'links#create', 'url' => '/links', 'verb' => 'POST'],
    ['name' => 'links#update', 'url' => '/links/{id}', 'verb' => 'PUT'],
    ['name' => 'links#favorite', 'url' => '/links/{id}/favorite', 'verb' => 'PUT'],
    ['name' => 'links#destroy', 'url' => '/links/{id}', 'verb' => 'DELETE'],
    // api
    ['name' => 'link_api#index', 'url' => '/api/v0.2/links', 'verb' => 'GET'],
    ['name' => 'link_api#get', 'url' => '/api/v0.2/links/{id}', 'verb' => 'GET'],
    ['name' => 'link_api#create', 'url' => '/api/v0.2/links', 'verb' => 'POST'],
    ['name' => 'link_api#update', 'url' => '/api/v0.2/links/{id}', 'verb' => 'PUT'],
    ['name' => 'link_api#destroy', 'url' => '/api/v0.2/links/{id}', 'verb' => 'DELETE'],
    ['name' => 'link_api#preflighted_cors', 'url' => '/api/v0.2/{path}',
     'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']],
]];