<?php

declare (strict_types = 1);

namespace App\Services;

class TagStats
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var int
     */
    private $tagCount;

    /**
     * @var int
     */
    private $attributesCount;

    /**
     * @var int
     */
    private $childrenCount;

    /**
     * @param string $tagName
     * @param int $tagCount
     * @param int $attributesCount
     * @param int $childrenCount
     */
    public function __construct(string $tagName, int $tagCount, int $attributesCount, int $childrenCount)
    {
        $this->tagName = $tagName;
        $this->tagCount = $tagCount;
        $this->attributesCount = $attributesCount;
        $this->childrenCount = $childrenCount;
    }

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }

    /**
     * @return int
     */
    public function getTagCount(): int
    {
        return $this->tagCount;
    }

    /**
     * @return int
     */
    public function getAttributesCount(): int
    {
        return $this->attributesCount;
    }

    /**
     * @return int
     */
    public function getChildrenCount(): int
    {
        return $this->childrenCount;
    }
}
