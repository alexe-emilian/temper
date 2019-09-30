<?php

namespace Temper\Model;

interface UserProgressInterface
{
    /**
     * @return string
     */
    public function getUserId(): string;

    /**
     * @param string $userId
     * @return UserProgress
     */
    public function setUserId(string $userId): UserProgress;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $createdAt
     * @return UserProgress
     */
    public function setCreatedAt(\DateTime $createdAt): UserProgress;

    /**
     * @return int
     */
    public function getOnboardingPercentage(): int;

    /**
     * @param int $onboardingPercentage
     * @return UserProgress
     */
    public function setOnboardingPercentage(int $onboardingPercentage): UserProgress;

    /**
     * @return int
     */
    public function getCountApplications(): int;

    /**
     * @param int $countApplications
     * @return UserProgress
     */
    public function setCountApplications(int $countApplications): UserProgress;

    /**
     * @return int
     */
    public function getCountAcceptedApplications(): int;

    /**
     * @param int $countAcceptedApplications
     * @return UserProgress
     */
    public function setCountAcceptedApplications(int $countAcceptedApplications): UserProgress;
}
