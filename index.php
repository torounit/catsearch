<?php
namespace App;

require 'vendor/autoload.php';
require 'config.php';


$app = new \Slim\Slim(array(
    "templates.path" => "templates"
));

Class Cache {

	private $cache;

	public function __construct() {
		$this->init();
	}

	public function init() {
		$this->cache = new \SimpleCache();
	}

	public function get( $label , $callback ) {
		$data = null;
		if($data = $this->cache->get_cache( $label )){
		} else {
			if ( is_callable( $callback ) ) {
				$data = call_user_func( $callback );
				$this->cache->set_cache($label, $data);
			}
		}

		if(!is_object($data)) {
			$data = json_decode($data);
		}

		return $data;
	}

}


Class Location {
	private $twitter;
	private $cache;
	private $param;

	public function __construct() {
		$this->twitterOAuth();
		$this->cache = new Cache();
	}

	public function twitterOAuth() {
		$this->twitter = new \TwitterOAuth(API_KEY, API_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	}

	public function search() {
		$data = $this->cache->get( md5(serialize($this->param)), array($this,"request"));
		return $data->statuses;
	}

	public function request() {
		return $this->twitter->get( "search/tweets", $this->param);
	}


	public function get_photos($lat, $lng) {
		$this->param = array(
			"q" => "instagram.com%20猫%20OR%20ねこ",
			"geocode" => $lat.",".$lng.",5km",
			"count" => 100
		);

		$tweets = $this->search();
		return array_map(function($tweet){
			return array(
				"url" => $tweet->entities->urls[0]->expanded_url,
				"src" => $tweet->entities->urls[0]->expanded_url."media/?size=m"
				);
		}, $tweets);
	}
}

$app->get('/', function () use($app) {
	$app->render("index.php", array("photos" => array() ));
});

$app->get('/location/:lat/:lng', function ($lat, $lng) use($app) {
	$location = new Location();
	#print_r($location->get_photos($lat, $lng));
	$app->render("index.php", array("photos" => $location->get_photos($lat, $lng) ));
});

$app->run();