<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class guru_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'namaLengkap',
				'label' => 'Nama Lengkap',
				'rules' => 'required'
			],
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|is_unique[guru.username]|regex_match[/^[a-z]/]'
				
			],
			[
				'field' => 'namaMapel[]',
				'label' => 'Mata Pelajaran',
				'rules' => 'required'
			],
			[
				'field' => 'jenisKelamin',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],
		];
	}

    public function insert()
	{
		$uuid = Uuid::uuid4()->toString();
        $namaLengkap = $this->input->post('namaLengkap');
        $username = $this->input->post('username');
        $password = 'edu12345';
		// $mapel_uuid = $this->input->post('namaMapel');
		$namaMapel = $this->input->post('namaMapel'); // array dari select multiple
		$mapel_json = json_encode($namaMapel);
        $jenisKelamin = $this->input->post('jenisKelamin');

		$data = array(
			'uuid' => $uuid,
			'nama' => $namaLengkap,
            'username' => $username,
            'mapel_uuid' => $mapel_json,
            'password' =>  password_hash($password, PASSWORD_DEFAULT),
            'jenis_kelamin' => $jenisKelamin
		);

		$this->db->insert('guru', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function update($uuid)
	{
		$namaLengkap = $this->input->post('namaLengkap');
		$username = $this->input->post('username');
		// $mapel_uuid = $this->input->post('namaMapel');
		$namaMapel = $this->input->post('namaMapel'); // array dari select multiple
		$mapel_json = json_encode($namaMapel);
		$jenisKelamin = $this->input->post('jenisKelamin');
		$data = array(
			'nama' => $namaLengkap,
            'username' => $username,
            'mapel_uuid' => $mapel_json,
            'jenis_kelamin' => $jenisKelamin,
			'modified_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('guru', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}

	public function get_all()
	{
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('nama', 'ASC');
		$data = $this->db->get('guru')->result();

		return $data;
	}

	public function delete_by_uuid($uuid)
	{
		$data = array(
			'deleted_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('guru', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}
	public function get_by_uuid($uuid)
	{
		$data = $this->db->get_where('guru', array('uuid' => $uuid))->row();
		return $data;
	}

	public function get_mapel_pengampu($mapel_uuid, $guru_uuid)
	{
		$this->db->select('*');
		// $this->db->where('mapel_uuid', $mapel_uuid);		
		$this->db->where("JSON_CONTAINS(mapel_uuid, '\"$mapel_uuid\"')", null, false);
		$this->db->where('uuid', $guru_uuid);
		$this->db->where('deleted_at', NULL, FALSE);
		$data = $this->db->get('guru')->row();

		return $data ? true : false;
	}

}
?>