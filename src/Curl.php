<?php
/**
 * Curl Class
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */
namespace Survarium\Api;

class Curl
{
    protected $curl;

    protected $request;

    protected $response;

    protected $defaultOptions = [
        CURLOPT_MAXREDIRS => 0,
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'gzip',
        CURLOPT_HEADER => true
    ];

    public function __construct(Request $request, Response $response)
    {
        if (!extension_loaded('curl')) {
            throw new SurvariumException('You should install curl extendion');
        }
        $this->curl = curl_init();
        $this->request = $request;
        $this->response = $response;
        $this->setOptions(
            $request->getRequestUrl(),
            $request->getHeaders(),
            $request->getHttpMethod()
        );
    }

    public function setOptions($url, $headers, $method = 'GET')
    {
        $curlOptions = [
           CURLOPT_URL => $url,
           CURLOPT_HTTPHEADER => $headers,
        ];

        $resultOptions  =  $this->defaultOptions + $curlOptions ;

        curl_setopt_array($this->curl, $resultOptions);
    }

    public function send()
    {
        $response =  curl_exec($this->curl);

        if (curl_errno($this->curl) > 0) {
            throw new SurvariumException(curl_error($this->curl), curl_errno($this->curl));
        }

        $this->response->setStatusCode(curl_getinfo($this->curl, CURLINFO_HTTP_CODE));
        //split headers and body
        $parts = explode("\r\n\r\n", $response);
        $responseBody = array_pop($parts);
        $responseHeader = array_pop($parts);
        $this->response->setHeaders($responseHeader);
        $this->response->setBody($responseBody);
        curl_close($this->curl);
    }

}


