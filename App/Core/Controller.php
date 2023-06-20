<?php

namespace App\Core;
use App\Core\View;
if(!defined(SECURITY)){exit();}
abstract class Controller {

	protected $get;
	protected $post = [];
	protected $view;
	protected $route;
	protected $routes = [];
	protected $model;
	protected $cache;
	protected $params;
	protected $upl;
	protected $api;

	public function __construct($get, $post, $route, $params, $routes) {
		$this->get = $get;
		$this->post = $post;
		$this->route = $route;
		$this->params = $params;
		$this->routes = $routes;
		$this->view = new View('public/');
	}
	public function loadModel() {
		$path = 'App\Http\Models\\'.ucfirst($this->route).'Model';
		if (class_exists($path)) {
			$this->model = new $path();
		}
	}	
	public function get_ip(){
		$value = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$value = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$value = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
			$value = $_SERVER['REMOTE_ADDR'];
		}
		return $value;
	}
	public function loadCache($name, $ras='php', $dir=''){
		$path = 'App\Libs\Cache';
		$this->cache = new $path($name);
	}
	public function loadApi(){
		$path = 'App\Libs\ApiWork';
		$this->api = new $path();
	}
	public function loadUpl(){
		$path = 'App\Libs\Upload';
		$this->upl = new $path();
	}
	public function add_route($link){
		if(file_exists(ROUTES)){
			$b = "'";
			$routess = require ROUTES; 
			$routess = json_decode($routess);
			var_dump($routess);
			if(is_array($routess)){
			$routess = array_merge($routess, (array)$link);}else {
				$routess = [$routess,$link];
			}
			var_dump($routess);
			$t = json_encode($routess, true);
			$t = $b.$t.$b;
			$a = '<?php if(!defined(SECURITY)){exit();} return '.$t.'; ?>';
			$f = fopen(APP.'Routes/web.php', 'w+');
			fwrite($f, $a);
			fclose($f);
			return 1;
		}
	}
}
?>
