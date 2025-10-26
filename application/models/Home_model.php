<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    // Total guru
    public function total_guru()
    {
        return $this->db->count_all('guru');
    }

    // Total karya
    public function total_karya()
    {
        $this->db->where('deleted_at', NULL, FALSE);
        return $this->db->count_all_results('karya');
    }

    // Guru dengan karya terbanyak
    public function guru_terbanyak()
    {
        $this->db->select('guru.nama, COUNT(karya.uuid) as total_karya');
        $this->db->from('karya');
        $this->db->join('guru', 'guru.uuid = karya.created_by', 'left');
        $this->db->where('karya.deleted_at', NULL, FALSE);
        $this->db->group_by('guru.uuid');
        $this->db->order_by('total_karya', 'DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    // Guru dengan karya paling sedikit (tapi masih punya karya)
    public function guru_tersedikit()
    {
        $this->db->select('guru.nama, COUNT(karya.uuid) as total_karya');
        $this->db->from('karya');
        $this->db->join('guru', 'guru.uuid = karya.created_by', 'left');
        $this->db->where('karya.deleted_at', NULL, FALSE);
        $this->db->group_by('guru.uuid');
        $this->db->order_by('total_karya', 'ASC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    // Komentar terbaru
    public function komentar_terbaru($limit = 5)
    {
        $this->db->select('komentar.komentar, komentar.modified_at, guru.nama as guru_nama, karya.judul');
        $this->db->from('komentar');
        $this->db->join('guru', 'guru.uuid = komentar.created_by', 'left');
        $this->db->join('karya', 'karya.uuid = komentar.karya_uuid', 'left');
        $this->db->order_by('komentar.modified_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Data grafik: jumlah karya per guru
    public function karya_per_guru()
    {
        $this->db->select('guru.nama, COUNT(karya.uuid) as total');
        $this->db->from('guru');
        $this->db->join('karya', 'karya.created_by = guru.uuid AND karya.deleted_at IS NULL', 'left');
        $this->db->group_by('guru.uuid');
        $this->db->order_by('total', 'DESC');
        return $this->db->get()->result();
    }

    public function get_karya_terbaru() {
        return $this->db->select('karya.*, guru.nama')
            ->from('karya')
            ->join('guru', 'karya.created_by = guru.uuid', 'left')
            ->where('karya.deleted_at', NULL, FALSE)
            ->order_by('karya.modified_at', 'DESC')
            ->limit(5)
            ->get()->result();
    }
}