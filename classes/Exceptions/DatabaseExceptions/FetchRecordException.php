<?php

namespace App\Exceptions\DatabaseExceptions;

use Exception;
class FetchRecordException extends Exception
{
	protected $message = 'Failed to retrieve the record from the database.';
}