<?php
namespace App;

interface Cache {
	public function get( $callback , $param );
}