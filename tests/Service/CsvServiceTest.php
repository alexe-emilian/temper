<?php

namespace Temper\Tests\Service;

use PHPUnit\Framework\TestCase;
use Temper\Repository\UserProgressRepository;
use Temper\Service\CsvService;

class CsvServiceTest extends TestCase
{
    public function testThatGivenFileExists(): void
    {
        $csvService = new CsvService();
        $result = $csvService->getContents(UserProgressRepository::USER_PROGRESS_PATH);

        $this->assertIsArray($result);
    }
}
