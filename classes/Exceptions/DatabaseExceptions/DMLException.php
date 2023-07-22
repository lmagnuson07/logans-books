<?php

namespace App\Exceptions\DatabaseExceptions;

use Exception;

class DMLException extends Exception
{
	protected $message = 'Failed to perform the database transaction.';
}