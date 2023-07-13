<?php

namespace App\Exceptions\ParameterExceptions;

class InvalidArgumentException extends \Exception
{
	protected $message = 'Invalid argument.';
}