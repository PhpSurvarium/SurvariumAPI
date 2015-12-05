<?php
require_once __DIR__ . '/autoload.php';

$api = new Survarium\Api\SurvariumApi('test', 'test');
var_dump($api->getMaxMatchId('17083592333428139024'));
var_dump($api->matchesCountByPublicId('17083592333428139024'));
var_dump($api->getPublicIdByNickname('Убить врага'));
var_dump($api->getMatchesIdByPublicId('17083592333428139024', 20, 0));
var_dump($api->getNicknamesByPublicIds(['17083592333428139024', '7542784095223883934']));
var_dump($api->getMatchStatistic(3200430));
var_dump($api->getUserData('17083592333428139024'));