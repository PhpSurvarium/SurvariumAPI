<?php
/**
 * Class that creates and checks signatures
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */

namespace Survarium\Api;

class SignatureProcessor
{
     /**
     * Chose acceptbale algo that exists on client side
     * @var array
     */
    protected $acceptedAlgos = [
        'sha1'
    ];

    /**
     * Return algorithm name
     *
     * @return string
     */
    public function getName()
    {
        return 'HMAC-SHA1';
    }

    /**
     * Create signature
     *
     * @param  Request  $request
     * @param  Consumer $consumer
     * @return string
     * @throws SurvariumException
     */
    public function buildSignature(Request $request, Consumer $consumer)
    {
        $algorithm = $this->getAcceptedAlgorithm();
        return base64_encode(hash_hmac($algorithm, $request->getSignatureString(), $consumer->getPrivateKey(), true));
    }


    /**
     * Check signature
     *
     * @param  $signature
     * @param  Request   $request
     * @param  Consumer  $consumer
     * @return bool
     */
    public function checkSignature($signature, Request $request, Consumer $consumer)
    {
        $rightSignature = $this->buildSignature($request, $consumer);
        if ($rightSignature === $signature) {
            return true;
        }
        return false;
    }

    /**
     * Choose acceptable algorithm installed on client OS
     *
     * @return mixed
     * @throws SurvariumException
     */
    protected function getAcceptedAlgorithm()
    {
        $algos = hash_algos();
        foreach ($this->acceptedAlgos as $currentAlgo) {
            if (in_array($currentAlgo, $algos)) {
                return $currentAlgo;
            }
        }
        throw new SurvariumException('Install necessary hash algorithm (SHA1)');
    }
}
