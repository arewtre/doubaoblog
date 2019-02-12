<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   九月一十八 <2505451091@qq.com>
 */

session_start();
//error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL); 
header("Content-Type:text/html;charset=utf-8");
header("Access-Control-Allow-Origin:*");
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}
define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
define('IA_ROOT', str_replace("\\", '/', dirname(__FILE__)));
define('LUMEN_START', microtime(true));
define('MSGTOKEN', "doudoubao");
define('STATICURL', '/resources/wap/static/');
require_once __DIR__.'/public/index.php';
