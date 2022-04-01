<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admin extends CI_Model {

	private function _get_datatables_query($table, $column_order, $column_search, $order, $condition=null) {
		if ($condition) {
	        foreach ($condition as $c) {
	            $this->db->$c[2]($c[0], $c[1]);
	        }
        }
		
		$this->db->from($table);

		$i = 0;
	
		foreach ($column_search as $item)
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($order))
		{
			$order = $order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($table, $column_order, $column_search, $order, $condition=null) {
		$this->_get_datatables_query($table, $column_order, $column_search, $order, $condition);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($table, $column_order, $column_search, $order, $condition=null) {
		$this->_get_datatables_query($table, $column_order, $column_search, $order, $condition);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all($table, $condition=null) {
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	function update_data($paramTable, $c, $data) {
        $this->db->$c[2]($c[0], $c[1]);
		$this->db->update($paramTable, $data);
	}

	function update_data_batch($paramTable, $c, $data) {
		$this->db->update_batch($paramTable, $data, $c);
	}	

	function insert_data($paramTable, $data) {
		$this->db->insert($paramTable, $data);
		return $this->db->insert_id();
	}

	function insert_data_batch($paramTable, $data) {
			$this->db->insert_batch($paramTable, $data);
	}	


	function get_data($paramTable, $condition=null) {
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
        return $this->db->get($paramTable);
	}

	function get_master_spec($paramTable, $paramSelect, $condition) {
		$this->db->select($paramSelect);
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
        return $this->db->get($paramTable);
	}

	function list_user($condition=null) {
		$this->db->select("
				mu.id_user,
				mu.nm_user,
				ja.nm_jabatan
			");
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }		
		$this->db->from('m_user mu');
		$this->db->join('m_personil mp', 'mu.id_personil = mp.id_personil');
		$this->db->join('m_jabatan ja', 'mp.id_jabatan = ja.id_jabatan');
		return $this->db->get();
	}

	function get_max_number($paramTable, $paramColumn, $condition=null) {
		$this->db->select($paramColumn);
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
        $data 	= $this->db->get($paramTable)->result_array();
        if ($data) {	
        	return $max_value 	= max($data)[$paramColumn];
        } else {
        	return null;
        }
	}


	function getJabatan(){

		$this->db->where('aktif =', 1);
		$query = $this->db->get('m_role');
		return $query;
	}

	function getTreeMenu(){
		$query = $this->db->query('Select id_menu_bo, nm_menu, url, aktif, id_parent FROM m_menu_bo')->result_array();

		foreach ($query as $row ) {
			$data[] = $row;
		}

		return $data;
	}

	function getJabatanById($id_role){
		$query = $this->db->get_where('m_role', array('id_role' => $id_role ));
		return $query;
	}

	function query($query) {
		return $this->db->query($query);
	}


}