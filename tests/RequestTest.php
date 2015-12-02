<?php
/**
 * TestRequest.php
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 */
namespace Survarium\Api\Tests;

use Survarium\Api\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected function getController()
    {
        return $this->getMockBuilder('Survarium\Api\Controller')
            ->disableOriginalConstructor()
            ->getMock();
    }
    protected function getConsumer()
    {
        $consumer = $this->getMockBuilder('Survarium\Api\Consumer')
            ->setConstructorArgs(['test', 'test'])
            ->getMock();
        $consumer->method('getSharedKey')->willReturn('test');
        $consumer->method('getPrivateKey')->willReturn('test');
        return $consumer;
    }
    protected function getSignatureProcessor(){
        $sp = $this->getMockBuilder('Survarium\Api\SignatureProcessor')
            ->getMock();
        $sp->method('buildSignature')->willReturn('testSignature');
        $sp->method('getName')->willReturn('SHA1-HMAC');
        return $sp;
    }

    /**
     * Check if we create the right url
     *
     */
    public function testConstructorWorksFine()
    {
        $request = new Request('GET', 'test', ['test' => 'test'], $this->getConsumer(), $this->getSignatureProcessor());

        //check full url was created well
        $this->assertEquals('http://api.survarium.loc/test?test=test', $request->getRequestUrl());

        // test if signature request Works fine
        $this->assertEquals('test', $request->getAuthParam('surv_consumer_key'));
        $this->assertEquals('SHA1-HMAC', $request->getAuthParam('surv_signature_method'));
        $this->assertEquals('testSignature', $request->getAuthParam('surv_signature'));
        $this->assertNotEmpty($request->getAuthParam('surv_nonce'));
        $this->assertNotEmpty($request->getAuthParam('surv_timestamp'));

        return $request;
    }

    /**
     *
     * @depends testConstructorWorksFine
     */
    public function testGetHttpMethod(Request $request)
    {
        $method = $request->getHttpMethod();
        $this->assertEquals('GET', $method);
    }

    /**
     * @depends testConstructorWorksFine
     */
    public function testHeadersSetCorrectly(Request $request)
    {
        $headers = $request->getHeaders();
        $this->assertTrue(is_array($headers));
        $this->assertContains('Accept: application/json', $headers);
    }
}