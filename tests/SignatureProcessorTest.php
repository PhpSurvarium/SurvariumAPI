<?php
/**
 * TestSignatureProcessor.php
 *
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 */

namespace Survarium\Api\Tests;


use Survarium\Api\SignatureProcessor;

class SignatureProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Adding abbility to test protected and private methods
     */
    public static function getMethod($name)
    {
        $class = new \ReflectionClass('Survarium\Api\SignatureProcessor');
        $method =  $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * Test if accepted method can be used
     */
    public function testAcceptedAlgorithm()
    {
        $sp = new SignatureProcessor();
        $getAcceptedAlgorithmMethod = self::getMethod('getAcceptedAlgorithm');
        $acceptedAlgo = $getAcceptedAlgorithmMethod->invoke($sp);
        $this->assertEquals('sha1', $acceptedAlgo);
    }


    /**
     * Check if client produce correct signature
     *
     * @dataProvider signatureDataProvider
     */
    public function testBuildSignature($result, $requestString, $consumerString)
    {
        $request = $this->getMockBuilder('Survarium\Api\Request')->disableOriginalConstructor()->getMock();
        $request->method('getSignatureString')->willReturn($requestString);

        $consumer = $this->getMockBuilder('Survarium\Api\Consumer')->disableOriginalConstructor()->getMock();
        $consumer->method('getPrivateKey')->willReturn($consumerString);

        $sp = new SignatureProcessor();
        $signature = $sp->buildSignature($request, $consumer);
        $this->assertEquals($result, $signature);
    }



    public function signatureDataProvider()
    {
        return [
            ['f0/Wf8QkSkruaDWg48oMkWQGnDg=', 'test string' , 'test'],
            ['/IUIdFJpblvL47enH94A4yCvLMo=', '' , 'test'],
            ['wdBUMZAinjZHgKuvr7+0Ze6N1do=', 'test string' , ''],
        ];
    }
}