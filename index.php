<?php

require 'vendor/autoload.php';
require 'config.php';


$app = new \Slim\Slim(array(
    "templates.path" => "templates"
));


$app->get('/', function () use($app) {
	$app->render("index.php", array("photos" => array() ));
});

$app->get('/location/:lat/:lng', function ($lat, $lng) use($app) {
	$nekoapi = new \App\NekoAPI();
	$app->render("index.php", array("photos" => $nekoapi->getPhotos($lat, $lng) ));
});

$app->run();