<?php

namespace App\Core;

use App\Libs\Mysql;
if(!defined(SECURITY)){exit();}

abstract class Model {
	protected $query;
	protected $post;
	protected $route;
	protected $conn = '';
	protected $cache;
	protected $upl;
	protected $api;

	 function __construct() {
		require APP.'Configs/bd.php';
		$this->conn = new Mysql($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
	}
	public function loadCache($name){
		$path = 'App\Libs\Cache';
		$this->cache = new $path($name);
	}
	public function loadUpl(){
		$path = 'App\Libs\Upload';
		$this->upl = new $path();
	}
	public function loadApi(){
		$path = 'App\Libs\ApiWork';
		$this->api = new $path();
	}
}
