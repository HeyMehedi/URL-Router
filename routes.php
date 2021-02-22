<?php
use OurApplication\Routing\Router;

Router::get('/', function () {
    echo "Homepage";
});

Router::get('/hello', function () {
    echo "Hello World";
});

Router::get('/hi/(\w+)', function ($name) {
    echo "Hello {$name}";
});

Router::get('/hello/(\w+)/title/(\w+)', function ($name, $title) {
    echo "Hello {$title} {$name}";
});

Router::get('/verb', function () {
    echo $_SERVER['REQUEST_METHOD'];
});

Router::post('/verb', function () {
    echo $_SERVER['REQUEST_METHOD'];
});

Router::delete('/verb', function () {
    echo $_SERVER['REQUEST_METHOD'];
});

Router::get('/price1', [OurApplication\Controller\PriceController::class, 'showPrice']);
Router::get('/price2', "OurApplication\Controller\PriceController@showPrice");

Router::cleanup();