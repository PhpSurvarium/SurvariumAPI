<?php

require_once __DIR__ . '/autoload.php';

$api = new Survarium\Api\SurvariumApi('test', 'test');
echo '<pre>';
print_r($api->getMaxMatchId());
print_r($api->matchesCountByPublicId('17083592333428139024'));
print_r($api->getPublicIdByNickname('Убить врага'));
print_r($api->getMatchesIdByPublicId('17083592333428139024', 20, 0));
print_r($api->getNicknamesByPublicIds(['17083592333428139024', '7542784095223883934']));
print_r($api->getMatchStatistic(3200430, 'russian'));
print_r($api->getUserData('17083592333428139024', 'russian'));
print_r($api->getClanAmounts());
print_r($api->getClans(20, 0));
print_r($api->getClanInfo(1));
print_r($api->getClanMembers(1));
print_r($api->getSlotsDict('english'));
print_r($api->getItemsDict('russian'));
print_r($api->getMapsDict('russian'));
print_r($api->getNewMatches(1451001600, 10));
echo '</pre>';
