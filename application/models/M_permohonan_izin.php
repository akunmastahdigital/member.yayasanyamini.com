<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_permohonan_izin extends CI_Model {

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

	function get_permohonan($id_aktivitas_workflow) {
		// $this->db->wh
		return $this->db->get();
	}

	function get_workflow($id_jenis_izin, $limit=null) {
		$this->db->select('
						taw.id_aktivitas_workflow,
						taw.kd_aktivitas_workflow,
						taw.nm_aktivitas_workflow
					');
		$this->db->from('t_aktivitas_workflow taw');
		$this->db->join('t_workflow two', 'taw.id_workflow=two.id_workflow', 'right');
		$this->db->where('taw.aktif', 1);
		$this->db->where('two.aktif', 1);
		$this->db->where('two.id_jenis_izin', $id_jenis_izin);
		$this->db->order_by('kd_aktivitas_workflow', 'asc');
		$this->db->limit($limit);
		return $this->db->get();
	}

	function get_user($id_aktivitas_workflow) {
		$this->db->select('
						id_user,
						id_aktivitas_workflow
					');
		$this->db->where('aktif', 1);
		$this->db->where('id_aktivitas_workflow', $id_aktivitas_workflow);
		$this->db->from('t_user_workflow');
		$this->db->order_by('id_user_workflow', 'asc');
		return $this->db->get();
	}

	function get_last_histori($id_aktivitas_workflow, $id_permohonan=null) {
		$this->db->select('
						id_user,
						id_aktivitas_workflow
					');
		if ($id_permohonan !=  null) {
			$this->db->where('id_histori_permohonan = (SELECT max(id_histori_permohonan) FROM t_histori_permohonan WHERE id_aktivitas_workflow='.$id_aktivitas_workflow.' AND id_permohonan='.$id_permohonan.')');
			$this->db->where('id_permohonan', $id_permohonan);
		} else {
			$this->db->where('id_histori_permohonan = (SELECT max(id_histori_permohonan) FROM t_histori_permohonan WHERE id_aktivitas_workflow='.$id_aktivitas_workflow.')');
		}
		$this->db->where('id_aktivitas_workflow', $id_aktivitas_workflow);
		$this->db->where('aktif', 1); // col
		$this->db->from('t_histori_permohonan');
		return $this->db->get();
	}

	function get_userDelegation($id_aktivitas_workflow) {
		$this->db->select('
					tuw.id_user, 
					mus.nm_user');
		$this->db->select('sum(if(this.id_user=tuw.id_user && this.aktif=1, 1, 0)) as jml_tugas');
		$this->db->from('t_user_workflow tuw');
		$this->db->join('m_user mus', 'tuw.id_user=mus.id_user', 'left');
		$this->db->join('t_histori_permohonan this', 'tuw.id_user=this.id_user', 'left');
		$this->db->where('tuw.aktif', 1);
		$this->db->where('mus.aktif', 1);
		// $this->db->where('this.aktif', 1); // col
		$this->db->where('tuw.id_aktivitas_workflow', $id_aktivitas_workflow);
		$this->db->group_by('tuw.id_user');
		return $this->db->get();
	}

	function get_id_workflows($kd_aktivitas) {
		$id_aktivitas 	= $this->get_aktivitas($kd_aktivitas);
		$this->db->select('id_aktivitas_workflow');
		$this->db->where_in('id_aktivitas', $id_aktivitas);
		return $this->db->get('t_aktivitas_workflow');
	}

	function get_aktivitas($kd_aktivitas) {
		$id_aktivitas = [];
		$aktivitas 	= $this->db->query('SELECT id_aktivitas FROM m_aktivitas WHERE aktif=1 AND kd_aktivitas="'.$kd_aktivitas.'" LIMIT 1')->row_array();
		$id_aktivitas[]= $aktivitas['id_aktivitas'];

		$aktivitas_ch= $this->db->query('SELECT id_aktivitas FROM m_aktivitas_extend WHERE id_aktivitas_parent="'.$aktivitas['id_aktivitas'].'"')->result_array();
		foreach ($aktivitas_ch as $ac) {
			$id_aktivitas[] 	= $ac['id_aktivitas'];
		}
		return $id_aktivitas;
	}

	function insert_histori($data) {
		$this->db->insert('t_histori_permohonan', $data);
	}

	function insert_histori_delegasi($data) {
		$this->db->insert('t_histori_permohonan', $data);
	}

	function get_data($paramTable, $condition=null) {
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
        return $this->db->get($paramTable);
	}

	function update_data($paramTable, $c, $data) {
        $this->db->$c[2]($c[0], $c[1]);
		$this->db->update($paramTable, $data);
	}


	function get_decision($id_user, $id_aktivitas_workflow, $condition=null) {
		$this->db->select('
					twd.id_workflow_decision,
					twd.kd_workflow_decision,
					twd.id_aktivitas_workflow,
					twd.id_decision,
					mdc.kd_decision,
					twd.nm_workflow_decision,
					twd.type
				');
		$this->db->where('twd.id_aktivitas_workflow', $id_aktivitas_workflow);
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
		$this->db->where('tuw.aktif', 1);
		$this->db->where('twd.aktif', 1);
		$this->db->from('t_user_workflow tuw');
		$this->db->join('t_workflow_decision twd', 'tuw.id_aktivitas_workflow=twd.id_aktivitas_workflow', 'right');
		$this->db->join('m_decision mdc', 'mdc.id_decision=twd.id_decision', 'left');
		$this->db->group_by('twd.id_workflow_decision');
		$this->db->order_by('mdc.kd_decision');
		return $this->db->get();
	}

	function get_master_spec($paramTable, $paramSelect, $condition) {
		$this->db->select($paramSelect);
		if ($condition) {
            foreach ($condition as $c) {
            	if (!$c[2]) {
                	$this->db->$c[1]($c[0]);
            	} elseif ($c[2]) {
                	$this->db->$c[2]($c[0], $c[1]);
            	}
            }
        }
        return $this->db->get($paramTable);
	}


	function get_master_spec_ts($paramTable, $paramSelect, $condition) {
		$this->db->select($paramSelect);
		if ($condition) {
            foreach ($condition as $c) {
            	if (!$c[2]) {
                	$this->db->$c[1]($c[0]);
            	} elseif ($c[2]) {
                	$this->db->$c[2]($c[0], $c[1]);
            	}
            }
		}
		$this->db->limit(20);
        return $this->db->get($paramTable);
	}

	function update_master_spec($paramTable, $data, $condition) {
		$this->db->select($paramSelect);
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
        return $this->db->update($paramTable, $data);
	}	

	function get_data_pemohon($id_pemohon) {
		$this->db->select('
					tpe.nama,
					tpe.no_identitas,
					mji.akronim as ak_jenis_identitas,
					tpe.alamat,
					tpe.email,
					tpe.no_telp,
					tpe.no_hp
				');
		$this->db->from('t_pemohon tpe');
		$this->db->join('m_jenis_identitas mji', 'tpe.id_jenis_identitas=mji.id_jenis_identitas', 'left');
		$this->db->where('id_pemohon', $id_pemohon);
		$this->db->group_by('tpe.id_pemohon');
		return $this->db->get();
	}

	function get_data_permohonan($id_jenis_izin) {
		$this->db->select('
						mji.id_jenis_izin,
						mji.kd_jenis_izin,
						mni.nama_izin,
						mni.akronim as ak_nama_izin
					');
		$this->db->where('mji.id_jenis_izin', $id_jenis_izin);
		$this->db->from('m_jenis_izin mji');
		$this->db->join('m_nama_izin mni', 'mji.id_nama_izin=mni.id_nama_izin', 'left');
		$this->db->group_by('mji.id_jenis_izin');
		return $this->db->get();
	}

	function get_parent_izin($kd_jenis_izin) {
		$this->db->select('
						kd_jenis_izin,
						jenis_izin
					');
		$this->db->where('kd_jenis_izin', $kd_jenis_izin);
		$this->db->where('aktif', 1);
		return $this->db->get('m_jenis_izin');
	}

	function get_last_decision($id_permohonan) {
		
	}

	function get_data_perusahaan($id_perusahaan) {
		$this->db->select('
						tpsh.nama_perusahaan,
						mbu.nama_bidang_usaha,
						mju.nama_jenis_usaha,
						tpsh.npwp_perusahaan,
						tpsh.alamat,
						tpsh.email,
						tpsh.no_telp,
						tpsh.no_fax
					');
		$this->db->from('t_perusahaan tpsh');
		$this->db->join('m_bidang_usaha mbu', 'tpsh.id_bidang_usaha=mbu.id_bidang_usaha', 'left');
		$this->db->join('m_jenis_usaha mju', 'tpsh.id_jenis_usaha=mju.id_jenis_usaha', 'left');
		$this->db->where('tpsh.id_perusahaan', $id_perusahaan);
		$this->db->group_by('tpsh.id_perusahaan');
		return $this->db->get();
	}

	// function get_data_perusahaan($id_perusahaan) {
	// 	$this->db->select('
	// 					tpsh.nama_perusahaan,
	// 					mbu.nama_bidang_usaha,
	// 					mju.nama_jenis_usaha,
	// 					tpsh.npwp_perusahaan,
	// 					tpsh.alamat,
	// 					tpsh.email,
	// 					tpsh.no_telp,
	// 					tpsh.no_fax
	// 				');
	// 	$this->db->from('v_perusahaan tpsh');
	// 	$this->db->join('m_bidang_usaha mbu', 'tpsh.id_bidang_usaha=mbu.id_bidang_usaha', 'left');
	// 	$this->db->join('m_jenis_usaha mju', 'tpsh.id_jenis_usaha=mju.id_jenis_usaha', 'left');
	// 	$this->db->where('tpsh.id_perusahaan', $id_perusahaan);
	// 	$this->db->group_by('tpsh.id_perusahaan');
	// 	return $this->db->get();
	// }

	function get_data_history($id_permohonan) {
		$this->db->select('
						this.id_histori_permohonan,
						taw.nm_aktivitas_workflow,
						this.id_user,
						mpe.nm_personil,
						mja.nm_jabatan,
						this.waktu_in,
						this.catatan
					');
		$this->db->from('t_histori_permohonan this');
		$this->db->join('t_aktivitas_workflow taw', 'this.id_aktivitas_workflow=taw.id_aktivitas_workflow', 'left');
		$this->db->join('m_user mus', 'this.id_user=mus.id_user', 'left');
		$this->db->join('m_personil mpe', 'mus.id_personil=mpe.id_personil', 'left');
		$this->db->join('m_jabatan mja', 'mpe.id_jabatan=mja.id_jabatan', 'left');
		$this->db->where('this.id_permohonan', $id_permohonan);
		$this->db->where('this.aktif', 1); // col
		$this->db->group_by('this.id_histori_permohonan');
		return $this->db->get();
	}

	function get_syarat_izin($id_jenis_izin) {
		$this->db->select('
						id_syarat_izin,
						nama_syarat,
						jenis_input,
						tabel_tujuan,
						teks_judul
					');
		$this->db->where('id_jenis_izin', $id_jenis_izin);
		$this->db->where('aktif', 1);
		return $this->db->get('m_syarat_izin');	
	}

	function get_data_syarat($paramTable, $id_syarat_izin, $id_permohonan) {
		$this->db->where('aktif', 1);
		$this->db->where('id_syarat_izin', $id_syarat_izin);
		$this->db->where('id_permohonan', $id_permohonan);
		return $this->db->get($paramTable);
	}

	function get_data_berkas($id_berkas_permohonan) {
		$this->db->where('aktif', 1);
		$this->db->where('id_berkas_permohonan', $id_berkas_permohonan);
		return $this->db->get('t_berkas_permohonan');
	}

	function getPermohonanPerUser($id_user) {
		$query = $this->db->get_where('v_show_permohonan', array('id_user' => $id_user));
		return $query;
	}

	function coba_login($condition=null) {
		$this->db->select('
						mus.id_user,
						mus.nm_user,
						mpe.nm_personil,
						mja.nm_jabatan
					');
		$this->db->from('m_user mus');
		$this->db->join('m_personil mpe', 'mus.id_personil=mpe.id_personil', 'left');
		$this->db->join('m_jabatan mja', 'mpe.id_jabatan=mja.id_jabatan', 'left');
		$this->db->where('mus.aktif', 1);
		if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
		$this->db->order_by('mpe.id_jabatan', 'asc');
		$this->db->group_by('mus.id_user');
		return $this->db->get();
	}
	
}