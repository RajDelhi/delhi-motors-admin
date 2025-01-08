<?php

namespace App\Controllers;

use App\Models\InvoiceModel;

class Invoice extends BaseController {

	public function __construct() {
		$this->session = session();
	}

	public function index(): string {
            die('asdf');
		$data['page_title'] = 'Home';

		return view( 'modules/home', $data );
	}

	public function about(): string {
		$data['page_title'] = 'About Us';

		return view( 'modules/about', $data );
	}





}
