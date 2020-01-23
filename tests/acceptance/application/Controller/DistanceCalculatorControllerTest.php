<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WoodWing\Application\Controller\DistanceCalculator\HttpController;
use WoodWing\Application\Service\DistanceCalculatorService;

class DistanceCalculatorControllerTest extends TestCase
{
    /** @var HttpController */
    private $controller;

    public function setUp(): void
    {
        $this->controller =  $controller = new HttpController(new DistanceCalculatorService());
    }

    public function testControllerWorksWithValidInput(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'resultUnit' => 'm',
            'distances' => [
                [
                    'distance' => 5,
                    'unit' => 'm'
                ],
                [
                    'distance' => 3,
                    'unit' => 'yd'
                ],
            ]
        ]));

        $this->assertEquals(new JsonResponse(['result' => '7.74 m'], 200), $this->controller->invoke($request));
    }

    public function testControllerValidationWorksForMissingDesiredUnitKey(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'distances' => [
                [
                    'distance' => 5,
                    'unit' => 'm'
                ],
                [
                    'distance' => 3,
                    'unit' => 'yd'
                ],
            ]
        ]));

        $expectedResponse = new JsonResponse('', 400);
        $actualResponse = $this->controller->invoke($request);

        $this->assertSame($expectedResponse->getStatusCode(), $actualResponse->getStatusCode());
    }

    public function testControllerValidationWorksForMissingDistancesKey(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'resultUnit' => 'm'
        ]));

        $expectedResponse = new JsonResponse('', 400);
        $actualResponse = $this->controller->invoke($request);

        $this->assertSame($expectedResponse->getStatusCode(), $actualResponse->getStatusCode());
    }

    public function testControllerValidationWorksForInvalidDistanceItem(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'resultUnit' => 'm',
            'distances' => [
                [
                    'invalid' => 5,
                    'unit' => 'm'
                ],
                [
                    'distance' => 3,
                    'unit' => 'yd'
                ],
            ]
        ]));

        $expectedResponse = new Response('', 400);
        $actualResponse = $this->controller->invoke($request);

        $this->assertSame($expectedResponse->getStatusCode(), $actualResponse->getStatusCode());
    }

    public function testControllerValidationWorksForDistanceItemWithUnknownUnit(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'resultUnit' => 'm',
            'distances' => [
                [
                    'distance' => 5,
                    'unit' => 'unknown'
                ],
                [
                    'distance' => 3,
                    'unit' => 'yd'
                ],
            ]
        ]));

        $expectedResponse = new JsonResponse('', 400);
        $actualResponse = $this->controller->invoke($request);

        $this->assertSame($expectedResponse->getStatusCode(), $actualResponse->getStatusCode());
    }
}