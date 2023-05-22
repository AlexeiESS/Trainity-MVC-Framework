<?php

namespace App\Libs;

if(!defined(SECURITY)){exit();}
class Dev {

	private $default_arr_url;

	function __construct(){
		$this->default_arr_url = [
			'path' => 'index',
			'type' => '.php'
			'get' => '?',
			'tabs' => '#',
		];
	}
	public function redirect($arr){
		$this->default_arr_url = $arr;
		$url = $_SERVER['HTTP_HOST'].$this->default_arr_url['path'].$this->default_arr_url['type'].$this->default_arr_url['get'].$this->default_arr_url['tabs'];
		header("Location: $url");
	}

}

?> 