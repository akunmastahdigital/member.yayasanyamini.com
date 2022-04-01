<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_timeline extends CI_Model {

	function get_tbl($paramTable, $paramSelect, $condition) {
		$this->db->select($paramSelect);
		if ($condition) {
            foreach ($condition as $c) {
                if($c[0] == '') {
                	$this->db->$c[2]($c[1]);
                } else {
                    $this->db->$c[2]($c[0], $c[1]);
                }
            }
        }
        return $this->db->get($paramTable);
	}

}