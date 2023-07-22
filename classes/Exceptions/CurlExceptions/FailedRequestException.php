<?php

namespace App\Exceptions\CurlExceptions;
use Exception;

class FailedRequestException extends Exception
{
	protected $message = 'The request failed.';
}