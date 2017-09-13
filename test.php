<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args){
   $response->write("mescouilles");
   return $response;
});

$app->get('/friends', function($request, $response, $args){
    $response->write('Hello friends');
    return $response;
});



$app->run();