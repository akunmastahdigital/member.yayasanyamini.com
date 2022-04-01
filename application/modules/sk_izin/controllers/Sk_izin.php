<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sk_izin extends MY_Controller {
	function __construct() {
        parent::__construct();
        
	}
	
	function index() {
        show_404();
	}

	function cetak() {
		$d['menu']  = 'Cetak SK Izin';
        $d['page']  = 'sk_izin_cetak';
        $d['title']	= 'Draft Izin Siap Cetak';
        $this->load->view('layout', $d);
	}

	function pengambilan() {
		$d['menu']  = 'Pengambilan SK Izin';
        $d['page']  = 'sk_izin_pengambilan';
        $d['title']	= 'Pengambilan Draft Izin';
        $this->load->view('layout', $d);
	}

	function arsip() {
		$d['menu']  = 'Arsip SK Izin';
        $d['page']  = 'sk_izin_arsip';
        $d['title']	= 'Arsip Izin';
        $this->load->view('layout', $d);
	}

	function show_cetak() {
		$table          = 'v_permohonan_izin_terbit';
		// $id_user 		= $this->session->userdata('id_user');
		
		$condition 	= [];
		$condition[] 	= ['terambil', 0, 'where'];
		
        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin',null); 
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin'); 
        $order          = array('id_permohonan' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
            $row[] = '<button onclick="showFile(this)" data-id="'.$ld->id_permohonan.'" 
            		  class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                      title="Cetak"> <i class="fa fa-print"></i> 
                      </button>';

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


	function cetakIptm() {
		$d['menu']  = 'Cetak SK Izin';
        $d['page']  = 'cetak_iptm';
        $d['title']	= 'Draft Izin Siap Cetak';
        $this->load->view('layout', $d);
	}

	function showCetakIptm() {
		$table          = 'v_cetak_iptm';
		// $id_user 		= $this->session->userdata('id_user');
		
		$condition 	= [];
		$condition[] 	= ['terambil', 0, 'where'];
		
        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin',null); 
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin'); 
        $order          = array('id_permohonan' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
            $row[] = '<button onclick="showFile(this)" data-id="'.$ld->id_permohonan.'" 
            		  class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                      title="Cetak"> <i class="fa fa-print"></i> 
                      </button>';

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

	function show_cetak_tss() {
		$table          = 't_permohonan';
		// $id_user 		= $this->session->userdata('id_user');
		
		$condition 	= [];
		// $condition[] 	= ['terambil', 0, 'where'];
		
        $column_order   = array(null, 'no_permohonan','tgl_permohonan','id_jenis_izin','id_jenis_izin','id_jenis_izin',null); 
        $column_search  = array('no_permohonan','tgl_permohonan','id_jenis_izin','id_jenis_izin','id_jenis_izin'); 
        $order          = array('id_permohonan' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
            $row[] = $ld->id_jenis_izin;
            $row[] = $ld->id_jenis_izin;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
            $row[] = '<button onclick="showFile(this)" data-id="'.$ld->id_permohonan.'" 
            		  class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                      title="Cetak"> <i class="fa fa-print"></i> 
                      </button>';

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

	function show_pengambilan() {

		if ($this->session->userdata('id_role') == 38) {
			$table = 'v_cetak_iptm';
		}else{
			$table          = 'v_permohonan_izin_terbit';
			
		}
		// $id_user 		= $this->session->userdata('id_user');
		
		$condition 	= [];
		$condition[] 	= ['terambil', 0, 'where'];
		
        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin',null); 
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin'); 
        $order          = array('id_permohonan' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
             $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
            $row[] = '<button data-action="input-pengambilan" data-id="'.$ld->id_permohonan.'" class="action btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                          title="Input"> Input Data Pengambil
                        </button>';

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

	function show_arsip() {
		$table          = 'v_permohonan_izin_terbit';
		// $id_user 		= $this->session->userdata('id_user');
		
		$condition 	= [];
		$condition[] 	= ['terambil', 1, 'where'];
		
        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin',null); 
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin'); 
        $order          = array('id_permohonan' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
            $row[] = '<button onclick="showFile(this)" data-id="'.$ld->id_permohonan.'" 
            		  class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                      title="Cetak"> <i class="fa fa-print"></i> 
                      </button>';

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

	/*function sk_izin_action($action) {
		if ($action == "input_peng") {
			$id_permohonan 		= $this->input->post('id_permohonan');
			$nama_pengambil 	= $this->input->post('nama_pengambil');
			$jabatan_pengambil 	= $this->input->post('jabatan_pengambil');
			$masa_berlaku 		= $this->input->post('masa_berlaku');
			$berlaku_sd 		= date('Y-m-d', strtotime($this->input->post('berlaku_sd')));

			$data 			= [ 
								'id_permohonan' 	=> $id_permohonan,
								'nama_pengambil' 	=> $nama_pengambil,
								'masa_berlaku' 		=> $masa_berlaku,
								'berlaku_sd' 		=> $berlaku_sd,
								'jabatan_pengambil' => $jabatan_pengambil
							];

			$this->M_admin->insert_data('t_permohonan_final', $data);
			
			$response 	= ['status' => "OK!"];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);		
	}*/


	function sk_izin_action($action) {
		if ($action == "input_peng") {
			$id_permohonan 		= $this->input->post('id_permohonan');
			$nama_pengambil 	= $this->input->post('nama_pengambil');
			$jabatan_pengambil 	= $this->input->post('jabatan_pengambil');
			$masa_berlaku 		= $this->input->post('masa_berlaku');
			$berlaku_sd 		= date('Y-m-d', strtotime($this->input->post('berlaku_sd')));

			$data 			= [ 
								'id_permohonan' 	=> $id_permohonan,
								'nama_pengambil' 	=> $nama_pengambil,
								'masa_berlaku' 		=> $masa_berlaku,
								'berlaku_sd' 		=> $berlaku_sd,
								'jabatan_pengambil' => $jabatan_pengambil
							];

			$this->M_admin->insert_data('t_permohonan_final', $data);
			$type = 'frezz';
			$this->pdf_frezz($type, $id_permohonan);
			
			$response 	= ['status' => "OK!"];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);		
	}


	
	function getFileFrezzPdf(){
		$id_permohonan = $this->input->post('id');
		$obj =	'<object width="100%" height="500px" type="application/pdf" 
					data="'.base_url('berkas/data_sk_izin/'.$id_permohonan.'.pdf').'">
			  	</object>';
		echo $obj;
	}

	function pdf_frezz($type, $id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$dPer		= $this->M_admin->get_master_spec('v_permohonan_izin_terbit', '*', $condition)->row_array();

		$id_permohonan	= $id_permohonan;
		$id_jenis_izin	= $dPer['id_jenis_izin'];

		$condition 	= [];
		$condition[]= ['aktif', 1, 'where'];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$draft_izin	= $this->M_admin->get_master_spec('v_draft_izin', '*', $condition)->result_array();	

		$pdf = new TCPDF('P', 'cm', PDF_PAGE_FORMAT, 'true');
		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);
        $pdf->setMargins(1.5, 0.8, 1);
        $pdf->SetFont('times', '', '11');		

			$page= 1;
		foreach ($draft_izin as $diz) {
	        $size 	= $diz['size'];
	        if ($diz['size'] == 'Legal') {
	        	$size 	= [21.6, 35.6];
	        }

	        $pdf->AddPage($diz['position'], $size);
			$kode_formula 	= [];
			$kode_formula 	= explode(", ", $diz['list_content']);

			$data_source = [];
			$data_source = $this->data_source_draft($id_permohonan, $kode_formula);

			$data_pdf 	 = [];

			$approver 	= [];
			$approver['name'] 	= 'Drs. AMIT RIYADI, M. Si';
			$approver['stempel'] = 'stempel.png';
			$approver['nip'] 	= '19590511 198603 1 005';
			$approver['pembina'] = 'Pembina Utama Muda';
			if ($dPer['id_nama_izin'] == 5) {
				$approver['jabatan'] = 'KA. DINAS PENANAMAN MODAL & PELAYANAN';
			} else {
				$approver['jabatan'] = 'KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU';
			}

			//if (strtotime($dPer['tgl_terbit']) >= strtotime('2017-12-27')) { 
			if (strtotime($dPer['tgl_terbit']) >= strtotime('2017-12-27') && strtotime($dPer['tgl_terbit']) < strtotime('2018-01-12')) { 
				$approver['name'] 	= 'Drs. H. Rayendra Sukarmadji, M. Si';
				$approver['stempel'] = 'stempel_sekda.png';
				$approver['nip'] 	= '19580724 198603 1 007';
				$approver['pembina'] = 'Pembina Utama';
				$approver['jabatan1'] = 'Plh. KEPALA DINAS PENANAMAN MODAL';
				$approver['jabatan'] = 'DAN PELAYANAN TERPADU SATU PINTU <br>SEKRETARIS DAERAH,';
				$approver['jabatan2'] = 'DAN PELAYANAN TERPADU SATU PINTU';
				$approver['jabatan3'] = 'SEKRETARIS DAERAH,';
				} else {
				$approver['name'] 	= 'Drs. AMIT RIYADI, M. Si';
				$approver['stempel'] = 'stempel.png';
				$approver['nip'] 	= '19590511 198603 1 005';
				$approver['pembina'] = 'Pembina Utama Muda';
				$approver['jabatan1'] = 'KEPALA DINAS PENANAMAN MODAL';
				$approver['jabatan'] = 'DAN PELAYANAN TERPADU SATU PINTU';
				$approver['jabatan2'] = 'DAN PELAYANAN TERPADU SATU PINTU';
				$approver['jabatan3'] = '';
			}

			$data_pdf['id_permohonan'] 	= $id_permohonan;
			$data_pdf['bentuk_usaha'] 	= $this->get_bentuk_usaha($dPer['id_perusahaan']);
			$data_pdf['status_perusahaan'] 	= $this->get_status_perusahaan($dPer['id_perusahaan']);
			$data_pdf['id_jenis_izin'] 	= $dPer['id_jenis_izin'];
			$data_pdf['type'] 			= $type;
			$data_pdf['tgl_terbit'] 	= $dPer['tgl_terbit'];
			$data_pdf['approver'] 		= $approver;

			$c_draft 	 = $this->load->view('sk_izin/'.$diz['template'], $data_pdf, TRUE);
			$index 		 = 1;
			foreach ($kode_formula as $kfr) {
				if ($kfr == 'DRD8' && count(explode(", ", $data_source['DRD8'])) > 1) {
					$c_draft = preg_replace('/#idx'.$index.'#/', explode(", ", $data_source['DRD8'])[$page-1], $c_draft);
				} elseif ($kfr == 'FIS43') {
					$c_draft = preg_replace('/#idx'.$index.'-1#/', substr($data_source['FIS43'], 0, 1), $c_draft);
					$c_draft = preg_replace('/#idx'.$index.'-2#/', substr($data_source['FIS43'], 1, 1), $c_draft);
				} elseif (in_array($kfr, ['SYA1002', 'SYA1003', 'SYA1004', 'SYA1005', 'SYA1023', 'SYA1024', 'SYA1025', 'SYA1026', 'SYA1006', 'SYA1007', 'SYA1008', 'SYA1009', 'SYA1027', 'SYA1028', 'SYA1029', 'SYA1030'])) {
					$c_draft = preg_replace('/#idx'.$index.'#/', ucwords(strtolower($data_source[$kfr])), $c_draft);
				} else {
					// echo $data_source[$kfr].' '.$kfr.'<br>';
					$c_draft = preg_replace('/#idx'.$index.'#/', $data_source[$kfr], $c_draft);
				}
				$c_draft = preg_replace('/Perorangan /', '', $c_draft);
				$c_draft = preg_replace('/PMA /', '', $c_draft);
				$c_draft = preg_replace('/-Pilih Rangukuman-/', '', $c_draft);
				$index++;
			}

			$pdf->writeHTML($c_draft, true, false, true, false, '');
			$page++;

			// echo '<pre>';
			// var_dump($data_source);

		}


		//$fileName = "$id_permohonan.pdf";
		//$filelocation = "C:\\xampp\\htdocs\\silat\\be\\berkas\\data_sk_izin";//windows
        //$filelocation = base_url('/berkas/data_sk_izin'); //Linux
		//$filelocation = 'opt/lampp/htdocs/silat/be/berkas/data_sk_izin';
   		 //$filelocation = "/var/www/project/custom"; //Linux

        //$fileNL = $filelocation."\\".$fileName;
	    //$fileNL = $filelocation."/".$fileName; //Linux
	    $pdf->Output("/var/www/html/silat/be/berkas/data_sk_izin/".$id_permohonan.'.pdf', 'F');	
	}


	
	function modul_izin($jenis) {
		if($jenis == 'cetak') {
			$d['menu']  = 'Cetak SK Izin';
	        $d['page']  = 'sk_izin';
	        $d['title']	= 'Draft Permohonan Siap Cetak Draft Izin';
	        $d['aksi']  = 'cetak';

		} else if($jenis == 'pengambilan') {
			$d['menu']  = 'Pengambilan';
	        $d['page']  = 'sk_izin';
	        $d['title']	= 'Pengambilan SK / Izin';
	        $d['aksi']  = 'input';

		} else if($jenis == 'arsip') {
			$d['menu']  = 'Arsip';
	        $d['page']  = 'sk_izin';
	        $d['title']	= 'Arsip SK / Izin';
	        $d['aksi']  = 'cetak';
		}
		$this->load->view('layout', $d);
	}

	public function pdf_show($type) {
		$id_permohonan = $this->input->post('id');
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];

		$no_permohonan= $this->M_admin->get_master_spec('t_permohonan', '*', $condition)->row_array()['no_permohonan'];
		
		$obj = 'Kwitansi : <label class="label label-sm btn-teal">'.$no_permohonan.'</label><span class="pull-right"><a class="btn btn-sm btn-danger" target="_blank" href="'.base_url().'sk_izin/pdf_generate/ctk/'.$id_permohonan.'"><i class="fa fa-download"></i> Download File</a></span>
		
		<br><br><iframe width="100%" height="500px" type="application/pdf" frameborder="0" src="https://docs.google.com/gview?embedded=true&url='.base_url('sk_izin/pdf_generate/'.$type.'/'.$id_permohonan).'"</iframe>';

		echo $obj;
	}

	function pdf_generate($type, $id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];

		// if ($type == 'pvw') {
			$dPer		= $this->M_admin->get_master_spec('v_permohonan_khusus', '*', $condition)->row_array();
			$dPer['tgl_terbit'] 	= date('Y-m-d');
		// } elseif ($type == 'ctk') {
			// $dPer		= $this->M_admin->get_master_spec('v_permohonan_izin_terbit', '*', $condition)->row_array();
		// }

		$id_permohonan	= $id_permohonan;
		$id_jenis_izin	= $dPer['id_jenis_izin'];

		$condition 	= [];
		$condition[]= ['aktif', 1, 'where'];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$draft_izin	= $this->M_admin->get_master_spec('v_draft_izin', '*', $condition)->result_array();	

		$condition 		= array();
		$condition[] 	= array('id_jenis_izin', $id_jenis_izin, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_s_grup 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_grup', 'id_syarat_izin_grup', $condition)->row_array()['id_syarat_izin_grup'];

		$condition 		= array();
		$condition[] 	= array('nama_syarat_izin', 'jumlah_uang', 'where');
		$condition[] 	= array('id_syarat_izin_grup', $id_s_grup, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_sizs 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s', $condition)->row_array()['id_syarat_izin_s'];	

		$pdf = new TCPDF('P', 'cm', PDF_PAGE_FORMAT, 'true');
		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);
        $pdf->setMargins(0.5, 0.5, 0.5);
        $pdf->SetFont('times', '', '12');		

		$page= 1;
		foreach ($draft_izin as $diz) {
	        $size 	= $diz['size'];
	        if ($diz['size'] == 'Legal') {
	        	$size 	= [21.6, 35.6];
	        }

	        $pdf->AddPage($diz['position'], $size);
			$kode_formula 	= [];
			$kode_formula 	= explode(", ", $diz['list_content']);

			$data_source = [];
			$data_source = $this->data_source_draft($id_permohonan, $kode_formula);

			$data_pdf 	 = [];

			$approver 	= [];
			$approver['name'] 	= 'Drs. AMIT RIYADI, M. Si';
			$approver['stempel'] = 'stempel.png';
			$approver['nip'] 	= '19590511 198603 1 005';
			$approver['pembina'] = 'Pembina Utama Muda';
			if ($dPer['id_nama_izin'] == 5) {
				$approver['jabatan'] = 'KA. DINAS PENANAMAN MODAL & PELAYANAN';
			} else {
				$approver['jabatan'] = 'KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU';
			}

			if (strtotime($dPer['tgl_terbit']) >= strtotime('2017-12-27') && strtotime($dPer['tgl_terbit']) < strtotime('2018-01-12')) { 
				$approver['name'] 	= 'Drs. H. Rayendra Sukarmadji, M. Si';
				$approver['stempel'] = 'stempel_sekda.png';
				$approver['nip'] 	= '19580724 198603 1 007';
				$approver['pembina'] = 'Pembina Utama';
				$approver['jabatan1'] = 'Plh. KEPALA DINAS PENANAMAN MODAL';
				$approver['jabatan'] = 'DAN PELAYANAN TERPADU SATU PINTU <br>SEKRETARIS DAERAH,';
				$approver['jabatan2'] = 'DAN PELAYANAN TERPADU SATU PINTU';
				$approver['jabatan3'] = 'SEKRETARIS DAERAH,';
				} else {
				$approver['name'] 	= 'Drs. AMIT RIYADI, M. Si';
				$approver['stempel'] = 'stempel.png';
				$approver['nip'] 	= '19590511 198603 1 005';
				$approver['pembina'] = 'Pembina Utama Muda';
				$approver['jabatan1'] = 'KEPALA DINAS PENANAMAN MODAL';
				$approver['jabatan'] = 'DAN PELAYANAN TERPADU SATU PINTU';
				$approver['jabatan2'] = 'DAN PELAYANAN TERPADU SATU PINTU';
				$approver['jabatan3'] = '';
			}

			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];
			$condition[]= ['id_permohonan', $id_permohonan, 'where'];
			$condition[]= ['id_syarat_izin_s', $id_sizs, 'where'];
			$jumlah		= $this->M_admin->get_master_spec('t_syarat_izin_s', 'nilai_num', $condition)->row_array()['nilai_num'];

			$data_pdf['jumlah'] = "Rp " . number_format($jumlah, 0,',','.');
			$data_pdf['terbilang'] = ucwords($this->terbilang($jumlah). ' Rupiah');
			$data_pdf['id_permohonan'] 	= $id_permohonan;
			$data_pdf['tgl_permohonan'] 	= $this->indonesian_date($dPer['tgl_permohonan']);
			$data_pdf['bentuk_usaha'] 	= $this->get_bentuk_usaha($dPer['id_perusahaan']);
			$data_pdf['status_perusahaan'] 	= $this->get_status_perusahaan($dPer['id_perusahaan']);
			$data_pdf['id_jenis_izin'] 	= $dPer['id_jenis_izin'];
			$data_pdf['type'] 			= $type;
			$data_pdf['tgl_terbit'] 	= $dPer['tgl_terbit'];
			$data_pdf['approver'] 		= $approver;

			$c_draft 	 = $this->load->view('sk_izin/'.$diz['template'], $data_pdf, TRUE);
			$index 		 = 1;
			foreach ($kode_formula as $kfr) {
				if ($kfr == 'DRD8' && count(explode(", ", $data_source['DRD8'])) > 1) {
					$c_draft = preg_replace('/#idx'.$index.'#/', explode(", ", $data_source['DRD8'])[$page-1], $c_draft);
				} elseif ($kfr == 'FIS43') {
					$c_draft = preg_replace('/#idx'.$index.'-1#/', substr($data_source['FIS43'], 0, 1), $c_draft);
					$c_draft = preg_replace('/#idx'.$index.'-2#/', substr($data_source['FIS43'], 1, 1), $c_draft);
				} elseif (in_array($kfr, ['SYA1057', 'SYA1058', 'SYA1059', 'SYA1060', 'SYA1061', 'SYA1062', 'SYA1063', 'SYA1064', 'SYA1002', 'SYA1003', 'SYA1004', 'SYA1005', 'SYA1023', 'SYA1024', 'SYA1025', 'SYA1026', 'SYA1065', 'SYA1066', 'SYA1067', 'SYA1068', 'SYA1069', 'SYA1070', 'SYA1071', 'SYA1072', 'SYA1006', 'SYA1007', 'SYA1008', 'SYA1009', 'SYA1027', 'SYA1028', 'SYA1029', 'SYA1030'])) {
					$c_draft = preg_replace('/#idx'.$index.'#/', ucwords(strtolower($data_source[$kfr])), $c_draft);
				} else {
					// echo $data_source[$kfr].' '.$kfr.'<br>';
					$c_draft = preg_replace('/#idx'.$index.'#/', $data_source[$kfr], $c_draft);
				}
				$c_draft = preg_replace('/Perorangan /', '', $c_draft);
				$c_draft = preg_replace('/PMA /', '', $c_draft);
				$c_draft = preg_replace('/-Pilih Rangukuman-/', '', $c_draft);
				$index++;
			}

			$pdf->writeHTML($c_draft, true, false, true, false, '');
			$page++;

			// echo '<pre>';
			// var_dump($data_source);

		}
		if($type == "ctk"){
			$pdf->Output("Kwitansi_".$dPer['no_permohonan'].".pdf", 'D');	
		}else{
			$pdf->Output("Kwitansi_".$dPer['no_permohonan'].".pdf", 'I');	
		}
	}

	public function pdf_show_sertif($type) {
		$id_permohonan = $this->input->post('id');
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];

		$no_permohonan= $this->M_admin->get_master_spec('t_permohonan', '*', $condition)->row_array()['no_permohonan'];
		// $obj = '<object width="100%" height="500px" type="application/pdf" 
		// 			data="'.base_url('sk_izin/pdf_generate_sertif/'.$type.'/'.$id_permohonan).'">
		// 	  	</object>';

		$obj = 'Sertifikat : <label class="label label-sm btn-teal">'.$no_permohonan.'</label><span class="pull-right"><a class="btn btn-sm btn-danger" target="_blank" href="'.base_url().'sk_izin/pdf_generate_sertif/ctk/'.$id_permohonan.'"><i class="fa fa-download"></i> Download File</a></span>
		
		<br><br><iframe width="100%" height="500px" type="application/pdf" frameborder="0" src="https://docs.google.com/gview?embedded=true&url='.base_url('sk_izin/pdf_generate_sertif/'.$type.'/'.$id_permohonan).'"</iframe>';

		echo $obj;
	}

	function pdf_generate_sertif($type, $id_permohonan) {
		$this->load->library('mypdf');
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];

		$dPer		= $this->M_admin->get_master_spec('v_permohonan_khusus', '*', $condition)->row_array();
		$dPer['tgl_terbit'] 	= $this->indonesian_date($dPer['tgl_permohonan']);

		$id_permohonan	= $id_permohonan;
		$id_jenis_izin	= $dPer['id_jenis_izin'];

		$condition 	= [];
		$condition[]= ['aktif', 1, 'where'];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$draft_izin	= $this->M_admin->get_master_spec('v_draft_izin', '*', $condition)->result_array();	

		$pdf = new MYPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// remove default footer
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set font
		$pdf->SetFont('times', '', 16);

		// add a page
		$pdf->AddPage();

		// Print a text
		$html =  $this->load->view('sk_izin/sertif', $dPer, TRUE);
		$pdf->writeHTML($html, true, false, true, false, '');

		if($type == "ctk"){
			$pdf->Output("Sertifikat_".$dPer['no_permohonan'].".pdf", 'D');	
		}else{
			$pdf->Output("Sertifikat_".$dPer['no_permohonan'].".pdf", 'I');	
		}
	}

	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}

	function pdf_generate_ts($type, $id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$dPer		= $this->M_admin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();

		$id_permohonan	= $id_permohonan;
		$id_jenis_izin	= $dPer['id_jenis_izin'];

		$condition 	= [];
		$condition[]= ['aktif', 1, 'where'];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$draft_izin	= $this->M_admin->get_master_spec('v_draft_izin', '*', $condition)->result_array();	

		$pdf = new TCPDF('P', 'cm', PDF_PAGE_FORMAT, 'true');
		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);
        $pdf->setMargins(1.5, 0.8, 1);
        $pdf->SetFont('times', '', '11');		

		// echo '<pre>';
  //       var_dump($draft_izin);

		$page= 1;
		foreach ($draft_izin as $diz) {
	        $size 	= $diz['size'];
	        if ($diz['size'] == 'Legal') {
	        	$size 	= [21.6, 35.6];
	        }

	        $pdf->AddPage($diz['position'], $size);
			$kode_formula 	= [];
			$kode_formula 	= explode(", ", $diz['list_content']);

			$data_source = [];
			$data_source = $this->data_source_draft($id_permohonan, $kode_formula);

			$data_pdf 	 = [];

			$data_pdf['id_permohonan'] 	= $id_permohonan;
			$data_pdf['bentuk_usaha'] 	= $this->get_bentuk_usaha($dPer['id_perusahaan']);
			$data_pdf['status_perusahaan'] = $this->get_status_perusahaan($dPer['id_perusahaan']);
			$data_pdf['id_jenis_izin'] 	= $dPer['id_jenis_izin'];
			$data_pdf['type'] 			= $type;


			$c_draft 	 = $this->load->view('sk_izin/'.$diz['template'], $data_pdf, TRUE);
			$index 		 = 1;
			foreach ($kode_formula as $kfr) {
				if ($kfr == 'DRD8' && count(explode(", ", $data_source['DRD8'])) > 1) {
					$c_draft = preg_replace('/#idx'.$index.'#/', explode(", ", $data_source['DRD8'])[$page-1], $c_draft);
				} elseif ($kfr == 'FIS43') {
					$c_draft = preg_replace('/#idx'.$index.'-1#/', substr($data_source['FIS43'], 0, 1), $c_draft);
					$c_draft = preg_replace('/#idx'.$index.'-2#/', substr($data_source['FIS43'], 1, 1), $c_draft);
				} else {
					// echo $data_source[$kfr].' '.$kfr.'<br>';
					$c_draft = preg_replace('/#idx'.$index.'#/', $data_source[$kfr], $c_draft);
				}
				$c_draft = preg_replace('/Perorangan /', '', $c_draft);
				$c_draft = preg_replace('/PMA /', '', $c_draft);

				$index++;
			}

			$pdf->writeHTML($c_draft, true, false, true, false, '');
			$page++;

		echo '<pre>';
		var_dump($data_source);

		}



		/*$d_page 	= $this->session->userdata('dpage');
		if ($d_page == 'arsip') {
			$this->tandaTangan($id_permohonan, $pdf);
		}*/


		// echo htmlentities($c_draft);

	    $pdf->Output("Draft Izin", 'I');	
	}	

	function fixPDF($id_permohonan){
		/*$query =  $this->db->query('select 
					a.id_permohonan as id_permohonan, 
					b.id_jenis_izin as id_jenis_izin, 
					b.no_permohonan as no_permohonan 
					from 
					t_permohonan_final a
					LEFT JOIN t_permohonan b ON a.id_permohonan = b.id_permohonan
					where b.id_jenis_izin in(11) 
					and b.id_permohonan not in(1, 4, 5, 6, 7, 14, 18, 25, 27, 29, 30, 
	31, 33, 37, 42, 43, 45, 47, 55, 59, 61, 73, 77, 92, 103, 105, 108, 111, 114, 115, 117, 
118, 124, 127, 130, 134, 140, 142, 143, 145, 153, 157, 163, 175, 188, 192, 195, 197, 204, 
205, 206, 207, 208, 209, 215, 245, 247, 248, 261, 266, 276, 279, 285, 287, 307, 311, 328, 329, 
330, 331, 335, 336, 339, 340, 342, 348, 349, 351, 353, 354, 356, 359, 365, 366, 374, 381, 384, 386, 
388, 389, 390, 391, 393, 394, 395, 396, 398, 400, 401, 402, 406, 407, 411, 428, 433, 434, 447, 449, 4,
51, 453, 457, 462, 465, 469, 472, 490, 491, 493, 494, 495, 498, 511, 514, 515, 518, 519, 520, 542, 543, 
544, 556, 557, 563, 567, 571, 574, 580, 581, 587, 588, 592, 596, 612, 613, 616, 617, 622, 625, 626, 633, 
642, 643, 652, 653, 657, 658, 661, 672, 687, 688, 693, 697, 703, 704, 706, 708, 713, 717, 719, 738, 739, 741, 
749, 760, 763, 770, 772, 780, 782, 783, 811, 818, 822, 823, 836, 849, 863, 872, 889, 451, 891, 894, 902, 904, 
922, 925, 928, 935, 947, 949, 954, 957, 958, 989, 993, 994, 1001, 1002, 1022, 1035, 1045, 1048, 1049, 1052, 1069, 1070, 1071, 1073, 1098, 1100, 1105, 1109, 1114, 1125, 1140, 1187, 1217, 1220, 1229, 1242, 1254, 1261, 1273, 1274, 1279, 1280, 1289, 1315, 1317, 1318, 1323, 1326, 1328, 1334, 1335, 1338, 1342, 1351, 1355, 1374, 1376, 1377, 1379, 1380, 1383, 1386, 1387, 1393, 1394, 1395, 1406, 1416, 1422, 
1423, 1424, 1425, 1429, 1432, 1436, 1437, 1449, 1468, 1471, 1473, 1476, 1484, 1485, 1489, 1490)');
		$hasil = $query->num_rows();
		$data = $query->result();
		$type = 'test';
		//echo $hasil;

		foreach ($data as $row) {
			$id_permohonan = $row->id_permohonan;
			$this->pdf_frezz($type, $id_permohonan);
			echo "<pre>";
			echo $id_permohonan;
		}*/

		//$id_permohonan = 3151;
		$type = 'cek';
		$this->pdf_frezz($type, $id_permohonan);
		echo $id_permohonan;

	}



	function tandaTangan($id_permohonan, $pdf){
		$condition = [];
		$condition[] = ['id_permohonan', $id_permohonan, 'where'];
		$condition[] = ['added_by !=', null, 'where' ];

		//$p['getJumlahTTD'] = $this->M_admin->get_master_spec('v_histori_permohonan', '*', $condition)->num_rows();

		$p['getTTD'] 	  = $this->M_admin->get_master_spec('v_histori_permohonan', '*', $condition)->result();


		$page = 1;
		
		$html = $this->load->view('zly_ttd', $p, true);

			$pdf->setPrintHeader(false);
	        $pdf->setPrintFooter(false);
	        $pdf->SetHeaderMargin(false);
	        $pdf->SetFooterMargin(false);
	        $pdf->setMargins(1, 0.8, 1);
	        $pdf->SetFont('times', 'B', '12');
	        $pdf->Ln();
	        $pdf->AddPage();
	        $pdf->resetColumns();
	        $pdf->setEqualColumns(2, 84);
	        $pdf->SetFont('times', '', '11');
			return $pdf->writeHTML($html, true, false, true, false, '');


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
		// flagging
		$condition 	= [];
		$condition[]= ['kode_formula', $kode_formula, 'where_in'];
		$condition[]= ['id_jenis_izin', $id_jenis_izin, 'where_in'];
		$data_raw	= $this->M_admin->get_master_spec('t_flagging_izin', '*', $condition)->result_array();

		foreach ($data_raw as $dr) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];
			$condition[]= ['id_permohonan', $id_permohonan, 'where'];
			$condition[]= ['id_flagging_izin', $dr['id_flagging_izin'], 'where'];
			$dt			= $this->M_admin->get_master_spec('t_flagging_data', '*', $condition)->row_array();	

			$value 	= $dt['text'];

			$data_draft[$dr['kode_formula']] = $value;
		}		
		
		// syarat_izin
		$condition 	= [];
		$condition[]= ['kode_formula', $kode_formula, 'where_in'];
		$data_raw	= $this->M_admin->get_master_spec('m_syarat_izin_s', '*', $condition)->result_array();

		foreach ($data_raw as $dr) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];
			$condition[]= ['id_permohonan', $id_permohonan, 'where'];
			$condition[]= ['id_syarat_izin_s', $dr['id_syarat_izin_s'], 'where'];
			$dt			= $this->M_admin->get_master_spec($dr['table_tujuan_s'], '*', $condition)->row_array();	


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
				$value 	= $this->table_data($id_jenis_izin, $id_permohonan, $dr['id_syarat_izin_s'], 'syarat_izin');
			} elseif ($dr['jenis_input'] == 'file') {
				$value 	= '<img src="'.$dt['file_lokasi'].'/'.$dt['file_name_hash'].'" width="200">';
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
				$value 	= $this->table_data($id_jenis_izin, $id_permohonan, $dr['id_rekam_berkas_s'], 'rekam_berkas');
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
				$value 	= $this->table_data($id_jenis_izin, $id_permohonan, $dr['id_perusahaan_bio_s'], 'perusahaan_bio');
			} elseif ($dr['nama_perusahaan_bio'] == 'npwp') {	
				// npwp abal		
				$npwp 	= $dt['nilai_'.$dr['tipe_data']];
				$f1 	= substr($npwp, 0, 2);
				$f2 	= substr($npwp, 2, 3);
				$f3 	= substr($npwp, 5, 3);
				$f4 	= substr($npwp, 8, 1);
				$f5 	= substr($npwp, 9, 3);
				$f6 	= substr($npwp, 12, 3);
				$value 	= $f1.'.'.$f2.'.'.$f3.'.'.$f4.'-'.$f5.'.'.$f6;
			} else {
				$value 	= $dt['nilai_'.$dr['tipe_data']];
			}
					
			$data_draft[$dr['kode_formula']] = $value;

		}
		
		if ($dPer['id_nama_izin'] == 5) {
			$condition 	= [];
			$condition[]= ['kode_formula', $kode_formula, 'where_in'];
			$data_raw	= $this->M_admin->get_master_spec('m_syarat_izin_p', '*', $condition)->result_array();	

			foreach ($data_raw as $dr) {
				$condition 	= [];
				$condition[]= ['aktif', 1, 'where'];
				$condition[]= ['id_permohonan', $id_permohonan, 'where'];
				$condition[]= ['id_syarat_izin_p', $dr['id_syarat_izin_p'], 'where'];
				$dt			= $this->M_admin->get_master_spec('t_syarat_izin_p', '*', $condition)->row_array();	

				$value 	= $dt['nilai_'.$dr['tipe_data']];
				
				$data_draft[$dr['kode_formula']] = $value;
			}		
		}				

		// flagging
		$data_draft 	= array_merge($data_draft, $this->cek_flag($id_jenis_izin, $id_permohonan));
		
		// $data_draft['TTD'] 	= $this->page_ttd($id_permohonan);
		return $data_draft;
	}

	/*private function indonesian_date($timestamp = '', $date_format = 'j F Y', $suffix = '') {
		$date 	= null;
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
*/
	private function indonesian_date($timestamp = '', $date_format = 'j F Y', $suffix = '') {
	    if (trim ($timestamp) == '') {
	        // $timestamp = time ();
	        $timestamp = '';
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

	    if($timestamp == '') {
	    	$date = '';

	    } else {
	    	$date = date ($date_format, $timestamp);
	    	$date = preg_replace ($pattern, $replace, $date);
	    	$date = "{$date} {$suffix}";
	    }

	    return $date;
	}	
	
	function qr_code($id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$data		= $this->M_admin->get_master_spec('v_draft_data', 'nama,
						akr_identitas,
						no_identitas,
						no_permohonan,
						tgl_permohonan,
						no_izin,
						jml_tercetak,
						tgl_terbit,
						masa_berlaku,
						berlaku_sd', $condition)->row_array();

		$code 	= '';
		foreach ($data as $k => $v) {
			$code 	.= $data[$k].'~';
		}

		$this->load->library('ciqrcode');
		$config['cacheable']	= false; //boolean, the default is true
		$config['cachedir']		= ''; //string, the default is application/cache/
		$config['errorlog']		= ''; //string, the default is application/logs/
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= 1024; //interger, the default is 1024
		$config['black']		= array(224,255,255); // array, default is array(255,255,255)
		$config['white']		= array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		header("Content-Type: image/png");
		$params['data'] = $code;
		$this->ciqrcode->generate($params);
	}

	function qr_code_ts($id_permohonan) {
		$condition 	= [];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$data		= $this->M_admin->get_master_spec('v_draft_data', 'nama,
						akr_identitas,
						no_identitas,
						no_permohonan,
						tgl_permohonan,
						no_izin,
						jml_tercetak,
						tgl_terbit,
						masa_berlaku,
						berlaku_sd', $condition)->row_array();

		$code 	= '';
		foreach ($data as $k => $v) {
			$code 	.= $data[$k].'~';
		}

		// echo $code;
		// exit();
		// $code 		= 'TEUKU BUSTAMAN~~3216052705620001~PHN23080800199~2017-08-23~~~~~~';

		$this->load->library('ciqrcode');
		$config['cacheable']	= false; //boolean, the default is true
		$config['cachedir']		= ''; //string, the default is application/cache/
		$config['errorlog']		= ''; //string, the default is application/logs/
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= 1024; //interger, the default is 1024
		$config['black']		= array(224,255,255); // array, default is array(255,255,255)
		$config['white']		= array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		header("Content-Type: image/png");
		$params['data'] = $code;
		$this->ciqrcode->generate($params);
	}	

	function table_data($id_jenis_izin, $id_permohonan, $id, $type) {
		$condition 	= [];
		$condition[]= ['id_'.$type.'_s', $id, 'where'];
		$condition[]= ['kd_'.$type.'_p', 'ASC', 'order_by'];
		$data_p		= $this->M_admin->get_master_spec('m_'.$type.'_p', 'id_'.$type.'_p, teks_judul, tipe_data, grouping, numbering', $condition)->result_array();	

		$content 	= '<style>
					  .l { border-left: 1px solid black; }
					  .t { border-top: 1px solid black; }
					  .r { border-right: 1px solid black; }
					  .b { border-bottom: 1px solid black; }
					</style>';
		$content 	.= '<table style="width: 100%; height: 10px; margin-left: 50%; margin-right: auto;line-height: 15px;">';
		$content 	.= '<thead>';
		$content 	.= '<tr>';
		$content 	.= '<td width="45">&nbsp;</td>';
		$content 	.= '<td class="l r t b" width="45">No</td>';

		foreach ($data_p as $dp) {
			$content 	.= '<td class="l r t b" >'.$dp['teks_judul'].'</td>';
		}

		$content 	.= '</tr>';
		$content 	.= '</thead>';

		$condition 	= [];
		$condition[]= ['id_'.$type.'_s', $id, 'where'];
		$condition[]= ['id_permohonan', $id_permohonan, 'where'];
		$condition[]= ['aktif', 1, 'where'];
		$index		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'max(`index`) as `index`', $condition)->row_array()['index'];			

		$content 	.= '<tbody>';

		$no = 1;
		for ($a=1;$a<=$index;$a++) {
			$content 	.= '<tr>';
			$content 	.= '<td width="45">&nbsp;</td>';

			//NUMBERING
			foreach ($data_p as $dp) {
				$condition 	= [];
				$condition[]= ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
				$condition[]= ['id_permohonan', $id_permohonan, 'where'];
				$condition[]= ['aktif', 1, 'where'];
				
				if($dp['numbering'] == 1) {
					$condition[]= ['index', $a, 'where'];
					$value		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'nilai_'.$dp['tipe_data'].' as value', $condition)->row_array()['value'];

					$condition2 	= [];
					$condition2[]   = ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
					$condition2[]   = ['id_permohonan', $id_permohonan, 'where'];
					$condition2[]   = ['nilai_'.$dp['tipe_data'], $value, 'where'];
					$condition2[]   = ['aktif', 1, 'where'];
					$min_idx		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'min(`index`) as `min_idx`', $condition2)->row_array()['min_idx'];

					$condition3   = [];
					$condition3[] = ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
					$condition3[] = ['id_permohonan', $id_permohonan, 'where'];
					$condition3[] = ['nilai_'.$dp['tipe_data'], $value, 'where'];
					$condition3[] = ['aktif', 1, 'where'];
					$count		  = $this->M_admin->get_master_spec('t_'.$type.'_p', 'count(nilai_'.$dp['tipe_data'].') as count', $condition3)->row_array()['count'];

					if($a == $min_idx) {
						$content 	.= 	'<td class="l r b" width="45" rowspan="'.$count.'">'.$no++.'</td>';
					} else {
						$content 	.= 	'';						
					}
				}
			}
			
			//DATA
			foreach ($data_p as $dp) {
				$condition 	= [];
				$condition[]= ['index', $a, 'where'];
				$condition[]= ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
				$condition[]= ['id_permohonan', $id_permohonan, 'where'];
				$condition[]= ['aktif', 1, 'where'];
				
				//GROUPING
				if($dp['grouping'] == 1) {
					$condition[]= ['index', $a, 'where'];
					$value		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'nilai_'.$dp['tipe_data'].' as value', $condition)->row_array()['value'];

					$condition2 	= [];
					$condition2[]   = ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
					$condition2[]   = ['id_permohonan', $id_permohonan, 'where'];
					$condition2[]   = ['nilai_'.$dp['tipe_data'], $value, 'where'];
					$condition2[]   = ['aktif', 1, 'where'];
					$min_idx		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'min(`index`) as `min_idx`', $condition2)->row_array()['min_idx'];

					$condition3   = [];
					$condition3[] = ['id_'.$type.'_p', $dp['id_'.$type.'_p'], 'where'];
					$condition3[] = ['id_permohonan', $id_permohonan, 'where'];
					$condition3[] = ['nilai_'.$dp['tipe_data'], $value, 'where'];
					$condition3[] = ['aktif', 1, 'where'];
					$count		  = $this->M_admin->get_master_spec('t_'.$type.'_p', 'count(nilai_'.$dp['tipe_data'].') as count', $condition3)->row_array()['count'];

					if($a == $min_idx) {
						$content 	.= 	'<td class="l r b" rowspan="'.$count.'">'.$value.'</td>';
					} else {
						$content 	.= 	'';						
					}

				//GENERAL
				} else {
					$value		= $this->M_admin->get_master_spec('t_'.$type.'_p', 'nilai_'.$dp['tipe_data'].' as value', $condition)->row_array()['value'];	

					$content 	.= 	'<td class="l r b" >'.$value.'</td>';
				}

			}
			$content 	.= '</tr>';
		}
		$content 	.= '</tbody>';
		$content 	.= '</table>';

		return $content;
		// echo $id_jenis_izin.' '.$id_permohonan;

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

	function get_bentuk_usaha($id_perusahaan) {
		$kode_formulabu = 'PRH94';

		$condition[] 	= ['kode_formula', $kode_formulabu, 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $id_perusahaan, 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_perusahaan_bio_p= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_p'], 'id_perusahaan_bio_p', $condition)->row_array()['id_perusahaan_bio_p'];		

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_p', $id_perusahaan_bio_p, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_p', 'nama_perusahaan_bio_p', $condition)->row_array()['nama_perusahaan_bio_p'];						

		return $value;
	}		

	function get_status_perusahaan($id_perusahaan) {
		$kode_formula = 'PRH21';

		$condition[] 	= ['kode_formula', $kode_formula, 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $id_perusahaan, 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_perusahaan_bio_p= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_p'], 'id_perusahaan_bio_p', $condition)->row_array()['id_perusahaan_bio_p'];		

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_p', $id_perusahaan_bio_p, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_p', 'teks_judul', $condition)->row_array()['teks_judul'];						

		return $value;
	}		



}