<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Calendars;

use Perscom\RequestType\AbstractSearchRequest;

class SearchCalendarsRequest extends AbstractSearchRequest
{
    /**
     * @inheritDoc
     */
    protected function getResource(): string
    {
        return 'calendars';
    }
}
