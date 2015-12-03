<?php
require_once __DIR__ . '/autoload.php';

$api = new Survarium\Api\SurvariumApi('test', 'test');
var_dump($api->getMaxMatchId('test'));
var_dump($api->getPublicIdByNickname('tester'));
