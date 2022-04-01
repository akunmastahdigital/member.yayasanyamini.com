<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends MY_Controller {
	function __construct() {
        parent::__construct();

	}

	function index() {
        show_404();
	}

	function laporan_disclaimer(){
		$d['menu']  = 'Laporan Disclaimer';
        $d['page']  = 'laporan_disclaimer';
        $d['title']	= 'Laporan Disclaimer';
        $d['jml_permohonan'] = $this->M_admin->get_master_spec('v_permohonan_disc', 'id_permohonan_disc', '')->num_rows();
        $this->load->view('layout', $d);
	}
	function showLaporanDisclaimer(){
		$table = 'v_permohonan_disc';
		$column_order   = array(null, 'id_permohonan_disc', 'id_permohonan', 'no_permohonan', 'nama_pemohon', 'user_fe', 'tgl_permohonan', null, null);
        $column_search  = array('id_permohonan', 'tgl_permohonan');
        $order          = array('id_permohonan_disc' => 'asc');
        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
         foreach ($list_data as $ld) {

            $no++;
            $row = array();
            $row[] = $ld->id_permohonan_disc;;
            $row[] = $ld->id_permohonan;
            $row[] = $ld->no_permohonan;
            $row[] = $ld->tgl_permohonan;
 			$row[] = $ld->nama_pemohon;
 			$row[] = $ld->user_fe;

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

	/////////////////////////////////////////////////////////////
	function rekap_perizinan() {
		$d['menu']  = 'Laporan';
        $d['page']  = 'laporan';
        $d['title']	= 'Laporan Rekap Perizinan';
        $d['list_menuizin'] = $this->list_menuizin();
        $d['total'] 		= $this->laporan_total(0);

		$this->load->view('layout', $d);
	}

	public function laporan_show() {
		$table          = 'v_show_laporan';

		//get data
		$id_nama_izin	= $this->input->post('id_nama_izin');
		$id_jenis_izin	= $this->input->post('id_jenis_izin');
		$date_start 	= $this->input->post('date_start');
		$date_end 		= $this->input->post('date_end');

		// condition
		$condition 	    = [];
		if($id_nama_izin != '') {
			$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
		}
		if($id_jenis_izin != '') {
			$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		}
		if($date_start != '') {
			$condition[]  = ['tgl_permohonan >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}
		if($date_end != '') {
			$condition[]  = ['tgl_permohonan <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}

        $column_order   = [null, 'no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $column_search  = ['no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $order          = ['tgl_permohonan' => 'asc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('Y-m-d', strtotime($ld->tgl_permohonan));

           // $tanggal_terbit = $ld->tgl_terbit;
            if ( $ld->tgl_terbit == null or $ld->tgl_terbit == '') {
            	$tanggal = '';
            } else{
            	$tanggal = date('Y-m-d', strtotime($ld->tgl_terbit));
            }
            $row[] = $tanggal;
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = $this->get_jenis_izin($ld->id_jenis_izin);

            // $row[] = $ld->nama_izin.' - '.$ld->jenis_izin;
            $data[] = $row;
        }

        $output = [
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_datatables->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_datatables->count_all($table, $condition),
	            "data" => $data,
            ];
        echo json_encode($output);
	}

	public function laporan_show2() {
		$table          = 'v_permohonan_izin_terbit';

		//get data
		$id_nama_izin	= $this->input->post('id_nama_izin');
		$id_jenis_izin	= $this->input->post('id_jenis_izin');
		$date_start 	= $this->input->post('date_start');
		$date_end 		= $this->input->post('date_end');

		// condition
		$condition 	    = [];
		if($id_nama_izin != '') {
			$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
		}
		if($id_jenis_izin != '') {
			$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		}
		if($date_start != '') {
			$condition[]  = ['tgl_terbit >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}
		if($date_end != '') {
			$condition[]  = ['tgl_terbit <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}

        $column_order   = [null, 'no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $column_search  = ['no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $order          = ['tgl_permohonan' => 'asc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('Y-m-d', strtotime($ld->tgl_permohonan));

           // $tanggal_terbit = $ld->tgl_terbit;
            if ( $ld->tgl_terbit == null or $ld->tgl_terbit == '') {
            	$tanggal = '';
            } else{
            	$tanggal = date('Y-m-d', strtotime($ld->tgl_terbit));
            }
            $row[] = $tanggal;
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = $this->get_jenis_izin($ld->id_jenis_izin);

            // $row[] = $ld->nama_izin.' - '.$ld->jenis_izin;
            $data[] = $row;
        }

        $output = [
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_datatables->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_datatables->count_all($table, $condition),
	            "data" => $data,
            ];
        echo json_encode($output);
	}

	function laporan_total_perizin($type) {
		$table          = 'v_permohonan_izin_terbit';

		// get data
		if($type == 0) {
			$id_nama_izin 	= '';
			$id_jenis_izin 	= '';
			$date_start 	= '';
			$date_end 		= '';
		} else if($type == 1) {
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$date_start 	= $this->input->post('date_start');
			$date_end 		= $this->input->post('date_end');
		}

		// condition
		$condition 	    = [];
		if($id_nama_izin != '') {
			$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
		}
		if($id_jenis_izin != '') {
			$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		}
		if($date_start != '') {
			$condition[]  = ['tgl_terbit >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}
		if($date_end != '') {
			$condition[]  = ['tgl_terbit <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}

		// query
		$gtl = $this->M_core->get_tbl($table, '*', $condition);
		$res['total'] = $gtl->num_rows();
		$res['msg'] = 'valid';

		// response
		if($type == 0) {
			return $res['total'];
		} else if($type == 1) {
			echo json_encode($res);
		}
	}

	function rekapPerizin(){
		$d['menu']  = 'Laporan_Perizin';
        $d['page']  = 'laporanPerizin';
        $d['title']	= 'Laporan Rekap Perizinan';
        $d['list_menuizin'] = $this->list_menuizin();
        $d['total'] 		= $this->laporan_total(0);

		$this->load->view('layout', $d);
	}

	function laporan_total($type) {
		$table          = 'v_show_laporan';

		// get data
		if($type == 0) {
			$id_nama_izin 	= '';
			$id_jenis_izin 	= '';
			$date_start 	= '';
			$date_end 		= '';
		} else if($type == 1) {
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$date_start 	= $this->input->post('date_start');
			$date_end 		= $this->input->post('date_end');
		}

		// condition
		$condition 	    = [];
		if($id_nama_izin != '') {
			$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
		}
		if($id_jenis_izin != '') {
			$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		}
		if($date_start != '') {
			$condition[]  = ['tgl_permohonan >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}
		if($date_end != '') {
			$condition[]  = ['tgl_permohonan <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}

		// query
		$gtl = $this->M_core->get_tbl($table, '*', $condition);
		$res['total'] = $gtl->num_rows();
		$res['msg'] = 'valid';

		// response
		if($type == 0) {
			return $res['total'];
		} else if($type == 1) {
			echo json_encode($res);
		}
	}


	function laporan_export($type) {
		// get data
		$p['id_nama_izin'] 	= $this->input->get('id_nama_izin');
		$p['id_jenis_izin'] = $this->input->get('id_jenis_izin');
		$p['date_start'] 	= $this->input->get('date_start');
		$p['date_end'] 		= $this->input->get('date_end');

		// get izin
		$condition 	    = [];
		$condition[]  	= ['id_nama_izin', $p['id_nama_izin'], 'where'];
		$p['gni'] 		= $this->M_core->get_tbl('m_nama_izin', '*', $condition)->row_array()['nama_izin'];

		$condition 	    = [];
		$condition[]  	= ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		$p['gji'] 		= $this->M_core->get_tbl('m_jenis_izin', '*', $condition)->row_array()['jenis_izin'];

		if($p['gji'] == '') {
			$p['izin']		= $p['gni'];
		} else {
			$p['izin']		= $p['gni'].' - '.$p['gji'];
		}

		// condition
		$condition 	    = [];
		if($p['id_nama_izin'] != '') {
			$condition[]  = ['id_nama_izin', $p['id_nama_izin'], 'where'];
		}
		if($p['id_jenis_izin'] != '') {
			$condition[]  = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		}
		if($p['date_start'] != '') {
			$condition[]  = ['tgl_permohonan >=', date('Y-m-d', strtotime($p['date_start'])), 'where'];
		}
		if($p['date_end'] != '') {
			$condition[]  = ['tgl_permohonan <=', date('Y-m-d', strtotime($p['date_end'])), 'where'];
		}

		// query
		$table          = 'v_for_laporan';
		$p['gtl'] 		= $this->M_core->get_tbl($table, '*', $condition);
		$p['total']		= $p['gtl']->num_rows();

		// response
		$html = $this->load->view('laporan_ly', $p, true);
		$filename = 'Laporan_'.date('d_m_Y');
        if ($type == "excel") {
			header("Content-Disposition: attachment; filename=\"$filename.xls\"");
  			header("Content-Type: application/vnd.ms-excel");
			echo $html;
		} elseif ($type == "pdf") {
			$pdf = new TCPDF('p', 'cm', 'A4', 'true');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetHeaderMargin(false);
            $pdf->SetFooterMargin(false);
            $pdf->setMargins(1, 0.8, 1);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', '11');
            $pdf->Ln();
            $pdf->SetFont('helvetica', '', '10');
            $pdf->writeHTML($html, true, false, true, false, '');
            echo $pdf->Output("$filename", 'I');
		} else {
			show_404();
		}
	}

function laporan_export_perizin($type){
			// get data
			// get data
		$p['id_nama_izin'] 	= $this->input->get('id_nama_izin');
		$p['id_jenis_izin'] = $this->input->get('id_jenis_izin');
		$p['date_start'] 	= $this->input->get('date_start');
		$p['date_end'] 		= $this->input->get('date_end');

		// get izin
		$condition 	    = [];
		$condition[]  	= ['id_nama_izin', $p['id_nama_izin'], 'where'];
		$p['gni'] 		= $this->M_core->get_tbl('m_nama_izin', '*', $condition)->row_array()['nama_izin'];

		$condition 	    = [];
		$condition[]  	= ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		$p['gji'] 		= $this->M_core->get_tbl('m_jenis_izin', '*', $condition)->row_array()['jenis_izin'];

		if($p['gji'] == '') {
			$p['izin']		= $p['gni'];
		} else {
			$p['izin']		= $p['gni'].' - '.$p['gji'];
		}

		// condition
		$condition 	    = [];
		if($p['id_nama_izin'] != '') {
			$condition[]  = ['id_nama_izin', $p['id_nama_izin'], 'where'];
		}
		if($p['id_jenis_izin'] != '') {
			$condition[]  = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		}
		if($p['date_start'] != '') {
			$condition[]  = ['tgl_terbit >=', date('Y-m-d', strtotime($p['date_start'])), 'where'];
		}
		if($p['date_end'] != '') {
			$condition[]  = ['tgl_terbit <=', date('Y-m-d', strtotime($p['date_end'])), 'where'];
		}

		// query
		
		$id_jenis_izin_sipa = [22, 23, 24, 25, 26, 27, 28, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47];
		$id_jenis_izin_siup_tdp = [1, 2, 3, 6, 7, 8, 9, 10, 11, 12, 13, 14, 33, 34, 48, 49, 50, 51];
		$id_nama_izin_siup_tdp = [1,2,7];
		$id_jenis_izin_siujk = [19, 20, 21];
		$id_jenis_izin_sip_dokter  = [58, 60, 62];
		$id_jenis_iptm = [15, 16, 17, 18];
		$id_jenis_izin_imb = [29, 30, 31, 32];

		if (in_array($p['id_nama_izin'], $id_nama_izin_siup_tdp) OR in_array($p['id_jenis_izin'], $id_jenis_izin_siup_tdp)) {
			$table          = 'v_laporan_siup_tdp';
			$template		= 'laporan_siup_tdp';
		}elseif ($p['id_nama_izin'] == 5 OR in_array($p['id_jenis_izin'], $id_jenis_izin_sipa)) {
			$table          = 'v_laporan_sipa';
			$template		= 'laporan_sipa';
		}elseif ($p['id_nama_izin'] == 4 OR in_array($p['id_jenis_izin'], $id_jenis_izin_siujk)) {
			$table          = 'v_laporan_siujk';
			$template		= 'laporan_siujk';
		}elseif ($p['id_nama_izin'] == 9 OR in_array($p['id_jenis_izin'], $id_jenis_izin_sip_dokter)) {
			$table          = 'v_laporan_sip_dokter';
			$template		= 'laporan_sip_dokter';
		}elseif ($p['id_nama_izin'] == 3 OR in_array($p['id_jenis_izin'], $id_jenis_iptm)) {
			$table          = 'v_laporan_iptm';
			$template		= 'laporan_iptm';
		}elseif ($p['id_nama_izin'] == 6 OR in_array($p['id_jenis_izin'], $id_jenis_izin_imb)) {
			$table          = 'v_laporan_imb_rt';
			$template		= 'laporan_imb_rt';
		}
		//$table          = 'v_for_laporan';
		$p['pt'] = '';
		$p['cv'] = '';
		$p['pma'] = '';
		$p['koperasi'] = '';
		$p['bentuk_lainnya'] = '';
		$p['perorangan'] = '';
		
		$p['Pmikro'] = '';
		$p['PKecil'] = '';
		$p['PMenengah'] = '';
		$p['PBesar'] = '';

		
		$p['lokal'] = '';
		$p['akdp'] = '';
		$p['barang'] = '';

		$p['bayar'] = '';

		$p['gtl'] 		= $this->M_core->get_tbl($table, '*', $condition);
		$p['total']		= $p['gtl']->num_rows();

		
		// response
		$html = $this->load->view($template, $p, true);

		/*echo $html;
		exit();*/
		/*var_dump($html);
		exit(0);*/
		

		$filename = 'Laporan_'.date('d_m_Y');
        if ($type == "excel") {
			header("Content-Disposition: attachment; filename=\"$filename.xls\"");
  			header("Content-Type: application/vnd.ms-excel");
			echo $html;
		} elseif ($type == "pdf") {
			$pdf = new TCPDF('p', 'cm', 'A4', 'true');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetHeaderMargin(false);
            $pdf->SetFooterMargin(false);
            $pdf->setMargins(1, 0.8, 1);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', '11');
            $pdf->Ln();
            $pdf->SetFont('helvetica', '', '10');
            $pdf->writeHTML($html, true, false, true, false, '');
            echo $pdf->Output("$filename", 'I');
		} else {
			show_404();
		}
	}
	
	////////////////////////////////////////////////////////////////
	function rekap_perizinan_ret() {
		$d['menu']  = 'Laporan';
        $d['page']  = 'laporan_ret';
        $d['title']	= 'Laporan Rekap Perizinan Retribusi';
        $d['list_menuizin'] = $this->list_menuizin();
        $d['total'] 		= $this->laporan_ret_total(0);

		$this->load->view('layout', $d);
	}

	public function laporan_ret_show() {
		$table          = 'v_permohonan_izin_ret';

		//get data
		$id_nama_izin	= $this->input->post('id_nama_izin');
		$id_jenis_izin	= $this->input->post('id_jenis_izin');
		$date_start 	= $this->input->post('date_start');
		$date_end 		= $this->input->post('date_end');
		$status_byr 	= $this->input->post('status_byr');

		// condition
		$condition 	    = [];
		if($id_nama_izin != '') {
			$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
		}
		if($id_jenis_izin != '') {
			$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		}
		if($date_start != '') {
			$condition[]  = ['tgl_permohonan >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}
		if($date_end != '') {
			$condition[]  = ['tgl_permohonan <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}
		if($status_byr == 1) {
			$condition[]  = ['id_histori_pembayaran !=', '', 'where'];
		} 
		if($status_byr == 2) {
			$condition[]  = ['id_histori_pembayaran', null, 'where'];
		}

        $column_order   = [null, 'no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $column_search  = ['no_permohonan', 'tgl_permohonan', 'tgl_terbit', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $order          = ['tgl_permohonan' => 'asc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('Y-m-d', strtotime($ld->tgl_permohonan));

           	// $tanggal_terbit = $ld->tgl_terbit;
            // if ( $ld->tgl_terbit == null or $ld->tgl_terbit == '') {
            // 	$tanggal = '';
            // } else{
            // 	$tanggal = date('Y-m-d', strtotime($ld->tgl_terbit));
            // }
            // $row[] = $tanggal;
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = $this->get_jenis_izin($ld->id_jenis_izin);
            $row[] = $ld->no_skrd;
            $row[] = $ld->tgl_terbit_skrd;

            // status bayar
            if($ld->id_histori_pembayaran != null) {
            	$status_byr = '<span class="label label-success">Sudah</span> 
            					<button onclick="showFile(this)"
			            			class="btn btn-xs btn-icon waves-effect btn-warning m-b-5 tooltip-hover tooltipstered" 
			            			title=" Kode Bayar : '.$ld->kode_bayar_histori.',
			            					Nominal : '.number_format($ld->nominal).', 
			            					Tgl : '.$ld->tgl_bayar.'"> 
			            			<i class="fa fa-search"></i> 
			                    </button>';
            } else {
            	$status_byr = '<span class="label label-danger">Belum</span>';
            }
            $row[] = $status_byr;

            $row[] = '<button style="margin-right:5px;" type="button" 
            			class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover tooltipstered"
            			title="Preview SKRD, SSRD & NOTA HITUNG" 
            			data-permohonan="'.$ld->id_permohonan.'" onclick="showSkrd(this)"> 
            			<i class="fa fa-print"></i>
					  </button>';
            // $row[] = $ld->nama_izin.' - '.$ld->jenis_izin;
            $data[] = $row;
        }

        $output = [
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_datatables->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_datatables->count_all($table, $condition),
	            "data" => $data,
            ];
        echo json_encode($output);
	}

	function laporan_ret_total($type) {
		$table          = 'v_permohonan_izin_ret';

		// get data
		if($type == 0) {
			$id_nama_izin 	= '';
			$id_jenis_izin 	= '';
			$date_start 	= '';
			$date_end 		= '';
			$status_byr 	= '';
		} else if($type == 1) {
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$date_start 	= $this->input->post('date_start');
			$date_end 		= $this->input->post('date_end');
			$status_byr 	= $this->input->post('status_byr');

		}

		// condition
		$condition 	    = [];
		if($id_nama_izin != '') {
			$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
		}
		if($id_jenis_izin != '') {
			$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		}
		if($date_start != '') {
			$condition[]  = ['tgl_permohonan >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}
		if($date_end != '') {
			$condition[]  = ['tgl_permohonan <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}
		if($status_byr == 1) {
			$condition[]  = ['id_histori_pembayaran !=', '', 'where'];
		} 
		if($status_byr == 2) {
			$condition[]  = ['id_histori_pembayaran', null, 'where'];
		}

		// query
		$gtl = $this->M_core->get_tbl($table, '*', $condition);
		$res['total'] = $gtl->num_rows();
		$res['msg'] = 'valid';

		// response
		if($type == 0) {
			return $res['total'];
		} else if($type == 1) {
			echo json_encode($res);
		}
	}

	function laporan_ret_export($type) {
		// get data
		$p['id_nama_izin'] 	= $this->input->get('id_nama_izin');
		$p['id_jenis_izin'] = $this->input->get('id_jenis_izin');
		$p['date_start'] 	= $this->input->get('date_start');
		$p['date_end'] 		= $this->input->get('date_end');
		$p['status_byr'] 	= $this->input->get('status_byr');

		// get izin
		$condition 	    = [];
		$condition[]  	= ['id_nama_izin', $p['id_nama_izin'], 'where'];
		$p['gni'] 		= $this->M_core->get_tbl('m_nama_izin', '*', $condition)->row_array()['nama_izin'];

		$condition 	    = [];
		$condition[]  	= ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		$p['gji'] 		= $this->M_core->get_tbl('m_jenis_izin', '*', $condition)->row_array()['jenis_izin'];

		if($p['gji'] == '') {
			$p['izin']		= $p['gni'];
		} else {
			$p['izin']		= $p['gni'].' - '.$p['gji'];
		}

		// condition
		$condition 	    = [];
		if($p['id_nama_izin'] != '') {
			$condition[]  = ['id_nama_izin', $p['id_nama_izin'], 'where'];
		}
		if($p['id_jenis_izin'] != '') {
			$condition[]  = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		}
		if($p['date_start'] != '') {
			$condition[]  = ['tgl_permohonan >=', date('Y-m-d', strtotime($p['date_start'])), 'where'];
		}
		if($p['date_end'] != '') {
			$condition[]  = ['tgl_permohonan <=', date('Y-m-d', strtotime($p['date_end'])), 'where'];
		}
		if($p['status_byr'] == 1) {
			$condition[]  = ['id_histori_pembayaran !=', '', 'where'];
		} 
		if($p['status_byr'] == 2) {
			$condition[]  = ['id_histori_pembayaran', '', 'where'];
		}

		// query
		$table          = 'v_permohonan_izin_ret';
		$p['gtl'] 		= $this->M_core->get_tbl($table, '*', $condition);
		$p['total']		= $p['gtl']->num_rows();

		// response
		$html = $this->load->view('laporan_ret_ly', $p, true);
		$filename = 'Laporan_'.date('d_m_Y');
        if ($type == "excel") {
			header("Content-Disposition: attachment; filename=\"$filename.xls\"");
  			header("Content-Type: application/vnd.ms-excel");
			echo $html;
		} elseif ($type == "pdf") {
			$pdf = new TCPDF('p', 'cm', 'A4', 'true');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetHeaderMargin(false);
            $pdf->SetFooterMargin(false);
            $pdf->setMargins(1, 0.8, 1);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', '11');
            $pdf->Ln();
            $pdf->SetFont('helvetica', '', '10');
            $pdf->writeHTML($html, true, false, true, false, '');
            echo $pdf->Output("$filename", 'I');
		} else {
			show_404();
		}
	}


	////////////////////////////////////////////////////////////////
	function rekap_perizinan_dcs() {
		$d['menu']  = 'Laporan';
        $d['page']  = 'laporan_dcs';
        $d['title']	= 'Laporan Rekap per User';
        $d['list_menuizin'] = $this->list_menuizin();
        $d['total'] 		= $this->laporan_dcs_total(0);

		$this->load->view('layout', $d);
	}

	public function laporan_dcs_show() {
		//get data
		$p_status		= $this->input->post('status');
		$id_nama_izin 	= $this->input->post('id_nama_izin');
		$id_jenis_izin 	= $this->input->post('id_jenis_izin');

		//condition
		$condition 	    = [];
		if($p_status == '') {
			$table  	  = 'v_histori_permohonan';
			$condition[]  = ['added_by', $this->session->userdata('id_user'), 'where'];
			$condition[]  = ['id_decision', 2, 'where'];

		} else {
			$status = $p_status;

			if($status == 1) {
				$table  	  = 'v_permohonan_izin';
				$condition[]  = ['id_user', $this->session->userdata('id_user'), 'where'];
			}

			if($status == 2) {
				$table  	  = 'v_histori_permohonan';
				$condition[]  = ['added_by', $this->session->userdata('id_user'), 'where'];
				$condition[]  = ['id_decision', 2, 'where'];
			}

			if($id_nama_izin != '') {
				$condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
			}
			if($id_jenis_izin != '') {
				$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
			}
		}

        $column_order   = [null, 'no_permohonan', 'tgl_permohonan', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $column_search  = ['no_permohonan', 'tgl_permohonan', 'nama_pemohon', 'nilai_string', 'nama_izin'];
        $order          = ['tgl_permohonan' => 'asc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('Y-m-d', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = $this->get_jenis_izin($ld->id_jenis_izin);
            // $row[] = $ld->nama_izin.' - '.$ld->jenis_izin;

            $data[] = $row;
        }

        $output = [
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_datatables->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_datatables->count_all($table, $condition),
	            "data" => $data,
            ];
        echo json_encode($output);
	}

	function laporan_dcs_total($type) {
		// get data
		if($type == 0) {
			$table  	  = 'v_histori_permohonan';
			$condition[]  = ['added_by', $this->session->userdata('id_user'), 'where'];
			$condition[]  = ['id_decision', 2, 'where'];

		} else if($type == 1) {
			$status 		= $this->input->post('status');
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');

			if($status == 1) {
				$table  	  = 'v_permohonan_izin';
				$condition[]  = ['id_user', $this->session->userdata('id_user'), 'where'];
			}

			if($status == 2) {
				$table  	  = 'v_histori_permohonan';
				$condition[]  = ['added_by', $this->session->userdata('id_user'), 'where'];
				$condition[]  = ['id_decision', 2, 'where'];
			}

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
		if($type == 0) {
			return $res['total'];
		} else if($type == 1) {
			echo json_encode($res);
		}
	}


	function laporan_dcs_export($type) {
		// get data
		$p['status'] 		= $this->input->get('status');
		$p['id_nama_izin'] 	= $this->input->get('id_nama_izin');
		$p['id_jenis_izin'] = $this->input->get('id_jenis_izin');

		// get izin
		$condition 	    = [];
		$condition[]  	= ['id_nama_izin', $p['id_nama_izin'], 'where'];
		$p['gni'] 		= $this->M_core->get_tbl('m_nama_izin', '*', $condition)->row_array()['nama_izin'];

		$condition 	    = [];
		$condition[]  	= ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		$p['gji'] 		= $this->M_core->get_tbl('m_jenis_izin', '*', $condition)->row_array()['jenis_izin'];

		if($p['gji'] == '') {
			$p['izin']		= $p['gni'];
		} else {
			$p['izin']		= $p['gni'].' - '.$p['gji'];
		}

		//condition
		$condition 	    = [];
		if($p['status'] == '') {
			$table  	  = 'v_histori_permohonan';
			$condition[]  = ['added_by', $this->session->userdata('id_user'), 'where'];
			$condition[]  = ['id_decision', 2, 'where'];

		} else {

			if($p['status'] == 1) {
				$table  	  = 'v_permohonan_izin';
				$condition[]  = ['id_user', $this->session->userdata('id_user'), 'where'];
			}

			if($p['status'] == 2) {
				$table  	  = 'v_histori_permohonan';
				$condition[]  = ['added_by', $this->session->userdata('id_user'), 'where'];
				$condition[]  = ['id_decision', 2, 'where'];
			}

			if($p['id_nama_izin'] != '') {
				$condition[]  = ['id_nama_izin', $p['id_nama_izin'], 'where'];
			}
			if($p['id_jenis_izin'] != '') {
				$condition[]  = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
			}
		}

		//query
		$p['gtl'] 		= $this->M_core->get_tbl($table, '*', $condition);
		$p['total']		= $p['gtl']->num_rows();

		// response
		$html = $this->load->view('laporan_dcs_ly', $p, true);
		$filename = 'Laporan_'.date('d_m_Y');
        if ($type == "excel") {
			header("Content-Disposition: attachment; filename=\"$filename.xls\"");
  			header("Content-Type: application/vnd.ms-excel");
			echo $html;
		} elseif ($type == "pdf") {
			$pdf = new TCPDF('p', 'cm', 'A4', 'true');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetHeaderMargin(false);
            $pdf->SetFooterMargin(false);
            $pdf->setMargins(1, 0.8, 1);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', '11');
            $pdf->Ln();
            $pdf->SetFont('helvetica', '', '10');
            $pdf->writeHTML($html, true, false, true, false, '');
            echo $pdf->Output("$filename", 'I');
		} else {
			show_404();
		}
	}
	/////////////////////////////////////////////////////////////////


	function rekap_perizinan_jml() {
		$d['menu']  = 'Lapora';
        $d['page']  = 'laporan_jml';
        $d['title']	= 'Laporan Jml Izin per Meja';

		$this->load->view('layout', $d);
	}

	public function laporan_jml_show() {
		$table          = 'v_jml_izin';
		$condition 		= [];
        $column_order   = [null, 'nm_personil', 'nm_jabatan', 'jml_siup_tdp', 'jml_tdp',
        					'jml_iptm', 'jml_siujk', 'jml_sipa', 'jml_imb', 'jml_sipb', 'jml_sipd', 'jml_total'];
        $column_search  = ['nm_personil', 'nm_jabatan', 'jml_siup_tdp', 'jml_tdp',
        					'jml_iptm', 'jml_siujk', 'jml_sipa', 'jml_imb', 'jml_sipb', 'jml_sipd', 'jml_total'];
        $order          = ['kd_personil' => 'asc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $ld->nm_personil;
           	$row[] = $ld->nm_jabatan;
           	$row[] = $ld->jml_siup;
           	$row[] = $ld->jml_siup_tdp;
           	$row[] = $ld->jml_tdp;
           	$row[] = $ld->jml_iptm;
           	$row[] = $ld->jml_siujk;
           	$row[] = $ld->jml_sipa;
           	$row[] = $ld->jml_imb;
           	$row[] = $ld->jml_sipb;
           	$row[] = $ld->jml_sipd;
           	$row[] = $ld->jml_total;

            $data[] = $row;
        }

        $output = [
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_datatables->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_datatables->count_all($table, $condition),
	            "data" => $data,
            ];
        echo json_encode($output);
	}

	function laporan_jml_export($type) {
		// query
		$table          = 'v_jml_izin';
		$condition 	    = [];
		$condition[] 		= ['kd_personil', 'asc', 'order_by'];
		$p['gtl'] 		= $this->M_core->get_tbl($table, '*', $condition);

		// response
		$html = $this->load->view('laporan_jml_ly', $p, true);
		$filename = 'Laporan_jml_'.date('d_m_Y');
        if ($type == "excel") {
			header("Content-Disposition: attachment; filename=\"$filename.xls\"");
  			header("Content-Type: application/vnd.ms-excel");
			echo $html;
		} elseif ($type == "pdf") {
			$pdf = new TCPDF('p', 'cm', 'A4', 'true');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetHeaderMargin(false);
            $pdf->SetFooterMargin(false);
            $pdf->setMargins(1, 0.8, 1);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', '11');
            $pdf->Ln();
            $pdf->SetFont('helvetica', '', '10');
            $pdf->writeHTML($html, true, false, true, false, '');
            echo $pdf->Output("$filename", 'I');
		} else {
			show_404();
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
