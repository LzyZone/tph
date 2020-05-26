<?php
return array(
	'SYS_TITLE' 		=> 'web-title',
	'DEFAULT_THEME'      => 'Default',
	'TMPL_PARSE_STRING'  =>array(
        '__PUBLIC__' => '/Public',
        '__ADMIN__' => '/Public/admin',
        '__JS__'     => '/Public/admin/js',
        '__CSS__'    => '/Public/admin/css',
        '__IMAGE__'  => '/Public/admin/images',
        '__LIB__'	 => '/Public/lib',
        '__UPLOAD__' => '/Uploads',
	),
	'ADMIN_PWD_SALT' => 'key',
	'ADMIN_LOGIN_ERR_LIMIT' => 3,
	'ADMIN_SESSION_NAME' => 'web_session'
);
