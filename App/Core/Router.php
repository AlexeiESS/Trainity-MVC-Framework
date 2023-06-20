<?php

namespace App\Core;
if(!defined(SECURITY)){exit();}
class Router {
	protected $routes;
	protected $route;
	protected $get;
	protected $post;
	protected $params;
	protected $error_page;
	protected $tmp;

	function __construct($route,$get, $post, $params, $error_page='Index'){
		$this->route = $route;
		$this->get = $get;
		$this->post = $post;
		$this->params = $params;
		$this->error_page = $error_page;
		$this->routes = json_decode(require_once APP.'Routes/web.php');
		$this->run();
	}
	public function match(){
		if(is_array($this->routes)){
		if(in_array($this->route,$this->routes)==true){
			return 1;
		}else {
			return 0;
		}}
		else {
			if($this->route==$this->routes){
				return 1;
			}else {
				return 0;
			}
		}
	}
	public function run(){
		if($this->match()==1){
			$path = 'App\Http\Controllers\\'.ucfirst($this->route).'Controller';
			if(class_exists($path)){
				if(isset($this->params[0]) && method_exists($path, (string)$this->params[0])==true){
					$func = (string)$this->params[0];
					$controller = new $path($this->get, $this->post, $this->route, $this->params, $this->routes);
                    $controller->$func();
				}else {
				$controller = new $path($this->get, $this->post, $this->route, $this->params, $this->routes);
				$controller->index();
			}
			}
			else {
			$this->error404();
		}
		}
		else {
			$this->error404();
		}
	}
	public function error404(){
		$path = 'App\Http\Controllers\\'.ucfirst($this->error_page).'Controller';
		$controller = new $path($this->get, $this->post, $this->error_page, $this->params);
		$controller->index();
	}
}


?>
