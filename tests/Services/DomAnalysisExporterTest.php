<?php

declare (strict_types = 1);

namespace Tests\Commands;

use App\Services\DomAnalysisExporter;
use App\Services\DomStats;
use App\Services\TagStats;
use Tests\TestCase;

class DomAnalysisExporterTest extends TestCase
{
    /**
     * @test
     */
    public function export__should_export_dom_stats_to_a_json_file()
    {
        $url = 'http://www.sapo.pt/';

        /** @var \App\Services\DomAnalysisExporter $exporter */
        $exporter = $this->app->build(DomAnalysisExporter::class);

        $exportedPath = $exporter->export($this->createMockedDomStats(), $url);

        $this->assertFileExists($exportedPath);

        $this->assertEquals(trim(file_get_contents($exportedPath)), trim($this->getExpectedJsonOutput()));
    }

    /**
     * @return \App\Services\DomStats
     */
    private function createMockedDomStats() : DomStats
    {
        $domStats = new DomStats;

        $domStats->setTotalClasses(100);
        $domStats->setTotalIds(20);
        $domStats->setTagsStats([
            new TagStats('a', 10, 10, 20),
            new TagStats('div', 23, 12, 21),
            new TagStats('video', 12, 4, 122),
        ]);

        return $domStats;
    }

    /**
     * @return string
     */
    private function getExpectedJsonOutput() : string
    {
        return file_get_contents(__DIR__ . '/_fixtures/expectedJsonOutput.json');
    }
}
