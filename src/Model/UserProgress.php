<?php

namespace Temper\Model;

class UserProgress implements UserProgressInterface
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $onboardingPercentage = 0;

    /**
     * @var int
     */
    private $countApplications = 0;

    /**
     * @var int
     */
    private $countAcceptedApplications = 0;

    /**
     * @inheritDoc
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @inheritDoc
     */
    public function setUserId(string $userId): UserProgress
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(\DateTime $createdAt): UserProgress
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOnboardingPercentage(): int
    {
        return $this->onboardingPercentage;
    }

    /**
     * @inheritDoc
     */
    public function setOnboardingPercentage(int $onboardingPercentage): UserProgress
    {
        $this->onboardingPercentage = $onboardingPercentage;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCountApplications(): int
    {
        return $this->countApplications;
    }

    /**
     * @inheritDoc
     */
    public function setCountApplications(int $countApplications): UserProgress
    {
        $this->countApplications = $countApplications;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCountAcceptedApplications(): int
    {
        return $this->countAcceptedApplications;
    }

    /**
     * @inheritDoc
     */
    public function setCountAcceptedApplications(int $countAcceptedApplications): UserProgress
    {
        $this->countAcceptedApplications = $countAcceptedApplications;

        return $this;
    }
}
