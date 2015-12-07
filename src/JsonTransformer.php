<?php
/**
 * Process jsonString to array and vice versa
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */

namespace Survarium\Api;

class JsonTransformer
{
    /**
     * @param array $array
     * @return string
     */
    public static function encode(array $array)
    {
        return json_encode($array);
    }

    /**
     * @param $jsonString
     * @param bool $asArray
     * @return mixed
     * @throws SurvariumException
     */
    public static function decode($jsonString, $asArray = true)
    {
        if (!is_string($jsonString)) {
            throw new SurvariumException('JsonDecode param should be a string');
        }
        return json_decode($jsonString, $asArray, 256, JSON_BIGINT_AS_STRING);
    }
}