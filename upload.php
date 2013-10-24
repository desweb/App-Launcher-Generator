<?php

require_once 'classes/Security.class.php';

$get_request	= $_GET;
$file_request	= $_FILES;

$security = new Security();

if (!$security->checkFile($file_request['launcher'])) return;

$security->setIdentifier($get_request['time']);

if (!$security->checkLauncherProperties()) return;

mkdir($security->getPathLauncherFolder(), 0777, true);

move_uploaded_file($file_request['launcher']['tmp_name'], $security->getPathLauncherFile());
