<?php

declare (strict_types = 1);

namespace App\Exceptions;

class FailedToLoadUrlException extends \Exception
{
    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        parent::__construct(sprintf('It was not possible to load contents from URL %s', $url));
    }
}
