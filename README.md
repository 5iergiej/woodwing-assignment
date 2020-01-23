# WoodWing Assignment
## Assignment: “Distance calculator”

Goal: Make a web service that accepts two distances (numbers) and returns the total distance
(sum of both).

Specifications: For each of the two distances, the requester can specify a unit, either Meters or
Yards.

Also for the returned total distance, the requester must specify a unit as well.
For example, the request could be 3 Yards + 5 Meters = ... Meters, and the response would be
7.74 Meters.

## Installation
Download composer and run 
```php
composer install
```

## Tests
```php
./vendor/bin/phpunit --testdox
```
The flag is optional but helps to see the result in human-readable format


## Technical details
Project is implemented with DDD approach in mind. Distance is a primary domain object which is combination of a number and a string representing distance unit.

Application service (**DistanceCalculatorService**) will calculate sum of any number of distance items and will convert those which have different unit than desired.

Validator is specific for the request and will validate given request only. The logic is in separate class to not pollute the controller itself.

There are 2 custom exceptions:
* AssertionError - use for validation purpose
* BadRequestException - this should result in 400 http response

## Usage
As there is only one controller it can be accessed in the main route ie. http://localhost". 
Refer to [index.php](index.php) or use the code below
```php
use Symfony\Component\HttpFoundation\Request;
use WoodWing\Application\Controller\DistanceCalculator\HttpController;
use WoodWing\Application\Service\DistanceCalculatorService;

$distanceCalculatorController = new HttpController(new DistanceCalculatorService());
$distanceCalculatorController->invoke(Request::createFromGlobals())->send();
```

Controller will accept a request with JSON body in the following format:
```json
{
    "distances": [
        {
            "distance": 1,
            "unit": "m"
        },
        {
            "distance": 1,
            "unit": "yd"
        }
    ],
    "desiredUnit": "m"
}
```