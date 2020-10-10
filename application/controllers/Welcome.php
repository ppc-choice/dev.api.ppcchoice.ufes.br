<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class Welcome extends APIController
{

	public function index()
	{
		if (file_exists('documentation')) {
			redirect('documentation', 'refresh');
		} else {
			$this->load->view('welcome_message');
		}
	}
}
