<?php 
error_reporting(E_ALL);
ini_set('ignore_repeat_errors',TRUE);
ini_set('display_errors',TRUE);
ini_set('log_errors',TRUE);
ini_set('error_log',"php-error.log");
error_log('Hello,erros');

require 'vendor/autoload.php';
require 'src/lib/routes.php';




?>