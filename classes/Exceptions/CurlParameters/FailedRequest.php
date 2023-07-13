<?php

namespace App\Exceptions\CurlParameters;
use \Exception;

class FailedRequest extends Exception
{
	protected $message = 'The request failed.';
}