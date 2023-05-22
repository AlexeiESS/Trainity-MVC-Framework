<?php

namespace App\Http\Controllers;

use App\Core\Controller;
if(!defined(SECURITY)){exit();}
class IndexController extends Controller {
	public function index(){
		$index = $this->view->parsein($this->view->create('index'));
		$this->view->parseprint(array('tmp'=>PUBLICTMP),$index);
	}
}

?>