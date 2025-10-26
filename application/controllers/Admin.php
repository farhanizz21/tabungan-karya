<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Admin_model');
		$this->load->library('form_validation');
		$this->load->model('Auth_model');
		if(!$this->Auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$admin = $this->Admin_model->get_all();
		
		$data = array(
			'admin' => $admin,
			'active_nav' => 'admin'
		);

		// echo "<pre>";
		// 	print_r($admin);
		// 	echo "</pre>";

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('admin/admin', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
        $rules = $this->Admin_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->Admin_model->insert();
			// echo "<pre>";
			// print_r($insert);
			// echo "</pre>";
			// exit;
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data Admin berhasil di simpan');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Admin gagal di simpan');
			}
			redirect('admin');
		}

		$data = array(
			'active_nav' => 'admin'
		);

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('admin/admin-tambah', $data);
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
				'field' => 'jenisKelamin',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->Admin_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Admin berhasil di Update');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Admin gagal di Update');
			}
			redirect('admin');
		}

		$admin = $this->Admin_model->get_by_uuid($uuid);

		$data = array(
			'admin' => $admin,
			'active_nav' => 'admin'
		);

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar',$data);
        $this->load->view('partials/topbar');
        $this->load->view('admin/admin-edit', $data);
		$this->load->view('partials/footer');
	}

	public function username_check($username, $uuid)
	{
		$uuid = $this->input->post('uuid'); // atau sesuaikan dengan cara kamu ambil ID
		$this->db->where('username', $username);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->where('uuid !=', $uuid);
		$query = $this->db->get('admin');

		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('username_check', 'Username sudah digunakan oleh pengguna lain.');
			return false;
		}
		
		return true;
	}


	public function hapus($uuid){
		{
			$result = $this->Admin_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data Admin berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data Admin');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}