<?php
require 'vendor/autoload.php';
require 'config.php';




$twitter = new TwitterOAuth(API_KEY, API_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);


$app = new \Slim\Slim(array(
    "templates.path" => "templates"
));

$cache = new SimpleCache();


function get_data($url) {
	global $cache;
	$label = md5($url);
	if($data = $cache->get_cache( $label )){
	} else {
	    $data = @file_get_contents($url);
	    $cache->set_cache($label, $data);

	}
	$data = json_decode($data);

	return $data;
}


function photos($lat, $lng) {

	global $twitter;
	global $cache;
	$param = array(
		"q" => "instagram.com%20猫%20OR%20ねこ",
		"geocode" => $lat.",".$lng.",5km",
		"count" => 100
	);

	md5(serialize($param));
	$label = md5(serialize($param));
	if($data = $cache->get_cache( $label )){

	} else {
	    $data = $twitter->get( "search/tweets", $param);
	    $cache->set_cache($label, json_encode($data));
	}

	if(!is_object($data)) {
		$data = json_decode($data);
	}

	$tweets = $data->statuses;

	$photos = array();
	foreach ($tweets as $key => $tweet) {
		$url = $tweet->entities->urls[0]->expanded_url;
		$media = get_data("http://api.instagram.com/oembed?url=".$url);
		$content = null;

		if(is_object($media)) {
			$content = get_data("https://api.instagram.com/v1/media/".$media->media_id."?access_token=".INSTAGRAM_TOKEN);
			if(isset($content->data->images->standard_resolution->url)) {
				$photos[] = array(
					"data" => $content->data->images->standard_resolution,
					"url" => $url
				);
			}
		}
	}

	return $photos;
}


$app->get('/', function () use($app) {
	$app->render("index.php", array("photos" => array() ));
});

$app->get('/location/:lat/:lng', function ($lat, $lng) use($app) {
	$app->render("index.php", array("photos" => photos($lat, $lng)));
});

$app->run();