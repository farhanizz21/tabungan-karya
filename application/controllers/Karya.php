<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karya extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('Karya_model');
		$this->load->model('Guru_model');
		$this->load->model('Komentar_model');
		$this->load->library('form_validation');
		$this->load->model('Auth_model');
		if(!$this->Auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$guru = $this->Guru_model->get_all();
		
		foreach ($guru as $g) {
			$g->total_karya = $this->Karya_model->count_by_guru_uuid($g->uuid);
		}
		$data = array(
			'guru' => $guru,
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

	
	public function list($uuid)
	{
		$guru = $this->Guru_model->get_by_uuid($uuid);

		$karya_guru = $this->Karya_model->get_by_guru_uuid($uuid);
		$total_karya = $this->Karya_model->count_by_guru_uuid($uuid);

		foreach ($karya_guru as $g) {
			$g->total_komentar = $this->Komentar_model->count_by_karya_uuid($g->uuid);
		}

		$data = [
			'guru_nama'   => $guru ? $guru->nama : 'Tidak diketahui',
			'karya_guru'  => $karya_guru,
			'total_karya' => $total_karya,
			'active_nav'  => 'karya'
		];

		// Load template (SB Admin 2)
		$this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
		$this->load->view('partials/topbar');
		$this->load->view('karya/karya-list', $data);
		$this->load->view('partials/footer');
	}


}