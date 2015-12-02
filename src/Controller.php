<?php

/**
 * Controller create request and return response
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */

namespace Survarium\Api;

class Controller
{
    protected $request;

    protected $response;

    protected $signatureProcessor;

    /**
     * We can not require ssl from our community so we use http
     * @var string
     */
    const baseUrl = 'http://api.survarium.com/';

    protected $consumer;

    function __construct($sharedKey, $privateKey)
    {
        $this->signatureProcessor = new SignatureProcessor();
        $this->consumer = new Consumer($sharedKey, $privateKey);
    }

    /**
     * Wrapper for sending GET requests
     *
     * @param  $path
     * @param  $urlParams
     * @throws SurvariumException
     * @return Response
     */
    public function sendGetRequest($path, $urlParams)
    {
        return $this->sendHttpRequest('GET', $path, $urlParams);
    }

    /**
     * Send Http request and return response
     *
     * For now we need only get requests
     *
     * @param  $method
     * @param  $path
     * @param  $params
     * @throws SurvariumException
     * @return Response
     */
    private function sendHttpRequest($method, $path, $params)
    {
        $this->request =  new Request($method, $path, $params, $this->consumer, $this->signatureProcessor);
        $this->response = new Response();
        $transporter = new Curl($this->request, $this->response);
        $transporter->send();
        return $this->getResponse();
    }

    /**
     * Response getter
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}