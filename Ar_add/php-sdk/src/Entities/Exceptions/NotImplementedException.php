<?php

namespace GlobalPayments\Api\Entities\Exceptions;

class NotImplementedException extends ApiException
{
    /**
     * Instantiates a new object
     *
     * @param string $message The exception message to throw.
     */
    public function __construct($message = null)
    {
        parent::__construct($message);
    }
}
