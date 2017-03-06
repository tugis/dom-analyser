<?php

declare (strict_types = 1);

namespace App\Console\Commands;

use App\Services\DomAnalyserService;
use App\Services\DomAnalysisExporter;
use Illuminate\Console\Command;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class AnalyseCommand extends Command
{
    use ValidatesAttributes;

    /**
     * @var \App\Services\DomAnalyserService
     */
    private $analyserService;

    /**
     * @var \App\Services\DomAnalysisExporter
     */
    private $analysisExporter;

    /** @var string */
    protected $signature = 'analyse {url : (required)  The URL we want to analyse}';

    /** @var string */
    protected $description = 'Analyses a given URL for an HTML document and compiles information about its markup as a json structure.';

    /**
     * @param \App\Services\DomAnalyserService $analyserService
     * @param \App\Services\DomAnalysisExporter $analysisExporter
     */
    public function __construct(DomAnalyserService $analyserService, DomAnalysisExporter $analysisExporter)
    {
        parent::__construct();

        $this->analyserService = $analyserService;
        $this->analysisExporter = $analysisExporter;
    }

    public function handle()
    {
        $url = $this->argument('url');

        $this->validateUrlArgument($url);

        $results = $this->analyserService->analyse($url);
        $exportedPath = $this->analysisExporter->export($results, $url);

        $this->info(sprintf('%s URL was analysed. Results available at %s', $url, $exportedPath));
    }

    /**
     * @param string $argument
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    private function validateUrlArgument(string $argument)
    {
        if ( ! $this->validateUrl(null, $argument)) {
            throw new \InvalidArgumentException(sprintf(
                "Argument '%s' is invalid. Must be a valid url",
                $argument
            ));
        }
    }
}
