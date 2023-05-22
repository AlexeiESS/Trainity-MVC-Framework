<?php

require_once 'App/init.php';
session_start();

use App\Core\Router;

$router = new Router($main_path, $get, $post, $params);

?>