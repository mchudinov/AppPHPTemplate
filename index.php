<?php
define('APPROOT', __DIR__.DIRECTORY_SEPARATOR);
require_once APPROOT.'vendor/autoload.php';
require_once APPROOT.'src/Autoloader.php';

$m = new MyClass();
echo $m->getTrue();

Logger::configure('log4php.xml');
$logger = Logger::getLogger(1);
$logger->info("This is an informational message.");
$logger->warn("I'm not feeling so good...");
    