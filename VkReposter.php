<?php
require_once __DIR__ . '/vendor/autoload.php';

$res =\vkBot\App::get()->getPDOConnection()->query("SELECT * FROM postsNeedSend")->fetchAll();

var_dump($res);