<?php

class auth_model extends CI_Model
{
	private $_table_admin = 'admin';
	private $_table_guru = 'guru';
	const SESSION_KEY = 'uuid';

	public function rules()
	{
		return [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			]
		];
	}
	
	public function login($username, $password)
	{
		//cek admin
		$this->db->where('username', $username);
		$this->db->where('deleted_at', NULL, FALSE);
        $query = $this->db->get($this->_table_admin);
        if ($query->num_rows() > 0) {
            $user = $query->row();
            $role = '1';
        } else {
			//cek guru
			$this->db->where('username', $username);
			$this->db->where('deleted_at', NULL, FALSE);
			$query = $this->db->get($this->_table_guru);
			
			if ($query->num_rows() > 0) {
				$user = $query->row();
				$role = '2';
			} else {
				return FALSE;
			}
		}
        if (!password_verify($password, $user->password)) {
            return FALSE;
        }
		
		$this->session->set_userdata([self::SESSION_KEY => $user->uuid, 'username' => $user->username, 'nama' => $user->nama, 'role' => $role ]);
		return $this->session->has_userdata(self::SESSION_KEY);
	}

	public function current_user()
	{
		if (!$this->session->has_userdata(self::SESSION_KEY)) {
			return null;
		}
		$user_uuid = $this->session->userdata(self::SESSION_KEY);
		$role = $this->session->userdata('role');
		
		switch ($role) {
			case '1':
				$table = $this->_table_admin;
				break;
			case '2':
				$table = $this->_table_guru;
				break;
			case '3':
				$table = $this->_table_siswa;
				break;
			default:
				return null; // Jika role tidak dikenali, return null
		}
		$query = $this->db->get_where($table, ['uuid' => $user_uuid]);
		return $query->row();
	}


	public function logout()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
		return !$this->session->has_userdata(self::SESSION_KEY);
	}
}