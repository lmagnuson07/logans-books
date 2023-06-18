<?php
/**
 * This file contains the class for interacting with the $files suberglobal.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since 		1.0
 * @version		1.0
 * @license 	http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */

namespace App\Superglobals;

/**
 * Contains static functions for interacting with the $_FILES suberglobal.
 * Also contains a constructor and methods for interacting with a single file in the $_FILES superglobal, stored in the static property $files.
 *
 * @package 	LogansBooks
 * @subpackage 	Main
 * @since		1.0
 * @version		1.0
 * @author 		Logan Magnuson <logmagns07@gmail.com>
 */
class Files {
	static private string $uploadsPath = UPLOADS_PATH;
	static private array $files;
	private string $fileName;
	private array $file;

	public function __construct(string $fileName, array $file) {
		$this->fileName = $fileName;
		$this->file = $file;
	}

	/**
	 * Initialize the $files static property through dependency injection.
	 *
	 * @param array $files
	 * @return void
	 */
	static public function initFilesArray(array $files): void {
		static::$files = $files;
	}

	/**
	 * Returns the static $files property.
	 *
	 * @return array
	 */
	static public function getFileArray(): array {
		return static::$files;
	}

	/**
	 * Returns a reference to the $_FILES superglobal.
	 *
	 * @return array
	 */
	static public function getRawFileArray(): array {
		return $_FILES;
	}

	/**
	 * Checks if key exists in the static $files property.
	 *
	 * @param string $key
	 * @return bool
	 */
	static public function hasKey(string $key): bool {
		return isset(static::$files[$key]);
	}

	/**
	 * Gets a single value from the static $files property.
	 *
	 * @param string $key
	 * @return array|null
	 */
	static public function getValue(string $key): array|null {
		return static::$files[$key] ?? null;
	}

	/**
	 * Returns a filtered array of values from the static $files property.
	 * Must pass an indexed array of strings to search for.
	 *
	 * @param array $keys
	 * @return array
	 */
	static public function getValues(array $keys): array {
		$filteredFilesArray = [];
		foreach($keys as $key) {
			if (key_exists($key, static::$files)) {
				$filteredFilesArray[$key] = static::$files[$key];
			} else {
				$filteredFilesArray[$key] = 'NotFound';
			}
		}
		return $filteredFilesArray;
	}

	/**
	 * Check if the instantiated $file property uploaded without errors.
	 *
	 * @return bool
	 */
	public function isValid(): bool {
		return isset($this->$file[$this->fileName]) && $this->$file['error'] == UPLOAD_ERR_OK;
	}

	/**
	 * Returns the instantiated $file properties name.
	 *
	 * @return string
	 */
	public function getFileName(): string {
		return $this->file['name'];
	}

	/**
	 * Returns the instantiated $file properties tmp_name which is the path to the temporary folder on the server that it is stored in.
	 *
	 * @return string
	 */
	public function getTemporaryFilePath(): string {
		return $this->file['tmp_name'];
	}

	/**
	 * Returns the instantiated $file properties size.
	 *
	 * @return int
	 */
	public function getFileSize(): int {
		return $this->file['size'];
	}

	/**
	 * Returns the instantiated $file properties file type.
	 *
	 * @return string
	 */
	public function getMimeType(): string {
		return $this->file['type'];
	}

	/**
	 * Moves the instantiated file to the passed $destination path in the uploads dir on the server if the file is valid.
	 * If the dir does not exist in the uploads dir, it will create the dir and save the file there.
	 *
	 * @param string $destination
	 * @return bool
	 */
	public function moveUploadedFile(string $destination): bool {
		if ($this->isValid()) {
			$destination = explode('?', $destination)[0];
			if (str_starts_with($destination, '\\')) {
				$destination = substr($destination, 1);
			}
			$url = static::$uploadsPath . $destination;

			if (filter_var($url, FILTER_VALIDATE_URL)) {
				if (!is_dir($url)) {
					mkdir(directory: $url, recursive: true);
				}
				return move_uploaded_file($this->getTemporaryFilePath(), $url);
			} else {
				return false;
			}
		}
		return false;
	}
}