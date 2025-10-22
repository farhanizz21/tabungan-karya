<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('guru_model');
		$this->load->model('mapel_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$guru = $this->guru_model->get_all();
		foreach ($guru as $val) {
			$uuid_array = json_decode($val->mapel_uuid); // array UUID
			$mapel_list = $this->mapel_model->get_many_mapel_by_uuid($uuid_array); // ambil semua mapel

			$val->mapel_nama = array_map(function($m) {
				return $m->nama;
			}, $mapel_list);
		}
		

		$data = array(
			'guru' => $guru,
			'active_nav' => 'guru'
		);

		// echo "<pre>";
		// 	print_r($guru);
		// 	echo "</pre>";

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('guru/guru', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
        $rules = $this->guru_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->guru_model->insert();
			// echo "<pre>";
			// print_r($insert);
			// echo "</pre>";
			// exit;
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data guru berhasil di simpan');
				redirect('guru');
			}else {
				$this->session->set_flashdata('error_msg', 'Data guru gagal di simpan');
				redirect('guru');
			}
		}

		$data = array(
			'mapel' => $this->mapel_model->get_all(),
			'active_nav' => 'guru'
		);

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('guru/guru-tambah', $data);
		$this->load->view('partials/footer');;
	}

	public function edit($uuid){
		$rules = [
			[
				'field' => 'namaLengkap',
				'label' => 'Nama Lengkap',
				'rules' => 'required'
			],[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|regex_match[/^[a-z]/]|callback_username_check'
			],[
				'field' => 'namaMapel[]',
				'label' => 'Nama Mata Pelajaran',
				'rules' => 'required'
			],[
				'field' => 'jenisKelamin',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->guru_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Guru berhasil di Update');
				redirect('guru');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Guru gagal di Update');
				redirect('guru');
			}
		}

		$guru = $this->guru_model->get_by_uuid($uuid);
		$mapel_list = json_decode($guru->mapel_uuid); // array UUID

		$data = array(
			'guru' => $guru,
			'mapel_list' => $mapel_list,
			'mapel' => $this->mapel_model->get_all(),
			'active_nav' => 'guru'
		);
		// 		echo "<pre>";
		// print_r($mapel_list);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar',$data);
        $this->load->view('partials/topbar');
        $this->load->view('guru/guru-edit', $data);
		$this->load->view('partials/footer');
	}

	public function username_check($username, $uuid)
	{
		$uuid = $this->input->post('uuid'); // atau sesuaikan dengan cara kamu ambil ID
		$this->db->where('username', $username);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->where('uuid !=', $uuid);
		$query = $this->db->get('guru');

		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('username_check', 'Username sudah digunakan oleh pengguna lain.');
			return false;
		}
		
		return true;
	}


	public function hapus($uuid){
		{
			$result = $this->guru_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data guru berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data guru');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}