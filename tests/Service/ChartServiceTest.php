<?php

namespace Temper\Tests\Service;

use PHPUnit\Framework\TestCase;
use Temper\Model\UserProgress;
use Temper\Repository\UserProgressRepository;
use Temper\Service\UserRetentionChartService;

class ChartServiceTest extends TestCase
{
    public function testThatRetentionChartDataIsBuilt(): void
    {
        $userProgressRepository = $this->getMockBuilder(UserProgressRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userProgressRepository->method('findGroupedByYearWeek')
            ->willReturn([
                '2019-20' => [
                    (new UserProgress())->setUserId('1111')
                        ->setCreatedAt(new \DateTime())
                        ->setOnboardingPercentage(50)
                        ->setCountApplications(0)
                        ->setCountAcceptedApplications(0)
                ]
            ]);
        $chartService = new UserRetentionChartService($userProgressRepository);
        $result = $chartService->getUserRetentionChartData();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('chart', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('xAxis', $result);
        $this->assertArrayHasKey('yAxis', $result);
        $this->assertArrayHasKey('series', $result);
    }
}
