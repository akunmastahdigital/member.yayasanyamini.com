<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
        	redirect('user/login');
        }
        
	}
	
	function index() {
        $d['page']      = 'dashboard';

        //belum di disposisi
        $condition 				= [];
		$condition[] 			= ['id_aktivitas', 4, 'where'];
		$d['jml_blm_disposisi'] = $this->M_core->get_tbl('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();

		//belum di verifikasi
        $condition 			 	 = [];
		$condition[] 		 	 = ['id_aktivitas', 5, 'where'];
		$d['jml_blm_verifikasi'] = $this->M_core->get_tbl('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();

		//di pending
        $condition 	  		 = [];
		$condition[]  		 = ['id_aktivitas', 20, 'where'];
		$d['jml_di_pending'] = $this->M_core->get_tbl('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();

		//di tolak
        $condition 	  		 = [];
		$condition[]  		 = ['id_decision', 3, 'where'];
		$d['jml_di_tolak']   = $this->M_core->get_tbl('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();

		//terbit
        $condition 	  		 = [];
		$d['jml_di_terbit']  = $this->M_core->get_tbl('v_permohonan_izin_terbit', 'id_permohonan', $condition)->num_rows();

		//semua
        $condition 	   	 = [];
        // $condition[]	 = ['id_aktivitas !=', null, 'where'];
		$d['jml_semua']  = $this->M_core->get_tbl('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();


		//perbandingan1
		$jml = $d['jml_di_tolak'] + $d['jml_di_terbit'];
		$d['cont_p1'][0] = 0;
		$d['cont_p1'][1] = 0;
		if($d['jml_di_terbit'] != 0) {
			$d['cont_p1'][0] = round($d['jml_di_terbit'] / $jml * 100, 1);
		}
		if($d['jml_di_tolak'] != 0) {
			$d['cont_p1'][1] = round($d['jml_di_tolak'] / $jml * 100, 1);
		}

		//perbandingan2&3
		$condition 	   	 = [];
		$condition[]   	 = ['bulan', 'asc', 'order_by'];
		$d['vpi_all']  	 = $this->M_core->get_tbl('v_permohonan_izin_all_by_m', '*', $condition);

		//all Aktivitas
		$condition		= [];
		$condition[]    = ['aktif != ', 0, 'where'];
		$d['get_aktivitas'] = $this->M_core->get_tbl('m_aktivitas', '*', $condition)->result();



		$this->load->view('layout', $d);
	}

}