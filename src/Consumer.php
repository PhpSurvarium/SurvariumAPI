<?php
/**
 * Consumer
 *
 * Store shared and private keys
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */

namespace Survarium\Api;

class Consumer
{
    private $sharedKey;

    private $privateKey;

    public function __construct($sharedKey, $privateKey)
    {
        $this->sharedKey  = $sharedKey;
        $this->privateKey = $privateKey;
    }

    /**
     * @return mixed
     */
    public function getSharedKey()
    {
        return $this->sharedKey;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }



}