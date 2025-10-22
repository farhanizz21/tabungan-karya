<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('auth_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		
	}

	public function login()
	{
		if($this->auth_model->current_user()){
			redirect(base_url());
		}
		
		$rules = $this->auth_model->rules();
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run() == FALSE){
			return $this->load->view('auth/login');
		}

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($this->auth_model->login($username, $password)){
			redirect(base_url());
		} else {
			$this->session->set_flashdata('error_msg', 'Login Gagal, pastikan username dan password benar!');	
        }
        $this->load->view('auth/login');
    }


	public function logout()
	{
		$this->auth_model->logout();
		redirect(base_url());
	}
}