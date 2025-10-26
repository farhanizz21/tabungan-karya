<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Ramsey\Uuid\Uuid;

class Migration_Add_admin_user extends CI_Migration {

    public function up() {
        
		$uuid = Uuid::uuid4()->toString();
        $data = [
            'uuid' => $uuid,
            'nama' => 'admin',
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT),
            'jenis_kelamin'     => '2',
        ];
        $this->db->insert('admin', $data);
    }

    public function down() {
        $this->db->delete('admin', ['username' => 'admin']);
    }
}