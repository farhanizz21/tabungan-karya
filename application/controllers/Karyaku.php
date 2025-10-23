<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyaku extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('karya_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$karyaku = $this->karya_model->get_all();
		
		$data = array(
			'karyaku' => $karyaku,
			'active_nav' => 'karyaku'
		);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('karyaku/karyaku', $data);
		$this->load->view('partials/footer');
	}

	
	public function tambah()
	{

        $rules = $this->karya_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$config = array(
                'upload_path' => "./uploads/karya/",
                'allowed_types' => "jpg|png|jpeg|pdf|docx|pptx|mp4|avi|mov|mkv",
				'max_size'      => 50000,
                'overwrite' => TRUE,
                'encrypt_name' => TRUE
            );
			$this->load->library('upload', $config);
			
            if (!$this->upload->do_upload('berkas')) {
				$this->session->set_flashdata('error_msg', 'Gagal mengunggah berkas: ' . $this->upload->display_errors());
			}
			else {
				$upload_data = $this->upload->data();
				$berkas = $upload_data['file_name'];
				$insert = $this->karya_model->insert($berkas);
				if ($insert) {
					$this->session->set_flashdata('success_msg', 'Data Karya Anda berhasil disimpan');
				} else {
					$this->session->set_flashdata('error_msg', 'Data Karya Anda gagal disimpan');
				}
			}
			redirect('karyaku');
		}

		$data = array(
			'active_nav' => 'karyaku'
		);

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('karyaku/karyaku-tambah', $data);
		$this->load->view('partials/footer');
	}

	public function validate_file_upload()
	{
		if (empty($_FILES['berkas']['name'])) {
			$this->form_validation->set_message('validate_file_upload', 'File harus diunggah.');
			return FALSE;
		}
		return TRUE;
	}

    
    
}