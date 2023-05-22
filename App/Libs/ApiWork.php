<?php
namespace App\Libs;

if(!defined(SECURITY)){exit();}
class ApiWork {
	function __construct(){
		$data = json_decode(file_get_contents("php://input"), true);
		if($data==NULL){
			exit();
		}
	}
}
?>