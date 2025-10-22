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
				'field' => 'namaMapel',
				'label' => 'Mata Pelajaran',
				'rules' => 'required'
			]
        ];
	}

	
}
?>