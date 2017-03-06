<?php

declare (strict_types = 1);

namespace Tests\Commands;

use App\Services\DomAnalyserService;
use App\Services\DomStats;
use DiDom\Document;
use Tests\TestCase;

class DomAnalyserServiceTest extends TestCase
{
    /**
     * @test
     *
     * @expectedException \App\Exceptions\FailedToLoadUrlException
     */
    public function analyse__should_throw_failed_to_load_url_exception_if_url_does_not_exist()
    {
        /** @var \App\Services\DomAnalyserService $analyser */
        $analyser = new DomAnalyserService(new Document, new DomStats);

        $analyser->analyse('http://nonexistingurl.xpto');
    }

    /**
     * @test
     */
    public function analyse__should_analyse_a_given_url_and_collect_information()
    {
        $url = __DIR__ . '/_fixtures/testCase.html';

        /** @var \App\Services\DomAnalyserService $analyser */
        $analyser = new DomAnalyserService(new Document, new DomStats);

        $results = $analyser->analyse($url);

        /** @var \App\Services\TagStats $divStats */
        $divStats = $results->getTagsStats()['div'];

        $this->assertInstanceOf(DomStats::class, $results);
        $this->assertEquals(3, $results->getTotalClasses());
        $this->assertEquals(3, $divStats->getTagCount());
        $this->assertEquals('div', $divStats->getTagName());
        $this->assertEquals(7, $divStats->getChildrenCount());
        $this->assertEquals(3, $divStats->getAttributesCount());
    }
}
