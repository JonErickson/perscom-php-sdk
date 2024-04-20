<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Documents;

use Perscom\Http\Requests\AbstractSearchRequest;

class SearchDocumentsRequest extends AbstractSearchRequest
{
    /**
     * @return string
     */
    protected function getResource(): string
    {
        return 'documents';
    }
}
