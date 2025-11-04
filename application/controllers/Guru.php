<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Guru_model');
		$this->load->library('form_validation');
		$this->load->model('Auth_model');
		if(!$this->Auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$guru = $this->Guru_model->get_all();
		
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
        $rules = $this->Guru_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->Guru_model->insert();
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
				'field' => 'jenisKelamin',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->Guru_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Guru berhasil di Update');
				redirect('guru');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Guru gagal di Update');
				redirect('guru');
			}
		}

		$guru = $this->Guru_model->get_by_uuid($uuid);

		$data = array(
			'guru' => $guru,
			'active_nav' => 'guru'
		);

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar',$data);
        $this->load->view('partials/topbar');
        $this->load->view('guru/guru-edit', $data);
		$this->load->view('partials/footer');
	}

	public function reset_password($uuid)
{
    // --- 1️⃣ Validasi form ---
    $rules = [
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        ]
    ];
    $this->form_validation->set_rules($rules);

    // --- 2️⃣ Jika form disubmit dan valid ---
    if ($this->form_validation->run() == TRUE) {
        // Cek di tabel guru
        $guru = $this->Guru_model->get_by_uuid($uuid);

        if ($guru) {
            $update = $this->Guru_model->reset_password($uuid);
        } else {
            // Jika tidak ditemukan di tabel guru, cek tabel admin
            $this->load->model('Admin_model');
            $admin = $this->Admin_model->get_by_uuid($uuid);
            if ($admin) {
                $update = $this->Admin_model->reset_password($uuid);
            } else {
                $update = false;
            }
        }

        // --- 3️⃣ Tampilkan hasil update ---
        if ($update) {
            $this->session->set_flashdata('success_msg', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error_msg', 'Password gagal diubah atau user tidak ditemukan');
        }

        redirect('guru');
    }

    // --- 4️⃣ Jika belum submit, tampilkan form ---
    $guru = $this->Guru_model->get_by_uuid($uuid);

    if ($guru) {
        $data = [
            'guru' => $guru,
            // 'role' => 'guru',
            'active_nav' => 'reset_password'
        ];
    } else {
        // Jika tidak ada di tabel guru, cek tabel admin
        $this->load->model('Admin_model');
        $admin = $this->Admin_model->get_by_uuid($uuid);

        if ($admin) {
            $data = [
                'guru' => $admin, // masih bisa pakai key 'guru' supaya view tidak perlu diubah
                // 'role' => 'admin',
                'active_nav' => 'reset_password'
            ];
        } else {
            // Kalau tidak ditemukan sama sekali
            show_404();
            return;
        }
    }

    // --- 5️⃣ Load view ---
    $this->load->view('partials/header');
    $this->load->view('partials/sidebar', $data);
    $this->load->view('partials/topbar');
    $this->load->view('guru/guru-reset-password', $data);
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
			$result = $this->Guru_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data guru berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data guru');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}