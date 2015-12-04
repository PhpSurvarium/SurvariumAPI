<?php
/**
 * TestRequest.php
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 */
namespace Survarium\Api\Tests;

use Survarium\Api\Request;

/**
 * @coverDefaultClass Survarium\Api\Request
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Add ability to set private property
     * @param $property
     */
    protected function setPrivateProperty($object, $property, $value)
    {
        $rClass = new \ReflectionClass($object);
        $rProperty = $rClass->getProperty($property);
        $rProperty->setAccessible(true);
        $rProperty->setValue($object, $value);
    }

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

    protected function getSignatureProcessor()
    {
        $sp = $this->getMockBuilder('Survarium\Api\SignatureProcessor')
            ->getMock();
        $sp->method('buildSignature')->willReturn('testSignature');
        $sp->method('getName')->willReturn('SHA1-HMAC');
        return $sp;
    }

    /**
     * Check if we create the right url
     *
     * @covers ::__construct
     * @covers ::signatureRequest
     * @covers ::createFullUrl
     */
    public function testConstructorWorksFine()
    {
        $request = new Request('GET', 'test', ['test' => 'test'], $this->getConsumer(), $this->getSignatureProcessor());

        //check full url was created well
        $this->assertEquals('http://api.survarium.com/test?test=test', $request->getRequestUrl());

        // test if signature request Works fine
        $this->assertEquals('test', $request->getAuthParam('surv_consumer_key'));
        $this->assertEquals('SHA1-HMAC', $request->getAuthParam('surv_signature_method'));
        $this->assertEquals('testSignature', $request->getAuthParam('surv_signature'));
        $this->assertNotEmpty($request->getAuthParam('surv_nonce'));
        $this->assertNotEmpty($request->getAuthParam('surv_timestamp'));

        return $request;
    }

    /**
     * @depends testConstructorWorksFine
     * @covers ::getHttpMethod
     */
    public function testGetHttpMethod(Request $request)
    {
        $method = $request->getHttpMethod();
        $this->assertEquals('GET', $method);
    }

    /**
     * @depends testConstructorWorksFine
     * @covers ::GetSignatureString
     */
    public function testGetSignatureString(Request $request)
    {
        $this->setPrivateProperty($request, 'timestamp', 1449069065);
        $this->setPrivateProperty($request, 'nonce', '79abde34395e05bb9abf2e2de0ba9be5');
        $string = $request->getSignatureString();
        $this->assertEquals('http://api.survarium.com/test?test=testGET79abde34395e05bb9abf2e2de0ba9be51449069065', $string);
    }

    /**
     * @depends testConstructorWorksFine
     * @covers ::parseHeaders
     * @covers ::getHeaders
     */
    public function testHeadersSetCorrectly(Request $request)
    {
        $headers = $request->getHeaders();
        $this->assertTrue(is_array($headers));
        $this->assertContains('Accept: application/json', $headers);
    }
}