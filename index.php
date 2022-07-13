<?php
session_start();

define('DIRECTORY', __DIR__);
define('SEPARATOR', DIRECTORY_SEPARATOR);

require DIRECTORY . SEPARATOR . 'app' . SEPARATOR .  'autoload.php';
?>