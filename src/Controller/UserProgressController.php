<?php

namespace Temper\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Temper\Service\UserRetentionChartService;
use Temper\Enum\ResponseEnum;

class UserProgressController
{
    /**
     * @var UserRetentionChartService
     */
    private $userRetentionChartService;

    /**
     * UserProgressController constructor.
     * @param UserRetentionChartService $userRetentionChartService
     */
    public function __construct(UserRetentionChartService $userRetentionChartService)
    {
        $this->userRetentionChartService = $userRetentionChartService;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws \Exception
     */
    public function getRetentionChartDataAction(Request $request, Response $response, $args): Response
    {
        $chart = $this->userRetentionChartService->getUserRetentionChartData();
        $response->getBody()->write(json_encode($chart));

        return $response
            ->withHeader(ResponseEnum::HEADER_CONTENT_TYPE, ResponseEnum::APPLICATION_JSON);
    }
}
