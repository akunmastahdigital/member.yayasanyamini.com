<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model {

	function getUser($username) {

		$query = $this->db->query("select 
							a.id_user,
							a.id_personil,
							a.id_role,
							a.nm_user,
							a.username,
							a.sandi_user,
							a.flagging,
							a.img,
							a.aktif as aktif,
							b.nm_role

							FROM m_user a LEFT JOIN 
							m_role b ON a.id_role = b.id_role

							WHERE a.aktif = 1 AND username = '$username'");

		return $query;
		
	}

}