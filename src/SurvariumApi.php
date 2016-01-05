<?php
/**
 * Facade class for using by community
 *
 * Contains all basic requests to Survarium API server.
 * It just wrapper controller and provide methods which will be used by Community members.
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
     * Return max match_id played in Survarium
     * @param $pid
     * @return mixed
     */
    public function getMaxMatchId()
    {
        $params = [
            'path' => 'getmaxmatchid',
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return users public account id by $nickname
     *
     * @param  $nickname
     * @return array
     */
    public function getPublicIdByNickname($nickname)
    {
        $params = [
            'path' => 'getpublicidbynickname',
            'params' => [
                'nickname' => $nickname
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return bunch of nicknames by array of public account ids
     *
     * @param  array $pidArray
     * @return mixed
     */
    public function getNicknamesByPublicIds($pidArray)
    {
        $params = [
            'path' => 'getnicknamesbypidarray',
            'params' => [
                'pids' => implode(',', $pidArray)
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Retrieve amount of played matches by  user whose public account Id equals $pid
     *
     * @param  $pid
     * @return mixed
     */
    public function matchesCountByPublicId($pid)
    {
        $params = [
            'path' => 'getmatchescountbypid',
            'params' => [
                'pid' => $pid
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return particular amount of played matches of user with public account id = $pid
     *
     * @param  $pid
     * @param  $matchAmount
     * @param  $offset - offset from last played match ( by default 0 )
     * @return mixed
     */
    public function getMatchesIdByPublicId($pid, $matchAmount = 10, $offset = 0)
    {
        $params = [
            'path' => 'getmatchesidbypublicid',
            'params' => [
                'pid' => $pid,
                'matchAmount' => $matchAmount,
                'offset' => $offset
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return statistic of particular match by match_id
     *
     * @param  $matchId
     * @param language
     * @return mixed
     */
    public function getMatchStatistic($matchId, $language = 'english')
    {
        $params = [
            'path' => 'getmatchstatisticbyid',
            'params' => [
                'matchid' => $matchId,
                'language' => $language
            ]
        ];
        return $this->returnResponseBody($params);

    }

    /**
     * Return all users data
     *
     * @param  $pid
     * @param language
     * @return mixed
     */
    public function getUserData($pid, $language = 'english')
    {
        $params = [
            'path' => 'getuserdatabypid',
            'params' => [
                'pid' => $pid,
                'language' => $language
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return amount of active clans in Survarium
     *
     * @return array
     */
    public function getClanAmounts()
    {
        $params = [
            'path' => 'getclansamount',
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return list of the clan ids and names  ordered by elo reiting (begin from the top)
     *
     * @param $amount
     * @param $offset
     * @return array
     */
    public function getClans($amount, $offset)
    {
        $params = [
            'path' => 'getclans',
            'params' => [
                'amount' => $amount,
                'offset' => $offset
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return name, abbr, level. elo reiting and pid of clan commander
     *
     * @param $clanId
     * @return array
     */
    public function getClanInfo($clanId)
    {
        $params = [
            'path' => 'getclaninfo',
            'params' => [
                'clanid' => $clanId,
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Return members of given clan with their roles
     *
     * @param $clanId
     * @return array
     */
    public function getClanMembers($clanId)
    {
        $params = [
            'path' => 'getclanmembers',
            'params' => [
                'clanid' => $clanId,
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * @param $language
     * @return array
     */
    public function getSlotsDict($language)
    {
        $params = [
            'path' => 'getslotsdict',
            'params' => [
                'language' => $language
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * @param $language
     * @return array
     */
    public function getItemsDict($language)
    {
        $params = [
            'path' => 'getitemsdict',
            'params' => [
                'language' => $language
            ]

        ];
        return $this->returnResponseBody($params);
    }

    public function getMapsDict($language)
    {
        $params = [
            'path' => 'getmapsdict',
            'params' => [
                'language' => $language
            ]

        ];
        return $this->returnResponseBody($params);
    }

    public function getNewMatches($timestamp, $limit = 50)
    {
        $params = [
            'path' => 'getnewmatchesfrom',
            'params' => [
                'timestamp' => $timestamp,
                'limit'     => $limit
            ]

        ];
        return $this->returnResponseBody($params);
    }

    public function getUserSkills($pid)
    {
        $params = [
            'path' => 'getuserskills',
            'params' => [
                'pid' => $pid
            ]
        ];
        return $this->returnResponseBody($params);
    }

    /**
     * Check if request was successful and return body of the request
     *
     * Here all SurvariumException could be Catched
     *
     * @param  array $params - api path and params
     * @return array
     */
    private function returnResponseBody(array $params)
    {
        try {
            $urlParams = !empty($params['params'])? $params['params'] : [];
            $response = $this->controller->sendGetRequest($params['path'], $urlParams);
            if ($response->getStatusCode() == 200) {
                return $this->returnResult($response->getStatusCode(), $response->getBody());
            } else {
                return $this->returnResult($response->getStatusCode(), false);
            }
        } catch (SurvariumException $e) {
            return $this->returnResult($e->getCode(), $e->getMessage());
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

