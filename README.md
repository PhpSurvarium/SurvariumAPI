It is an example of API client for api.survarium.com
You can instal it through composer by adding to your composer.json

```
{
    "require" : {
        "survarium/api" : "*"
    }
}

```

If you do not use composer you should add next line to your php script
* require __DIR__ . '/autoload.php'; 
then you can use $survariumApi object to retrieve necessary data:
* $survariumApi = new \Survarium\Api\SurvariumApi('test', 'test');
* $maxMatchId = $survariumApi->getMaxMatchId($publicAccountId); 

But amount of request per second for test user strongly limited.
In order to get personal credentials mail to mail@vostokgames.com