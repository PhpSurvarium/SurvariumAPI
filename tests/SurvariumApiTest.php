<?php
/**
 * SurvariumApiTest.php
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @todo    add more spesific assertion about received data
 */

namespace Survarium\Api\Tests;

use Survarium\Api\SurvariumApi;

/**
 * @coverDefaultClass Survarium\Api\SurvariumApi
 */
class SurvariumApiTest extends \PHPUnit_Framework_TestCase
{
    private $api;

    public function setUp()
    {
        $this->api = new SurvariumApi('test', 'test');
    }

    /**
     * @covers ::getMaxMatchId
     */
    public function testGetMaxMatchId()
    {
         $result = $this->api->getMaxMatchId('17083592333428139024');

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::matchesCountByPublicId
     */
    public function testMatchesCountByPublicId()
    {
        $result = $this->api->matchesCountByPublicId('17083592333428139024');

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::getPublicIdByNickname
     */
    public function testGetPublicIdByNickname()
    {
        $result = $this->api->getPublicIdByNickname('Убить врага');

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::getMatchesIdByPublicId
     */
    public function testGetMatchesIdByPublicId()
    {
        $result = $this->api->getMatchesIdByPublicId('17083592333428139024', 20, 0);

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::getNicknamesByPublicIds
     */
    public function testGetNicknamesByPublicIds()
    {
        $result = $this->api->getNicknamesByPublicIds(['17083592333428139024', '7542784095223883934']);

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::getMatchStatistic
     */
    public function testGetMatchStatistic()
    {
        $result = $this->api->getMatchStatistic(3200430);

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::getUserData
     */
    public function testGetUserData()
    {
        $result = $this->api->getUserData('17083592333428139024');

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }

    /**
     * @covers ::getClanAmounts
     */
    public function testGetClanAmounts()
    {
        $result = $this->api->getClanAmounts();
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_clans_amount', $result['data']['action']);
        $this->assertTrue($result['data']['amount'] >0);
    }

    /**
     * @covers ::getClans
     */
    public function testGetClans()
    {
        $result = $this->api->getClans(20, 0);
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_clans', $result['data']['action']);
        $this->assertTrue(is_array($result['data']['clans_data']));
        $this->assertEquals(20, count($result['data']['clans_data']));
    }

    /**
     * @covers ::clanInfo
     */
    public function testClanInfo()
    {
        $result = $this->api->getClanInfo(1);
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_clan_info', $result['data']['action']);
        $this->assertTrue(is_array($result['data']['clan_info']));
        $this->assertEquals('1', $result['data']['clan_info']['id']);
        $this->assertEquals('Vostok Games', $result['data']['clan_info']['name']);
        $this->assertEquals('VG', $result['data']['clan_info']['abbreviation']);
        $this->assertTrue($result['data']['clan_info']['level'] > 0);
        $this->assertTrue($result['data']['clan_info']['elo'] > 0);
    }

    /**
     * @covers ::claninfo
     */

    public function testGetClanMembers()
    {
        $result = $this->api->getClanMembers(1);
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_clan_members_by_clanid', $result['data']['action']);
        $this->assertEquals('1', $result['data']['clan_id']);
        $this->assertTrue(is_array($result['data']['members']));
        $this->assertTrue(count($result['data']['members']) > 0);
    }

    /**
     * @covers ::getSlotsDict
     */
    public function testGetSlotsDict()
    {
        $result = $this->api->getSlotsDict('english');
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_slots_dict', $result['data']['action']);
        $this->assertEquals('helmet', $result['data']['dictionary'][0]);
    }

    /**
     * @covers ::getItemsDict
     */
    public function testGetItemsDict()
    {
        $result = $this->api->getItemsDict('russian');
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_items_dict', $result['data']['action']);
        $this->assertEquals('АК-74М', $result['data']['dictionary'][3]);
    }

    /**
     * @covers ::getMapsDict
     */
    public function testGetMapsDict()
    {
        $result = $this->api->getMapsDict('russian');
        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
        $this->assertTrue(is_array($result['data']));
        $this->assertEquals('get_maps_dict', $result['data']['action']);
        $this->assertTrue($result['data']['dictionary'][0]['map_id'] > 0);
    }


}