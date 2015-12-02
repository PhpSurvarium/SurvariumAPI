# Survarium API 
It is a recommended example of API client for api.survarium.com.
You can request for some information about Survarium with help of API.

## Usage
You can install it through composer by adding next lines to your composer.json

```
{
    "require" : {
        "survarium/api" : "*"
    }
}
```

If you do not use composer you should add next line to your php script

```
* require  DIR  . '/autoload.php'; 
```
where DIR is filepath to root library directory.
You can use $survariumApi object to retrieve necessary data:

```
$survariumApi = new \Survarium\Api\SurvariumApi('Shared key', 'Private key');
$maxMatchId = $survariumApi->getMaxMatchId($publicAccountId); 
```

In order to get personal credentials, to use our API, please, mail to mail@vostokgames.com.

 