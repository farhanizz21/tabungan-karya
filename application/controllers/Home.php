<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('auth_model');
		$this->load->library('form_validation');
		
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}
	public function index()
	{
        // $this->load->view('partials/header');
		// $this->load->view('partials/sidebar');
        // $this->load->view('partials/topbar');
        $this->load->view('home/home');
		// $this->load->view('partials/footer');
	}
}