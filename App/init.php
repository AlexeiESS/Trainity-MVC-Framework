<?php
define('SECURITY', 'true'); //Константа для защиты кода
//Вывод ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


//Получаем первостепенные пути и параметры

$path = explode('/',trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH), '/'));
if(empty($path[0])){
    $main_path = 'index';
}else {
    $main_path = $path[0];
}
if(!empty($path[1])){
    unset($path[0]);
    $params = array_merge($path);
}else {
    $params = '';
}
if(isset($_POST)){$post = $_POST;}else{$post = '';}
if(isset($_GET)){$get = $_GET;}else{$get = '';}
$fragment = trim(trim(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH), '/'));


//Получение директорий
$engine = __DIR__;
$index = 	substr(__DIR__, 0, -3);


//Defines  Глобальные константы для упрощения работы

define('INIT',__DIR__.'/init.php');//https://example.com/App/init.php
define('VIEW',$index.'public/');//https://example.com/public/

if(is_array($path)==true){
    $d = '';
    if(str_ends_with(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH), '/')==true){
        $d = '../';
    }
for($i=0; $i<count($path);$i++){
    $d = $d.'../';
}
define('PUBLICTMP',$d.'public/');//https://example.com/[../]/public/
}else {
define('PUBLICTMP','public/');//https://example.com/public/
}
define('CACHE',$index.'Cache/');//https://example.com/Cache/
define('UPLOAD',$index.'Upload/');//https://example.com/Upload/
define('ROUTES',$index.'App/Routes/web.php');
define('APP',$engine.'/'); //https://example.com/App/
define('LIBS',$engine.'/Libs/'); //https://example.com/App/Libs/
define('INDEX', 'https://'.$_SERVER['SERVER_NAME'].'/'); // https://example.com/


//Подключение конфигов
define('CFG',$engine.'/Configs');
    if ($handle = opendir(CFG)) {
     while (false !== ($configs = readdir($handle))) {  
                if(!is_dir($configs)){
                    require_once(''.CFG.'/'.$configs.'');
         }
    }
      closedir($handle); 
    }
//Подключение конфигов Кэша
/*define('CACHE',$index.'/Cache');
    if ($handle = opendir(CFG)) {
     while (false !== ($configs = readdir($handle))) {  
                if(!is_dir($configs)){
                    require_once(''.CFG.'/'.$configs.'');
         }
    }
      closedir($handle); 
    }
    */
//Подключаем все классы для работы
spl_autoload_register(function($class) {
	$path = str_replace('\\', '/', $class.'.php');
    if(file_exists($path)){
    	require $path;
    }
});
require 'vendor/autoload.php';
?>
