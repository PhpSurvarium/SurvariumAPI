<?php
/**
 * TestResponse.php
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 */

namespace Survarium\Api\Tests;

use Survarium\Api\Response;

/**
 * @coverDefaultClass Survarium\Api\Response
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::setHeadersString
     */
    public function testParseHeaders()
    {
        $headerString = <<<TEXT
            HTTP/1.1 200 OK \r\n
            Date: Wed, 02 Dec 2015 11:33:54 GMT \r\n
            Content-Type: text/html; charset=utf-8 \r\n
            Transfer-Encoding: chunked \r\n
            Connection: keep-alive \r\n
            Cache-Control: public, no-cache=\"Set-Cookie\", max-age=35 \r\n
            Expires: Wed, 02 Dec 2015 11:34:29 GMT \r\n
            Last-Modified: Wed, 02 Dec 2015 11:33:29 GMT \r\n
            Vary: * \r\n
            Server: nginx \r\n
TEXT;
        $response = new Response();
        $response->setHeadersString($headerString);
        $responseHeaders = $response->getHeaders();
        $expectedArray = [
            'Date' => 'Wed, 02 Dec 2015 11:33:54 GMT',
            'Content-Type' => 'text/html; charset=utf-8',
            'Transfer-Encoding' => 'chunked',
            'Connection' => 'keep-alive',
            'Cache-Control'  => 'public, no-cache=\"Set-Cookie\", max-age=35',
            'Expires'  => 'Wed, 02 Dec 2015 11:34:29 GMT',
            'Last-Modified'  => 'Wed, 02 Dec 2015 11:33:29 GMT',
            'Vary'  => '*',
            'Server'  => 'nginx'
        ];

        $this->assertEquals($expectedArray, $responseHeaders);
    }
}