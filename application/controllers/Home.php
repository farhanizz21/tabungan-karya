<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('auth_model');
		$this->load->model('Home_model');
		
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

    public function index()
    {
        $data = [
            'active_nav'       => 'home',
            'total_guru'       => $this->Home_model->total_guru(),
            'total_karya'      => $this->Home_model->total_karya(),
            'guru_terbanyak'   => $this->Home_model->guru_terbanyak(),
            'guru_tersedikit'  => $this->Home_model->guru_tersedikit(),
            'komentar_terbaru' => $this->Home_model->komentar_terbaru(),
            'karya_chart'      => $this->Home_model->karya_per_guru(),
			'karya_terbaru' => $this->Home_model->get_karya_terbaru(),
        ];

        // $this->load->view('partials/header');
        // $this->load->view('partials/sidebar', $data);
        // $this->load->view('partials/topbar');
        // $this->load->view('home/home', $data);
        // $this->load->view('partials/footer');        
        $this->load->view('landing/index.html');

    }
}