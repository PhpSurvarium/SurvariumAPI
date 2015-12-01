<?php
/**
 * Request.php
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */

namespace Survarium\Api;

class Request
{

    protected $headers = [];

    protected $body = null;

    /**
     * Url with GET params
     */
    protected $requestUrl;

    protected $nonce;

    protected $timestamp;

    /**
     * We use only GET method yet
     */
    protected $httpMethod;

    public $params;

    protected $authParams = [];

    public function __construct($method, $urlPath, array $urlParams = null,  Consumer $consumer)
    {
        $this->nonce = $this->generateNonce();
        $this->timestamp = time();
        $this->requestUrl = $this->createFullUrl($urlPath, $urlParams);
        $this->httpMethod = $method;
        $this->signatureRequest($consumer);
    }

    /**
     *
     * @param $urlPath
     * @param array   $urlParams
     * @return string
     */
    protected function createFullUrl($urlPath, array $urlParams)
    {
        $url = Controller::baseUrl . rawurldecode($urlPath);
        if (!empty($urlParams)) {
            $url .= '?' .  http_build_query($urlParams);
        }
        return $url;

    }

    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * Create auth params for request
     *
     * @param Consumer
     */
    protected function signatureRequest(Consumer $consumer)
    {
        $signature = new SignatureProcessor();
        $sign = $signature->buildSignature($this, $consumer);
        $this->setAuthParams('surv_consumer_key', $consumer->getSharedKey());
        $this->setAuthParams('surv_nonce', $this->nonce);
        $this->setAuthParams('surv_signature', $sign);
        $this->setAuthParams('surv_signature_method', $signature->getName());
        $this->setAuthParams('surv_timestamp', $this->timestamp);
    }

    /**
     * @return string
     */
    public function getSignatureString()
    {
        return $this->requestUrl . $this->httpMethod . $this->nonce;
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setAuthParams($key, $value)
    {
        $this->authParams[$key] = $value;
    }

    /**
     * @return string
     */
    protected function generateNonce()
    {
        return md5(mt_rand() . time());
    }

    /**
     * Combine necessary headers params to string
     *
     * @return string
     */
    public function getAuthHeader()
    {
        $first = true;
        $output = 'OAuth ';
        foreach ($this->authParams as $key => $value) {
            $separator = ($first == true)? ' ' : ', ';
            $output .= $separator  . rawurlencode($key) . '="' . rawurlencode($value) . '"' ;
            $first = false;
        }
        return $output;
    }

    /**
     * Get Headers array and return
     * @return array
     */
    public function getHeaders()
    {
        $authHeader = $this->getAuthHeader();
        return [
            'Accept: application/json',
            'Authorization:' . $authHeader,
            'Expect:'
        ];
    }

    /**
     * @return mixed
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }
}