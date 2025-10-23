<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karya extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('karya_model');
		$this->load->model('guru_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$data = array(
			'active_nav' => 'karya'
		);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('karya/karya', $data);
		$this->load->view('partials/footer');
	}

}