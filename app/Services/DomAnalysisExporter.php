<?php

declare (strict_types = 1);

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DomAnalysisExporter
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param \App\Services\DomStats $domStats
     * @param string $url
     *
     * @return string
     */
    public function export(DomStats $domStats, string $url) : string
    {
        $response = [
            'tags' => $this->formatTagsStatsInfo($domStats->getTagsStats()),
            'totalClasses' => $domStats->getTotalClasses(),
            'totalIds' => $domStats->getTotalIds(),
        ];

        $exportedPath = $this->getExportPath($url);
        if (! $this->filesystem->put($this->getExportPath($url), json_encode($response))) {
            throw new FileException('Not possible to create exported file result');
        }

        return $exportedPath;
    }

    /**
     * @param array $tagsStats
     *
     * @return array
     */
    private function formatTagsStatsInfo(array $tagsStats)
    {
        return array_map(function (TagStats $item) {
            return [
                'name' => $item->getTagName(),
                'count' => $item->getTagCount(),
                'childrenCount' => $item->getChildrenCount(),
                'attributesCount' => $item->getAttributesCount(),
            ];
        }, $tagsStats);
    }


    /**
     * @param string $url
     *
     * @return string
     */
    private function getExportPath(string $url)
    {
        $urlParts = parse_url($url);
        $path = str_replace('/', '\\', sprintf(
            '%s%s',
            $urlParts['host'],
            isset($urlParts['path']) ? $urlParts['path'] : ''
        ));

        return sprintf('%s/%s_%d.json', storage_path('app'), stripslashes($path), time());
    }
}
