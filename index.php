<?php

use Symfony\Component\HttpFoundation\Request;
use WoodWing\Application\Controller\DistanceCalculator\HttpController;
use WoodWing\Application\Service\DistanceCalculatorService;

require_once('vendor/autoload.php');

$distanceCalculatorController = new HttpController(new DistanceCalculatorService());
$distanceCalculatorController->invoke(Request::createFromGlobals())->send();
