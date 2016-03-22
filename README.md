# Survarium API 
It is a recommended example of API client for api.survarium.com.
You can request some statistic information about Survarium with help of API.

## Usage
You can install it through composer by adding next lines to your composer.json

```
{
    "require" : {
        "survarium/api" : "dev-master@dev"
    }
}
```

If you do not use composer you should add next line to your php script

```
require  DIR  . '/autoload.php'; 
```
where DIR is filepath to root library directory.
You can use $survariumApi object to retrieve necessary data:

```
$survariumApi = new \Survarium\Api\SurvariumApi('test', 'test');
$maxMatchId = $survariumApi->getMaxMatchId(); 
```

API server is under development now. You can use it only for test now.
In order to get personal credentials for our API, please, mail to phoenix@vostokgames.com.

 
