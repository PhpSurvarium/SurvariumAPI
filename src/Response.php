<?php
/**
 * Response.php
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com

 */

namespace Survarium\Api;

class Response
{
    protected $body;

    protected $headers;

    protected $statusCode = 0;

    public function getBody()
    {
        return $this->body;
    }

    public function getHeader()
    {
        return $this->headers;
    }

    public function setBody($body)
    {
        $this->body = $this->parseBody($body);
    }

    public function setHeaders($headers)
    {
        $this->headers = $this->parseHeaders($headers);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($code)
    {
        $this->statusCode = (int)$code;
    }

    protected function parseHeaders($headers)
    {
        $resultArray = [];
        $headerLines = explode('/r/n', $headers);
        foreach ($headerLines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line);
                $resultArray[$key] = $value;
            }
        }
        return $resultArray;

    }

    protected function parseBody($body)
    {
        return json_decode($body, true);
    }

}