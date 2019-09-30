<?php

namespace Temper\Service;

use Temper\Enum\StepsEnum;
use Temper\Model\UserProgressInterface;
use Temper\Repository\UserProgressRepository;

class UserRetentionChartService
{
    /**
     * @var UserProgressRepository
     */
    private $userProgressRepository;

    /**
     * ChartService constructor.
     * @param UserProgressRepository $userProgressRepository
     */
    public function __construct(UserProgressRepository $userProgressRepository)
    {
        $this->userProgressRepository = $userProgressRepository;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getUserRetentionChartData(): array
    {
        $chart = $this->getDefaultChartConfiguration();
        $steps = $this->getSteps();

        $groupedEntries = $this->userProgressRepository->findGroupedByYearWeek();
        foreach ($groupedEntries as $yearWeek => $userProgressEntries) {
            $weeklyRetentionBySteps = $this->countWeeklyRetentionBySteps($userProgressEntries, $steps);
            $chart['series'][] = [
                'name' => $this->getFormattedChartDate($yearWeek),
                'data' => $this->buildChartData($weeklyRetentionBySteps, count($userProgressEntries)),
            ];
        }

        return $chart;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getDefaultChartConfiguration(): array
    {
        return [
            'chart' => [
                'type' => 'line',
            ],
            'title' => [
                'text' => 'Weekly Retention Curve',
            ],
            'credits' => [
                'enabled' => false,
            ],
            'xAxis' => [
                'categories' => array_values($this->getSteps()),
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Total Onboarded',
                ],
                'labels' => [
                    'format' => '{value}%',
                ],
                'min' => '0',
                'max' => '100',
            ],
            'tooltip' => [
                'valueSuffix' => '%',
            ],
        ];
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getSteps(): array
    {
        return (new \ReflectionClass(StepsEnum::class))->getConstants();
    }

    /**
     * @param array $userProgressEntries
     * @param array $steps
     * @return array
     */
    private function countWeeklyRetentionBySteps(array $userProgressEntries, array $steps): array
    {
        $weeklyRetention = [];
        /** @var UserProgressInterface $userProgressEntry */
        foreach ($userProgressEntries as $userProgressEntry) {
            foreach ($steps as $step => $onboardingPercentage) {
                if ($userProgressEntry->getOnboardingPercentage() >= $onboardingPercentage) {
                    $weeklyRetention = $this->setStepValue($weeklyRetention, $step);
                }
            }
        }

        return $weeklyRetention;
    }

    /**
     * @param array $weeklyRetention
     * @param string $step
     * @return array
     */
    private function setStepValue(array $weeklyRetention, string $step): array
    {
        if(!isset($weeklyRetention[$step])) {
            $weeklyRetention[$step] = 0;

            return $weeklyRetention;

        }
        $weeklyRetention[$step] += 1;

        return $weeklyRetention;
    }

    /**
     * @param array $weeklyRetention
     * @param int $numberOfEntries
     * @return array
     */
    private function buildChartData(array $weeklyRetention, int $numberOfEntries): array
    {
        $chartData = [];
        foreach ($weeklyRetention as $retention) {
            $chartData[] = round(($retention/$numberOfEntries) * 100);
        }

        return $chartData;
    }

    /**
     * @param string $yearWeek
     * @return string
     * @throws \Exception
     */
    private function getFormattedChartDate(string $yearWeek): string
    {
        $date = explode('-', $yearWeek);
        $year = $date[0];
        $week = $date[1];
        $dateTime = new \DateTime();
        $dateTime->setISODate($year, $week);

        return $dateTime->format('Y-m-d');
    }
}
