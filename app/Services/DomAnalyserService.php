<?php

declare (strict_types = 1);

namespace App\Services;

use App\Exceptions\FailedToLoadUrlException;
use DiDom\Document;

class DomAnalyserService
{
    /**
     * @var \DiDom\Document
     */
    private $document;

    /**
     * @var \App\Services\DomStats
     */
    private $domStats;

    /**
     * @param \DiDom\Document $document
     * @param \App\Services\DomStats $domStats
     */
    public function __construct(Document $document, DomStats $domStats)
    {
        $this->document = $document;
        $this->domStats = $domStats;
    }

    /**
     * @param string $url
     *
     * @return \App\Services\DomStats
     *
     * @throws \App\Exceptions\FailedToLoadUrlException
     */
    public function analyse(string $url)
    {
        try {
            $this->document->loadHtmlFile($url);

            $this->domStats->setTagsStats($this->performTagsAnalysis());
            $this->domStats->setTotalClasses($this->getAttributeCount('class'));
            $this->domStats->setTotalIds($this->getAttributeCount('id'));

            return $this->domStats;
        } catch (\Exception $exception) {
            throw new FailedToLoadUrlException($url);
        }
    }

    /**
     * @return int
     */
    private function getAttributeCount(string $attribute) : int
    {
        return count($this->document->find("[$attribute]"));
    }

    /**
     * @return array
     */
    private function performTagsAnalysis() : array
    {
        $tagsStats = [];
        foreach ($this->getTagsList() as $tagName) {
            $elements = $this->document->find($tagName);

            $tagStats = new TagStats(
                $tagName,
                (int) $this->document->count($tagName),
                (int) $this->getNumberOfAttributes($elements),
                (int) $this->getNumberOfChildren($elements)
            );
            $tagsStats[$tagName] = $tagStats;
        }

        return $tagsStats;
    }

    /**
     * @param array $elements
     *
     * @return int
     */
    private function getNumberOfAttributes(array $elements) : int
    {
        $attributesNumber = 0;

        /** @var \DiDom\Element $element */
        foreach ($elements as $element) {
            try {
                $attributesNumber += count($element->attributes());
            } catch (\InvalidArgumentException $exception) {

            }
        }

        return $attributesNumber;
    }

    /**
     * @param array $elements
     *
     * @return int
     */
    private function getNumberOfChildren(array $elements) : int
    {
        $childrenNumber = 0;

        /** @var \DiDom\Element $element */
        foreach ($elements as $element) {

            try {
                $childrenNumber += count($element->children());
            } catch (\InvalidArgumentException $exception) {

            }
        }

        return $childrenNumber;
    }

    /**
     * @return array
     */
    private function getTagsList() : array
    {
        return json_decode(file_get_contents(__DIR__ . '/html_tags.json', true));
    }
}
