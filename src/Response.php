<?php
/**
 * Response.php
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 * @todo    add ability to supply body in different formats
 */

namespace Survarium\Api;

class Response
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @var array of headers
     */
    protected $headers;

    protected $statusCode = 0;

    /**
     * @return mixed
     */
    public function getBody()
    {
        $result = null;
        if (!empty($this->headers['Content-Type'])) {
            switch ($this->headers['Content-Type'])
            {
                case 'application/json':
                    $result = JsonTransformer::decode($this->body);
                    break;
                default:
                    $result = $this->body;
            }
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $body
     */
    public function setBodyString($body)
    {
        $this->body = $this->parseBody($body);
    }

    /**
     * @param $headers
     */
    public function setHeadersString($headers)
    {
        $this->headers = $this->parseHeaders($headers);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $code
     */
    public function setStatusCode($code)
    {
        $this->statusCode = (int)$code;
    }

    /**
     * It takes raw header string return array of key value headers
     *
     * @param  $headers
     * @return array
     */
    public function parseHeaders($headers)
    {
        $resultArray = [];
        $headerLines = explode("\r\n", $headers);
        foreach ($headerLines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $resultArray[trim($key)] = trim($value);
            }
        }
        return $resultArray;
    }

    /**
     * Change body format
     *
     * Could be implemented later
     *
     * @param  $body
     * @return mixed
     */
    protected function parseBody($body)
    {
        return $body;
    }

}