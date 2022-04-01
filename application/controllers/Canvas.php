<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canvas extends CI_Controller {

	function __construct() {
        parent::__construct();
	}

	function boom() {
		// set post fields
		$post = [
		    'user' => 'bekasikota',
		    'pwd' => 'P4trioTCity'
		];

		$ch = curl_init('https://ex-1.pajak.go.id/djpws/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		var_dump($response);
		// $this->load->view('teser');
	}


	private function bot_core_cfg_si() {
		$condition   = [];
		$condition[] = ['aktif', 1, 'where'];
		$get_vaw     = $this->M_core->get_tbl('v_aktivitas_workflow', '*', $condition);
		$i = 0;

		foreach($get_vaw->result_array() as $vaw) {

			$dCfg[$i]['id_aktivitas_workflow'] = $vaw['id_aktivitas_workflow'];

			if($vaw['id_aktivitas'] == 5) {

				$dCfg[$i]['permission'] = 2;

			} else {

				$dCfg[$i]['permission'] = 1;

			}

			$i++;

			// echo $vaw['id_aktivitas_workflow'].' '.$vaw['id_aktivitas'].'<br>';

		}



		// $ins_si   = $this->M_core->insert_tbl_batch('m_syarat_izin_cfg', $dCfg);

	}



	private function bot_core_cfg_rb() {

		$condition   = [];

		$condition[] = ['aktif', 1, 'where'];

		// $condition[] = ['id_jenis_izin', [36,37,38,40,45], 'where_in']; // iptm 36,37,38,40 , imb 45

		// $condition[] = ['id_jenis_izin', 36, 'where'];

		// $condition[] = ['id_jenis_izin', 37, 'where'];

		// $condition[] = ['id_jenis_izin', 38, 'where'];

		// $condition[] = ['id_jenis_izin', 40, 'where'];

		// $condition[] = ['id_jenis_izin', 45, 'where'];

		$get_vaw     = $this->M_core->get_tbl('v_aktivitas_workflow', '*', $condition);



		$i = 0;

		foreach($get_vaw->result_array() as $vaw) {

			$dCfg[$i]['id_aktivitas_workflow'] = $vaw['id_aktivitas_workflow'];

			if($vaw['id_aktivitas'] == 5) {

				$dCfg[$i]['permission'] = 2;

			} else {

				$dCfg[$i]['permission'] = 1;

			}

			$i++;

			// echo $vaw['id_aktivitas_workflow'].' '.$vaw['id_aktivitas'].'<br>';

		}



		// $ins_rb   = $this->M_core->insert_tbl_batch('m_rekam_berkas_cfg', $dCfg);

	}

	function detail(){
		$condition		= [];
		$condition[]    = ['aktif != ', 0, 'where'];
		$d['get_aktivitas'] = $this->M_core->get_tbl('m_aktivitas', '*', $condition)->result();

		$this->load->view('teser', $d);
	}



	private function bot_core_cfg_pbio() {

		$condition   = [];

		$condition[] = ['aktif', 1, 'where'];

		$condition[] = ['id_jenis_izin != ', 8, 'where'];  //siup perorangan baru

		$condition[] = ['id_jenis_izin != ', 9, 'where']; //siup perorangan daftar ulang

		$condition[] = ['id_jenis_izin != ', 17, 'where']; //tdp perorangan baru

		$condition[] = ['id_jenis_izin != ', 27, 'where']; //tdp perorangan daftar ulang

		$condition[] = ['id_jenis_izin != ', 36, 'where'];  //iptm baru

		$condition[] = ['id_jenis_izin != ', 37, 'where'];  //iptm tumpang tindih

		$condition[] = ['id_jenis_izin != ', 38, 'where'];  //iptm pindah kerangka

		$condition[] = ['id_jenis_izin != ', 40, 'where'];  //iptm perpanjangan

		$condition[] = ['id_jenis_izin != ', 45, 'where'];  //imb rt baru

		$condition[] = ['id_jenis_izin != ', 47, 'where'];  //sipa barang baru

		$condition[] = ['id_jenis_izin != ', 49, 'where'];  //sipa barang perpanjangan

		$get_vaw     = $this->M_core->get_tbl('v_aktivitas_workflow', '*', $condition);



		$i = 0;

		foreach($get_vaw->result_array() as $vaw) {

			$dCfg[$i]['id_aktivitas_workflow'] = $vaw['id_aktivitas_workflow'];

			if($vaw['id_aktivitas'] == 5) {

				$dCfg[$i]['permission'] = 2;

			} else {

				$dCfg[$i]['permission'] = 1;

			}

			$i++;

			// echo $vaw['id_aktivitas_workflow'].' '.$vaw['id_aktivitas'].'<br>';

		}



		// $ins_pbio = $this->M_core->insert_tbl_batch('m_perusahaan_bio_cfg', $dCfg);

	}



	//Insert Koef

	private function insert_koef() {

		$condition   = [];

		$condition[] = ['aktif', 1, 'where'];

		$condition[] = ['id_jenis_izin', 45, 'where'];

		$condition[] = ['id_ret_nilai_koef', 'asc', 'order_by'];

		$get_data    = $this->M_core->get_tbl('m_ret_nilai_koef', '*', $condition);

		

		$i = 0;

		foreach($get_data->result_array() as $gd) {



			$data[$i]['id_ret_jenis_koef'] 	= $gd['id_ret_jenis_koef'];

			$data[$i]['item_koef'] 			= $gd['item_koef'];

			$data[$i]['nilai_koef'] 		= $gd['nilai_koef'];

			$data[$i]['id_jenis_izin'] 		= 32;

			$data[$i]['satuan'] 			= $gd['satuan'];



			$data_ins = $this->M_core->insert_tbl_normal('m_ret_nilai_koef', $data[$i]);

			$i++;

		}	

	}



	private function insert_formula() {

		$condition   = [];

		$condition[] = ['aktif', 1, 'where'];

		$condition[] = ['id_jenis_izin', 29, 'where'];

		$condition[] = ['id_ret_formula', 'asc', 'order_by'];

		$get_data    = $this->M_core->get_tbl('m_ret_formula', '*', $condition);

		

		$i = 0;

		foreach($get_data->result_array() as $gd) {



			$data[$i]['id_jenis_izin'] 	= 32;

			$data[$i]['formula'] 		= $gd['formula'];

			$data[$i]['query'] 			= $gd['query'];



			$data_ins = $this->M_core->insert_tbl_normal('m_ret_formula', $data[$i]);

			$i++;

		}	

	}



	function sw_m_jenis_izin($id_nama_izin) {
		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_nama_izin', $id_nama_izin, 'where'];
		$condition[] 	= ['level_ke', 2, 'where'];
		$get_tbl		= $this->M_core->get_tbl('m_jenis_izin', '*', $condition);

		$html = '';
		foreach($get_tbl->result_array() as $gtb) {
			$html .= $gtb['id_jenis_izin'].' '.$this->get_jenis_izin($gtb['id_jenis_izin']).'<br>';
		}

		echo $html;
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



