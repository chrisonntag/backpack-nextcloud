<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Backpack\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'link#index', 'url' => '/links', 'verb' => 'GET'],
        ['name' => 'link#show', 'url' => '/links/{id}', 'verb' => 'GET'],
        ['name' => 'link#create', 'url' => '/links', 'verb' => 'POST'],
        ['name' => 'link#update', 'url' => '/links/{id}', 'verb' => 'PUT'],
        ['name' => 'link#destroy', 'url' => '/links/{id}', 'verb' => 'DELETE']
    ]
];
