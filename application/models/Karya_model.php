<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class karya_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'judul',
				'label' => 'Judul karya',
				'rules' => 'required'
			],
			[
				'field' => 'berkas',
				'label' => 'File',
				'rules' => 'callback_validate_file_upload'
			]
        ];
	}

	public function get_all()
	{
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('judul', 'ASC');
		$data = $this->db->get('karya')->result();

		return $data;
	}

	public function get_all_karyaku()
	{
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('judul', 'ASC');
		$data = $this->db->get('karya')->result();

		return $data;
	}

	public function insert($berkas)
	{
		$uuid = Uuid::uuid4()->toString();
		$judul = $this->input->post('judul');

		$data = array(
			'uuid' => $uuid,
			'judul' => $judul,
			'berkas' => $berkas,
			'created_by' => $this->session->userdata('uuid')
		);

		// 🔍 DEBUG: tampilkan data sebelum insert
		echo "<pre>DEBUG DATA:\n";
		print_r($data);
		echo "</pre>";

		// Jalankan query insert
		$this->db->insert('karya', $data);

		// 🔍 DEBUG: tampilkan query SQL yang dijalankan
		echo "<pre>LAST QUERY: " . $this->db->last_query() . "</pre>";

		// 🔍 DEBUG: tampilkan hasil affected_rows
		echo "<pre>AFFECTED ROWS: " . $this->db->affected_rows() . "</pre>";

		if ($this->db->affected_rows() > 0) {
			echo "<pre>INSERT STATUS: SUCCESS</pre>";
			return true;
		} else {
			echo "<pre>INSERT STATUS: FAILED</pre>";
			return false;
		}
	}

	
}
?>