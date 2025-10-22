<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('materi_model');
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
			'active_nav' => 'materi'
		);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('materi/materi', $data);
		$this->load->view('partials/footer');
	}
    
	public function detail($mapel_uuid)
	{
		$materi = $this->materi_model->get_by_mapel_uuid($mapel_uuid);
		$mapel = $this->mapel_model->get_by_uuid($mapel_uuid);
		$guru_uuid = $this->session->userdata('uuid');
		$pengampu = $this->guru_model->get_mapel_pengampu($mapel_uuid, $guru_uuid);

		if (!empty($materi)) { // Pastikan ada data dalam materi
			foreach ($materi as $m) {
				if (!empty($m->mapel_uuid)) { // Cek apakah mapel_uuid ada
					$mapel = $this->mapel_model->get_by_uuid($m->mapel_uuid);
					$m->mapel = (!empty($mapel)) ? $mapel->nama : 'Tidak ditemukan'; // Hindari error jika null
				} else {
					$m->mapel = '-';
				}
			}
		}

		$data = array(
			'materi' => $materi,
			'mapel' => $mapel,
			'pengampu' => $pengampu,
			'active_nav' => 'materi'
		);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('materi/materi-list', $data);
		$this->load->view('partials/footer');
	}

    public function tambah($mapel_uuid)
	{
        $rules = $this->materi_model->rules();
		$this->form_validation->set_rules($rules);
		
		if (empty($_FILES['berkas']['name'])) {
			$this->form_validation->set_rules('berkas', 'File Materi', 'required');
		}

		if ($this->form_validation->run() == TRUE) {
			$this->load->library('upload');

			$thumbnail = null;
			$berkas = null;

			$config_thumbnail = array(
				'upload_path'   => "./uploads/thumbnail/",
				'allowed_types' => "jpg|png|jpeg",
				'max_size'      => 2048, // 2MB
				// 'encrypt_name'  => TRUE
			);
			$this->upload->initialize($config_thumbnail);

			if (!empty($_FILES['thumbnail']['name'])) {
				if ($this->upload->do_upload('thumbnail')) {
					$thumbnail = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('error_msg', 'Gagal mengunggah thumbnail: ' . $this->upload->display_errors());
					redirect('materi/tambah/'.$mapel_uuid);
				}
			}

			$config_berkas = array(
				'upload_path'   => "./uploads/materi/",
				'allowed_types' => "jpg|png|jpeg|pdf|docx|pptx|mp4|avi|mov|mkv",
				'max_size'      => 50000, 
				'encrypt_name'  => TRUE
			);
			// echo mime_content_type($_FILES['berkas']['tmp_name']);
			// exit;

			$this->upload->initialize($config_berkas);
			if (!empty($_FILES['berkas']['name'])) {
				if ($this->upload->do_upload('berkas')) {
					$berkas = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('error_msg', 'Gagal mengunggah file materi: ' . $this->upload->display_errors());
					redirect('materi/tambah/'.$mapel_uuid);
				}
				
			}
	
			$insert = $this->materi_model->insert($thumbnail, $berkas);
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data Materi berhasil disimpan');
			} else {
				$this->session->set_flashdata('error_msg', 'Data Materi gagal disimpan');
			}
			redirect('materi/detail/'.$mapel_uuid);	
		}
		
		$guru_uuid = $this->session->userdata('uuid');
		$guru = $this->guru_model->get_by_uuid($guru_uuid);

		$data = array(
			'guru' => $guru,
			'active_nav' => 'materi'
		);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
        
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar',$data);
        $this->load->view('partials/topbar');
        $this->load->view('materi/materi-tambah',$data);
		$this->load->view('partials/footer');
	}

	public function edit($uuid){
		$rules = [
			[
				'field' => 'namamateri',
				'label' => 'Nama Mata Pelajaran',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->materi_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Mata Pelajaran berhasil di Update');
				redirect('materi');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Mata Pelajaran gagal di Update');
				redirect('materi');
			}
		}

		$data = array(
			'materi' => $this->materi_model->get_by_uuid($uuid),
			'active_nav' => 'materi'
		);

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('materi/materi-edit', $data);
		$this->load->view('partials/footer');
	}

	public function hapus($uuid){
		{
			$result = $this->materi_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data mata pelajaran berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data mata pelajaran');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
    
}