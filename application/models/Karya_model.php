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
			]
        ];
	}

	public function get_all()
	{
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('modified_at', 'DESC');
		$data = $this->db->get('karya')->result();

		return $data;
	}
	
	public function get_by_guru_uuid($uuid)
	{
		$this->db->where('created_by', $uuid);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('modified_at', 'DESC');
		$data = $this->db->get('karya')->result();

	// 	echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	// exit;
		return $data;
	}

	public function count_by_guru_uuid($uuid)
	{
		$this->db->where('created_by', $uuid);
		$this->db->where('deleted_at', NULL, FALSE);
		return $this->db->count_all_results('karya');
	}


	public function insert($data)
	{
		$uuid = Uuid::uuid4()->toString();
		$user_uuid = $this->session->userdata('uuid');

		$insert_data = array(
			'uuid'         => $uuid,
			'judul'        => $this->input->post('judul', TRUE),
			'deskripsi'    => $this->input->post('deskripsi', TRUE)?: NULL,
			'tipe_upload'  => $data['tipe_upload'],
			'berkas'       => $data['berkas']?: NULL,
			'link'   => $data['link']?: NULL,
			'created_by'   => $user_uuid,
		);

		$this->db->insert('karya', $insert_data);
		return $this->db->affected_rows() > 0;
	}


	public function delete_by_uuid($uuid)
	{
		$data = array(
			'deleted_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('karya', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}
	
	public function get_by_uuid($uuid)
	{
		$this->db->where('uuid', $uuid);
		$this->db->where('deleted_at', NULL, FALSE);
		$data = $this->db->get('karya')->row();

		return $data;
	}
	
	public function update($uuid, $data)
	{
		$this->db->where('uuid', $uuid);
		$this->db->update('karya', $data);
		return ($this->db->affected_rows() > 0);
	}

}
?>