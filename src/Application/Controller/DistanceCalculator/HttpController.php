<?php

namespace WoodWing\Application\Controller\DistanceCalculator;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WoodWing\Application\Exception\AssertionError;
use WoodWing\Application\Service\DistanceCalculatorService;
use WoodWing\Domain\Distance;
use WoodWing\Domain\DistanceUnit;

class HttpController
{
    /** @var DistanceCalculatorService  */
    private $service;

    /**
     * HttpController constructor.
     * @param DistanceCalculatorService $service
     */
    public function __construct(DistanceCalculatorService $service)
    {
        $this->service = $service;
    }

    public function invoke(Request $request): JsonResponse
    {
        try {
            $input = json_decode($request->getContent(false), true, 512, JSON_THROW_ON_ERROR);
            DistanceInputValidator::validate($input);

            $distances = array_map(function($distance) {
                return new Distance($distance['distance'], new DistanceUnit($distance['unit']));
            }, $input['distances']);

            $desiredResultUnit = new DistanceUnit($input['resultUnit']);

            $result = $this->service->calculateSum($distances, $desiredResultUnit);

            return new JsonResponse([
                'result' => sprintf('%.2f %s', $result->getValue(), $result->getUnit()->getValue())
            ], 200);
        } catch (AssertionError|InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 400);
        } catch (Exception $exception) {
            // todo: log error
            return new JsonResponse(['error' => 'Something went wrong'], 500);
        }
    }
}