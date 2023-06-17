<?php

namespace App\Controllers\Admin;

use App\App;
use App\View;

class AdminController
{
	public function index(): View {
		$db = App::db();

		$db->beginTransaction();

		$db->rollBack();
		return View::make(view: 'admin/index', params: ['foo' => 'bar']);
	}
}