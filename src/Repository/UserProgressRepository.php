<?php

namespace Temper\Repository;

use Temper\Model\UserProgress;
use Temper\Model\UserProgressInterface;
use Temper\Service\CsvService;

class UserProgressRepository
{
    const USER_PROGRESS_PATH = '../export.csv';
    const DATE_TIME_FORMAT = 'Y-m-d';
    const USER_ID = 'user_id';
    const CREATED_AT = 'created_at';
    const ONBOARDING_PERCENTAGE = 'onboarding_perentage';
    const COUNT_APPLICATIONS = 'count_applications';
    const COUNT_ACCEPTED_APPLICATIONS = 'count_accepted_applications';

    /**
     * @var CsvService
     */
    private $csvService;

    /**
     * UserProgressRepository constructor.
     * @param CsvService $csvService
     */
    public function __construct(CsvService $csvService)
    {
        $this->csvService = $csvService;
    }

    /**
     * @return UserProgressInterface[]
     */
    public function findAll(): array
    {
        $userProgressEntries = $this->csvService->getContents(self::USER_PROGRESS_PATH);

        $result = [];
        foreach ($userProgressEntries as $userProgressEntry) {
            $result[] = (new UserProgress())
                ->setUserId($userProgressEntry[self::USER_ID])
                ->setCreatedAt(
                    \DateTime::createFromFormat(
                        self::DATE_TIME_FORMAT,
                        $userProgressEntry[self::CREATED_AT]
                    )
                )
                ->setOnboardingPercentage((int) $userProgressEntry[self::ONBOARDING_PERCENTAGE])
                ->setCountApplications((int) $userProgressEntry[self::COUNT_APPLICATIONS])
                ->setCountAcceptedApplications((int) $userProgressEntry[self::COUNT_ACCEPTED_APPLICATIONS]);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function findGroupedByYearWeek(): array
    {
        $userProgressEntries = $this->findAll();

        $groupedEntries = [];
        foreach ($userProgressEntries as $userProgressEntry) {
            $groupedEntries[$userProgressEntry->getCreatedAt()->format('Y-W')][] = $userProgressEntry;
        }

        return $groupedEntries;
    }
}
