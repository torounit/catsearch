<?php
namespace App;


Class NekoAPI {

	private $twitter;
	private $cache;
	private $param;

	public function __construct() {
		$this->twitterOAuth();
		$this->cache = new Cache();
	}

	private function twitterOAuth() {
		$this->twitter = new \TwitterOAuth(API_KEY, API_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	}

	public function getTweets( $param ) {

		$data = $this->cache->get( function ($param) {
			return $this->twitter->get( "search/tweets", $param);
		}, $param );

		return $data->statuses;
	}

	public function getPhotos($param) {

		$tweets = $this->getTweets($param);
		return array_map(function($tweet){
			return array(
				"url" => $tweet->entities->urls[0]->expanded_url,
				"src" => $tweet->entities->urls[0]->expanded_url."media/?size=m"
				);
		}, $tweets);

	}

	public function getLocationPhotos($lat, $lng) {
		$param = array(
			"q" => "instagram.com%20猫%20OR%20ねこ",
			"geocode" => $lat.",".$lng.",5km",
			"count" => 100
		);
		return $this->getPhotos($param);
	}
}