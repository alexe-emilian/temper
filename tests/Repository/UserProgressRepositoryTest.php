<?php

namespace Temper\Tests\Repository;

use PHPUnit\Framework\TestCase;
use Temper\Model\UserProgress;
use Temper\Repository\UserProgressRepository;
use Temper\Service\CsvService;

class UserProgressRepositoryTest extends TestCase
{
    public function testThatDataIsProperlyFormattedFromTheCsv(): void
    {
        $csvData = [
            [
                'user_id' => '3121',
                'created_at' => '2016-07-19',
                'onboarding_perentage' => '40',
                'count_applications' => '0',
                'count_accepted_applications' => '0',
            ]
        ];
        $csvService = $this->getMockBuilder(CsvService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $csvService->method('getContents')->willReturn($csvData);
        $userProgressRepository = new UserProgressRepository($csvService);
        $result = $userProgressRepository->findGroupedByYearWeek();

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, $result);
        $this->assertInstanceOf(UserProgress::class, $result['2016-29'][0]);
    }
}
