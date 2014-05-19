<?php
namespace App;

Class SimpleCacheAdapter implements Cache {

	private $cache;

	public function __construct() {
		$this->init();
	}

	private function init() {
		$this->cache = new \SimpleCache();
	}

	public function get( $callback , $param , $label = null ){
		if(!$label) {
			$label = md5(serialize($param));
		}
		$data = null;
		if($data = $this->cache->get_cache( $label )){
		} else {
			if ( is_callable( $callback ) ) {
				$data = call_user_func( $callback, $param );
				$this->cache->set_cache($label, $data);
			}
		}

		if(!is_object($data)) {
			$data = json_decode($data);
		}

		return $data;
	}

}