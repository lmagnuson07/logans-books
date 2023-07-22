<?php

namespace App\Exceptions\DatabaseExceptions;

use Exception;

class DataInsertException extends Exception
{
	protected $message = 'Failed to insert data.';
}