<?php

namespace App;

class Response
{
	protected string $base;
	// The buffer for HTTP header calls.
	protected array $headers = [];
	// Variables to extract into the view scope.
	protected array $vars = [];
	// A view file to require in its own scope
	protected string $view;
	// The callable and arguments to be invoked with `call_user_func_array()' as the last step in the `send()` process.
	protected array $last_call;
	public function __construct($base=null) {
		$this->setBase($base);
	}
	public function setBase($base): void {
		$this->base = $base;
	}
	public function getBase(): ?string {
		return $this->base;
	}
	public function setView($view): void {
		$this->view = $view;
	}
	public function getView(): ?string {
		return $this->view;
	}
	public function getViewPath()
	{
		if (! $this->base) {
			return $this->view;
		}

		return rtrim($this->base, DIRECTORY_SEPARATOR)
			. DIRECTORY_SEPARATOR
			. ltrim($this->view, DIRECTORY_SEPARATOR);
	}
	public function setVars(array $vars): void {
		unset($vars['this']);
		$this->vars = $vars;
	}
	public function addVars(array $vars): void {
		unset($vars['this']);
		$this->vars = array_merge($this->vars, $vars);
	}
		// Sets the callable to be invoked with `call_user_func_array()` as the last step in the `send()` process; extra arguments are passed to the call.
	public function setLastCall($func) {
		$this->last_call = func_get_args();
	}
	public function getVars(): array {
		return $this->vars;
	}
	public function h($string) {
		return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
	}
	///////////////// Buffers ///////////////////////////////////////
	// Buffers a call to header
	public function header()
	{
		$args = func_get_args();
		array_unshift($args, 'header');
		$this->headers[] = $args;
	}
	// Buffers a call to setcookie()
	public function setCookie()
	{
		$args = func_get_args();
		array_unshift($args, 'setcookie');
		$this->headers[] = $args;
		return true;
	}
	// Buffer a call to setrawcookie
	public function setRawCookie()
	{
		$args = func_get_args();
		array_unshift($args, 'setrawcookie');
		$this->headers[] = $args;
		return true;
	}
	// Returns the buffer for http header calls
	public function getHeaders()
	{
		return $this->headers;
	}
	public function send()
	{
		$buffered_output = $this->requireView();
		$this->sendHeaders();
		echo $buffered_output;
		$this->invokeLastCall();
	}
	// Requires the view in its own scope with etracted variables and returns the buffered output.
	public function requireView()
	{
		if (! $this->view) {
			return '';
		}

		extract($this->vars);
		ob_start();
		require $this->getViewPath();
		return ob_get_clean();
	}
	// Outputs the buffered calls to `header`, `setcookie`, etc.
	public function sendHeaders()
	{
		foreach ($this->headers as $args) {
			$func = array_shift($args);
			call_user_func_array($func, $args);
		}
	}
	// Invokes `$this->call`.
	public function invokeLastCall()
	{
		if (!isset($this->last_call)) {
			return;
		}
		$args = $this->last_call;
		$func = array_shift($args);
		call_user_func_array($func, $args);
	}
	/////////////////////////////////////////////////////////////////
}