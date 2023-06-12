<?php

namespace App\Controllers;

use App\App;
use App\View;

class HomeController
{
	public function index(): View {
		$db = App::db();

		$db->beginTransaction();

		$db->rollBack();
		return View::make(view: 'index', params: ['foo' => 'bar']);
	}

	public function download() {
		// Need to register the route.
		header('Content-Type: application/pfg');
		header('Content-Disposition: attatchment;filename="myfile.pdf"'); // Sets the downloaded file name

//		readfile(STORAGE_PATH . 'receipt 6-20-2021');
	}

	public function upload() {
//		$filePath = STORATE_PATH . '/' . $_FILES['receipt']['name'];

//		move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);
//
//		header('Location: /');
//		exit;
	}
}