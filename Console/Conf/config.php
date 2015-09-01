<?php
return array(
	//'配置项'=>'配置值'

		
		'TMPL_PARSE_STRING'  =>array(
				'/Console/Public/' => '/Console/Tpl/Console/Public/',
				// 更改默认的/Public 替换规则
		),
		
		
		//连接MYSQL数据库
		'DB_TYPE'              => 'mysql',
		'DB_HOST'              => "192.168.1.41",
		'DB_NAME'              => "MT_Ports",
		'DB_USER'              => "jackie",
		'DB_PWD'               => "37113009",
		'DB_PORT'              => '',
		'DB_PREFIX'            => '',
		
		'DEFAULT_MODULE'		=> 'Home',
		'DEFAULT_ACTION'		=> 'Login',
		
		'WS_CONFIG_HOST'		=> 'hj',
		
		//缓存有效期
		'DATA_CACHE_TIME'       => 86400,
		
		//'DEFAULT_MODULE'       => 'account',
		//'DEFAULT_ACTION'       => 'login',
		
		'URL_CASE_INSENSITIVE' 	=> true,
		'URL_MODEL'				=> 2,
		
		'DEFAULT_THEME'  		=> "Console",
		
		'TMPL_L_DELIM'			=> "<!--{",
		'TMPL_R_DELIM'			=> "}-->",
		
		'LOG_RECORD' 			=> true,
		'LOG_FILE_SIZE'			=> 50000000,
		'LOG_FULL_DETAIL'		=> false,
);
?>