<?php

namespace App\Exceptions;

use Exception;

class FileNotReadableException extends Exception
{
	protected $message = 'File not readable.';
}