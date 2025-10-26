<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar extends CI_Controller {

    public function __construct()
	{
		parent::__construct();

		$this->load->model('Komentar_model');
		$this->load->library('form_validation');
		$this->load->model('Auth_model');
		if(!$this->Auth_model->current_user()){
			redirect('login');
		}
	}
    
    public function get_by_karya_uuid($karya_uuid)
    {
        $komentar = $this->Komentar_model->get_by_karya($karya_uuid);
        if (empty($komentar)) {
            echo '<div class="text-center text-muted py-3">Belum ada komentar.</div>';
        } else {
            foreach ($komentar as $k) {
                echo '
                <div class="d-flex">
                    <i class="fa-solid fa-circle-user text-secondary fs-2 me-3 align-self-start"></i>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-1">
                                <strong>' . htmlspecialchars($k->nama_user ?? 'Anonim', ENT_QUOTES, "UTF-8") . '</strong>
                                <span class="text-muted small mx-2">|</span>
                                <span class="text-muted small">' . date('d M Y, H.i', strtotime($k->modified_at ?? $k->created_at)) . ' WIB</span>
                            </p>


                        </div>
                        <p class="mb-2">
                            '. $k->komentar .
                        '</p>
                        <hr>
                    </div>
                </div>';
            }
        }
    }

    private function get_komentar_html($karya_uuid)
    {
        $komentar = $this->Komentar_model->get_by_karya($karya_uuid);

        if (empty($komentar)) {
            return '<div class="text-center text-muted py-3">Belum ada komentar.</div>';
        }

        $html = '';
        foreach ($komentar as $k) {
            $html .= '
            <div class="d-flex mb-2">
                <i class="fa-solid fa-circle-user text-secondary fs-2 me-3 align-self-start"></i>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-1">
                            <strong>' . htmlspecialchars($k->nama_user ?? 'Anonim', ENT_QUOTES, "UTF-8") . '</strong>
                            <span class="text-muted small"> ' . date('d M Y, H.i', strtotime($k->modified_at ?? $k->created_at)) . ' WIB</span>
                        </p>
                    </div>
                    <p class="mb-2">' . nl2br(htmlspecialchars($k->komentar ?? '', ENT_QUOTES, "UTF-8")) . '</p>
                    <hr class="my-2">
                </div>
            </div>';
        }

        return $html;
    }

    public function tambah()
    {
        $rules = $this->Komentar_model->rules();
        $this->form_validation->set_rules($rules);

        $karya_uuid = $this->input->post('karya_uuid');

        if ($this->form_validation->run() == TRUE) {
            $insert = $this->Komentar_model->insert();

            if ($insert) {
                // Kembalikan komentar terbaru
                $html = $this->get_komentar_html($karya_uuid);
                echo json_encode(['status' => 'success', 'html' => $html]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan komentar.']);
            }

        } else {
            // Ambil pesan error khusus field 'komentar'
            $error_msg = form_error('komentar', '<small class="text-danger d-block mt-1">', '</small>');
            echo json_encode(['status' => 'validation_error', 'message' => $error_msg]);
        }
    }
    
}