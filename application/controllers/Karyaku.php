<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyaku extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('Karya_model');
		$this->load->library('form_validation');
		$this->load->model('Auth_model');
		if(!$this->Auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$uuid = $this->session->userdata('uuid');
		$karyaku = $this->Karya_model->get_by_guru_uuid($uuid);
		
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
        $rules = $this->Karya_model->rules();
		$this->form_validation->set_rules($rules);
	
		$tipe_upload = $this->input->post('tipe_upload');

		if ($tipe_upload === '1') {
			if (empty($_FILES['berkas']['name'])) {
				$this->form_validation->set_rules('berkas', 'File Karya', 'required');
			}
		} elseif ($tipe_upload === '2') {
			$this->form_validation->set_rules('link', 'Link Karya', 'required|valid_url');
		}

		if ($this->form_validation->run() == TRUE) {
			$berkas = null;
			$link = null;

			if ($tipe_upload === '1') {
				// Konfigurasi upload
				$config = array(
					'upload_path'   => "./uploads/karya/",
					'allowed_types' => "jpg|png|jpeg|pdf|docx|pptx|mp4|avi|mov|mkv",
					'max_size'      => 50000, // 50MB
					'overwrite'     => TRUE,
					'encrypt_name'  => TRUE
				);

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('berkas')) {
					$this->session->set_flashdata('error_msg', 'Gagal mengunggah berkas: ' . strip_tags($this->upload->display_errors()));
					redirect('karyaku/tambah');
					return;
				}

				$upload_data = $this->upload->data();
				$berkas = $upload_data['file_name'];
			} else {
				// Jika link
				$link = $this->input->post('link', TRUE);
			}

			// Simpan ke model
			$insert = $this->Karya_model->insert([
				'berkas' => $berkas,
				'link' => $link,
				'tipe_upload' => $tipe_upload
			]);

			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Karya berhasil disimpan.');
			} else {
				$this->session->set_flashdata('error_msg', 'Karya gagal disimpan.');
			}

			redirect('karyaku');
		}

		// Jika validasi gagal atau form pertama kali dibuka
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

	public function edit($uuid)
	{
		$rules = $this->Karya_model->rules();
		$this->form_validation->set_rules($rules);

		// Ambil data karya berdasarkan UUID
		$karya = $this->Karya_model->get_by_uuid($uuid);

		if ($this->form_validation->run() == TRUE) {
			$tipe_upload = $this->input->post('tipe_upload');
			$berkas_new = $karya->berkas;
			$link = NULL;

			// === Jika tipe upload adalah FILE ===
			if ($tipe_upload == '1') {
				if (!empty($_FILES['berkas']['name'])) {
					$config = array(
						'upload_path' => "./uploads/karya/",
						'allowed_types' => "jpg|png|jpeg|pdf|docx|pptx|mp4|avi|mov|mkv",
						'max_size' => 50000,
						'overwrite' => TRUE,
						'encrypt_name' => TRUE
					);
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('berkas')) {
						$this->session->set_flashdata('error_msg', 'Gagal mengunggah berkas: ' . strip_tags($this->upload->display_errors()));
						redirect('karyaku/edit/' . $uuid);
					} else {
						$upload_data = $this->upload->data();
						$berkas_new = $upload_data['file_name'];

						// Hapus berkas lama
						if (!empty($karya->berkas) && file_exists(FCPATH . 'uploads/karya/' . $karya->berkas)) {
							unlink(FCPATH . 'uploads/karya/' . $karya->berkas);
						}
					}
				}
			}

			// === Jika tipe upload adalah LINK ===
			else if ($tipe_upload == '2') {
				$link = $this->input->post('link');
				$berkas_new = NULL; // kosongkan file jika pakai link
			}

			// Simpan update ke database
			$update = $this->Karya_model->update($uuid, [
				'judul'       => $this->input->post('judul'),
				'deskripsi'   => $this->input->post('deskripsi'),
				'berkas'      => $berkas_new,
				'link'        => $link,
				'tipe_upload' => $tipe_upload,
			]);			
		// echo "<pre>";
		// print_r($update);
		// echo "</pre>";
		// exit;

			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data karya berhasil diperbarui.');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal memperbarui data karya.');
			}
			redirect('karyaku');
		}

		// Load view edit
		$data = array(
			'karya' => $karya,
			'active_nav' => 'karyaku'
		);

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
		$this->load->view('partials/topbar');
		$this->load->view('karyaku/karyaku-edit', $data);
		$this->load->view('partials/footer');
	}


	public function hapus($uuid)
	{
		$this->load->model('Karya_model');
		$result = $this->Karya_model->delete_by_uuid($uuid);
		if ($result) {
			$this->session->set_flashdata('success_msg', 'Data Karya Anda berhasil dihapus');
		} else {
			$this->session->set_flashdata('error_msg', 'Gagal menghapus data Karya Anda');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

    
    
}