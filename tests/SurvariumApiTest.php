<?php
/**
 * SurvariumApiTest.php
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @todo    add tests for every method of Survarium API with test data
 */

namespace Survarium\Api\Tests;

use Survarium\Api\SurvariumApi;

class SurvariumApiTest extends \PHPUnit_Framework_TestCase
{
    public function testSurvariumApiWorks()
    {
        $sApi = new SurvariumApi('test', 'test');
        $result = $sApi->getMaxMatchId(1);

        $this->assertTrue(is_array($result));
        $this->assertEquals(200, $result['code']);
    }
}