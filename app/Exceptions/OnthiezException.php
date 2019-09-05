<?php

namespace App\Exceptions;

use Exception;
use Throwable;

abstract class OnthiezException extends Exception
{
    /**
     * The status code that will be used for JSON response representation of the exception.
     *
     * @var integer
     */
    protected $statusCode;

    /**
     * @param string $message
     * @param integer|null $statusCode
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = '', $statusCode = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->statusCode = $statusCode;
    }

    /**
     * @return int|null
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
