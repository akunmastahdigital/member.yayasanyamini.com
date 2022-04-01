<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_cms extends CI_Model {

	function l_nama_izin() {
		$this->db->where('aktif', 1);
		return $this->db->get('m_nama_izin');
	}

	function l_jenis_izin($kode, $lvl) {
		$this->db->where('aktif', 1);
		$this->db->where('level_ke', $lvl);
		$this->db->like('kd_jenis_izin', $kode, 'after');
		$this->db->order_by('kd_jenis_izin', 'asc');
		return $this->db->get('m_jenis_izin');
	}

}