<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;
$db['default'] = array(
	'dsn'	=> 'mysql:host=localhost;dbname=hrsale',
	'hostname' => "localhost",
	'username' => "root",
	'password' => "",
	'database' => "hrsale",
	'dbdriver' => 'pdo',
	#'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
// CS Phone Panel
$db['apgdb'] = array(
	 'dsn' => '',
	 #'dsn'	=> 'mysql:host=localhost;dbname=apgdb',
	 'hostname' => 'localhost',
	 'username' => 'root',
	 'password' => '',
	 'database' => 'apgdb',
	 'dbdriver' => 'mysqli',
	 #'dbdriver' => 'pdo',
	 'dbprefix' => '',
	 'pconnect' => FALSE,
	 'db_debug' => (ENVIRONMENT !== 'production'),
	 'cache_on' => FALSE,
	 'cachedir' => '',
	 'char_set' => 'utf8',
	 'dbcollat' => 'utf8_general_ci',
	 'swap_pre' => '',
	 'encrypt' => FALSE,
	 'compress' => FALSE,
	 'stricton' => FALSE,
	 'failover' => array(),
	 'save_queries' => TRUE
);
