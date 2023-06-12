<?php

namespace App\Controllers;

use App\Config\Twig;
use App\View;

class InvoiceController extends Twig
{
	public function index(): View {
		return View::make(view: 'invoices/index');
	}
	public function create(): string {
		return View::make(view: 'invoices/create', params: ['foo' => 'bar']);
	}

	public function store() {
		$amount = $_POST['amount'];

		var_dump($amount);
	}
}