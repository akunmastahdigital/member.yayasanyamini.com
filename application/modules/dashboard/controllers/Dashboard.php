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

		$this->load->view('layout', $d);
	}

	function relawan(){
		$d['page']      = 'dashboard2';     
		$condition 	  = [];
		$condition[]  = ['id_user', $this->session->userdata('id_user'), 'where'];
		$d['result'] = $this->M_core->get_tbl('v_progress_zakat', '*', $condition)->row_array();
		$d['data_user'] = $this->M_core->get_tbl('m_user', '*', $condition)->row_array();
		$d['nama_user'] = $this->session->userdata('nm_user');
		$condition 		= array();
		$condition[] 	= array('id_nama_izin', 1, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$d['option'] 	= $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'id_jenis_izin, teks_menu', $condition)->result_array();
		$this->load->view('layout', $d);
	}
	

	function admin(){
		$d['page']      = 'dashboard1'; 
		$condition 		= array();
		$d['list_jenis']= $this->M_permohonan_izin->get_master_spec('v_jmlh', '*', $condition)->result_array();
		$d['sum_lj']	= array_sum(array_column($d['list_jenis'], 'jumlah_transaksi'));
		$get_data 		= $this->M_permohonan_izin->get_master_spec('v_progress_zakat', 'total_ziswaf, jmlh_uang', $condition)->result_array();
		
		$d['data'] 	= $this->M_permohonan_izin->get_master_spec('v_total', 'jenis_izin, total_transaksi, total_transaksi_finish', $condition)->result_array();

		$d['total_blm'] = array_sum(array_column($d['data'], 'total_transaksi'));
		$d['jmlh'] 		= array_sum(array_column($get_data, 'jmlh_uang'));

		$d['jmlh_trans']= array_sum(array_column($get_data, 'total_ziswaf'));
		$d['jmlh_blm']	= $d['sum_lj'] - $d['jmlh_trans']; 
		$d['persentase']= ($d['jmlh'] * 100) / 883000000;
		
		$this->load->view('layout', $d);
	}

	function change_data_admin(){
		$condition = [];
		$data 	= $this->M_permohonan_izin->get_master_spec('v_total', 'jenis_izin, total_transaksi, total_transaksi_finish', $condition)->result_array();

		$result = '';
		$no = 0;
		$a = array('danger', 'success', 'primary', 'warning', 'info', 'orange', 'danger','success', 'primary', 'warning', 'info', 'orange', 'danger', 'success', 'primary');
		foreach ($data as $d) {
			$result .=
			'<div class="col-sm-4">
				<div class="card-box widget-box-one card_jenis" >
					<div class="wigdet-one-content" style="font-size:14px;">
						<p class="m-0 font-secondary">'.$d['jenis_izin'].' : <span class="label label-'.$a[$no].'">Rp '.number_format($d['total_transaksi_finish'], 0,',','.').'</span></p>
					</div>
				</div>
			</div>';
			$no++;
		} 

		echo $result;
	}

	function rollback_data_admin(){
		$condition = [];
		$data 	= $this->M_permohonan_izin->get_master_spec('v_total', 'jenis_izin, total_transaksi, total_transaksi_finish', $condition)->result_array();

		$result = '';
		$no = 0;
		$a = array('danger', 'success', 'primary', 'warning', 'info', 'orange', 'danger','success', 'primary', 'warning', 'info', 'orange', 'danger', 'success', 'primary');
		foreach ($data as $d) {
			$result .=
			'<div class="col-sm-4">
				<div class="card-box widget-box-one card_jenis" >
					<div class="wigdet-one-content" style="font-size:14px;">
						<p class="m-0 font-secondary">'.$d['jenis_izin'].' : <span class="label label-'.$a[$no].'">Rp '.number_format($d['total_transaksi'], 0,',','.').'</span></p>
					</div>
				</div>
			</div>';
			$no++;
		} 

		echo $result;
	}


	function staff(){
		$d['page']      = 'dashboard-staff'; 
		$condition 		= array();
		$d['list_jenis']= $this->M_permohonan_izin->get_master_spec('v_jmlh', '*', $condition)->result_array();
		$d['sum_lj']	= array_sum(array_column($d['list_jenis'], 'jumlah_transaksi'));
		$get_data 		= $this->M_permohonan_izin->get_master_spec('v_progress_zakat', 'total_ziswaf, jmlh_uang', $condition)->result_array();
		$d['jmlh'] 		= array_sum(array_column($get_data, 'jmlh_uang'));
		$d['jmlh_trans']= array_sum(array_column($get_data, 'total_ziswaf'));
		$d['persentase']= ($d['jmlh'] * 100) / 883000000;
		
		$this->load->view('layout', $d);
	}

	public function show_permohonan_khusus() {
		$table          = 'v_permohonan_khusus';
		$id_user 		= $this->session->userdata('id_user');


		unset($condition);
		$condition 		= array();

		$condition[]  = array('id_user_bo', $id_user, 'where_in');
		$condition[]  = array('5', '', 'limit');


        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin', null);
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin','jenis_izin');
        $order          = array('id_permohonan' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = array();

			if($ld->id_aktivitas != 14){
				$label = 'Menunggu '.$ld->nm_aktivitas_workflow;
				$btn = '';
			}else{
				$label = '<label class="label label-sm label-teal">'.$ld->nm_aktivitas_workflow.'</label>';
				$btn = '<center><button style="margin-right:5px;" type="button" data-id="'.$ld->id_permohonan.'" class="btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered" onclick="showDraft(this)" title="Preview Kwitansi"> <i class="fa fa-file-pdf-o"></i> Kwitansi
				</button> <button style="margin-right:5px;" type="button" data-id="'.$ld->id_permohonan.'" class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover tooltipstered" onclick="showDraft(this)" title="Preview Sertifikat"> <i class="fa fa-file-text-o"></i> Sertif
				</button></center>';
			}

            $row[] = $no;
            $row[] = $ld->nama_pemohon;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
			$row[] = $label;
			// $row[] = $btn;

            $data[] = $row;
        }

        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_permohonan_izin->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_permohonan_izin->count_all($table, $condition),
	            "data" => $data,
            );
        echo json_encode($output);
	}

	function get_jenis_izin($id_jenis_izin) {
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

	function indonesian_date($timestamp = '', $date_format = 'j F Y', $suffix = '') {
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
	        'Januari','Februari','Maret','April','Juni','Juli','Agustus','September',
	        'Oktober','November','Desember',
	    ];
	    $date = date ($date_format, $timestamp);
	    $date = preg_replace ($pattern, $replace, $date);
	    $date = "{$date} {$suffix}";

	    return $date;
	}

}