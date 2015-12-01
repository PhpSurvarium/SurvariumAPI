<?php
/**
 * Facade class for using by community
 *
 * Contains all basic requests to Survarium API server
 *
 * @package Survarium\Api
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author: Maxim Gar<maxim@vostokgames.com>
 * @version 1.0
 * @link    survarium.com
 */

namespace Survarium\Api;

class SurvariumApi
{
    private $controller;

    public function __construct($sharedKey, $secretKey)
    {
        $this->controller = new Controller($sharedKey, $secretKey);
    }

    /**
     *
     * @param $pid
     * @return mixed
     */
    public function getMaxMatchId($pid)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getmaxmatchid', ['pid' => $pid]));
    }

    /**
     * Retrieve user nickname by public account ids
     * @param $nickname
     * @return array
     */
    public function getPublicIdByNickname($nickname)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getpublicidbynickname', ['nickname' => $nickname]));
    }

    /**
     * Retrieve a bunch of nicknames by array of public account ids
     *
     * @param  array $pidArray
     * @return mixed
     */
    public function getNicknamesByPublicIds($pidArray)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getnicknamesbypidarray', ['pids' => $pidArray]));
    }

    /**
     * Retrieve amount of played matches by public account Id
     *
     * @param  $pid
     * @return mixed
     */
    public function matchesCountByPublicId($pid)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getmatchescountbypid', ['pid' => $pid]));
    }

    /**
     * Retrieve particular amount of played matches  by public account id
     *
     * @param  $pid
     * @param  $matchAmount
     * @param  $offset - offset from last played match( by default 0
     * @return mixed
     */
    public function getMatchesIdByPublicId($pid, $matchAmount = 10, $offset = 0)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getmatchescountbypid', ['pid' => $pid]));
    }

    /**
     * Retrieve statistic of particular match by match_id
     *
     * @param  $matchId
     * @return mixed
     */
    public function getMatchStatistic($matchId)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getmatchstatisticbyid', ['matchid' => $matchId]));
    }

    /**
     * Retrieve all user data
     *
     * @param  $pid
     * @return mixed
     */
    public function getUserData($pid)
    {
        return $this->returnResponseBody($this->controller->sendGetRequest('getuserdatabypid', ['pid' => $pid]));
    }

    /**
     * Check if request was successful and return body of the request
     *
     * @param  Response $response
     * @return array
     */
    private function returnResponseBody(Response $response)
    {
        if ($response->getStatusCode() == 200) {
            return $this->returnResult($response->getStatusCode(), $response->getBody());
        } else {
            return $this->returnResult($response->getStatusCode(), false);
        }
    }

    /**
     * Return result array
     *
     * @param  $result
     * @param  $data
     * @return array
     */
    private function returnResult($result, $data)
    {
        return [
             'code' => $result,
             'data' => $data
        ];
    }

}

