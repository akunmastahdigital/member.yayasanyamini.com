<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teser extends CI_Controller {
	function __construct() {
        parent::__construct();

		}


	function index(){
		
		// Logika 1
		$n = 3;
		$res = 0;
		echo "Hasil : ";

		for ($i = 1; $i <= $n; $i++) {
			$res = $res + $i;
		}
		echo $res;


	}

	
	function countPermohonan(){
		$id_user = 5;
		$jumlahPermohonan = $this->db->query('select count(id_permohonan) as id_permohonan from v_show_permohonan where id_user = 5')->row_array;
		echo $jumlahPermohonan;

	}

	function boon() {
		// // set post fields
		// $post = [
		//     'user' => 'bekasikota',
		//     'pwd' => 'P4trioTCity'
		// ];

		// $ch = curl_init('https://ex-1.pajak.go.id/djpws/token');
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// // execute!
		// $response = curl_exec($ch);

		// // close the connection, release resources used
		// curl_close($ch);

		// // do anything you want with your response
		// var_dump($response);
		// $this->load->view('teser');
		// echo $this->encrypt->decode('xEp5/8JrcgWC+lR5DdNdi1bMgnJ8K4zjtUop2hLNcCp1ky3IfDfJPxHCljy4LrLKSov7U3iSyRqD6ggnQ7PPcg==');

		// echo $this->encrypt->decode('u4Tjtv2NNwXnzOUrOAi0BgvPrEREaZ7eZns0X72e5WsSZ4ETClwH738w+lG7lkXidoR2jUkJW31GV2dC0epj2Q==');
		echo 'jeng';
	}

	function ucup() {
		$user 	= $this->input->post('user');
		$pwd 	= $this->input->post('pwd');

		return $user.' '.$pwd;
	}

	function cek(){
		$condition = [];
		$getAllId = $this->M_permohonan_izin->get_master_spec('t_permohonan_final', 'id_permohonan', $condition)->result_array();
		foreach ($getAllId as $row) {
			echo '<pre>';
			echo $row['id_permohonan'];
		}

	}

	public function api_bayar_permohonan() {
		$id_permohonan 		= $this->input->post('permohonan');
		$id_aktivitas_workflow 	= $this->input->post('aktivitas');

		$condition 			= [];
		$condition[] 		= ['id_decision', 2, 'where'];
		$condition[] 		= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
		$id_workflow_decision 	= $this->M_permohonan_izin->get_master_spec('t_workflow_decision', 'id_workflow_decision', $condition)->row_array()['id_workflow_decision'];


		$catatan 			= $this->input->post('catatan');
		$page 				= $this->input->post('page');

		$id_user 			= $this->session->userdata('id_user');

		$condition 			= array();
		$condition[] 		= array('id_permohonan', $id_permohonan, 'where');
		$id_jenis_izin 		= $this->M_permohonan_izin->get_master_spec('t_permohonan', 'id_jenis_izin', $condition)->row_array()['id_jenis_izin'];

		unset($condition);
		$condition 			= array();
		$condition[] 		= array('id_permohonan', $id_permohonan, 'where');
		$v_permohonan_izin 	= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'no_permohonan, id_pemohon', $condition)->row_array();
		$no_permohonan   	= $v_permohonan_izin['no_permohonan'];
		$id_pemohon			= $v_permohonan_izin['id_pemohon'];

		$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
		$id_user_next 				= $this->get_next_user($id_aktivitas_workflow_next);
		$data 	= array(
					'id_permohonan' 	=> $id_permohonan,
					'id_user' 			=> $id_user_next,
					'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
					'catatan'			=> $catatan,
					'id_workflow_decision'	=> $id_workflow_decision
				);
	}

	function bayar_permohonan() {
		$no_permohonan 	= $this->input->get('no_permohonan');

		$condition 		= [];
		$condition[] 	= ['no_permohonan', $no_permohonan, 'where'];

		$response 	= $this->M_admin->get_master_spec('v_permohonan_izin', '*' , $condition)->row_array();

		$d['data'] 		= $response;
		$this->load->view('page_bayar', $d);
	}

	function get_next_user() {
		$id_jabatan_workflow 	= 2;

		$count_user			= $this->M_permohonan_izin->get_user($id_jabatan_workflow)->num_rows();
		$list_user			= $this->M_permohonan_izin->get_user($id_jabatan_workflow)->result_array();

		$next_user 			= $this->M_permohonan_izin->get_user($id_jabatan_workflow)->row_array()['id_user'];

		$last_user 			= $this->M_permohonan_izin->get_last_histori($id_jabatan_workflow)->row_array()['id_user'];

		foreach ($list_user as $lu => $value) {
			if (($list_user[$lu]['id_user'] == $last_user) && ($lu+1 < $count_user)) {
				$next_user 	= $list_user[$lu+1]['id_user'];
			} else {
				break;
			}
		}

		return $next_user;
	}

	function get_next_workflow($id_jenis_izin, $id_jabatan_workflow=null) {
		$list_workflow= $this->M_permohonan_izin->get_workflow($id_jenis_izin)->result_array();

		$next_aktivitas 			= $this->M_permohonan_izin->get_workflow($id_jenis_izin)->row_array()['id_jabatan_workflow'];

		foreach ($list_workflow as $lw => $value) {
			if ($list_workflow[$lw]['id_jabatan_workflow'] == $id_jabatan_workflow_now) {
				$next_aktivitas 	= $list_workflow[$lw+1]['id_jabatan_workflow'];
			}
		}

		return $next_aktivitas;
	}

	function get_user() {
		var_dump($this->M_permohonan_izin->get_userDelegation(2)->result_array());
	}

	function get_workflow() {
		$id_jabatan_workflows 	= $this->M_permohonan_izin->get_id_workflows(10)->result_array();
		// var_dump($id_jabatan_workflows);
		$id_jabatan_workflow_next	= $this->get_next_workflow($ld->id_jenis_izin, $ld->id_jabatan_workflow);
		echo $id_jabatan_workflow_next;
		// echo $id_jabatan_workflows;
	}

	function get_button() {
		$response 	= '';
		$id_user 	= 2;

		$get_decision 	= $this->M_permohonan_izin->get_decision($id_user, 2)->result_array();

		foreach ($get_decision as $gd) {
			$costum 	= array();
			if ($gd['kd_decision'] == 'aprv') {
				$cust 	= array(
							'btn_color' 	=> 'btn-success',
							'btn_icon' 		=> 'fa fa-check',
							'btn_title'		=> 'Setujui',
							'btn_action'	=> ''
						);
			} elseif ($gd['kd_decision'] == 'pndg') {
				$cust 	= array(
							'btn_color' 	=> 'btn-warning',
							'btn_icon' 		=> 'fa fa-circle-o-notch',
							'btn_title'		=> 'Pending',
							'btn_action'	=> ''
						);
			} elseif ($gd['kd_decision'] == 'dtl') {
				$cust 	= array(
							'btn_color' 	=> 'btn-primary',
							'btn_icon' 		=> 'fa fa-search',
							'btn_title'		=> 'Detail Permohonan',
							'btn_action'	=> ''
						);
			} elseif ($gd['kd_decision'] == 'vw') {
				$cust 	= array(
							'btn_color' 	=> 'btn-default',
							'btn_icon' 		=> 'ti ti-eye',
							'btn_title'		=> 'Lihat',
							'btn_action'	=> ''
						);
			} elseif ($gd['kd_decision'] == 'rjct') {
				$cust 	= array(
							'btn_color' 	=> 'btn-danger',
							'btn_icon' 		=> 'fa fa-times',
							'btn_title'		=> 'Tolak',
							'btn_action'	=> ''
						);
			}

			$response 	.= '<button data-permohonan="" data-action="'.$cust['btn_action'].'" class="btn btn-xs btn-icon waves-effect '.$cust['btn_color'].' m-b-5 tooltip-hover">
						  		<title="'.$cust['btn_title'].'"> <i class="'.$cust['btn_icon'].'"></i>
							</button>';
		};

		// echo $get_decision;
		echo ($response);
	}

	function detail() {
		$id_permohonan 	= 1;
		$id_perusahaan 	= 1;
		$id_jenis_izin 	= 8;
		$id_pemohon 	= 2;

		$pemohon		= $this->M_permohonan_izin->get_data_pemohon($id_pemohon)->row_array();

		$permohonan		= $this->M_permohonan_izin->get_data_permohonan($id_jenis_izin)->row_array();
		$permohonan['jenis_izin'] 	= $this->get_jenis_izin($permohonan['kd_jenis_izin']);

		$perusahaan 	= $this->M_permohonan_izin->get_data_perusahaan($id_perusahaan)->row_array();
		$perusahaan['badan_usaha'] 	= $perusahaan['nama_bidang_usaha']." ,".$perusahaan['nama_jenis_usaha'];

		$history 		= $this->M_permohonan_izin->get_data_history($id_permohonan)->result_array();

		$data_permohonan= array();
		$syarat_permohonan	= $this->M_permohonan_izin->get_syarat_izin($id_jenis_izin)->result_array();
		foreach ($syarat_permohonan as $sP) {
			if ($sP['jenis_input'] == 'text') {
				$data_syarat= $this->M_permohonan_izin->get_data_syarat('t_syarat_permohonan', $sP['id_syarat_izin'], $id_permohonan)->result_array();
				if ($data_syarat) {
					foreach ($data_syarat as $dS) {
						$data 		= array();
						// $data['teks_syarat'] 	= $sP['teks_judul'].' ('.intval($dS['indeks']+1).')';
						$data['teks_syarat'] 	= $sP['teks_judul'];
						$data['jenis_input'] 	= $sP['jenis_input'];
						$data['nilai_string']	= $dS['nilai_string'];
						$data['nilai_numerik']	= $dS['nilai_numerik'];
						$data_permohonan[$sP['jenis_input']][]= $data;
					}
				} else {
					$data 		= array();
					// $data['teks_syarat'] 	= $sP['teks_judul'].' ('.intval($dS['indeks']+1).')';
					$data['teks_syarat'] 	= $sP['teks_judul'];
					$data['jenis_input'] 	= $sP['jenis_input'];
					$data['nilai_string']	= $dS['nilai_string'];
					$data['nilai_numerik']	= $dS['nilai_numerik'];
					$data_permohonan[$sP['jenis_input']][]= $data;
				}
			} elseif ($sP['jenis_input'] == 'file') {
				$data_syarat= $this->M_permohonan_izin->get_data_syarat('t_berkas_permohonan', $sP['id_syarat_izin'], $id_permohonan)->result_array();
				if ($data_syarat) {
					foreach ($data_syarat as $dS) {
						$data 		= array();
						// $data['teks_syarat'] 	= $sP['teks_judul'].' ('.intval($dS['indeks']+1).')';
						$data['teks_syarat'] 	= $sP['teks_judul'];
						$data['jenis_input'] 	= $sP['jenis_input'];
						$data['nama_file_asli']	= $dS['nama_file_asli'];
						$data['nama_file_hash']	= $dS['nama_hash'];
						$data['lokasi_file']	= $dS['lokasi_file'];
						$data_permohonan[$sP['jenis_input']][]= $data;
					}
				} else {
					$data 		= array();
					// $data['teks_syarat'] 	= $sP['teks_judul'].' ('.intval($dS['indeks']+1).')';
					$data['teks_syarat'] 	= $sP['teks_judul'];
					$data['jenis_input'] 	= $sP['jenis_input'];
					$data['nama_file_asli']	= '';
					$data['nama_file_hash']	= '';
					$data['lokasi_file']	= '';
					$data_permohonan[$sP['jenis_input']][]= $data;
				}
			}
		}

		var_dump($data_permohonan);
	}

	function get_jenis_izin($kd_jenis_izin) {
		$data_jenis	= array();

		$data		= $this->M_permohonan_izin->get_parent_izin($kd_jenis_izin)->row_array();
		while ($data) {
			$parent_kd 	= substr($data['kd_jenis_izin'], 0, -2);
			$data_jenis[] = $data['jenis_izin'];
			$data		= $this->M_permohonan_izin->get_parent_izin($parent_kd)->row_array();
		}

		$data_jenis 	= array_reverse($data_jenis);

		$response 		= '';
		foreach ($data_jenis as $dj) {
			$response	.= $dj." ";
		}
		// echo ;
		return $response;
	}

	function sql_query() {
		$this->load->view('sql_query');
	}

	function sql_query_action() {
		$text_sql 	= $this->input->post('text_sql');
		echo $this->db->query($text_sql).'<br>';

		$sql = file_get_contents("update-001.sql");

		$sqls = explode(';', $sql);
		array_pop($sqls);

		foreach($sqls as $statement){
		    $statment = $statement . ";";
		    echo $this->db->query($statement).'<br>';
		}
	}

	function test() {
		$nm_jabatan 	= $this->input->get('nm_jabatan');
		$data 	= $this->M_permohonan_izin->get_id_workflows($nm_jabatan);
		// echo $data;
		var_dump($data->result_array());
	}

	function dm_jabatan() {
		$d['page']      	= 'dm_jabatan';
        $d['menu']      	= 'Data Master Jabatan';
        $d['title']      	= 'Data Master Jabatan';

		$this->load->view('layout', $d);
	}

	public function show_dm_jabatan() {
		$table          = 'm_jabatan';

        $column_order   = array(null, 'id_jabatan', 'nm_jabatan', 'level_jabatan', 'keterangan', null, null);
        $column_search  = array('id_jabatan', 'nm_jabatan', 'level_jabatan', 'keterangan',);
        $order          = array('id_jabatan' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jabatan="'.$ld->id_jabatan.'" type="checkbox" id="lbl-'.$ld->id_jabatan.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_jabatan.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jabatan="'.$ld->id_jabatan.'" type="checkbox" id="lbl-'.$ld->id_jabatan.'" switch="none" >
                                            <label for="lbl-'.$ld->id_jabatan.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nm_jabatan;
            $row[] = $ld->level_jabatan;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button
							type="button" data-id="'.$ld->id_jabatan.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
					  		title="Ubah"> <i class="fa fa-pencil"></i>
					</button>';

            $data[] = $row;
        }

        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order),
	            "recordsTotal" => $this->M_admin->count_all($table),
	            "data" => $data,
            );
        echo json_encode($output);
	}

	public function dm_jabatan_action($action) {

		if ($action == "aktif") {
			$id_jabatan 	= $this->input->post('id_jabatan');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_jabatan';
			$condition[1] 	= $id_jabatan;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jabatan', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$nm_jabatan 	= $this->input->post('nm_jabatan');
			$level_jabatan  = $this->input->post('level_jabatan');
			$keterangan 	= $this->input->post('keterangan');

			$data 			= [
								'nm_jabatan' 	=> $nm_jabatan,
								'level_jabatan'=> $level_jabatan,
								'keterangan' 		=> $keterangan
							];

			$this->M_admin->insert_data('m_jabatan', $data);

			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_jabatan 	= $this->input->post('id_jabatan');
			$nm_jabatan 	= $this->input->post('nm_jabatan');
			$level_jabatan  = $this->input->post('level_jabatan');
			$keterangan 	= $this->input->post('keterangan');


			$data 			= [
								'nm_jabatan' 	=> $nm_jabatan,
								'level_jabatan'=> $level_jabatan,
								'keterangan' 		=> $keterangan
							];

			$condition 		= [];
			$condition[0] 	= 'id_jabatan';
			$condition[1] 	= $id_jabatan;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jabatan', $condition, $data);

			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_jabatan= $this->input->post('id_jabatan');

			$condition 		= [];
			$condition[] 	= ['id_jabatan', $id_jabatan, 'where'];

			$response 	= $this->M_admin->get_master_spec('m_jabatan', 'id_jabatan, nm_jabatan, level_jabatan, keterangan' , $condition)->row_array();
		}

		echo json_encode($response);
	}

	public function test_tree() {
		$data 	= 		'{"status":"OK","data":[
				            {"id":1,"name":"label 1","type":"folder","additionalParameters":
		                     	{"id":2,"children":false,"itemSelected":false}
		                  	},
				            {"id":2,"name":"label 2","type":"item","additionalParameters":
				                {"id":2,"children":false,"itemSelected":false}
				            },
				            {"id":3,"name":"label 3","type":"item","additionalParameters":
				                {"id":3,"children":false,"itemSelected":false}
				            }
				  		]}';

		// $data 				= [];
		// $data[]				=

		// $response 			= [];
		// $response['status'] = "OK";
		// $response['data'] 	= $data;

		// var_dump(json_decode($data));
		echo ($data);
	}

	function generate_form() {
			$start 	= 784;
			$c 		= 18;
			$form 	= 'SYA';

			for ($a=$start;$a<=$start+$c;$a++) {
				echo $form.$a.'<br>';
			}
	}


	function test_session() {
		var_dump($this->session->userdata('last_order_aw'));
	}

	function test_array() {
		$datas 	= json_decode('[
				  {
				    "id": "AW12041700091"
				  },
				  {
				    "id": "AW12041700093"
				  },
				  {
				    "id": "AW12041700092"
				  },
				  {
				    "id": "AW12041700094"
				  },
				  {
				    "id": "AW12041700095"
				  },
				  {
				    "id": "AW12041700096"
				  },
				  {
				    "id": "AW12041700097"
				  },
				  {
				    "id": "AW12041700098"
				  },
				  {
				    "id": "AW12041700099"
				  },
				  {
				    "id": "AW12041700100"
				  }
				]', true);

		// f
		$data = json_decode($this->input->get('data'), true);
		echo $data[2]['id'];
		// foreach ($data as $k => $v) {
		// 	echo $data[$k]['id'].'&nbsp;';
		// 	echo $k.'<br>';
		// }

		// echo($data[0]['id']);
	}


// 36
// 37
// 38
// 40
	function insert_syarat_izin() {
		// 41 baru
		// 42 perpanjang
		// 43 perubahan
		$id_jenis_izin 		= 47;

		// 46

		// 47
		// 49

		$syarat['tj'][] 	= 'Sipa Lama';
		$syarat['tj'][] 	= 'STNK';
		$syarat['tj'][] 	= 'KIR';
		$syarat['tj'][] 	= 'KTP';

		for($a=0;$a<count($syarat['tj']);$a++) {
			$data[] 	= [
				'id_syarat_izin_grup'	=> 25,
				'nama_syarat_izin'	 	=> hash('crc32', $syarat['tj'][$a].date('YmdHis')),
				'teks_judul'	 		=> $syarat['tj'][$a],
				'jenis_input'	 		=> 'file',
				'tipe_data'	 			=> 'string',
				'wajib_isi'	 			=> 1,
				'table_tujuan_s'	 	=> 't_syarat_izin_f',
				'pk_tujuan_s'	 		=> 'id_syarat_izin_f_t',
				'show_first'	 		=> 1,
				'keterangan'	 		=> NULL
			];
		}

		echo count($syarat['tj']).' '.count($syarat['tj']);

		$this->M_admin->insert_data_batch('m_syarat_izin_s', $data);
	}

	function insert_ak_workflow() {


	$baru 			= [1,4,5,6,7,8,9,15,17,18,19,20];
	// $daftar_ulang 	= [2,3,10,11,12,13,14,16];
	$daftar_ulang 	= [23, 24, 25];

	$ak_br 			= [4, 5, 11, 12, 13, 9, 7, 8, 10, 14];
	// $ak_dft	 		= [4, 5, 9, 7, 8, 10, 14];
	$ak_dft	 		= [4, 5, 9, 7, 8, 10, 14];

	$type 			= "dft";

	if ($type == "dft") {
		$wk 	= $daftar_ulang;
		$ak 	= $ak_dft;
		// $nm 	= $nm_dft;
	} elseif ($type == "br") {
		$wk 	= $baru;
		$ak 	= $ak_br;
		// $nm 	= $nm_br;
	}


	for($b=0;$b<count($wk);$b++) {
		if ($type == "dft") {
			$id_workflow 	= $daftar_ulang[$b];
		} elseif ($type == "br") {
			$id_workflow 	= $baru[$b];
		}

		$nm[] 	= 'Disposisi';
		$nm[] 	= 'Verifikasi';
		// $nm[] 	= 'Persetujuan SKPD Kabid';
		// $nm[] 	= 'Persetujuan SKPD Ka TU';
		// $nm[] 	= 'Persetujuan SKPD Kadis';
		$nm[] 	= 'Persetujuan Kabid Admin';
		$nm[] 	= 'Persetujuan Kabid Teknis';
		$nm[] 	= 'Persetujuan Ka TU';
		$nm[] 	= 'Persetujuan Kadis';
		$nm[] 	= 'Cetak';



		$data 	= [];
		for($a=0;$a<count($ak);$a++) {
			$data[] 	= [
				'nm_aktivitas_workflow' 	=> $nm[$a],
				'id_workflow' 				=> $id_workflow,
				'id_aktivitas' 				=> $ak[$a],
				'aktif' 					=> 1
			];
		}

		$this->M_admin->insert_data_batch('t_aktivitas_workflow', $data);
	}

	}

	function workflow_dict() {
		// dispisisi
		$datas[0]['id_aktivitas']  	= 4;
		$datas[0]['nm_aktivitas_workflow']  	= 'Disposisi';
		$datas[0]['id_user'][] 		= 10;
		$datas[0]['id_decision'][] 	= ['nm_workflow' => 'Delegasi', 'val' => 1, 'type' => 'int'];

		// verifikasi
		$datas[1]['id_aktivitas']  	= 5;
		$datas[1]['nm_aktivitas_workflow']  	= 'Verifikasi';
		$datas[1]['id_user'][]  	= 22;
		$datas[1]['id_decision'][]  = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[1]['id_decision'][]  = ['nm_workflow' => 'Pending', 'val' => 4, 'type' => 'int'];
		$datas[1]['id_decision'][] 	= ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Perbaikan User
		$datas[2]['id_aktivitas']  	= 20;
		$datas[2]['nm_aktivitas_workflow']  	= 'Perbaikan User';
		$datas[2]['id_user'][]  	= 22;
		$datas[2]['id_decision'][]  = ['nm_workflow' => 'Submit Perubahan', 'val' => 13, 'type' => 'ext'];
		$datas[2]['id_decision'][]  = ['nm_workflow' => 'Pending Label', 'val' => 13, 'type' => 'int'];


		// SKPD Kasi
		$datas[3]['id_aktivitas']  	= 36;
		$datas[3]['nm_aktivitas_workflow']  	= 'Delegasi SKPD';
		$datas[3]['id_user'][]  	= 29;
		$datas[3]['id_decision'][] 	= ['nm_workflow' => 'Delegasi', 'val' => 1, 'type' => 'int'];

		// SKPD Staf
		$datas[4]['id_aktivitas']  	= 37;
		$datas[4]['nm_aktivitas_workflow']  	= 'Verifikasi SKPD';
		$datas[4]['id_user'][]  	= 30;
		$datas[4]['id_decision'][]  = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[4]['id_decision'][]  = ['nm_workflow' => 'Pending', 'val' => 4, 'type' => 'int'];
		$datas[4]['id_decision'][] 	= ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// SKPD Kabid
		$datas[5]['id_aktivitas']  	= 11;
		$datas[5]['nm_aktivitas_workflow']  	= 'Persetujuan SKPD Kabid';
		$datas[5]['id_user'][]  	= 25;
		$datas[5]['id_decision'][]  = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[5]['id_decision'][]  = ['nm_workflow' => 'Reject', 'val' => 3, 'type' => 'int'];
		$datas[5]['id_decision'][] 	= ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];


		// PUPR Kasi
		$datas[6]['id_aktivitas']  	= 25;
		$datas[6]['nm_aktivitas_workflow']  	= 'Perhitungan SKRD';
		$datas[6]['id_user'][]  	= 23;
		$datas[6]['id_decision'][] 	= ['nm_workflow' => 'Delegasi', 'val' => 1, 'type' => 'int'];

		// PUPR Staf
		$datas[7]['id_aktivitas']  	= 27;
		$datas[7]['nm_aktivitas_workflow']  	= 'Perhitungan SKRD';
		$datas[7]['id_user'][]  	= 16;
		$datas[7]['id_decision'][]  = ['nm_workflow' => 'Submit Perhitungan', 'val' => 2, 'type' => 'int'];
		$datas[7]['id_decision'][] 	= ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// PUPR Kabid
		$datas[8]['id_aktivitas']  	= 28;
		$datas[8]['nm_aktivitas_workflow']  	= 'Perhitungan SKRD';
		$datas[8]['id_user'][]  	= 25;
		$datas[8]['id_decision'][]  = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[8]['id_decision'][] 	= ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Perkim Kasi
		$datas[9]['id_aktivitas']  	= 29;
		$datas[9]['nm_aktivitas_workflow']  	= 'Perhitungan SKRD';
		$datas[9]['id_user'][]  	= 24;
		$datas[9]['id_decision'][] 	= ['nm_workflow' => 'Delegasi', 'val' => 1, 'type' => 'int'];

		// Perkim Staf
		$datas[10]['id_aktivitas']  = 30;
		$datas[10]['nm_aktivitas_workflow']  = 'Perhitungan SKRD';
		$datas[10]['id_user'][]  	= 26;
		$datas[10]['id_decision'][] = ['nm_workflow' => 'Submit Perhitungan', 'val' => 2, 'type' => 'int'];
		$datas[10]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Perkim Kabid
		$datas[11]['id_aktivitas']  = 31;
		$datas[11]['nm_aktivitas_workflow']  = 'Perhitungan SKRD';
		$datas[11]['id_user'][]  	= 27;
		$datas[11]['id_decision'][] = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[11]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Bapenda Kasi
		$datas[12]['id_aktivitas']  = 32;
		$datas[12]['nm_aktivitas_workflow']  = 'Persetujuan SKRD';
		$datas[12]['id_user'][]  	= 17;
		$datas[12]['id_decision'][] = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[12]['id_decision'][] = ['nm_workflow' => 'Lihat Perhitungan', 'val' => 11, 'type' => 'int'];
		$datas[12]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Bapenda Kabid
		$datas[13]['id_aktivitas']  = 33;
		$datas[13]['nm_aktivitas_workflow']  = 'Persetujuan SKRD';
		$datas[13]['id_user'][]  	= 28;
		$datas[13]['id_decision'][] = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[13]['id_decision'][] = ['nm_workflow' => 'Lihat Perhitungan', 'val' => 11, 'type' => 'int'];
		$datas[13]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];


		// Kabid Admin
		$datas[14]['id_aktivitas']  = 9;
		$datas[14]['nm_aktivitas_workflow']  ='Persetujuan Kabid Admin';
		$datas[14]['id_user'][]  	= 2;
		$datas[14]['id_decision'][] = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[14]['id_decision'][] = ['nm_workflow' => 'Reject', 'val' => 3, 'type' => 'int'];
		$datas[14]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Kabid Teknis
		$datas[15]['id_aktivitas']  = 7;
		$datas[15]['nm_aktivitas_workflow']  ='Persetujuan Kabid Teknis';
		$datas[15]['id_user'][]  	= 3;
		$datas[15]['id_decision'][] = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[15]['id_decision'][] = ['nm_workflow' => 'Reject', 'val' => 3, 'type' => 'int'];
		$datas[15]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Ka TU
		$datas[16]['id_aktivitas']  = 8;
		$datas[16]['nm_aktivitas_workflow']  ='Persetujuan Ka TU';
		$datas[16]['id_user'][]  	= 4;
		$datas[16]['id_decision'][] = ['nm_workflow' => 'View', 'val' => 5, 'type' => 'int'];
		$datas[16]['id_decision'][] = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];

		// Pembayaran
		$datas[17]['id_aktivitas']  = 15;
		$datas[17]['nm_aktivitas_workflow']  = 'Pembayaran User';
		$datas[17]['id_user'][]  	= 15;
		$datas[17]['id_decision'][] = ['nm_workflow' => 'Membayar', 'val' => 14, 'type' => 'ext'];

		// Cek Pembayaran
		$datas[18]['id_aktivitas']  = 19;
		$datas[18]['nm_aktivitas_workflow']  = 'Cek Pembayaran';
		$datas[18]['id_user'][]  	= 15;
		$datas[18]['id_decision'][] = ['nm_workflow' => 'Cetak SKRD', 'val' => 12, 'type' => 'int'];

		// Kadis
		$datas[19]['id_aktivitas']  	= 10;
		$datas[19]['nm_aktivitas_workflow']  	= 'Persetujuan Kadis';
		$datas[19]['id_user'][]  	= 5;
		$datas[19]['id_decision'][]  = ['nm_workflow' => 'Approve', 'val' => 2, 'type' => 'int'];
		$datas[19]['id_decision'][]  = ['nm_workflow' => 'Reject', 'val' => 3, 'type' => 'int'];
		$datas[19]['id_decision'][]  = ['nm_workflow' => 'Detail', 'val' => 6, 'type' => 'int'];



		return $datas;
	}

	function insert_wk() {
		$id_workflow= 23;
		$urutan 	= [4, 5, 20, 7, 25, 27, 28, 32, 33, 15, 19, 8, 10, 9];

		$wk_dict 	= $this->workflow_dict();

		for ($a=0;$a<count($urutan);$a++) {
			foreach ($wk_dict as $wd) {
				if ($wd['id_aktivitas'] == $urutan[$a]) {
					$data 	= [];
					$data 	= [
								'id_workflow' 	=> $id_workflow,
								'id_aktivitas' 	=> $wd['id_aktivitas'],
								'nm_aktivitas_workflow' => $wd['nm_aktivitas_workflow'],
								'aktif' 		=> 1
							];

					$id_aktivitas_workflow 	= $this->M_admin->insert_data('t_aktivitas_workflow', $data);

					// Insert User
					for ($b=0;$b<count($wd['id_user']);$b++) {
						$data 	= [];
						$data 	= [
									'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
									'id_user' 					=> $wd['id_user'][$b],
									'aktif' 					=> 1
								];

						$this->M_admin->insert_data('t_user_workflow', $data);
					}

					// Insert Decision
					for ($b=0;$b<count($wd['id_decision']);$b++) {
						$data 	= [];
						$data 	= [
									'nm_workflow_decision' 		=> $wd['id_decision'][$b]['nm_workflow'],
									'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
									'id_decision' 				=> $wd['id_decision'][$b]['val'],
									'type' 						=> $wd['id_decision'][$b]['type'],
									'direct_id_aktivitas_workflow'	=> '',
									'aktif' 					=> 1
								];

						$this->M_admin->insert_data('t_workflow_decision', $data);
					}

					$permission 		= 1;

					if ($wd['id_aktivitas'] == 5) {
						$permission 	= 2;
					}

					$data 	= [];
					$data  	= [
								'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
								'permission' 				=> $permission,
								'aktif' 					=> 1
							];

					$this->M_admin->insert_data('m_syarat_izin_cfg', $data);
					$this->M_admin->insert_data('m_rekam_berkas_cfg', $data);
					$this->M_admin->insert_data('m_perusahaan_bio_cfg', $data);

				}
			}
		}

	}

	function create_trigger() {
		// inc_aktivitas_workflow
		// inc_no_permohonan
		// inc_syarat_izin
		// inc_workflow
		// inc_workflow_decision

		$nm_trigger 	= 'inc_workflow_decision';
		$nm_table 		= 't_workflow_decision';
		$col_table 		= 'kd_workflow_decision';
		$use_date 		= 1;


		if ($use_date == 1) {
			$date 		= "
				CONCAT_WS(
					'',
					LPAD(DAY(CURRENT_DATE()), 2, 0),
					LPAD(MONTH(CURRENT_DATE()), 2, 0),
					RIGHT(YEAR(CURRENT_DATE()), 2)
				)
			";
		} else {
			$date 		= "";
		}

		$query 			= "
			CREATE TRIGGER $nm_trigger BEFORE INSERT ON $nm_table FOR EACH ROW SET
			NEW.$col_table = CONCAT_WS('',
								(select nm_prefix from s_prefix
								where kd_prefix='$col_table'),
								$date,
								LPAD(
									ifnull((SELECT max(num) FROM $nm_table)*1, 0)+1,
									(select zero_length from s_prefix
									where kd_prefix='$col_table'),
									'0'
								)
						),
			NEW.num = ifnull((SELECT max(num) FROM $nm_table)*1, 0)+1";
		// echo $query;
		$this->db->query($query);
		}

		function md5_test() {

			echo md5($this->input->get('key'));
			echo '<br>';
			echo '38e2f3cdfbbcf3b373f27e1bfbcac820';
		}






	// 'Delegasi ke Evaluator'
	// 'Verifikasi - Approve', 'Verifikasi - Pending', 'Verifikasi - Detail'
	// 'Persetujuan SKPD Kabid - Approve', 'Persetujuan SKPD Kabid - Reject', 'Persetujuan SKPD Kabid - Detail'
	// 'Persetujuan SKPD Ka TU - Approve', 'Persetujuan SKPD Ka TU - Reject', 'Persetujuan SKPD Ka TU - Detail'
	// 'Persetujuan SKPD Kadis - Approve', 'Persetujuan SKPD Kadis - Reject', 'Persetujuan SKPD Kadis - Detail'
	// 'Persetujuan Kabid Admin - Approve', 'Persetujuan Kabid Admin - Pending', 'Persetujuan Kabid Admin - Detail'
	// 'Persetujuan Kabid Teknis - Approve', 'Persetujuan Kabid Teknis - Reject', 'Persetujuan Kabid Teknis - Detail'
	// 'Persetujuan Ka TU - View', 'Persetujuan Ka TU - Detail'
	// 'Persetujuan Kadis - Approve', 'Persetujuan Kadis - Reject', 'Persetujuan Kadis - Detail'

	function copy_workflow() {
		$workflow_s 		= 39;
		$workflow_t 		= 41;

// 36
// 37
// 38

// 39
// 40
// 41

// 		28
// 31
// 29
// 32

// 		33
// 30



		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_workflow', $workflow_s, 'where'];
		$condition[] 	= ['kd_aktivitas_workflow', 'asc', 'order_by'];
		$list_workflow 	= $this->M_admin->get_master_spec('t_aktivitas_workflow', '*', $condition)->result_array();

		$this->db->trans_start();
		foreach ($list_workflow as $lw) {
			$data 	= [];
			$data	= [
							'id_workflow' 	=> $workflow_t,
							'nm_aktivitas_workflow' 	=> $lw['nm_aktivitas_workflow'],
							'id_aktivitas' 	=> $lw['id_aktivitas'],
							'aktif' 	=>1
						];

			$id_aktivitas_workflow 	= $this->M_admin->insert_data('t_aktivitas_workflow', $data);

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];
			$condition[] 	= ['id_aktivitas_workflow', $lw['id_aktivitas_workflow'], 'where'];
			$list_user 		= $this->M_admin->get_master_spec('t_user_workflow', '*', $condition)->result_array();

			foreach ($list_user as $lu) {
				$datau 	= [];
				$datau 	= [
								'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
								'id_user'					=> $lu['id_user'],
								'aktif' 					=> 1
							];
				$this->M_admin->insert_data('t_user_workflow', $datau);
			}


			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];
			$condition[] 	= ['id_aktivitas_workflow', $lw['id_aktivitas_workflow'], 'where'];
			$list_decision	= $this->M_admin->get_master_spec('t_workflow_decision', '*', $condition)->result_array();

			foreach ($list_decision as $ld) {
				$datad 	= [
								'nm_workflow_decision'		=> $ld['nm_workflow_decision'],
								'id_aktivitas_workflow'		=> $id_aktivitas_workflow,
								'id_decision'		 		=> $ld['id_decision'],
								'type' 						=> $ld['type'],
								'direct_id_aktivitas_workflow' => '',
								'aktif' 					=> 1
							];
				$id_decision  	= $this->M_admin->insert_data('t_workflow_decision', $datad);

				$condition 		= [];
				$condition[] 	= ['aktif', 1, 'where'];
				$condition[] 	= ['id_workflow_decision', $ld['id_workflow_decision'], 'where'];
				$list_action	= $this->M_admin->get_master_spec('t_action_decision', '*', $condition)->result_array();

				foreach ($list_action as $la) {
						$data 	= [
								'id_action' 	=> $la['id_action'],
								'id_workflow_decision' 	=> $la['id_workflow_decision'],
								'retribusi' 	=> $la['retribusi'],
								'nama_action' 	=> $la['nama_action'],
								'id_message' 	=> $la['id_message'],
								'aktif' 		=> 1,
							];
					$this->M_admin->insert_data('t_action_decision', $data);
				}
			}

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];
			$condition[] 	= ['id_aktivitas_workflow', $lw['id_aktivitas_workflow'], 'where'];
			$list_perusahaan= $this->M_admin->get_master_spec('m_perusahaan_bio_cfg', '*', $condition)->result_array();
			foreach ($list_perusahaan as $lp) {
				$data 	= [
								'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
								'permission' 				=> $lp['permission'],
								'aktif' 					=> 1
							];

				$this->M_admin->insert_data('m_perusahaan_bio_cfg', $data);
			}

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];
			$condition[] 	= ['id_aktivitas_workflow', $lw['id_aktivitas_workflow'], 'where'];
			$list_rekam		= $this->M_admin->get_master_spec('m_rekam_berkas_cfg', '*', $condition)->result_array();
			foreach ($list_rekam as $lp) {
				$data 	= [
								'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
								'permission' 				=> $lp['permission'],
								'aktif' 					=> 1
							];

				$this->M_admin->insert_data('m_rekam_berkas_cfg', $data);
			}

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];
			$condition[] 	= ['id_aktivitas_workflow', $lw['id_aktivitas_workflow'], 'where'];
			$list_syarat	= $this->M_admin->get_master_spec('m_syarat_izin_cfg', '*', $condition)->result_array();
			foreach ($list_syarat as $lp) {
				$data 	= [
								'id_aktivitas_workflow' 	=> $id_aktivitas_workflow,
								'permission' 				=> $lp['permission'],
								'aktif' 					=> 1
							];

				$this->M_admin->insert_data('m_syarat_izin_cfg', $data);
			}

		}
		$this->db->trans_complete();

		echo $workflow_s.' to '.$workflow_t;



	}

	function insert_user_izin() {
		$data 	= $this->db->query('SELECT
			id_aktivitas_workflow
		FROM
			t_aktivitas_workflow taw
			JOIN t_workflow two
				ON taw.id_workflow=two.id_workflow
			JOIN m_jenis_izin mji
				ON two.id_jenis_izin=mji.id_jenis_izin

		WHERE
		 	mji.id_nama_izin= 3
			AND taw.id_aktivitas=5')->result_array();

		$datau 		= [];
		foreach ($data as $d) {
			$datau[] 	= [
							'id_aktivitas_workflow' 	=> $d['id_aktivitas_workflow'],
							'id_user'					=> 22,
							'aktif' 					=> 2204
						];
		}
		$this->M_admin->insert_data_batch('t_user_workflow', $datau);
	}

	function test_in_array() {
		$left 	= [1,2,7];
		$right 	= [1,2,4,5];


		for ($a=0;$a<count($left);$a++) {
			if (in_array($left[$a], $right)) {
			echo $left[$a].' ';
			}
		}
	}

	function get_wk_2() {
		$kd_aktivitas 	= 20;
		var_dump ($this->M_permohonan_izin->get_decision($id_user, $id_aktivitas_workflow)->result_array());

	}

	function insert_workflow() {
		$id_workflow 	= [];
		$nm_workflow 	= 'Mode 1';

		$id_jenis_izin 	= [
							7,
							8,
							11,
							12,

							9,
							10,
							13,
							14,

							19,
							20,
							21,

							25,
							26,
							27,
							28,

							15,
							16,
							17,
							18,

							29,
							30,
							31,
							32
						];

		for ($a=0;$a<count($id_jenis_izin);$a++) {
			$data 	= [];
			$data 	= [
						'nm_workflow' 	=> $nm_workflow,
						'id_jenis_izin' => $id_jenis_izin[$a],
						'aktif' 		=> 1
					];
			$id_workflow[$a]['id_jenis_izin'] 	= $id_jenis_izin[$a];
			$id_workflow[$a]['id_workflow'] 	= $this->M_admin->insert_data('t_workflow', $data);
		}

		var_dump($id_workflow);
	}

	// function jj() {
	// 	// perorangan
	// 	INSERT INTO `m_syarat_izin_s` (`id_syarat_izin_grup`, `nama_syarat_izin`, `kode_formula`, `teks_judul`, `sub_teks_judul`, `jenis_input`, `special`, `tipe_data`, `wajib_isi`, `multivalue`, `table_tujuan_s`, `pk_tujuan_s`, `table_tujuan_p`, `pk_tujuan_p`, `class`, `maxlength`, `attribute`, `table_refrensi`, `pk_refrensi`, `nm_refrensi`, `show_first`, `show_select`, `show_tbl_be`, `show_tbl_fe`, `show_pg_be`, `show_pg_fe`, `keterangan`, `aktif`) VALUES
	// 	(36, 'frm_permohonan', NULL, '', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(36, 'ftcp_ktp', NULL, '', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(36, 'ftcp_npwp', NULL, '', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(36, 'ftcp_domisili', NULL, '', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(36, 'srt_kuasa_pengurus', NULL, '', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(36, 'pas_foto', NULL, '', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1);

	// 	// berbadan hukum
	// 	INSERT INTO `m_syarat_izin_s` (`id_syarat_izin_grup`, `nama_syarat_izin`, `kode_formula`, `teks_judul`, `sub_teks_judul`, `jenis_input`, `special`, `tipe_data`, `wajib_isi`, `multivalue`, `table_tujuan_s`, `pk_tujuan_s`, `table_tujuan_p`, `pk_tujuan_p`, `class`, `maxlength`, `attribute`, `table_refrensi`, `pk_refrensi`, `nm_refrensi`, `show_first`, `show_select`, `show_tbl_be`, `show_tbl_fe`, `show_pg_be`, `show_pg_fe`, `keterangan`, `aktif`) VALUES
	// 	(38, 'frm_permohonan', NULL, 'Formulir Permohonan stempel Perusahaaan', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(38, 'ftcp_ktp', NULL, 'Foto Copy KTP Direktur', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(38, 'ftcp_npwp', NULL, 'Foto Copy Akta Pendirian dan/atau Akte Perubahan (untuk PT melampirkan SK pengesahan dari Kementerian Hukumdan HAM ,untuk CV sudah terdaftar di Pengadilan Negeri Kota Bekasi dengan SK pengesahan), Foto Copy akte perubahan / penyesuaian Undang – undang nomor 40 tahun 2007 tentang Perseroan Terbatas (PT) (Bila belum menyesuaikan perubahan)', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(38, 'ftcp_domisili', NULL, 'Foto Copy NPWP perusahaan', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(38, 'srt_kuasa_pengurus', NULL, 'Foto Copy Surat Keterangan Domisili Usaha yang masih berlaku yang di tandatangani oleh lurah/sekel', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(38, 'pas_foto', NULL, 'Surat Kuasa apabila dikuasakan pengurusannya (Materai 6000)', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(38, 'pas_foto', NULL, 'Foto Direktur ukuran 3 X 4 berwarna (2Lembar)', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1);

	// 	// daftar ulang
	// 	INSERT INTO `m_syarat_izin_s` (`id_syarat_izin_grup`, `nama_syarat_izin`, `kode_formula`, `teks_judul`, `sub_teks_judul`, `jenis_input`, `special`, `tipe_data`, `wajib_isi`, `multivalue`, `table_tujuan_s`, `pk_tujuan_s`, `table_tujuan_p`, `pk_tujuan_p`, `class`, `maxlength`, `attribute`, `table_refrensi`, `pk_refrensi`, `nm_refrensi`, `show_first`, `show_select`, `show_tbl_be`, `show_tbl_fe`, `show_pg_be`, `show_pg_fe`, `keterangan`, `aktif`) VALUES
	// 	(31, 'frm_permohonan', NULL, 'Surat Permohonan', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'ftcp_ktp', NULL, 'Foto copy Surat Tanah', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'ftcp_npwp', NULL, 'Foto copy Kartu Tanda Penduduk (KTP) atau identitas diri', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'ftcp_domisili', NULL, 'Foto copy Bukti Lunas PBB', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'srt_kuasa_pengurus', NULL, 'Foto copy Izin Peruntukan Penggunaan Tanah (untuk yang di luar perumahan)', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'srt_kuasa_pengurus', NULL, 'Gambar Rencana Bangunan', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'srt_kuasa_pengurus', NULL, 'Perhitungan Konstruksi (untuk bangunan lebih dari dua lantai)', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'srt_kuasa_pengurus', NULL, 'Persetujuan Tetangga, diketahui Kelurahan dan Kecamatan (untuk yang di luar perumahan)', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'srt_kuasa_pengurus', NULL, 'Rekomendasi Rencana Teknis Bangunan Gedung', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1),
	// 	(31, 'srt_kuasa_pengurus', NULL, 'Foto copy IMB yang lama', NULL, 'file', NULL, 'string', 1, 0, 't_syarat_izin_f', 'id_syarat_izin_f_t', NULL, NULL, NULL, '50', '0', NULL, NULL, NULL, 1, 0, 0, 0, 0, 0, NULL, 1);
	// }

	function kandaria() {
		// $need_update	= [];
		// // $need_update_ds	= [];
		// // $need_update_wk	= [];
		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_decision', 4, 'where'];
		$list_decision	= $this->M_admin->get_master_spec('t_workflow_decision', '*', $condition)->result_array();

		// echo '<pre>';
		// var_dump($list_workflow);

		foreach ($list_decision as $ld) {
			// $condition 		= [];
			// $condition[] 	= ['aktif', 1, 'where'];
			// // $condition[] 	= ['id_aktivitas_workflow', $lw['id_aktivitas_workflow'], 'where'];
			// $condition[] 	= ['id_decision', 2, 'where'];
			// $ld				= $this->M_admin->get_master_spec('t_workflow_decision', '*', $condition)->row_array();

			// $need_update_wk[] 	= $lw['id_aktivitas_workflow'];
			// $need_update_ds[] 	= $ld['id_workflow_decision'];
			$data  			= [
								'id_action' 				=> 1,
								'id_workflow_decision' 		=> $ld['id_workflow_decision'],
								'nama_action' 				=> 'Permohonan Dipending',
								'id_message' 				=> 6,
								'aktif' 					=> 1
							];
			// var_dump($data);
			// echo count($data);
			$this->M_admin->insert_data('t_action_decision', $data);
			// echo $lw['id_aktivitas_workflow'].'<br>';
			// }
		}

		// foreach ($need_update as $nu) {
		// 	$data 	= [];
		// 	$data 			= [
		// 						'direct_id_aktivitas_workflow' 	=> 'd'
		// 					];

		// 	$condition 		= [];
		// 	$condition[0] 	= 'id_workflow_decision';
		// 	$condition[1] 	= $nu;
		// 	$condition[2] 	= 'where';
		// 	// $this->M_admin->update_data('t_workflow_decision', $condition, $data);
		// }

		// foreach ($need_update_wk as $nu) {
		// 	$data 	= [];
		// 	$data 			= [
		// 						'nm_workflow_decision' 	=> "Pending Verifikasi",
		// 						'id_decision' 	=> 8,
		// 						'id_aktivitas_workflow' 	=> $nu,
		// 						'direct_id_aktivitas_workflow' 	=> 0,
		// 						'aktif' 	=> 1
		// 					];

		// 	// $condition 		= [];
		// 	// $condition[0] 	= 'id_workflow_decision';
		// 	// $condition[1] 	= $nu;
		// 	// $condition[2] 	= 'where';
		// 	// $this->M_admin->update_data('t_workflow_decision', $condition, $data);
		// 	// $this->M_admin->insert_data('t_workflow_decision', $data);
		// 					// echo $nu.'<br>';
		// }
		// var_dump($need_update);
	}

	function normai() {
		$condition 		= [];
		$condition[] 	= ['aktif', 5, 'where'];
		// $condition[] 	= ['id_perusahaan_bio_s', 10, 'where'];
		$condition[] 	= ['id_rekam_berkas_grup', 11, 'where'];
		$list_source  	= $this->M_admin->get_master_spec('m_rekam_berkas_s', '*', $condition)->result_array();


		$list_id_grup 	= [8, 9, 10];

		// var_dump($list_source);

		foreach ($list_id_grup as $li) {
			foreach ($list_source as $ls) {
				$data 	= [
							'id_rekam_berkas_grup' => $li,
      'nama_rekam_berkas' => $ls['nama_rekam_berkas'],
      'kode_formula' => $ls['kode_formula'],
      'teks_judul' => $ls['teks_judul'],
      'sub_teks_judul' => $ls['sub_teks_judul'],
      'jenis_input' => $ls['jenis_input'],
      'special' => $ls['special'],
      'tipe_data' => $ls['tipe_data'],
      'wajib_isi' => $ls['wajib_isi'],
      'multivalue' => $ls['multivalue'],
      'table_tujuan_s' => $ls['table_tujuan_s'],
      'pk_tujuan_s' => $ls['pk_tujuan_s'],
      'table_tujuan_p' => $ls['table_tujuan_p'],
      'pk_tujuan_p' => $ls['pk_tujuan_p'],
      'class' => $ls['class'],
      'maxlength' => $ls['maxlength'],
      'attribute' => $ls['attribute'],
      'table_refrensi' => $ls['table_refrensi'],
      'pk_refrensi' => $ls['pk_refrensi'],
      'nm_refrensi' => $ls['nm_refrensi'],
      'show_first' => $ls['show_first'],
      'show_select' => $ls['show_select'],
      'show_tbl_be' => $ls['show_tbl_be'],
      'show_tbl_fe' => $ls['show_tbl_fe'],
      'show_pg_be' => $ls['show_pg_be'],
      'show_pg_fe' => $ls['show_pg_fe'],
      'keterangan' => $ls['keterangan'],
      'aktif' => 1
					];
		// // 		// var_dump($data);

				$this->M_admin->insert_data('m_rekam_berkas_s', $data);
			}
		}

	}


	function akt_action($action) {
		$id_permohonan 		= $this->input->get('permohonan');
		$id_aktivitas_workflow 	= $this->input->get('aktivitas');
		$id_workflow_decision 	= $this->input->get('decision');
		$catatan 			= $this->input->get('catatan');
		$page 				= $this->input->get('page');

		$id_user 			= $this->session->userdata('id_user');

		$condition 			= array();
		$condition[] 		= array('id_permohonan', $id_permohonan, 'where');
		$id_jenis_izin 		= $this->M_permohonan_izin->get_master_spec('t_permohonan', 'id_jenis_izin', $condition)->row_array()['id_jenis_izin'];

		unset($condition);
		$condition 			= array();
		$condition[] 		= array('id_permohonan', $id_permohonan, 'where');
		$v_permohonan_izin 	= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'no_permohonan, id_pemohon', $condition)->row_array();
		$no_permohonan   	= $v_permohonan_izin['no_permohonan'];
		$id_pemohon			= $v_permohonan_izin['id_pemohon'];

		$data['id_pemohon'] 			= $id_pemohon;
		$data['id_permohonan'] 			= $id_permohonan;
		$data['id_aktivitas_workflow'] 	= $id_aktivitas_workflow;
		$data['id_workflow_decision'] 	= $id_workflow_decision;
		$data['id_jenis_izin'] 			= $id_jenis_izin;
		// $this->cek_config_terbit($data);
		$this->send_response($data);

	}

	function cek_config_terbit($data) {
		$condition 			 = [];
		$condition[] 		 = ['aktif', 1, 'where'];
		$condition[] 		 = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
		$condition[] 		 = ['id_aktivitas_workflow', $data['id_aktivitas_workflow'], 'where'];
		$condition[] 		 = ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$check_cfg 			= $this->M_permohonan_izin->get_master_spec('m_izin_terbit_cfg', 'id_izin_terbit_cfg', $condition)->row_array();
		if ($check_cfg) {
			$this->terbit_noizin($data['id_permohonan']);
		} else {
			exit();
		}

	}

	function terbit_noizins($id_permohonan) {
		$id_sdp 	= 1;
		$id_tdp 	= 2;

		$condition 	= [];
		$condition[] 	= ['id_permohonan', $id_permohonan, 'where'];
		$dPer 			= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();

		$condition 	= [];
		$condition[] 	= ['id_nama_izin', $dPer['id_nama_izin'], 'where'];

		$dJiz 			= $this->M_permohonan_izin->get_master_spec('t_data_no_izin', 'id_data_no_izin, jml_izin_terbit', $condition)->row_array();
		$jml_izin		= $dJiz['jml_izin_terbit'];
		$id_data_no_izin= $dJiz['id_data_no_izin'];
		if ($dJiz) {
			$jml_izin 	= intval($jml_izin)+1;
			$data 	= [
						'jml_izin_terbit' 	=> $jml_izin
					];

			$condition 		= [];
			$condition[0] 	= 'id_data_no_izin';
			$condition[1] 	= $id_data_no_izin;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_data_no_izin', $condition, $data);
		} else {
			$jml_izin 	= 1;
			$data 	= [
						'id_nama_izin' 	=> $dPer['id_nama_izin'],
						'jml_izin_terbit' 	=> $jml_izin
					];
			$this->M_admin->insert_data('t_data_no_izin', $data);
		}


		$no_izin 	= $jml_izin;
		if($dPer['id_nama_izin'] == $id_sdp) {
			$jml_izin_tdp 	= '';

			$condition 	= [];
			$condition[] 	= ['id_nama_izin', $id_tdp, 'where'];
			$dJiz 			= $this->M_permohonan_izin->get_master_spec('t_data_no_izin', 'id_data_no_izin, jml_izin_terbit', $condition)->row_array();
			$jml_izin_tdp	= $dJiz['jml_izin_terbit'];
			$id_data_no_izin= $dJiz['id_data_no_izin'];
			if ($dJiz) {
				$jml_izin_tdp 	= intval($jml_izin_tdp);
			} else {
				$jml_izin_tdp 	= 1;
			}

			$no_izin 	.= ', '.strval(($jml_izin-1)+($jml_izin_tdp));
		} elseif ($dPer['id_nama_izin'] == $id_tdp) {
			$condition 	= [];
			$condition[] 	= ['id_nama_izin', $id_sdp, 'where'];
			$dJiz 			= $this->M_permohonan_izin->get_master_spec('t_data_no_izin', 'id_data_no_izin, jml_izin_terbit', $condition)->row_array();
			$jml_izin_sdp	= $dJiz['jml_izin_terbit'];

			$no_izin 	= $no_izin+intval($jml_izin_sdp);
		}

		$data 	= [
					'id_permohonan' 	=> $id_permohonan,
					'no_izin' 			=> $no_izin,
					'jml_tercetak'		=> 0
				];

		$this->M_admin->insert_data('t_izin_terbit', $data);

	}

	function send_response($data) {
		$condition 	= [];
		$condition[] 	= ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$data_action	= $this->M_permohonan_izin->get_master_spec('v_action_decision', 'method, subject, message, formula, query', $condition)->result_array();

		foreach ($data_action as $dac) {
			$data_mg 	= [];
			if ($dac['method'] == 'send_email') {
				// reciever
				$condition 		= [];
				$condition[] 	= ['id_pemohon', $data['id_pemohon'], 'where'];
				$email_user 	= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'email_user', $condition)->row_array()['email_user'];

				// subject
				$subject 		= $dac['subject'];

				// message
				$query 			= $dac['query'];
				$query 			= preg_replace('/#id_workflow_decision#/', $data['id_workflow_decision'], $query); //id_workflow_decision

				$message 		= $dac['message'];
				$formula 		= explode(", ", $dac['formula']);
				$data_source 	= $this->M_admin->query($query)->result_array();
				foreach ($data_source as $ds) {
					foreach ($formula as $fr) {
						$message 	= preg_replace('/#'.$fr.'#/', $ds[$fr], $message);
					}
				}

				$data_mg['rcv'] = $email_user;
				$data_mg['msg'] = $message;
				$data_mg['sj'] 	= $subject;
			} elseif ($dac['method'] == 'send_sms') {
				// reciever
				$condition 		= [];
				$condition[] 	= ['id_pemohon', $data['id_pemohon'], 'where'];
				$email_user 	= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'email_user', $condition)->row_array()['email_user'];

				// subject
				$subject 		= $dac['subject'];

				// message
				$query 			= $dac['query'];
				$query 			= preg_replace('/#id_workflow_decision#/', $data['id_workflow_decision'], $query); //id_workflow_decision

				$message 		= $dac['message'];
				$formula 		= explode(", ", $dac['formula']);
				$data_source 	= $this->M_admin->query($query)->result_array();
				foreach ($data_source as $ds) {
					foreach ($formula as $fr) {
						$message 	= preg_replace('/#'.$fr.'#/', $ds[$fr], $message);
					}
				}

				$data_mg['rcv'] = $email_user;
				$data_mg['msg'] = $message;
				$data_mg['sj'] 	= $subject;
			}

			$this->$dac['method']($data_mg);
		}
	}

	function send_email($data=null) {
		// $data['rcv'] 	= 'rian6517@gmail.com';
		// $data['sj'] 	= 'test';
		// $data['msg'] 	= 'boom';

		$url = "http://182.253.11.251/production/epermit_api/api/send_email";
		
		$post_data = [
		    // "rcv"   => $data['rcv'],
		    // "sj"    => $data['sj'],
		    // "msg"   => $data['msg'],

		    "rcv"   => 'ghozi.alwan@gmail.com',
		    "sj"    => 'test',
		    "msg"   => 'boom',

		    "token" => '59079ec0d587c937c6e2d31e5dd2eb4e'
		];

		$output = $this->curl->simple_post($url, $post_data);
	}

	function test_sms() {
		$data_mg['rcv'] = '08999503824';
		$data_mg['msg'] = 'test sms';
		$this->send_sms($data_mg);
	}

	function send_sms($data) {
		$config = [
			'username' 	=> 'bekasi.sms2016',
			'password' 	=> 'jbiuDn',
			'apikey' 	=> 'd58f6032a6bed03d7fd48aef450053b7',
			'url' 		=> 'http://162.211.84.203'
		];

		$curlHandle = curl_init();
		$url 	= $config['url']."/sms/smsmasking.php?";
		$url 	.= "username=".urlencode($config['username']);
		$url 	.= "&password=".urlencode($config['password']);
		$url 	.= "&key=".urlencode($config['apikey']);
		$url 	.= "&number=".urlencode($data['rcv']);
		$url 	.= "&message=".urlencode($data['msg']);

		curl_setopt($curlHandle, CURLOPT_URL,$url);
		curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,120);
		$hasil 	= curl_exec($curlHandle);
		curl_close($curlHandle);
	}

	function select() {
		$condition 	= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$data_action	= $this->M_admin->get_master_spec('t_action_decision', '*', $condition)->result_array();
		foreach ($data_action as $da) {
			$data 	= [
						'id_action' 	=> 2,
						'id_workflow_decision'=> $da['id_workflow_decision'],
						'nama_action'	=> $da['nama_action'],
						'id_message' 	=> $da['id_message'],
						'aktif' 		=> 1
					];
			// var_dump($data);
			$this->M_admin->insert_data('t_action_decision', $data);
		}
	}

	function get_jenis_izins($kd_jenis_izin) {
		$data_jenis	= array();

		$data		= $this->M_permohonan_izin->get_parent_izin($kd_jenis_izin)->row_array();
		while ($data) {
			$parent_kd 	= substr($data['kd_jenis_izin'], 0, -2);
			$data_jenis[] = $data['jenis_izin'];
			$data		= $this->M_permohonan_izin->get_parent_izin($parent_kd)->row_array();
		}
		$data_jenis 	= array_reverse($data_jenis);

		$response 		= '';
		foreach ($data_jenis as $dj) {
			$response	.= $dj." ";
		}
		echo $response;
	}

	function kode_formula() {
		$condition 	= [];
		// $condition[] 	= ['aktif', 1, 'where'];
		$data		= $this->M_admin->get_master_spec('m_perusahaan_bio_s', '*', $condition)->result_array();
		$prefix 	= 'PRH';

		$kd_fr 		= 1;
		foreach ($data as $da) {
			$data 	= [
						'kode_formula' 	=> $prefix.$kd_fr
			 		];

			$condition 		= [];
			$condition[0] 	= 'id_perusahaan_bio_s';
			$condition[1] 	= $da['id_perusahaan_bio_s'];
			$condition[2] 	= 'where';

			// $this->M_admin->update_data('m_perusahaan_bio_s', $condition, $data);
			$kd_fr++;
			// var_dump($data);

		}
	}

	function pdf_generate($id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$dPer		= $this->M_admin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();

		$id_permohonan	= $id_permohonan;
		$id_jenis_izin	= $dPer['id_jenis_izin'];

		$condition 	= [];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$draft_izin	= $this->M_admin->get_master_spec('v_draft_izin', '*', $condition)->result_array();

		$pdf = new TCPDF('P', 'cm', 'A4', 'true');
		$page= 1;
		foreach ($draft_izin as $diz) {
			$kode_formula 	= [];
			$kode_formula 	= explode(", ", $diz['list_content']);

			$data_source = [];
			$data_source = $this->data_source_draft($id_permohonan, $kode_formula);

			$data_pdf 	 = [];
			$data_pdf['id_permohonan'] 	= $id_permohonan;

			$c_draft 	 = $this->load->view('sk_izin/'.$diz['template'], $data_pdf, TRUE);
			$index 		 = 1;
			foreach ($kode_formula as $kfr) {
				if ($kfr == 'DRD8' && count(explode(", ", $data_source['DRD8'])) > 1) {
					$c_draft = preg_replace('/#idx'.$index.'#/', explode(", ", $data_source['DRD8'])[$page-1], $c_draft);
				} else {
					$c_draft = preg_replace('/#idx'.$index.'#/', $data_source[$kfr], $c_draft);
				}
				$index++;
			}

			$pdf->setPrintHeader(false);
	        $pdf->setPrintFooter(false);
	        $pdf->SetHeaderMargin(false);
	        $pdf->SetFooterMargin(false);
	        $pdf->setMargins(1, 0.8, 1);
	        $pdf->SetFont('times', 'B', '12');
	        $pdf->Ln();
	        $pdf->AddPage($diz['position'], $diz['size']);
	        $pdf->SetFont('times', '', '11');
			$pdf->writeHTML($c_draft, true, false, true, false, '');
			$page++;

			// echo '<pre>';
			// var_dump($data_source);

		}

		$d_page 	= $this->session->userdata('dpage');
		if ($d_page == 'arsip') {
			$this->tandaTangan($id_permohonan, $pdf);
		}




	    $pdf->Output("Draft Izin", 'I');
	}

	private function data_source_draft($id_permohonan, $kode_formula) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$dPer		= $this->M_admin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();
		$id_jenis_izin 	= $dPer['id_jenis_izin'];

		// pemohon
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$data_raw	= $this->M_admin->get_master_spec('v_draft_data', '*', $condition)->row_array();

		$data_draft = [];
		$num 	= 1;
		foreach ($data_raw as $dr) {
			$value 	= $dr;
			if (DateTime::createFromFormat('Y-m-d', $value) !== FALSE) {
			    $value 	= $this->indonesian_date($value);
			}

			$data_draft['DRD'.$num] = $value;
			$num++;
		}
		// $data_draft['DRD'.'8'] 	= explode(', ', $dr);


		// syarat_izin
		$condition 	= [];
		$condition[]= ['kode_formula', $kode_formula, 'where_in'];
		$data_raw	= $this->M_admin->get_master_spec('m_syarat_izin_s', '*', $condition)->result_array();

		foreach ($data_raw as $dr) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];
			$condition[]= ['id_permohonan', $id_permohonan, 'where'];
			$condition[]= ['id_syarat_izin_s', $dr['id_syarat_izin_s'], 'where'];
			$dt			= $this->M_admin->get_master_spec($dr['table_tujuan_s'], 'nilai_string, nilai_num', $condition)->row_array();


			if ($dr['jenis_input'] == 'date') {
			    $value 	= $this->indonesian_date($dt['nilai_'.$dr['tipe_data']]);
			} elseif ($dr['jenis_input'] == 'currency') {
			    $value 	= number_format($dt['nilai_'.$dr['tipe_data']]);
			} elseif ($dr['jenis_input'] == 'select' && $dr['special'] == 0) {
				$id 		= $this->M_admin->get_master_spec($dr['table_tujuan_p'], 'id_syarat_izin_p', $condition)->row_array()['id_syarat_izin_p'];
				$condition 	= [];
				$condition[]	= ['id_syarat_izin_p', $id, 'where'];
				$value 	= $this->M_admin->get_master_spec('m_syarat_izin_p', 'teks_judul', $condition)->row_array()['teks_judul'];
			} elseif ($dr['jenis_input'] == 'select' && $dr['special'] == 1) {
				$dt		= $this->M_admin->get_master_spec($dr['table_tujuan_p'], 'nilai_string, nilai_num', $condition)->row_array();
				$value 	= $dt['nilai_string'];
			} elseif ($dr['jenis_input'] == 'tbl') {
				$value 	= $this->table_data($id_jenis_izin, $id_permohonan, 'syarat_izin');
			} else {
				$value 	= $dt['nilai_'.$dr['tipe_data']];
			}

			$data_draft[$dr['kode_formula']] = $value;
		}


		// rekam_berkas
		$condition 	= [];
		$condition[]= ['kode_formula', $kode_formula, 'where_in'];
		$data_raw	= $this->M_admin->get_master_spec('m_rekam_berkas_s', '*', $condition)->result_array();

		foreach ($data_raw as $dr) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];
			$condition[]= ['id_permohonan', $id_permohonan, 'where'];
			$condition[]= ['id_rekam_berkas_s', $dr['id_rekam_berkas_s'], 'where'];
			$dt			= $this->M_admin->get_master_spec($dr['table_tujuan_s'], 'nilai_string, nilai_num', $condition)->row_array();

			if ($dr['jenis_input'] == 'date') {
			    $value 	= $this->indonesian_date($dt['nilai_'.$dr['tipe_data']]);
			} elseif ($dr['jenis_input'] == 'currency') {
			    $value 	= number_format($dt['nilai_'.$dr['tipe_data']]);
			} elseif ($dr['jenis_input'] == 'select' && $dr['special'] == 0) {
				$id 		= $this->M_admin->get_master_spec($dr['table_tujuan_p'], 'id_rekam_berkas_p', $condition)->row_array()['id_rekam_berkas_p'];
				$condition 	= [];
				$condition[]	= ['id_rekam_berkas_p', $id, 'where'];
				$value 	= $this->M_admin->get_master_spec('m_rekam_berkas_p', 'teks_judul', $condition)->row_array()['teks_judul'];
			} elseif ($dr['jenis_input'] == 'select' && $dr['special'] == 1) {
				$dt		= $this->M_admin->get_master_spec($dr['table_tujuan_p'], 'nilai_string, nilai_num', $condition)->row_array();
				$value 	= $dt['nilai_string'];
			} elseif ($dr['jenis_input'] == 'tbl') {
				$value 	= $this->table_data($id_jenis_izin, $id_permohonan, 'rekam_berkas');
			} else {
				$value 	= $dt['nilai_'.$dr['tipe_data']];
			}

			$data_draft[$dr['kode_formula']] = $value;
		}


		// perusahaan_bio
		$condition 	= [];
		$condition[]= ['kode_formula', $kode_formula, 'where_in'];
		$data_raw	= $this->M_admin->get_master_spec('m_perusahaan_bio_s', '*', $condition)->result_array();

		foreach ($data_raw as $dr) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];
			$condition[]= ['id_perusahaan', $dPer['id_perusahaan'], 'where'];
			$condition[]= ['id_perusahaan_bio_s', $dr['id_perusahaan_bio_s'], 'where'];
			$dt			= $this->M_admin->get_master_spec($dr['table_tujuan_s'], 'nilai_string, nilai_num', $condition)->row_array();

			if ($dr['jenis_input'] == 'date') {
			    $value 	= $this->indonesian_date($dt['nilai_'.$dr['tipe_data']]);
			} elseif ($dr['jenis_input'] == 'currency') {
			    $value 	= number_format($dt['nilai_'.$dr['tipe_data']]);
			} elseif ($dr['jenis_input'] == 'select' && $dr['special'] == 0) {
				$id 		= $this->M_admin->get_master_spec($dr['table_tujuan_p'], 'id_perusahaan_bio_p', $condition)->row_array()['id_perusahaan_bio_p'];
				$condition 	= [];
				$condition[]	= ['id_perusahaan_bio_p', $id, 'where'];
				$value 	= $this->M_admin->get_master_spec('m_perusahaan_bio_p', 'teks_judul', $condition)->row_array()['teks_judul'];
			} elseif ($dr['jenis_input'] == 'select' && $dr['special'] == 1) {
				$dt		= $this->M_admin->get_master_spec($dr['table_tujuan_p'], 'nilai_string, nilai_num', $condition)->row_array();
				$value 	= $dt['nilai_string'];
			} elseif ($dr['jenis_input'] == 'tbl') {
				$value 	= $this->table_data($id_jenis_izin, $id_permohonan, 'perusahaan_bio');
			} else {
				$value 	= $dt['nilai_'.$dr['tipe_data']];
			}

			$data_draft[$dr['kode_formula']] = $value;
		}

		// flagging
		$data_draft 	= array_merge($data_draft, $this->cek_flag($id_jenis_izin, $id_permohonan));

		// $data_draft['TTD'] 	= $this->page_ttd($id_permohonan);
		return $data_draft;
	}

	function table_data($id_jenis_izin, $id_permohonan, $id, $type) {
		$condition 	= [];
		$condition[]= ['id_'.$type.'_s', $id, 'where'];
		$data_p		= $this->M_admin->get_master_spec('m_'.$type.'_p', 'id_'.$type.'_p, teks_judul, tipe_data', $condition)->result_array();

		$content 	= '<style>
					  .l { border-left: 1px solid black; }
					  .t { border-top: 1px solid black; }
					  .r { border-right: 1px solid black; }
					  .b { border-bottom: 1px solid black; }
					</style>';
		$content 	.= '<table>';
		$content 	.= '<thead>';
		$content 	.= '<tr>';

		foreach ($data_p as $dp) {
			$content 	.= '<td class="l r t b">'.$dp['teks_judul'].'</td>';
		}

		$content 	.= '</tr>';
		$content 	.= '</thead>';

		$condition 	= [];
		$condition[]= ['id_rekam_berkas_s', $id, 'where'];
		$index		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'max(`index`) as `index`', $condition)->row_array()['index'];

		$content 	.= '<tbody>';
		for ($a=1;$a<=$index;$a++) {
			$content 	.= '<tr>';
			foreach ($data_p as $dp) {
				$condition 	= [];
				$condition[]= ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
				$condition[]= ['aktif', 1, 'where'];
				$condition[]= ['index', $a, 'where'];
				$value		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'nilai_'.$dp['tipe_data'].' as value', $condition)->row_array()['value'];
				$content 	.= 	'<td class="l r b">'.$value.'</td>';
			}
			$content 	.= '</tr>';
		}
		$content 	.= '</tbody>';
		$content 	.= '</table>';

		echo $content;
		// echo $id_jenis_izin.' '.$id_permohonan;

	}

	private function indonesian_date($timestamp = '', $date_format = 'j F Y', $suffix = '') {
	    if (trim ($timestamp) == '') {
	        $timestamp = time ();
	    } elseif (!ctype_digit ($timestamp)) {
	        $timestamp = strtotime ($timestamp);
	    }

	    # remove S (st,nd,rd,th) there are no such things in indonesia :p
	    $date_format = preg_replace ("/S/", "", $date_format);
	    $pattern = [
	        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
	        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
	        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
	        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
	        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
	        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
	        '/April/','/June/','/July/','/August/','/September/','/October/',
	        '/November/','/December/',
	    ];
	    $replace = [
	    	'Sen','Sel','Rab','Kam','Jum','Sab','Min',
	        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
	        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
	        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
	        'Oktober','November','Desember',
	    ];
	    $date = date ($date_format, $timestamp);
	    $date = preg_replace ($pattern, $replace, $date);
	    $date = "{$date} {$suffix}";

	    return $date;
	}

	function qr_code($id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$data		= $this->M_admin->get_master_spec('v_draft_data', '*', $condition)->row_array();

		$code 	= '';
		foreach ($data as $k => $v) {
			$code 	.= $data[$k].'~';
		}

		$this->load->library('ciqrcode');
		$config['cacheable']	= true; //boolean, the default is true
		$config['cachedir']		= ''; //string, the default is application/cache/
		$config['errorlog']		= ''; //string, the default is application/logs/
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= 100; //interger, the default is 1024
		$config['black']		= array(224,255,255); // array, default is array(255,255,255)
		$config['white']		= array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		header("Content-Type: image/png");
		$params['data'] = $code;
		$this->ciqrcode->generate($params);
	}

	function cek_flag($id_jenis_izin, $id_permohonan) {

		$condition 	= [];
		$condition[]= ['aktif', 1, 'where'];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$config_flag= $this->M_permohonan_izin->get_master_spec('m_flag_izin', '*', $condition)->result_array();

		$data 	= [];

		foreach ($config_flag as $cf) {
			$loop 	= 1;

			$count 			= 0;
			$id_permohonan_prev	= $id_permohonan;
			while ($loop == 1) {
				$condition 	= [];
				$condition[]= ['id_jenis_izin', $cf['count_id_jenis_izin'], 'where'];
				$condition[]= ['id_permohonan', $id_permohonan_prev, 'where'];
				$cek_trans 	= $this->M_permohonan_izin->get_master_spec('t_count_flag', '*', $condition)->row_array();
				if ($cek_trans)	{
					$count++;
					$id_permohonan_prev 	= $cek_trans['id_permohonan_prev'];
				} else {
					$loop = 0;
				}
			}

			$flag 	= $cf['flag'];
			$flag 	= preg_replace('/#n#/', $count, $flag);

			$data[$cf['kode_formula']] 	= $flag;
		}

		return $data;
	}

	function terbit_noizin($id_permohonan) {
		$id_sdp 	= 1;
		$id_tdp 	= 2;

		$condition 	= [];
		$condition[] 	= ['id_permohonan', $id_permohonan, 'where'];
		$dPer 			= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();

		$condition 	= [];
		$condition[] 	= ['id_nama_izin', $dPer['id_nama_izin'], 'where'];

		$dJiz 			= $this->M_permohonan_izin->get_master_spec('t_data_no_izin', 'id_data_no_izin, jml_izin_terbit', $condition)->row_array();
		$jml_izin		= $dJiz['jml_izin_terbit'];
		$id_data_no_izin= $dJiz['id_data_no_izin'];
		if ($dJiz) {
			$jml_izin 	= intval($jml_izin)+1;
			$data 	= [
						'jml_izin_terbit' 	=> $jml_izin
					];

			$condition 		= [];
			$condition[0] 	= 'id_data_no_izin';
			$condition[1] 	= $id_data_no_izin;
			$condition[2] 	= 'where';
			// $this->M_admin->update_data('t_data_no_izin', $condition, $data);
		} else {

			$jml_izin 	= 1;
			$data 	= [
						'id_nama_izin' 	=> $dPer['id_nama_izin'],
						'jml_izin_terbit' 	=> $jml_izin
					];
			// $this->M_admin->insert_data('t_data_no_izin', $data);
		}


		$no_izin 	= $jml_izin;
		if($dPer['id_nama_izin'] == $id_sdp) {
			$no_izin 	= 'SIUP'.$no_izin;

			$jml_izin_tdp 	= '';

			$condition 	= [];
			$condition[] 	= ['id_nama_izin', $id_tdp, 'where'];
			$dJiz 			= $this->M_permohonan_izin->get_master_spec('t_data_no_izin', 'id_data_no_izin, jml_izin_terbit', $condition)->row_array();
			$jml_izin_tdp	= $dJiz['jml_izin_terbit'];
			$id_data_no_izin= $dJiz['id_data_no_izin'];
			if ($dJiz) {
				$jml_izin_tdp 	= intval($jml_izin_tdp);
			} else {
				$jml_izin_tdp 	= 1;
			}

			$no_izin 	.= ', '.'TDP'.strval($no_izin+intval($jml_izin_tdp));
		} elseif ($dPer['id_nama_izin'] == $id_tdp) {
			$condition 	= [];
			$condition[] 	= ['id_nama_izin', $id_sdp, 'where'];
			$dJiz 			= $this->M_permohonan_izin->get_master_spec('t_data_no_izin', 'id_data_no_izin, jml_izin_terbit', $condition)->row_array();
			$jml_izin_sdp	= $dJiz['jml_izin_terbit'];

			$no_izin 	= $no_izin+intval($jml_izin_sdp);
			$no_izin 	= 'TDP'.$no_izin;
		} else {
			if ($dPer['id_nama_izin'] == 3) {
				$prefix 	= 'IPTM';
			} elseif ($dPer['id_nama_izin'] == 4) {
				$prefix 	= 'SIUJK';
			} elseif ($dPer['id_nama_izin'] == 5) {
				$prefix 	= 'SIPA';
			} elseif ($dPer['id_nama_izin'] == 6) {
				$prefix 	= 'IMB';
			}
			$no_izin 	= $prefix.$no_izin;
		}

		$data 	= [
					'id_permohonan' 	=> $id_permohonan,
					'no_izin' 			=> $no_izin,
					'jml_tercetak'		=> 0
				];
		echo $no_izin;

		// $this->M_admin->insert_data('t_izin_terbit', $data);

	}

	function hilang_preg() {
		$condition 	= [];
		$condition[] 	= ['teks_judul', ' Copy', 'LIKE'];
		$syar			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s, teks_judul', $condition)->result_array();

		foreach ($syar as $sy) {
			$data 	= [];
			$data 	= [
						'teks_judul' 	=> preg_replace('/Foto Copy /i', '', $sy['teks_judul'])
					];

			$condition 		= [];
			$condition[0] 	= 'id_syarat_izin_s';
			$condition[1] 	= $sy['id_syarat_izin_s'];
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_syarat_izin_s', $condition, $data);
			echo '<pre>';
			var_dump($data);
		}

	}

	function test_content() {
		echo '<table><thead><tr><td class="l r t b">Kualifikasi Usaha</td><td class="l r t b">Sub Kualifikasi Pekerjaan</td><td class="l r t b">Tanggal dan No. SBU</td><td class="l r t b">Nama Peket Pekerjaan Tertinggi</td><td class="l r t b">Tahun Pekerjaan</td><td class="l r t b">Nilai Pekerjaan</td><td class="l r t b">Keterangan</td></tr></thead><tbody><tr><td class="l r b">asdf</td><td class="l r b">asdf</td><td class="l r b"></td><td class="l r b">asdf</td><td class="l r b">asdf</td><td class="l r b">adsf</td><td class="l r b">asdf</td></tr><tr><td class="l r b">1</td><td class="l r b">1</td><td class="l r b"></td><td class="l r b">1</td><td class="l r b">1</td><td class="l r b">1</td><td class="l r b">1</td></tr></tbody><style> .l { border-left: 1px solid black; } .t { border-top: 1px solid black; } .r { border-right: 1px solid black; } .b { border-bottom: 1px solid black; } </style><table><thead><tr><td class="l r t b">Kualifikasi Usaha</td><td class="l r t b">Sub Kualifikasi Pekerjaan</td><td class="l r t b">Tanggal dan No. SBU</td><td class="l r t b">Nama Peket Pekerjaan Tertinggi</td><td class="l r t b">Tahun Pekerjaan</td><td class="l r t b">Nilai Pekerjaan</td><td class="l r t b">Keterangan</td></tr></thead><tbody><tr><td class="l r b">asdf</td><td class="l r b">asdf</td><td class="l r b"></td><td class="l r b">asdf</td><td class="l r b">asdf</td><td class="l r b">adsf</td><td class="l r b">asdf</td></tr><tr><td class="l r b">1</td><td class="l r b">1</td><td class="l r b"></td><td class="l r b">1</td><td class="l r b">1</td><td class="l r b">1</td><td class="l r b">1</td></tr></tbody> ';
	}

	function test_message() {
		$data['id_workflow_decision'] 	= 724;
		$data['id_permohonan']			= 67;
		$data['id_pemohon'] 			= 48;
		$data['id_user_fe'] 			= 24;
		$data['id_aktivitas_workflow'] 	= 286;
		$data['id_jenis_izin'] 			= 34;


		$condition 	= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$data_action	= $this->M_permohonan_izin->get_master_spec('v_action_decision', 'retribusi, method, subject, message, formula, query', $condition)->result_array();

		foreach ($data_action as $dac) {
			$data_mg 	= [];
			if ($dac['method'] == 'send_email') {
				// reciever
				$condition 		= [];
				$condition[] 	= ['id_user_fe', $data['id_user_fe'], 'where'];
				$receiver 		= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'email_user', $condition)->row_array()['email_user'];

			} else if ($dac['method'] == 'send_sms') {
				// reciever
				$condition 		= [];
				$condition[] 	= ['id_user_fe', $data['id_user_fe'], 'where'];
				$receiver 		= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'no_hp', $condition)->row_array()['no_hp'];
			}

			// subject
			$subject 		= $dac['subject'];

			// message
			$query 			= $dac['query'];
			$query 			= preg_replace('/#id_workflow_decision#/', $data['id_workflow_decision'], $query); //id_workflow_decision
			$query 			= preg_replace('/#id_permohonan#/', $data['id_permohonan'], $query); //id_permohonan

			// preg replace
			$message 		= $dac['message'];
			$formula 		= explode(", ", $dac['formula']);


			$data_source 	= $this->M_admin->query($query)->result_array();
			var_dump($data_source);
			exit();

			foreach ($data_source as $ds) {
				foreach ($formula as $fr) {
					$message 	= preg_replace('/#'.$fr.'#/', $ds[$fr], $message);
				}
			}

			// cek retribusi
			if($dac['retribusi'] == 1) {
				$condition 			= [];
				$condition[] 		= ['aktif', 1, 'where'];
				$condition[] 		= ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
				$get_ret_tarif		= $this->M_core->get_tbl('m_ret_tarif', '*', $condition);

				// ret simple
				if($get_ret_tarif->num_rows() == 1) {
					$condition 			= [];
					$condition[] 		= ['aktif', 1, 'where'];
					$condition[] 		= ['id_permohonan', $data['id_permohonan'], 'where'];
					$tarif				= $this->M_core->get_tbl('t_ret_tarif', 'tarif', $condition)->row_array()['tarif'];

					$ret_biaya_total 	= 'Rp. '.number_format((int)$tarif);

				// ret kompleks
				} else {
					$condition       = [];
                    $condition[]     = ['aktif', 1, 'where'];
                    $condition[]     = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
                    $condition[]     = ['final', 1, 'where'];
                    $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                    $grf 			 = $get_ret_formula->row_array();

                    $ffn 		= str_replace('$var', $data['id_permohonan'], $grf['query']);
                    $query_ffn 	= $this->db->query($ffn);
                    $tarif 		= $query_ffn->row_array()['total'];

                    $ret_biaya_total 	= 'Rp. '.number_format((int)$tarif);
				}

				$message 	= preg_replace('/#ret_biaya_total#/', $ret_biaya_total, $message);
			}

			$data_mg['rcv'] = $receiver;
			$data_mg['msg'] = $message;
			$data_mg['sj'] 	= $subject;

			echo $data_mg;
		}
	}

	function flagging_izin() {
		$id_jenis_izin 	= 7;
		$id_aktivitas_workflow 	= 9;
		$id_workflow_decision 	= 19;
		$id_permohonan 	= 59;

		echo 'test';
	}

	function masa_izin() {
		$id_jenis_izin 	= 7;
		$date_daftar 	= '2017-07-12';

		$condition 		= [];
		$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$masa_berlaku	= $this->M_permohonan_izin->get_master_spec('m_masa_izin_cfg', 'masa_berlaku', $condition)->row_array()['masa_berlaku'];

		echo $masa_berlaku.'<br>';
		echo date("Y-m-d", strtotime(date("Y-m-d", strtotime($date_daftar)) . " + ".$masa_berlaku." year"));
	}

	function change_user() {
		$id_workflow 	= 9;
		$id_user 		= 10;
		$id_user_n 		= 38;

		$condition 		= [];
		$condition[] 	= ['id_workflow', $id_workflow, 'where'];
		$aktivitas		= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->result_array();

		$aktivitas_wk 	= null;
		foreach ($aktivitas as $ak) {
			$aktivitas_wk[] 	= $ak['id_aktivitas_workflow'];
		}

		$data 			= ['id_user' => $id_user_n];

		$condition 		= [];
		$condition[] 	= ['id_aktivitas_workflow', $aktivitas_wk, 'where_in'];
		$condition[] 	= ['id_user', $id_user, 'where'];

		$this->M_admin->update_data_spec('t_user_workflow', $condition, $data);

	}

	function cek_aktivitas() {
		$condition 			= [];
		$condition[] 		= ['id_workflow', [9, 10, 11], 'where_in'];
		$aktivitas_wk 		= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->result_array();

		foreach ($aktivitas_wk as $aw) {
			echo $aw['id_aktivitas_workflow'].', ';
		}
	}

	function bug() {
		$condition 	  		 = [];
		$d  = $this->M_core->get_tbl('v_permohonan_izin_terbit', 'id_permohonan', $condition)->num_rows();
		echo $d;
	}

	function insert_reject() {
		// $condition 			= [];
		// $condition[] 		= ['id_workflow', [9, 10, 11], 'where_in'];
		// $aktivitas_wk 		= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->result_array();

		$ar 	= [34,35,1,2,3,4,5,6,24,7,8,25,9,10,11,12,26,13,27,14,15,28,31,29,32,33,30,16,17,18,19,20,21,22,23];
		foreach ($ar as $ar) {
			$data 	= [
						'nm_aktivitas_workflow'	=> 'Tolak',
						'id_workflow'			=> $ar,
						'id_aktivitas' 			=> 38,
						'aktif' 				=> 1,
					];

			$this->M_admin->insert_data('t_aktivitas_workflow', $data);
		}

	}

	function query_ts()	 {
		$data 	= $this->M_admin->query('select a.id_permohonan
from v_permohonan_izin a
where a.id_aktivitas = 14 and
NOT EXISTS(
select * FROM t_izin_terbit b
where a.id_permohonan = b.id_permohonan
)')->result_array();

		
		foreach ($data as $aa) {
			echo $aa['id_permohonan'].', ';
		}
	}

	function cek_cfg_terbit() {
		$condition 			= [];
		$condition[] 		= ['id_aktivitas', 10, 'where'];
		$aktivitas_wk 		= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->result_array();

		$terbit_cfg 		= [];
		foreach ($aktivitas_wk as $aw) {
			$condition 			= [];
			$condition[] 		= ['id_aktivitas_workflow', $aw['id_aktivitas_workflow'], 'where'];
			$terbit_cfg[]		= $this->M_permohonan_izin->get_master_spec('m_izin_terbit_cfg', 'id_workflow_decision', $condition)->row_array()['id_workflow_decision'];
		}

		$decision_wk 		= [];
		foreach ($aktivitas_wk as $aw) {
			$condition 			= [];
			$condition[] 		= ['id_aktivitas_workflow', $aw['id_aktivitas_workflow'], 'where'];
			$condition[] 		= ['aktif', 1, 'where'];
			$condition[] 		= ['id_decision', 2, 'where'];
			$decision_wk[]	= $this->M_permohonan_izin->get_master_spec('t_workflow_decision', '*', $condition)->row_array();
		}

		$terbit_cfg 		= [];
		foreach ($decision_wk as $dw) {
			$condition 			= [];
			$condition[] 		= ['id_aktivitas_workflow', $dw['id_aktivitas_workflow'], 'where'];
			$condition[] 		= ['id_workflow_decision', $dw['id_workflow_decision'], 'where'];
			$condition[] 		= ['aktif', 1, 'where'];
			$cek						= $this->M_permohonan_izin->get_master_spec('m_izin_terbit_cfg', 'id_izin_terbit_cfg', $condition)->row_array()['id_izin_terbit_cfg'];
			if ($cek == null) {
				$terbit_cfg[] 		= $dw;
			}

		}

		echo '<pre>';
		var_dump($terbit_cfg);

	}

	function status_perusahaan() {
		$kode_formulabu = 'PRH21';

		$condition[] 	= ['kode_formula', $kode_formulabu, 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', 4, 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_perusahaan_bio_p= $this->M_permohonan_izin->get_master_spec('t_perusahaan_bio_p', 'id_perusahaan_bio_p', $condition)->row_array()['id_perusahaan_bio_p'];		

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_p', $id_perusahaan_bio_p, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_p', 'teks_judul', $condition)->row_array()['teks_judul'];						

		echo $value;
	}		

}
