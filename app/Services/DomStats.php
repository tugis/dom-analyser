<?php

declare (strict_types = 1);

namespace App\Services;

class DomStats
{
    /**
     * @var array
     */
    private $tagsStats;

    /**
     * @var int
     */
    private $totalIds;

    /**
     * @var int
     */
    private $totalClasses;

    /**
     * @return array
     */
    public function getTagsStats(): array
    {
        return $this->tagsStats;
    }

    /**
     * @param array $tagsStats
     */
    public function setTagsStats(array $tagsStats)
    {
        $this->tagsStats = $tagsStats;
    }

    /**
     * @return int
     */
    public function getTotalIds(): int
    {
        return $this->totalIds;
    }

    /**
     * @param int $totalIds
     */
    public function setTotalIds(int $totalIds)
    {
        $this->totalIds = $totalIds;
    }

    /**
     * @return int
     */
    public function getTotalClasses(): int
    {
        return $this->totalClasses;
    }

    /**
     * @param int $totalClasses
     */
    public function setTotalClasses(int $totalClasses)
    {
        $this->totalClasses = $totalClasses;
    }
}
