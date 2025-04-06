<?php
ini_set('display_errors', 0);

$dev_data = array(
    'id' => '-1',
    'firstname' => 'IHM Southern Africa',
    'lastname' => '',
    'username' => 'ihm',
    'password' => '',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('dev_data')) define('dev_data', $dev_data);
if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', "root"); 
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', ""); 
if (!defined('DB_NAME')) define('DB_NAME', 'esams'); 

require_once 'helper.php';

