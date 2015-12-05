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
}