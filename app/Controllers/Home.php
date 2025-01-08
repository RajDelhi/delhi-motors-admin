<?php

namespace App\Controllers;

use App\Models\AgentsModel;

class Home extends BaseController {

	public function __construct() {
		$this->session = session();
	}

	public function index(): string {
		$data['page_title'] = 'Home';

		return view( 'modules/home', $data );
	}

	public function about(): string {
		$data['page_title'] = 'About Us';

		return view( 'modules/about', $data );
	}

	public function term_condition(): string {
		$data['page_title'] = 'Term condition';

		return view( 'modules/terms-conditions', $data );
	}

	public function site_map(): string {
		$data['page_title'] = 'Site Map';

		return view( 'modules/site-map', $data );
	}

	public function privacy(): string {
		$data['page_title'] = 'Privacy';

		return view( 'modules/privacy', $data );
	}

	public function nar_resources_start_date_august_17_2024(): string {
		$data['page_title'] = 'NAR Resources Start Date August 17 th 2024.';

		return view( 'modules/nar-resources-start-date-august-17-2024', $data );
	}

	public function nar_resources_mandatory_buyers_broker_agreements(): string {
		$data['page_title'] = 'NAR Resources: Mandatory Buyers Broker Agreements';

		return view( 'modules/nar-resources-mandatory-buyers-broker-agreements', $data );
	}

	public function nar_resources_contract_signed_prior_to_august_17(): string {
		$data['page_title'] = 'NAR Resources: Contract signed Prior to August 17 th , are they valid?';

		return view( 'modules/nar-resources-contract-signed-prior-to-august-17', $data );
	}

	public function nar_resources_written_buyer_agreements(): string {
		$data['page_title'] = 'NAR Resources: Written Buyer Agreements.';

		return view( 'modules/nar-resources-written-buyer-agreements', $data );
	}

	public function terms_of_service(): string {
		$data['page_title'] = 'Terms of Service';

		return view( 'modules/terms-of-service', $data );
	}

	public function advertise(): string {
		$data['page_title'] = 'Advertise';
		return view( 'modules/advertise', $data );
	}


}
