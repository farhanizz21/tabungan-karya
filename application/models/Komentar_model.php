<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class Komentar_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'komentar',
				'label' => 'Isi Komentar',
				'rules' => 'required',
                'errors' => [
                    'required' => 'Komentar tidak boleh kosong.'
                ]
			]
        ];
	}

    public function get_by_karya($karya_uuid)
    {
        $this->db->select('k.*, 
            COALESCE(g.nama, a.nama) AS nama_user'
        );
        $this->db->from('komentar k');
        $this->db->join('guru g', 'g.uuid = k.created_by', 'left');
        $this->db->join('admin a', 'a.uuid = k.created_by', 'left');
        $this->db->where('k.karya_uuid', $karya_uuid);
        $this->db->order_by('k.modified_at', 'DESC');

        return $this->db->get()->result();
    }

    public function count_by_karya_uuid($uuid)
	{
		$this->db->where('karya_uuid', $uuid);
		$this->db->where('deleted_at', NULL, FALSE);
		return $this->db->count_all_results('komentar');
	}

    public function insert()
	{
		$uuid = Uuid::uuid4()->toString();
        $komentar = $this->input->post('komentar');
        $karya_uuid = $this->input->post('karya_uuid');

		$data = array(
			'uuid' => $uuid,
            'komentar' => $komentar,
            'karya_uuid' => $karya_uuid,
			'created_by' => $this->session->userdata('uuid')
		);

		$this->db->insert('komentar', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}