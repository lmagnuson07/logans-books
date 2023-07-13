<?php

namespace App\Exceptions\ParameterExceptions;
use Exception;

class EmptyParameterException extends Exception
{
	protected $message = 'Empty parameter.';
}