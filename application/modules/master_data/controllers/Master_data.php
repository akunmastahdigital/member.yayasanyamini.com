<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_data extends MY_Controller {
	function __construct() {
        parent::__construct();
		if (!$this->session->userdata('id_user')) {
        	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->session->set_userdata('url', $actual_link);
			redirect('user/login');
        }
        
	}
	
	function index() {
        show_404();
	}

	function proposal(){
		$d['menu']  = 'Master Data';
        $d['page']  = 'md_proposal';
        $d['title']	= 'List Proposal';

		$condition 	  = [];
		$condition[]  = ['id_user', $this->session->userdata('id_user'), 'where'];
		// $d['result'] = $this->M_core->get_tbl('v_progress_zakat', '*', $condition)->row_array();
		$d['data_user'] = $this->M_core->get_tbl('m_user', '*', $condition)->row_array();
		$d['nama_user'] = $this->session->userdata('nm_user');
		$condition 		= array();
		$condition[] 	= array('id_nama_izin', 1, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$d['option'] 	= $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'id_jenis_izin, teks_menu', $condition)->result_array();

		$this->load->view('layout', $d);
	}
	function program(){
		$d['menu']  = 'Master Data';
        $d['page']  = 'md_program';
        $d['title']	= 'List Program';
        // $d['list_progress_user'] = $this->get_progress_user();

		$this->load->view('layout', $d);
	}
	function tools_marketing(){
		$d['menu']  = 'Master Data';
        $d['page']  = 'md_tools_marketing';
        $d['title']	= 'List tools_marketing';
        // $d['list_progress_user'] = $this->get_progress_user();

		$this->load->view('layout', $d);
	}
	function social_media(){
		$d['menu']  = 'Master Data';
        $d['page']  = 'md_social_media';
        $d['title']	= 'List Social Media';
        // $d['list_progress_user'] = $this->get_progress_user();

		$this->load->view('layout', $d);
	}

	function list_progress(){
		$d['menu']  = 'Master Data';
        $d['page']  = 'md_progress_zakat';
        $d['title']	= 'List Progress Zakat';
        $d['list_progress_user'] = $this->get_progress_user();

		$this->load->view('layout', $d);
	}

	function get_progress_user(){
		$condition 	  = [];
		//$condition[]  = ['8', '', 'limit'];
		$result = $this->M_core->get_tbl('v_progress_zakat', '*', $condition)->result_array();
		return $result;
	}

	function permohonan_izin() {
		$d['menu']  = 'Master Data';
        $d['page']  = 'md_permohonan_izin';
        $d['title']	= 'List Permohonan Izin';
        $d['list_menuizin'] = $this->list_menuizin();
        $d['total'] 		= $this->permohonan_izin_total(0, 'normal');

		$this->load->view('layout', $d);
	}

	public function permohonan_izin_show($type=null) {
		//get data
		$id_nama_izin	= $this->input->post('id_nama_izin');
		$id_jenis_izin	= $this->input->post('id_jenis_izin');
		$id_decision 	= $this->input->post('id_decision');
		
		$type = 'normal';
		if($id_decision == 2) {
			$type = 'terbit';
		}

		// table
		if($type == 'normal') {
			$table          = 'v_permohonan_izin';

			// condition
			$condition 	    = [];
			if($id_nama_izin != '') {
				$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
			}
			if($id_jenis_izin != '') {
				$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
			}
			if($id_decision != '') {
				$condition[]  = ['id_decision', $id_decision, 'where'];
			}

			// datatable
			$column_order   = [null, 'no_permohonan', 'tgl_permohonan', null, 'nama_pemohon', 'nilai_string', 'nama_izin', 'nm_aktivitas_workflow']; 
	        $column_search  = ['no_permohonan', 'tgl_permohonan', 'nama_pemohon', 'nilai_string', 'nama_izin', 'nm_aktivitas_workflow']; 
	        $order          = ['tgl_permohonan' => 'asc'];

	        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = [];
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {
	        	if ($ld->kd_decision == 'rjct') {
	                $prmh['status']     = "Mohon Ajukan Ulang";
	            } elseif ($ld->kd_decision == 'pndg') {
	                $prmh['status']     = "Menunggu Diperbaiki";
	            } else {
	                $prmh['status']     = "Menunggu ".$ld->nm_aktivitas_workflow;
	            }

	            $no++;
	            $row = [];
	            $row[] = $no;
	            $row[] = $ld->no_permohonan;
	            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
	            $row[] = '';
	            $row[] = $ld->nama_pemohon;
	            $row[] = $ld->nilai_string;
	            $row[] = $this->get_jenis_izin($ld->id_jenis_izin);
	            // $row[] = $ld->nama_izin.' - '.$ld->jenis_izin;
	            $row[] = $prmh['status'];

	            $data[] = $row;
	        }
		} 

		if($type == 'terbit') {
			$table          = 'v_permohonan_izin_terbit';

			// condition
			$condition 	    = [];
			if($id_nama_izin != '') {
				$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
			}
			if($id_jenis_izin != '') {
				$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
			}

			// datatable
			$column_order   = [null, 'no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin', 'nm_aktivitas_workflow']; 
	        $column_search  = ['no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin', 'nm_aktivitas_workflow']; 
	        $order          = ['tgl_permohonan' => 'asc'];

	        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = [];
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {
	        	if ($ld->kd_decision == 'rjct') {
	                $prmh['status']     = "Mohon Ajukan Ulang";
	            } elseif ($ld->kd_decision == 'pndg') {
	                $prmh['status']     = "Menunggu Diperbaiki";
	            } else {
	                $prmh['status']     = "Menunggu ".$ld->nm_aktivitas_workflow;
	            }

	            $no++;
	            $row = [];
	            $row[] = $no;
	            $row[] = $ld->no_permohonan;
	            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
	            $row[] = date('d-m-Y', strtotime($ld->tgl_terbit));
	            $row[] = $ld->nama_pemohon;
	            $row[] = $ld->nilai_string;
	            $row[] = $this->get_jenis_izin($ld->id_jenis_izin);
	            // $row[] = $ld->nama_izin.' - '.$ld->jenis_izin;
	            $row[] = $prmh['status'];

	            $data[] = $row;
	        }
		}
				
        $output = [
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_datatables->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_datatables->count_all($table, $condition),
	            "data" => $data,
            ];
        echo json_encode($output);
	}

	function permohonan_izin_total($type1, $type2) {		
		// get data
		if($type1 == 0) {
			$id_nama_izin 	= '';
			$id_jenis_izin 	= '';
			$id_decision 	= '';
			$date_end 		= '';
		} else if($type1 == 1) {
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$id_decision 	= $this->input->post('id_decision');
		}

		if($type2 == 'normal') {
			$table          = 'v_permohonan_izin';

			// condition
			$condition 	    = [];
			if($id_nama_izin != '') {
				$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
			}
			if($id_jenis_izin != '') {
				$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
			}
			if($id_decision != '') {
				$condition[]  = ['id_decision', $id_decision, 'where'];
			}
		}

		if($type2 == 'terbit') {
			$table          = 'v_permohonan_izin_terbit';

			// condition
			$condition 	    = [];
			if($id_nama_izin != '') {
				$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
			}
			if($id_jenis_izin != '') {
				$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
			}
		}


		// query
		$gtl = $this->M_core->get_tbl($table, '*', $condition);
		$res['total'] = $gtl->num_rows();
		$res['msg'] = 'valid';

		// response
		if($type1 == 0) {
			return $res['total'];
		} else if($type1 == 1) {
			echo json_encode($res);	
		}
	}

	// tools
	function list_menuizin() {
		$body 	= '';
		$nama_izin 	= $this->M_cms->l_nama_izin()->result_array();

		$kd_helperjn= [];

		foreach ($nama_izin as $ni) {
			$check_child 	= $this->M_cms->l_jenis_izin($ni['kd_nama_izin'], 1)->result_array();
			if ($check_child) {
				$helperjn['kd'] =  $ni['kd_nama_izin'];
				$helperjn['lv'] =  1;
				$helperjn['jl'] =  $ni['jumlah_level'];
				$kd_helperjn[] 	= $helperjn;


				$body 	.= '<li><a onclick="get_nama_izin('.$ni['id_nama_izin'].', this)" data-status="0" data-izin="'.$ni['id_nama_izin'].'" class="prev-default ">'.$ni['akronim'].'</a>
					            <ul>
					            change-'.$ni['kd_nama_izin'].
					            '</ul>
							</li>';
			} else {
				$body 	.= '<li><a class="prev-default ">'.$ni['akronim'].'</a></li>';
			}
		}

		while (count($kd_helperjn) != 0) {
			foreach ($kd_helperjn as $k => $v) {
				$jenis_izin 	= $this->M_cms->l_jenis_izin($kd_helperjn[$k]['kd'], $kd_helperjn[$k]['lv'])->result_array();
				$content 		= '';
				foreach ($jenis_izin as $ji) {
					$check_child 	= $this->M_cms->l_jenis_izin($ji['kd_jenis_izin'], $kd_helperjn[$k]['lv']+1)->result_array();
					if ($check_child && $kd_helperjn[$k]['lv']+1 <= $kd_helperjn[$k]['jl']) {
						$helperjn['kd'] = $ji['kd_jenis_izin'];
						$helperjn['lv'] = $kd_helperjn[$k]['lv']+1;
						$helperjn['jl'] = $kd_helperjn[$k]['jl'];
						$kd_helperjn[] 	= $helperjn;

						$content 	.= '<li><a class="prev-default ">'.$ji['teks_menu'].'</a>
							            <ul>
							            change-'.$ji['kd_jenis_izin'].
							            '</ul>
									</li>';
					} else {
						$content 	.= '<li><a onclick="get_jenis_izin('.$ji['id_jenis_izin'].', this)" data-status="0" data-kd_izin="'.$ji['kd_jenis_izin'].'" data-izin="'.$ji['id_jenis_izin'].'" class="prev-default">'.$ji['teks_menu'].'</a></li>';
					}
				}
				$body 			= preg_replace('/change-'.$kd_helperjn[$k]['kd'].'/', $content, $body);
				unset($kd_helperjn[$k]);
			}
		}		

		return '<ul class="collapsibleList">'.$body.'</ul>';			
	}

	private function get_jenis_izin($id_jenis_izin) {
		$condition 		= [];
		$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$jiz			= $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'kd_jenis_izin, id_nama_izin', $condition)->row_array();

		$kd_jenis_izin = $jiz['kd_jenis_izin'];

		$condition 		= [];
		$condition[] 	= ['id_nama_izin', $jiz['id_nama_izin'], 'where'];
		$nama_izin 		= $this->M_permohonan_izin->get_master_spec('m_nama_izin', 'akronim', $condition)->row_array()['akronim'];		

		$data_jenis	= array();

		$data		= $this->M_permohonan_izin->get_parent_izin($kd_jenis_izin)->row_array();
		while ($data) {	
			$parent_kd 	= substr($data['kd_jenis_izin'], 0, -2);
			$data_jenis[] = $data['jenis_izin'];
			$data		= $this->M_permohonan_izin->get_parent_izin($parent_kd)->row_array();
		}
		$data_jenis 	= array_reverse($data_jenis);

		$response 		= $nama_izin.' - ';
		
		$i = 0;
		$count = count($data_jenis);
		foreach ($data_jenis as $dj) {
			$pref = " - ";
			if(++$i === $count) {
				$pref = "  ";
			}
			$response	.= $dj.$pref;
		}
		return $response;
	}



}