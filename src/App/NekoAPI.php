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

	public function search( $param ) {
		$data = $this->cache->get( array($this,"request"), $param );
		return $data->statuses;
	}

	public function request( $param ) {
		return $this->twitter->get( "search/tweets", $param);
	}

	public function getPhotos($lat, $lng) {
		$param = array(
			"q" => "instagram.com%20猫%20OR%20ねこ",
			"geocode" => $lat.",".$lng.",5km",
			"count" => 100
		);

		$tweets = $this->search($param);
		return array_map(function($tweet){
			return array(
				"url" => $tweet->entities->urls[0]->expanded_url,
				"src" => $tweet->entities->urls[0]->expanded_url."media/?size=m"
				);
		}, $tweets);

	}
}