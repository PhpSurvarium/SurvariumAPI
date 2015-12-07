<?php
/**
 * It helps to check if the whole library works
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 */

namespace Survarium\Api\Tests;

use Survarium\Api\Controller;


class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testReceivingRequest()
    {
        $controller = new Controller('test', 'test');
        $result = $controller->sendGetRequest('getmaxmatchid', ['pid' => '17083592333428139024']);
        $this->assertInstanceOf('\Survarium\Api\Response', $result);
        $this->assertEquals(200, $result->getStatusCode());
    }
}