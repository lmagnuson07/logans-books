<?php

namespace App\Exceptions;
use Exception;
use Throwable;

class RouteNotFoundException extends Exception
{
	protected $message = '404 Not Found';
}