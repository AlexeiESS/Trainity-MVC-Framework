<?php
namespace App\Libs;
if(!defined(SECURITY)){exit();}
class Cache {
	private $file;
	private $name;
	private $path;
	private $ras;

	function __construct($name, $ras='php', $dir=''){
		$this->file = md5($name).'.'.$ras;
		$this->path = CACHE.$dir.$this->file;
		$this->name = $name;
		$this->ras = $ras;
	}
	public function csave($data){
		$b = "'";
		if(file_exists(CACHE.$this->file)){
			$cache = require CACHE.$this->file;
			$ndata = json_decode($cache);
			if(is_array($cache)==true){
				if(is_array($data)){
				$sdata = array_merge($ndata, $data);
			}else {
				$sdata = array_merge((array)$data,$ndata);
			}
			}else {
				if(is_array($data)){
				$sdata = array_merge((array)$ndata, $data);
			}else {
				$sdata = [$data,$ndata];
			}
			}
			$t = json_encode($sdata, true);
		}else {
			$t = json_encode($data, true);
		}
		
		if($this->ras=='php'){
		$t = $b.$t.$b;
		$a = '<?php if(!defined(SECURITY)){exit();} return '.$t.'; ?>';}
		else {
			$a = $t;
		}
		$f = fopen($this->path, 'w+');
		fwrite($f, $a);
		fclose($f);
		return 1;
	}
	public function tplsave($tpl_name,$tpl_data,$tpl_dir=''){
		$f = fopen(VIEW.$tpl_dir.$tpl_name.'.tpl', 'w+');
		fwrite($f, $tpl_data);
		fclose($f);
		return 1;
	}
	public function tplclean($tpl_name, $tpl_dir=''){
		if(file_exists(VIEW.$tpl_dir.$tpl_name.'.tpl')){
			unlink(VIEW.$tpl_dir.$tpl_name.'.tpl');
			return 1;
		}else {
			return 0;
		}
	}
	public function cclean(){
		if(file_exists($this->path)){
			unlink($this->path);
			return 1;
		}else {
			return 0;
		}
	}
	public function cget(){
		if(file_exists($this->path)){
		$cache = require $this->path;
		$cache = json_decode($cache);
		return $cache;
		}else {return 0;}
	}

}
?>