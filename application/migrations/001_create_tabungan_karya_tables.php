<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tabungan_karya_tables extends CI_Migration
{
    public function up()
    {
        /**
         * Table: admin
         */
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenis_kelamin' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'modified_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('admin', TRUE);
        $this->db->query("
            ALTER TABLE `admin`
            MODIFY `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
        ");
        /**
         * Table: guru
         */
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 100,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jenis_kelamin' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'modified_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('guru', TRUE);
        $this->db->query("
            ALTER TABLE `guru`
            MODIFY `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
        ");
        /**
         * Table: karya
         */
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 50,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'tipe_upload' => [
                'type' => 'SMALLINT',
                'constraint' => 6,
                'comment' => '1=file, 2=link',
            ],
            'link' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'berkas' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'modified_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('karya', TRUE);
        $this->db->query("
            ALTER TABLE `karya`
            MODIFY `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
        ");
        /**
         * Table: komentar
         */
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'komentar' => [
                'type' => 'TEXT',
            ],
            'karya_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_by' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'modified_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('komentar', TRUE);
        $this->db->query("
            ALTER TABLE `komentar`
            MODIFY `modified_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
        ");
    }  

    public function down()
    {
        $this->dbforge->drop_table('admin', TRUE);
        $this->dbforge->drop_table('guru', TRUE);
        $this->dbforge->drop_table('karya', TRUE);
        $this->dbforge->drop_table('komentar', TRUE);
    }
}