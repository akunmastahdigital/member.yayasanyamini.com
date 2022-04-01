<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_userbo extends CI_Model {

	function insert_to($tbl, $data) {
		$this->db->insert($tbl, $data);
	}

	function get_from($tbl, $where) {
		$this->db->where($where);
		return $this->db->get($tbl);
	}

	function update_from($tbl, $data, $where) {
		$this->db->where($where);
		$this->db->update($tbl, $data);
	}

}