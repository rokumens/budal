<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// $hook['post_controller_constructor'][] = array(
// 'function' => 'redirect_ssl',
// 'filename' => 'ssl.php',
// 'filepath' => 'hooks'
// );
// luffy was here
$hook['post_controller_constructor'][] = array(
	// 'class'    => 'ProfilerEnabler',
	// 'function' => 'enableProfiler',
	// 'filename' => 'hooks.profiler.php',
	'function' => 'redirect_ssl',
	'filename' => 'ssl.php',
	'filepath' => 'hooks',
	'params'   => array()
);
// buat log query
$hook['display_override'][] = array(
  'class' => '',
  'function' => 'log_queries',
  'filename' => 'log_queries.php',
  'filepath' => 'hooks'
);
