<?php
namespace App\Libs;

if(!defined(SECURITY)){exit();}
class Upload {
	public function take_name($file, $input_name){
		if(isset($filename = $file[$input_name]['name'])){
			return 1;
		}else {
			return 0;
		}
	}
	public function upload($file,$input_name,$filename, $dir=''){
		if(!move_uploaded_file($file[$input_name]['tmp_name'], UPLOAD.$dir.$filename)==1)
		{
			return 0;
		}
		else {
			return 1;
		}
	}
	public function encode_upload(){
		if (function_exists('com_create_guid') === true) {
		return trim(com_create_guid(), '{}');
		}
 
		$name = md5(sprintf(
			'%04X%04X-%04X-%04X-%04X-%04X%04X%04X', 
			mt_rand(0, 65535), 
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(16384, 20479), 
			mt_rand(32768, 49151),
			mt_rand(0, 65535),
			mt_rand(0, 65535), 
			mt_rand(0, 65535)
		));
		return $name
	}
}

?>