<?php

namespace App\Exceptions;

use Exception;
class FileNotFoundException extends Exception
{
	protected $message = 'File not found.';
}