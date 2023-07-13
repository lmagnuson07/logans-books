<?php

namespace App\Exceptions;

use Exception;

class DataInsertException extends Exception
{
	protected $message = 'Failed to insert data.';
}