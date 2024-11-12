<?php
$configPath = realpath(__FILE__);
$configDir = dirname(dirname(dirname($configPath)));
$configDir = str_replace('\\', '/', $configDir);
$documentRoot = $_SERVER['DOCUMENT_ROOT'];
$relativePath = str_replace($documentRoot, '', $configDir);
define('BASE_PATH', $relativePath);