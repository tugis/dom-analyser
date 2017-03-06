<?php

declare (strict_types = 1);

namespace Tests\Commands;

use App\Services\DomAnalyserService;
use App\Services\DomAnalysisExporter;
use App\Services\DomStats;
use App\Services\TagStats;
use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

class AnalyseCommandTest extends TestCase
{
    /**
     * @test
     */
    public function analyse__should_analyse_a_given_url_and_export_results_as_json()
    {
        $url = 'http://www.sapo.pt';

        $analyserService = \Mockery::mock(DomAnalyserService::class)->makePartial();
        $this->app->instance(DomAnalyserService::class, $analyserService);

        $analyserExporter = \Mockery::mock(DomAnalysisExporter::class, [new Filesystem])->makePartial();
        $this->app->instance(DomAnalysisExporter::class, $analyserExporter);

        $mockedAnalysis = $this->createMockedDomAnalysis();

        $analyserService
            ->shouldReceive('analyse')
            ->with($url)
            ->andReturn($mockedAnalysis);

        $analyserExporter
            ->shouldReceive('export')
            ->with($url, $mockedAnalysis);

        $this->artisan('analyse', [
            'url' => $url,
        ]);
    }

    /**
     * @return \App\Services\DomStats
     */
    private function createMockedDomAnalysis()
    {
        $domStats = new DomStats;

        $domStats->setTotalClasses(100);
        $domStats->setTotalIds(20);
        $domStats->setTagsStats([
            new TagStats('a', 10, 10, 20),
            new TagStats('div', 23, 12, 21),
        ]);

        return $domStats;
    }
}
