<?php

namespace App\Config;

/**
 * @property-read ?array $db
 * @property-read ?array $paths
 */
class Config
{
	protected array $config = [];

	public function __construct(array $env) {
		$this->config = [
			'db' => [
				'db_driver' => $env['DB_DRIVER'],
				'db_name' => $env['DB_NAME'],
				'db_server' => $env['DB_SERVER'],
				'db_port' => $env['DB_PORT'],
				'db_user' => $env['DB_USER'],
				'db_pass' => $env['DB_PASS'],
			],
			'paths' => [
				'csv_path' => $_ENV['CSV_DOCUMENT_PATH']
			]
		];
	}

	public function __get(string $name) {
		return $this->config[$name] ?? null;
	}
}