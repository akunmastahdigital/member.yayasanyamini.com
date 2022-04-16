<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permohonan_izin extends MY_Controller {
	function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id_user')) {
        	redirect('user/login');
        }
	}

	function index() {
        show_404();
	}

	function input_manual(){
        $d['page']      = 'input manual';
		$d['nama_user'] = $this->session->userdata('nm_user');
		$condition 		= array();
		$condition[] 	= array('id_nama_izin', 1, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$condition[] 	= array('show', 1, 'where');
		$d['option'] 	= $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'id_jenis_izin, teks_menu', $condition)->result_array();
		
		$this->load->view('layout', $d);

	}

	public function show_permohonan_khusus() {
		$table          = 'v_permohonan_khusus';
		$id_user 		= $this->session->userdata('id_user');
		$id_role 		= $this->session->userdata('id_role');

		unset($condition);
		$condition 		= array();

		if($id_role == 3){
			$condition[]  = array('id_user_bo', $id_user, 'where');
		}else{
			$condition[]  = array('id_workflow_decision !=', null, 'where');
		}


        $column_order   = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin', null);
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin','jenis_izin');
        $order          = array('waktu_in' => 'desc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$id_aktivitas_workflow_next	= $this->get_next_workflow_2($ld->id_workflow_decision, $ld->id_jenis_izin, $ld->id_aktivitas_workflow);
            $no++;
            $row = array();

			if(in_array($ld->id_jenis_izin, [1, 2, 3])){
				$btn_sertif = ' <button style="margin-right:5px;" type="button" data-id="'.$ld->id_permohonan.'" class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover tooltipstered" onclick="showDraftSertif(this)" title="Preview Sertifikat"><i class="fa fa-file-text-o"></i> Sertif
				</button>';
			}else{
				$condition 		= array();
				$condition[] 	= array('id_permohonan', $ld->id_permohonan, 'where');
				$condition[] 	= array('id_jenis_izin', [1,2,3], 'where_in');
				$cek_multi_ziswaf_zakat 	= $this->M_permohonan_izin->get_master_spec('t_multiple_ziswaf', '*', $condition)->result_array();
				if(count($cek_multi_ziswaf_zakat) > 0){
					$btn_sertif = ' <button style="margin-right:5px;" type="button" data-id="'.$ld->id_permohonan.'" class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover tooltipstered" onclick="showDraftSertif(this)" title="Preview Sertifikat"><i class="fa fa-file-text-o"></i> Sertif
					</button>';
				}else{
					$btn_sertif = '';
				}
				// $btn_sertif = '';
			}


			if($ld->id_aktivitas != 14){
				$label = 'Menunggu '.$ld->nm_aktivitas_workflow;
				$btn = '';
			}else{
				$label = '<label class="label label-sm label-teal">'.$ld->nm_aktivitas_workflow.'</label>';
				$btn = '<button style="margin-right:5px;" type="button" data-id="'.$ld->id_permohonan.'" class="btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered" onclick="showDraft(this)" title="Preview Kwitansi"> <i class="fa fa-file-pdf-o"></i> Kwitansi </button>'.$btn_sertif;
			}

            // $row[] = $no;
            $row[] = '<input type="hidden" name="id_aktivitas_workflow_next[]" value="'.$id_aktivitas_workflow_next.'">'.$ld->no_permohonan;
            $row[] = $this->indonesian_date(date('d-m-Y', strtotime($ld->tgl_permohonan)));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
			$row[] = $label;
			$row[] = '<center><a href="'.base_url().'permohonan_izin/detail?no_permohonan='.$ld->no_permohonan.'&ro=true" class="btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered" title="Detail Ziswaf"><i class="fa fa-search"></i> Lihat</a>&nbsp; '.$btn.'</center>';

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

	function submit_manual(){
		
		$nama_relawan = $this->input->post('nm_user');
		$id_user = $this->input->post('id_user');
		$id_jenis_izin = $this->input->post('jenis_ziswaf');
		$nama_muzakki = $this->input->post('nama_muzakki');
		$alamat_muzakki = $this->input->post('alamat_muzakki');
		$no_hp_muzakki = $this->input->post('no_hp_muzakki');
		$email_muzakki = $this->input->post('email_muzakki');
		$jmlh_transaksi = $this->input->post('jmlh_transaksi');
		$tgl_transaksi = $this->input->post('tgl_transaksi');
		$jenis_infaq = $this->input->post('jenis_infaq');
		$keterangan = $this->input->post('keterangan');

		$dsi = [];
		$dpmhn = [];

		$dsi['id_user_fe'] 			= 0;
		$dsi['nama']		     	= $nama_muzakki;
		$dsi['alamat']         	 	= $alamat_muzakki;
		$dsi['no_telp']	    	    = $no_hp_muzakki;
		$dsi['email']	    	    = $email_muzakki;

		$id_pemohon = $this->M_core->insert_tbl_normal('t_pemohon', $dsi);

		$dpmhn['id_pemohon'] 		= $id_pemohon;
		$dpmhn['id_jenis_izin'] 	= $id_jenis_izin;
		$dpmhn['id_user_bo']		= $id_user;
		$dpmhn['tgl_permohonan']    = date('Y-m-d H:i:s', strtotime($tgl_transaksi));
		$dpmhn['aktif']		     	= 1;

		$id_permohonan = $this->M_core->insert_tbl_normal('t_permohonan', $dpmhn);

		$condition 		= array();
		$condition[] 	= array('id_jenis_izin', $id_jenis_izin, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_s_grup 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_grup', 'id_syarat_izin_grup', $condition)->row_array()['id_syarat_izin_grup'];

		$condition 		= array();
		$condition[] 	= array('nama_syarat_izin', 'upld_bukti_bayar', 'where');
		$condition[] 	= array('id_syarat_izin_grup', $id_s_grup, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_upload 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s', $condition)->row_array()['id_syarat_izin_s'];


		$dS['id_permohonan']		= $id_permohonan;
		$dS['id_syarat_izin_s']		= $id_upload;
		$dS['index']				= 1;

		$nama_input = $_FILES['file_upload']['tmp_name'];

		$path 	= '/berkas/berkas_permohonan';
		$config = [
			'upload_path' 	=> '.'.$path,
			'allowed_types' => 'pdf|png|jpg|jpeg',
			// 'max_size' 		=> '6000',
			'max_size' 		=> '8000',
			'file_name' 	=> $_FILES['file_upload']['name'],
			'encrypt_name' 	=> TRUE
		];
		$this->upload->initialize($config);

		if($this->upload->do_upload("file_upload")) {
			$dS['file_lokasi']		= base_url().substr($path, 1);
			$dS['file_name_asli']	= $this->upload->data('orig_name');
			$dS['file_name_hash']	= $this->upload->data('file_name');
			$ins_dS = $this->M_core->insert_tbl_normal("t_syarat_izin_f", $dS);
		}

		$condition 		= array();
		$condition[] 	= array('nama_syarat_izin', 'jumlah_uang', 'where');
		$condition[] 	= array('id_syarat_izin_grup', $id_s_grup, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_jmlh_uang 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s', $condition)->row_array()['id_syarat_izin_s'];

		$dSU['id_permohonan']		     = $id_permohonan;
		$dSU['id_syarat_izin_s']         = $id_jmlh_uang;
		$dSU['nilai_string']			 = $jmlh_transaksi;
		$dSU['nilai_num']			 	 = str_replace(".", "", $jmlh_transaksi);
		$dSU['index']	    	         = 1;

		$ins_dSU = $this->M_core->insert_tbl_normal('t_syarat_izin_s', $dSU);

		$condition 		= array();
		$condition[] 	= array('nama_syarat_izin', 'tgl_transaksi', 'where');
		$condition[] 	= array('id_syarat_izin_grup', $id_s_grup, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_tgl_transaksi 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s', $condition)->row_array()['id_syarat_izin_s'];

		$dSUi['id_permohonan']		     = $id_permohonan;
		$dSUi['id_syarat_izin_s']        = $id_tgl_transaksi;
		$dSUi['nilai_string']			 = $tgl_transaksi;
		$dSUi['index']	    	         = 1;

		$ins_dSUi = $this->M_core->insert_tbl_normal('t_syarat_izin_s', $dSUi);

		$condition 		= array();
		$condition[] 	= array('nama_syarat_izin', 'keterangan', 'where');
		$condition[] 	= array('id_syarat_izin_grup', $id_s_grup, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_keterangan 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s', $condition)->row_array()['id_syarat_izin_s'];

		$dSUi['id_permohonan']		     = $id_permohonan;
		$dSUi['id_syarat_izin_s']        = $id_keterangan;
		$dSUi['nilai_string']			 = $keterangan;
		$dSUi['index']	    	         = 1;

		$ins_dSUi = $this->M_core->insert_tbl_normal('t_syarat_izin_s', $dSUi);

		if($id_jenis_izin == 5){
			$condition 		= array();
			$condition[] 	= array('nama_syarat_izin', 'jenis_infaq', 'where');
			$condition[] 	= array('id_syarat_izin_grup', $id_s_grup, 'where');
			$condition[] 	= array('aktif', 1, 'where');
			$id_jns_infaq 	= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s', $condition)->row_array()['id_syarat_izin_s'];

			$dSUi['id_permohonan']		     = $id_permohonan;
			$dSUi['id_syarat_izin_s']        = $id_jns_infaq;
			$dSUi['nilai_string']			 = $jenis_infaq;
			$dSUi['index']	    	         = 1;

			$ins_dS = $this->M_core->insert_tbl_normal('t_syarat_izin_s', $dSUi);
		}

		if($this->input->post('jenis_multi_ziswaf')){
			$count = count($this->input->post('jenis_multi_ziswaf'));
			
			for ($i=0; $i < $count; $i++) { 
				$mtz['id_permohonan']		= $id_permohonan;
				$mtz['id_jenis_izin']		= $this->input->post('jenis_multi_ziswaf')[$i];
				$mtz['jenis_infaq']		= $this->input->post('jenis_infaq_multi')[$i];
				$mtz['sub_total']		= str_replace(".", "", $this->input->post('jmlh_transaksi_multi')[$i]);
				$mtz['index']	= $i + 1;
				$mtz['added_by']	= $id_user;
				$mtz['aktif']	= 1;
				$this->M_core->insert_tbl_normal("t_multiple_ziswaf", $mtz);		
			}
		}

		$condition 		= array();
		$condition[] 	= array('id_jenis_izin', $id_jenis_izin, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_workflow 	= $this->M_permohonan_izin->get_master_spec('t_workflow', 'id_workflow', $condition)->row_array()['id_workflow'];

		$condition 		= array();
		$condition[] 	= array('id_workflow', $id_workflow, 'where');
		$condition[] 	= array('id_aktivitas', 43, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_akt_first 	= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->row_array()['id_aktivitas_workflow'];

		$condition 		= array();
		$condition[] 	= array('id_workflow', $id_workflow, 'where');
		$condition[] 	= array('id_aktivitas', 5, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$id_akt_second 	= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->row_array()['id_aktivitas_workflow'];

		$dhp['id_permohonan']		= $id_permohonan;
		$dhp['id_workflow_decision']	= null;
		$dhp['id_aktivitas_workflow']	= $id_akt_first;
		$dhp['id_user']	= $id_user;
		$dhp['added_by']	= null;
		$dhp['aktif']	= 1;
		$this->M_core->insert_tbl_normal("t_histori_permohonan", $dhp);

		$dhp['id_aktivitas_workflow']	= $id_akt_second;
		$dhp['id_user']	= 2;
		$dhp['added_by']	= $id_user;
		$this->M_core->insert_tbl_normal("t_histori_permohonan", $dhp);

		// response
		$this->session->set_flashdata("tipe-alert", "success");
		$this->session->set_flashdata("teks-alert", "Data Laporan Zakat / Donasi Berhasil Disimpan");
		$this->session->set_flashdata("icon-alert", "fa fa-check-circle");

		redirect('permohonan_izin/input_manual');
	}

	function disposisi() {
		// set session list permohonan
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$this->session->set_userdata('list_permohonan', $uri1.'/'.$uri2);

        $d['page']      	= 'disposisi';

        $id_user 		= $this->session->userdata('id_user');

		$page 			= $this->uri->segment(3);
		$condition 		= array();
		$condition[] 	= array('param', $page, 'where');
		$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];

		$condition 		= array();
		$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
		$condition[] 	= array('id_user', $id_user, 'where');
   		$iawArr[]  	   = null;
        foreach ($id_aktivitas_workflows as $iaw) {
   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
		}
		$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');

        $jml_tugas   		= $this->M_permohonan_izin->get_data('v_show_permohonan', $condition)->num_rows();

        $d['jml_tugas']     = $jml_tugas;
		$this->load->view('layout', $d);
	}

	public function show_disposisi() {
		$table          = 'v_show_permohonan';
		$id_user 		= $this->session->userdata('id_user');

		$page 			= $this->input->post('page');
		$condition 		= array();
		$condition[] 	= array('param', $page, 'where');
		$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];

		$condition 		= array();
		$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
		$condition[] 	= array('id_user', $id_user, 'where');
		$iawArr[]  	   = null;
        foreach ($id_aktivitas_workflows as $iaw) {
   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
		}
		$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');

        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string', 'nama_izin', null);
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin','jenis_izin');
        $order          = array('tgl_permohonan' => 'asc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$id_aktivitas_workflow_next	= $this->get_next_workflow_2(null, $ld->id_jenis_izin, $ld->id_aktivitas_workflow);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<input type="hidden" name="id_aktivitas_workflow_next[]" value="'.$id_aktivitas_workflow_next.'">'.$ld->no_permohonan;
            $row[] = date('d-m-Y', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$ld->nama_izin.' - '.$ld->jenis_izin;
            $row[] = '<select class="form-control select_delegasi" data-id_aktivitas_workflow="'.$id_aktivitas_workflow_next.'" name="id_user_select[]">
            			<option value="0">-Pilih Evaluator-</option>
            		  </select>';

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

	function delegasikan() {
		$id_aktivitas_workflow_next 	= $this->input->post('id_aktivitas_workflow_next');
		$id_user_select 				= $this->input->post('id_user_select');
		$id_permohonan 					= $this->input->post('id_permohonan');
		$page 							= $this->input->post('page');

		$jml_input 	= count($id_user_select);

		$data = [];
		for ($a=0; $a<$jml_input; $a++) {
			if($id_user_select[$a] != 0) {
				$data[$a] = array(
							'id_permohonan' 	=> $id_permohonan[$a],
							'id_user' 			=> $id_user_select[$a],
							'id_aktivitas_workflow' => $id_aktivitas_workflow_next[$a],
							'added_by'      => $this->session->userdata('id_user')
						);
				$insert_hisdel = $this->M_permohonan_izin->insert_histori_delegasi($data[$a]);
			}
		}
		redirect($page);
	}

	function verifikasi() {
		// set session list permohonan
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$this->session->set_userdata('list_permohonan', $uri1.'/'.$uri2);

		$id_user 		= $this->session->userdata('id_user');
		$id_role 		= $this->session->userdata('id_role'); 

		$page 			= $this->uri->segment(2);
		$condition 		= array();
		$condition[] 	= array('param', $page, 'where');
		$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];

		$condition 		= array();
		$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
		$condition[] 	= array('id_user', $id_user, 'where');
		$iawArr 		= null;
		foreach ($id_aktivitas_workflows as $iaw) {
   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
		}
		$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');

        $jml_tugas   		= $this->M_permohonan_izin->get_data('v_show_permohonan', $condition)->num_rows();

        $d['jml_tugas']     = $jml_tugas;
        $d['page']      	= 'verifikasi';

		if($id_role == 2){
			
		}

		$this->load->view('layout', $d);
		// echo $kd_aktivitas;
		// var_dump($id_aktivitas_workflows);
	}

	function pembayaran() {
		// set session list permohonan
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$this->session->set_userdata('list_permohonan', $uri1.'/'.$uri2);

		$id_user 		= $this->session->userdata('id_user');

		$page 			= $this->uri->segment(2);
		$condition 		= array();
		$condition[] 	= array('param', $page, 'where');
		$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];

		$condition 		= array();
		$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
		$condition[] 	= array('id_user', $id_user, 'where');
		$iawArr 		= null;
		foreach ($id_aktivitas_workflows as $iaw) {
   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
		}
		$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');

        $jml_tugas   		= $this->M_permohonan_izin->get_data('v_show_permohonan', $condition)->num_rows();

        $d['jml_tugas']     = $jml_tugas;
        $d['page']      	= 'verifikasi';
		$this->load->view('layout', $d);
		// echo $kd_aktivitas;
		// var_dump($id_aktivitas_workflows);
	}

	function evaluasi($page) {
		// set session list permohonan
		$uri1 = $this->uri->segment(1);
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$this->session->set_userdata('list_permohonan', $uri1.'/'.$uri2.'/'.$uri3);

		$id_user 		= $this->session->userdata('id_user');

		$condition 		= array();
		$condition[] 	= array('param', $page, 'where');
		$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];

		$condition 		= array();
		$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
		$condition[] 	= array('id_user', $id_user, 'where');
		$iawArr 		= null;
		foreach ($id_aktivitas_workflows as $iaw) {
   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
		}
		$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');

        $jml_tugas   		= $this->M_permohonan_izin->get_data('v_show_permohonan', $condition)->num_rows();

		$condition = [];
		$condition[] = ['id_workflow_decision !=', null, 'where'];
        $jml_done   		= $this->M_permohonan_izin->get_data('v_permohonan_khusus', $condition)->num_rows();

        $d['jml_tugas']     = $jml_tugas;
        $d['jml_done']     = $jml_done;
		$d['page']       	= 'evaluasi';
		$this->load->view('layout', $d);
	}

	public function show_permohonan() {
		$table          = 'v_show_permohonan';
		$id_user 		= $this->session->userdata('id_user');

		$page 			= $this->input->post('page');
		$condition 		= array();
		$condition[] 	= array('param', $page, 'where');
		$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];
		// $kd_aktivitas 	= 20;

		unset($condition);
		$condition 		= array();
		$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
		$condition[] 	= array('id_user', $id_user, 'where');
		$iawArr 		= null;
        foreach ($id_aktivitas_workflows as $iaw) {
   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
		}
		$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');


        $column_order   = array(null, 'no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin', null);
        $column_search  = array('no_permohonan','tgl_permohonan','nama_pemohon','nilai_string','nama_izin','jenis_izin');
        $order          = array('tgl_permohonan' => 'asc');

        $list_data   	= $this->M_permohonan_izin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$id_aktivitas_workflow_next	= $this->get_next_workflow_2($ld->id_workflow_decision, $ld->id_jenis_izin, $ld->id_aktivitas_workflow);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<input type="hidden" name="id_aktivitas_workflow_next[]" value="'.$id_aktivitas_workflow_next.'">'.$ld->no_permohonan;
            $row[] = $this->indonesian_date(date('d-m-Y', strtotime($ld->tgl_permohonan)));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = '<input type="hidden" name="id_permohonan[]" value="'.$ld->id_permohonan.'">'.$this->get_jenis_izin($ld->id_jenis_izin);
            // $row[] = $this->get_button($id_user, $ld->id_aktivitas_workflow, $ld->id_permohonan, $ld->no_permohonan, 'btn-xs'); 
			$row[] = '<span style="display:block;" class="init-spin text-center" 
							data-user="'.$id_user.'" 
							data-awk="'.$ld->id_aktivitas_workflow.'"
							data-permohonan="'.$ld->id_permohonan.'"
							data-phn="'.$ld->no_permohonan.'"
							data-size="btn-xs">
						<img src="'.base_url().'/berkas/core/images/loading3.gif" alt="Loading" height="22px">
					  </span>';

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

	public function get_button_ajax() {
		$id_user				= $this->input->post('user');
		$id_aktivitas_workflow	= $this->input->post('awk');
		$id_permohonan			= $this->input->post('permohonan');
		$no_permohonan			= $this->input->post('phn');
		$size 					= $this->input->post('size');
		$button 				= $this->get_button($id_user, $id_aktivitas_workflow, $id_permohonan, $no_permohonan, $size); 

		echo json_encode($button);
	}

	function akt_action($action) {
		$id_permohonan 		= $this->input->post('permohonan');
		$id_aktivitas_workflow 	= $this->input->post('aktivitas');
		$id_workflow_decision 	= $this->input->post('decision');
		$catatan 			= $this->input->post('catatan');
		$page 				= $this->input->post('page');

		$id_user 			= $this->session->userdata('id_user');

		$condition 			= array();
		$condition[] 		= array('id_permohonan', $id_permohonan, 'where');
		$id_jenis_izin 		= $this->M_permohonan_izin->get_master_spec('t_permohonan', 'id_jenis_izin', $condition)->row_array()['id_jenis_izin'];

		unset($condition);
		$condition 			= array();
		$condition[] 		= array('id_permohonan', $id_permohonan, 'where');
		$v_permohonan_izin 	= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'no_permohonan, id_pemohon, id_user_fe, id_nama_izin', $condition)->row_array();
		$no_permohonan   	= $v_permohonan_izin['no_permohonan'];
		$id_pemohon			= $v_permohonan_izin['id_pemohon'];
		$id_user_fe			= $v_permohonan_izin['id_user_fe'];
		$id_nama_izin		= $v_permohonan_izin['id_nama_izin'];


		if ($action == "aprv") {
			$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
			$id_user_next 				= $this->get_next_user($id_aktivitas_workflow_next);
			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> $id_user_next,
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);
		} elseif ($action == "pndg") {
			$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> $id_user,
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);

		} elseif ($action == "rjct") {
			$id_aktivitas_workflow_next	= $this->get_workflow_spec($id_aktivitas_workflow, 38);
			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> $id_user,
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);

		} elseif ($action == "vw") {
			$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
			$id_user_next 				= $this->get_next_user($id_aktivitas_workflow_next);
			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> $id_user_next,
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);
		} elseif ($action == "prm_pbyr") {
			$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
			$id_user_next 				= $this->get_next_user($id_aktivitas_workflow_next);
			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> $id_user_next,
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);
		} elseif ($action == "pdg_ver") {
			$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
			$id_user_next 				= $this->get_last_user($id_aktivitas_workflow_next, $id_permohonan);
			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> $id_user_next,
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);
		}

		if($action == 'hps'){
			$condition   = [];
			$condition[] = ['id_permohonan', $id_permohonan, 'where'];
			$condition[] = ['aktif', 1, 'where'];
			$hapus_prmhn = $this->M_core->update_tbl('t_permohonan', ['aktif' => 0], $condition);

			$data 	= array(
						'id_permohonan' 	=> $id_permohonan,
						'id_user' 			=> 2,
						'id_aktivitas_workflow'	=> 0,
						'catatan'			=> $catatan,
						'id_workflow_decision'	=> $id_workflow_decision,
						'added_by'      => $this->session->userdata('id_user')
					);
		}else{
			$this->M_permohonan_izin->insert_histori($data);
			// terbitkan nomor izin & send notif
			$data['no_permohonan'] 			= $no_permohonan;
			$data['id_permohonan'] 			= $id_permohonan;
			$data['id_pemohon'] 			= $id_pemohon;
			$data['id_user_fe'] 			= $id_user_fe;
			$data['id_aktivitas_workflow'] 	= $id_aktivitas_workflow;
			$data['id_workflow_decision'] 	= $id_workflow_decision;
			$data['id_jenis_izin'] 			= $id_jenis_izin;
			$data['id_nama_izin'] 			= $id_nama_izin;
	
			$this->cek_config_terbit($data);
			$this->cek_config_terbit_skrd($data);
			$this->cek_config_ret_save($data);
			$this->cek_config_frz_skrd($data);
			$this->send_response($data);
		}

		if ($page != '') {
			$condition 		= array();
			$condition[] 	= array('param', $page, 'where');
			$kd_aktivitas 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'kd_aktivitas', $condition)->row_array()['kd_aktivitas'];

			unset($condition);
			$condition 		= array();
			$id_aktivitas_workflows 	= $this->M_permohonan_izin->get_id_workflows($kd_aktivitas)->result_array();
			$condition[] 	= array('id_user', $id_user, 'where');
			$iawArr 		= null;
	        foreach ($id_aktivitas_workflows as $iaw) {
	   			$iawArr[]  = $iaw['id_aktivitas_workflow'];
			}
			$condition[]  = array('id_aktivitas_workflow', $iawArr, 'where_in');

	        $jml_tugas   		= $this->M_permohonan_izin->get_data('v_permohonan_izin', $condition)->num_rows();
			echo json_encode(array($jml_tugas));
		} else {
			$condition 		= array();
			$condition[] 	= array('id_aktivitas_workflow', $id_aktivitas_workflow, 'where');
			$id_aktivitas 	= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas', $condition)->row_array()['id_aktivitas'];

			unset($condition);
			$condition 		= array();
			$condition[] 	= array('id_aktivitas', $id_aktivitas, 'where');
			$param_page 	= $this->M_permohonan_izin->get_master_spec('m_aktivitas', 'param', $condition)->row_array()['param'];
			echo json_encode(array($param_page));
		}

	}

	// retribusi
	function ret_perhitungan() {
		$no_permohonan 		= $this->input->get('no_permohonan');

    	$condition 			= array();
		$condition[] 		= array('no_permohonan', $no_permohonan, 'where');
		$dPer				= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'id_nama_izin, nama_izin, jenis_izin, id_jenis_izin, id_perusahaan, id_permohonan, nama_pemohon, id_pemohon, id_aktivitas_workflow', $condition)->row_array();

		$id_user 			= $this->session->userdata('id_user');
		$id_permohonan 		= $dPer['id_permohonan'];
		$id_aktivitas_workflow = $dPer['id_aktivitas_workflow'];
		$id_pemohon 		= $dPer['id_pemohon'];

		$d['page']      	= 'perhitungan';
		$d['menu']      	= 'Perhitungan Retribusi';
		$d['title']      	= 'Perhitungan Retribusi';

		$p['desc']      	= 'Nama : '.$dPer['nama_pemohon'];
		$p['permission']	= 1;
		$p['nama_izin']   	= $dPer['nama_izin'];
		$p['jenis_izin']   	= $dPer['jenis_izin'];
		$p['id_jenis_izin'] = $dPer['id_jenis_izin'];
		$p['id_permohonan'] = $dPer['id_permohonan'];
		$p['no_permohonan'] = $no_permohonan;

		// detect jenis retribusi
		$condition 			= [];
		$condition[] 		= ['aktif', 1, 'where'];
		$condition[] 		= ['id_jenis_izin', $dPer['id_jenis_izin'], 'where'];
		$get_tfret 			= $this->M_core->get_tbl('m_ret_tarif', '*', $condition);

		// ret simple
		if($get_tfret->num_rows() != 0) {
			//detect retribusi
			$condition 			 = [];
			$condition[] 		 = ['aktif', 1, 'where'];
			$condition[] 		 = ['id_permohonan', $dPer['id_permohonan'], 'where'];
			$detect_ret 		 = $this->M_core->get_tbl('t_ret_tarif', '*', $condition);
			if($detect_ret->num_rows() != 0) {
				$p['permission'] = 0;
				$dtcret 		= $detect_ret->row_array();
				$p['tarif']  	= $dtcret['tarif'];
			} else {
				$p['permission'] = 1;
				$dtfret 		= $get_tfret->row_array();
				$p['tarif']  	= $dtfret['tarif'];
			}

			$d['ret'] = $this->load->view('retribusi/ret_simple', $p, true);
		}

		// ret kompleks
		else {

			//imb
			if($dPer['id_nama_izin'] == 6) {
				// get tarif
				$condition 			= [];
				$condition[] 		= ['aktif', 1, 'where'];
				$p['get_tarif']		= $this->M_core->get_tbl('m_ret_jenis_tarif', '*', $condition);

				//get koef
				$arr_koef = [];
				$arr_koef = ['kj' => 1, 'gb' => 2, 'lb' => 3, 'tb' => 4, 'ja' => 5, 'jt' => 6, 'ret' => 7];
				foreach($arr_koef as $k => $v) {
					$condition 			 = [];
					$condition[] 		 = ['aktif', 1, 'where'];
					$condition[] 		 = ['id_ret_jenis_koef', $v, 'where'];
					$condition[] 		 = ['id_jenis_izin', $dPer['id_jenis_izin'], 'where'];
					$p['get_koef'][$k] = $this->M_core->get_tbl('m_ret_nilai_koef', '*', $condition);
				}

				//detect retribusi
				$condition 			 = [];
				$condition[] 		 = ['aktif !=', 3, 'where'];
				$condition[] 		 = ['id_permohonan', $dPer['id_permohonan'], 'where'];
				$detect_ret 		 = $this->M_core->get_tbl('t_ret_biaya_item', '*', $condition);
				if($detect_ret->num_rows() != 0) {
					$p['status'] = 'exist';
				} else {
					$p['status'] = 'not_exist';
				}

				if($p['status'] == 'exist') {
					$d['ret'] 		= $this->load->view('retribusi/ret_imb_x', $p, true);
				}
				if($p['status'] == 'not_exist') {
					$d['ret'] 		= $this->load->view('retribusi/ret_imb', $p, true);
				}
			}
		}

		$d['button']      	= $this->get_button($id_user, $id_aktivitas_workflow, $id_permohonan, $no_permohonan, 'btn-lg');
		$this->load->view('layout', $d);
	}

	function ret_submit_perhitungan_s($no_permohonan) {
		// $no_permohonan = $this->input->post('no_permohonan');

		// get permohonan
		$condition 	 = [];
		$condition[] = ['no_permohonan', $no_permohonan, 'where'];
		$vpi 		 = $this->M_core->get_tbl('v_permohonan_izin', '*', $condition)->row_array();
		
		// get tarif
		$condition 	 = [];
		$condition[] = ['aktif', 1, 'where'];
		$condition[] = ['id_jenis_izin', $vpi['id_jenis_izin'], 'where'];
		$ret 		 = $this->M_core->get_tbl('m_ret_tarif', '*', $condition)->row_array();

		// insert tarif
		$dtarif['id_permohonan'] = $vpi['id_permohonan'];
		$dtarif['tarif'] 		 = $ret['tarif'];

		$tarif_ins 	= $this->M_core->insert_tbl_normal('t_ret_tarif', $dtarif);
		$res['msg'] = 'valid';

		echo json_encode($res);
	}

	function ret_submit_perhitungan_k($type=null) {
		// param general
		$no_permohonan 	= $this->input->post('no_permohonan');

		// get permohonan
		$condition 			  = [];
		$condition[] 		  = ['no_permohonan', $no_permohonan, 'where'];
		$get_phn			  = $this->M_core->get_tbl('v_permohonan_izin', '*', $condition);
		$gphn 				  = $get_phn->row_array();

		//permohonan
		$p['desc']      	= 'Nama : '.$gphn['nama_pemohon'];
		$p['no_permohonan'] = $gphn['no_permohonan'];
		$p['id_permohonan'] = $gphn['id_permohonan'];
		$p['id_jenis_izin'] = $gphn['id_jenis_izin'];
		$p['permission'] 	= 1;

		
		// koef
		if($gphn['id_nama_izin'] == 6) {
			// get tarif
			$condition 			= [];
			$condition[] 		= ['aktif', 1, 'where'];
			$p['get_tarif']		= $this->M_core->get_tbl('m_ret_jenis_tarif', '*', $condition);

			//get koef
			$p['arr_koef'] = [];
			$p['arr_koef'] = ['kj' => 1, 'gb' => 2, 'lb' => 3, 'tb' => 4, 'ja' => 5, 'jt' => 6, 'ret' => 7];
			foreach($p['arr_koef'] as $k => $v) {
				$condition 			 = [];
				$condition[] 		 = ['aktif', 1, 'where'];
				$condition[] 		 = ['id_ret_jenis_koef', $v, 'where'];
				$condition[] 		 = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
				$p['get_koef'][$k]   = $this->M_core->get_tbl('m_ret_nilai_koef', '*', $condition);
			}

			//get koef dynamic
			$p['arr_koef'] = [];
			$p['arr_koef'] = ['kj' => 1, 'gb' => 2, 'lb' => 3, 'tb' => 4, 'ja' => 5, 'jt' => 6, 'ret' => 7];
			foreach($p['arr_koef'] as $k => $v) {
				$id_rjk[] = $v;
			}
			
			$condition 			 = [];
			$condition[] 		 = ['aktif', 1, 'where'];
			$condition[] 		 = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
			$condition[] 		 = ['tipe', 'dynamic', 'where'];
			$condition[] 		 = ['id_ret_jenis_koef', $id_rjk, 'where_in'];
			$p['get_koef_dyn']   = $this->M_core->get_tbl('v_nilai_koef', '*', $condition);
		}

		// param spesfic
		if($type == 'ins') {
			//tarif
			$p['tarif'] = $this->input->post('tarif');
			$p['value'] = $this->input->post('value');

			//koef
			foreach($p['arr_koef'] as $k => $v) {
				$p['koef_'.$k] = $this->input->post('koef_'.$k);
			}
		} else if ($type == 'del') {
			$p['index'] = $this->input->post('index');
		}
		
		//process ret
		if($type == 'ins') {
			$this->ret_insert_perhitungan($p);
		} else if($type == 'del') {
			$this->ret_delete_perhitungan($p);			
		}

		//response
		$res['msg'] = 'not_valid';
		if($gphn['id_nama_izin'] == 6) {
			$res['ret_form'] = $this->load->view('retribusi/ret_imb_x', $p, true);
			$res['msg'] = 'valid';
		}

		echo json_encode($res);
	}

	function ret_delete_perhitungan($p) {
		// upd tarif
		$condition   = [];
		$condition[] = ['id_permohonan', $p['id_permohonan'], 'where'];
		$condition[] = ['index', $p['index'], 'where'];
		$condition[] = ['aktif', 1, 'where'];
		$tarif_upd = $this->M_core->update_tbl('t_ret_biaya_item', ['aktif' => 0], $condition);

		// upd koef
		foreach($p['get_koef_dyn']->result_array() as $gkdyn) {
			$kodeArr[] = $gkdyn['kode']; 
		}
		$condition   = [];
		$condition[] = ['aktif', 1, 'where'];
		$condition[] = ['id_permohonan', $p['id_permohonan'], 'where'];
		$condition[] = ['index', $p['index'], 'where'];
		$condition[] = ['kode', $kodeArr, 'where_in'];
		$koef_upd  = $this->M_core->update_tbl('t_ret_nilai_koef', ['aktif' => 0], $condition);
	}

	function ret_insert_perhitungan($p) {
		//tarif insert
		$index = 1;
		for($i=0; $i<count($p['tarif']); $i++) {
			$condition 		= [];
			$condition[] 	= ['id_ret_jenis_tarif', $p['tarif'][$i], 'where'];
			$get_tarif		= $this->M_core->get_tbl('m_ret_jenis_tarif', '*', $condition);
			$gtrf 			= $get_tarif->row_array();

			$dtarif[$i]['id_permohonan'] 		= $p['id_permohonan'];
			$dtarif[$i]['id_ret_jenis_tarif'] 	= $p['tarif'][$i];
			$dtarif[$i]['nilai_tarif'] 		  	= $gtrf['nilai_tarif'];
			$dtarif[$i]['value'] 				= $p['value'][$i];
			$dtarif[$i]['kode'] 			  	= $gtrf['kode'];
			$dtarif[$i]['index'] 				= $index;

			$condition   = [];
			$condition[] = ['id_permohonan', $p['id_permohonan'], 'where'];
			$condition[] = ['index', $index, 'where'];
			$condition[] = ['aktif', 1, 'where'];

			$check_trbi = $this->M_core->get_tbl('t_ret_biaya_item', '*', $condition);		
			if($check_trbi) {
				$dtrbi = $check_trbi->row_array();
				// tarif different
				if($dtrbi['id_ret_jenis_tarif'] != $dtarif[$i]['id_ret_jenis_tarif']) {
					$tarif_upd = $this->M_core->update_tbl('t_ret_biaya_item', ['aktif' => 0], $condition);
					$tarif_ins = $this->M_core->insert_tbl_normal('t_ret_biaya_item', $dtarif[$i]);
				} else {
					// value different
					if($dtrbi['value'] != $dtarif[$i]['value']) {
						$tarif_upd = $this->M_core->update_tbl('t_ret_biaya_item', ['aktif' => 0], $condition);
						$tarif_ins = $this->M_core->insert_tbl_normal('t_ret_biaya_item', $dtarif[$i]);
					} 
				}
			} else {
				$tarif_ins = $this->M_core->insert_tbl_normal('t_ret_biaya_item', $dtarif[$i]);
			}

			$index++;
		}

		//koef insert
		foreach($p['arr_koef'] as $k => $v) {
			$index = 1;
			for($i=0; $i<count($p['koef_'.$k]); $i++) {
				$condition 		= [];
				$condition[] 	= ['id_ret_nilai_koef', $p['koef_'.$k][$i], 'where'];
				$get_nkoef		= $this->M_core->get_tbl('m_ret_nilai_koef', '*', $condition);
				$gnkf 			= $get_nkoef->row_array();

				$condition 		= [];
				$condition[] 	= ['id_ret_jenis_koef', $gnkf['id_ret_jenis_koef'], 'where'];
				$get_jkoef		= $this->M_core->get_tbl('m_ret_jenis_koef', '*', $condition);
				$gjkf 			= $get_jkoef->row_array();

				$dkoef[$i]['id_permohonan'] 		= $p['id_permohonan'];
				$dkoef[$i]['id_ret_nilai_koef'] 	= $p['koef_'.$k][$i];
				$dkoef[$i]['nilai_koef'] 		  	= $gnkf['nilai_koef'];
				$dkoef[$i]['kode'] 			  		= $gjkf['kode'];
				$dkoef[$i]['index'] 				= $index;

				$condition   = [];
				$condition[] = ['id_permohonan', $p['id_permohonan'], 'where'];
				$condition[] = ['kode', $gjkf['kode'], 'where'];
				$condition[] = ['index', $index, 'where'];
				$condition[] = ['aktif', 1, 'where'];

				$check_trnk = $this->M_core->get_tbl('t_ret_nilai_koef', '*', $condition);		
				if($check_trnk) {
					$dtrnk = $check_trnk->row_array();
					if($dtrnk['id_ret_nilai_koef'] != $dkoef[$i]['id_ret_nilai_koef']) {
						$koef_upd = $this->M_core->update_tbl('t_ret_nilai_koef', ['aktif' => 0], $condition);
						$koef_ins = $this->M_core->insert_tbl_normal('t_ret_nilai_koef', $dkoef[$i]);
					} 
				} else {
					$koef_ins = $this->M_core->insert_tbl_normal('t_ret_nilai_koef', $dkoef[$i]);
				}

				$index++;
			}
			unset($index);
		}
	}

	function ret_lihat_perhitungan() {
		$no_permohonan 		= $this->input->get('no_permohonan');

    	$condition 			= array();
		$condition[] 		= array('no_permohonan', $no_permohonan, 'where');
		$dPer				= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'id_nama_izin, nama_izin, jenis_izin, id_jenis_izin, id_perusahaan, id_permohonan, nama_pemohon, id_pemohon, id_aktivitas_workflow', $condition)->row_array();

		$id_user 			= $this->session->userdata('id_user');
		$id_permohonan 		= $dPer['id_permohonan'];
		$id_aktivitas_workflow = $dPer['id_aktivitas_workflow'];
		$id_pemohon 		= $dPer['id_pemohon'];

		$d['page']      	= 'perhitungan';
		$d['menu']      	= 'Perhitungan Retribusi';
		$d['title']      	= 'Perhitungan Retribusi';

		$p['desc']      	= 'Nama : '.$dPer['nama_pemohon'];
		$p['permission']	= 0;
		$p['nama_izin']   	= $dPer['nama_izin'];
		$p['jenis_izin']   	= $dPer['jenis_izin'];
		$p['id_jenis_izin'] = $dPer['id_jenis_izin'];
		$p['id_permohonan'] = $dPer['id_permohonan'];
		$p['no_permohonan'] = $no_permohonan;

		// detect jenis retribusi
		$condition 			= [];
		$condition[] 		= ['aktif', 1, 'where'];
		$condition[] 		= ['id_jenis_izin', $dPer['id_jenis_izin'], 'where'];
		$get_tfret 			= $this->M_core->get_tbl('m_ret_tarif', '*', $condition);

		// ret simple
		if($get_tfret->num_rows() != 0) {
			$dtfret = $get_tfret->row_array();
			$p['tarif']   = $dtfret['tarif'];

			$d['ret'] = $this->load->view('retribusi/ret_simple', $p, true);
		}

		// ret kompleks
		else {

			//imb
			if($dPer['id_nama_izin'] == 6) {
				// get tarif
				$condition 			= [];
				$condition[] 		= ['aktif', 1, 'where'];
				$p['get_tarif']		= $this->M_core->get_tbl('m_ret_jenis_tarif', '*', $condition);

				//get koef
				$arr_koef = [];
				$arr_koef = ['kj' => 1, 'gb' => 2, 'lb' => 3, 'tb' => 4, 'ja' => 5, 'jt' => 6, 'ret' => 7];
				foreach($arr_koef as $k => $v) {
					$condition 			 = [];
					$condition[] 		 = ['aktif', 1, 'where'];
					$condition[] 		 = ['id_ret_jenis_koef', $v, 'where'];
					$condition[] 		 = ['id_jenis_izin', $dPer['id_jenis_izin'], 'where'];
					$p['get_koef'][$k] = $this->M_core->get_tbl('m_ret_nilai_koef', '*', $condition);
				}

				//force x
				$d['ret'] 		= $this->load->view('retribusi/ret_imb_x', $p, true);
			}
		}

		$d['button']      	= $this->get_button($id_user, $id_aktivitas_workflow, $id_permohonan, $no_permohonan, 'btn-lg');
		$this->load->view('layout', $d);
	}

	function ret_lihat_skrd() {
		$id_permohonan 	= $this->input->post('permohonan');

		$condition 			= [];
		$condition[] 		= ['aktif', 1, 'where'];
		$condition[] 		= ['id_permohonan', $id_permohonan, 'where'];
		$get_frz 			= $this->M_core->get_tbl('t_draft_skrd_frz', '*', $condition);

		// if already frz
		if($get_frz->num_rows() > 0) {
			$dfrz 	  = $get_frz->row_array();
			$data_obj = $dfrz['file_lokasi'].'/'.$dfrz['file_name_hash'];
		
		// if notyet frz
		} else {
			$data_obj = base_url('permohonan_izin/ret_generate_skrd/'.$id_permohonan);
		}

		$obj = '<object width="100%" height="500px" type="application/pdf"
					data="'.$data_obj.'">
  				</object>';

		echo $obj;
	}

	function ret_generate_skrd($id_permohonan, $frz=null) {
		//permohonan
		$condition    = [];
	    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		$vpi 	 	  = $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();
		$akr 		  = preg_replace('/[^A-Za-z0-9\-]/', '', $vpi['akronim']);

		//pemohon
		$condition    = [];
	    $condition[]  = ['id_pemohon', $vpi['id_pemohon'], 'where'];
		$tphn 	  	  = $this->M_permohonan_izin->get_master_spec('t_pemohon', '*', $condition)->row_array();

		//skrd
		$condition    = [];
	    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		$skrd 	 	  = $this->M_permohonan_izin->get_master_spec('t_skrd_terbit', '*', $condition)->row_array();


		// passing data
		$data_formula = [];
		$data_formula['id_permohonan'] = $id_permohonan;
		$data_formula['id_jenis_izin'] = $vpi['id_jenis_izin'];

		$data_pdf = [];
		$data_pdf['izin'] 				= $this->get_jenis_izin($vpi['id_jenis_izin']);
		$data_pdf['nama_pemohon'] 		= $tphn['nama'];
		$data_pdf['alamat_pemohon'] 	= $tphn['alamat'];
		$data_pdf['total'] 				= str_replace(',', '.', number_format($this->ret_formula($data_formula)));
		$data_pdf['total_terbilang'] 	= '<b>'.$this->M_core->terbilang($this->ret_formula($data_formula), 1).' RUPIAH</b>';
		$data_pdf['kode_rekening'] 		= '#'; 
		
		$data_pdf['tgl_terbit'] 	    = '#'; 
		$data_pdf['bulan'] 				= '#'; 
		$data_pdf['tahun'] 				= '#';
		$data_pdf['no_skrd'] 			= '#';
		$data_pdf['masa_retribusi'] 	= '#';	

		if($skrd) {
			$data_pdf['tgl_terbit'] 	= date('d-m-Y', strtotime($skrd['tgl_terbit'])); 
			$data_pdf['bulan'] 			= date('F', strtotime($skrd['tgl_terbit'])); 
			$data_pdf['tahun'] 			= date('Y', strtotime($skrd['tgl_terbit']));
			$data_pdf['no_skrd'] 		= $skrd['no_skrd'];
			$data_pdf['masa_retribusi'] = date('F', strtotime($skrd['tgl_terbit']));
		} 

		// draft skrd
		$condition 		= [];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['id_jenis_izin', $vpi['id_jenis_izin'], 'where'];
		$draft_skrd		= $this->M_admin->get_master_spec('v_draft_skrd', '*', $condition)->result_array();	


		// looping template
		$pdf = new TCPDF('P', 'cm', PDF_PAGE_FORMAT, 'true');
		$pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);
        $pdf->setMargins(1.5, 0.8, 1);
        $pdf->SetFont('times', '', '11');	

        $page = 1;
		foreach ($draft_skrd as $dsk) {
	        $size 	= $dsk['size'];
	        if ($dsk['size'] == 'Legal') {
	        	$size 	= [21.6, 35.6];
	        }

	        $pdf->AddPage($dsk['position'], $size);
			$c_draft 	 = $this->load->view('sk_izin/'.$dsk['template'], $data_pdf, TRUE);
			$pdf->writeHTML($c_draft, true, false, true, false, '');

			$page++;
		}


		// if freeze
		if($frz == 1) {	
			$dfrz = [];
			$dfrz['id_permohonan'] 	= $id_permohonan;
			$dfrz['file_name_asli'] = $id_permohonan.'.pdf';
			$dfrz['file_name_hash'] = md5($id_permohonan).'.pdf';
			$dfrz['file_lokasi'] 	= base_url('berkas/data_skrd');
			$dfrz['index'] 			= 1;
			$dfrz['catatan'] 		= '';
			$dfrz['added_by'] 		= $this->session->userdata('id_user');

			$ins_frz = $this->M_core->insert_tbl_normal('t_draft_skrd_frz', $dfrz);
			$folder  = FCPATH.'berkas/data_skrd/';
			$pdf->Output($folder.$dfrz['file_name_hash'], 'F');
		
		// if not freeze
		} else {
			$filename = 'skrd_'.$akr.'_'.date('d_m_Y');
	    	$pdf->Output("$filename", 'I');

		}		
	}

	private function ret_formula($p) {
		$condition 			= [];
		$condition[] 		= ['aktif', 1, 'where'];
		$condition[] 		= ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
		$get_tfret 			= $this->M_core->get_tbl('m_ret_tarif', '*', $condition);

		// ret simple
		if($get_tfret->num_rows() != 0) {
			$condition 			 = [];
			$condition[] 		 = ['aktif', 1, 'where'];
			$condition[] 		 = ['id_permohonan', $p['id_permohonan'], 'where'];
			$res['tarif']		 = $this->M_core->get_tbl('t_ret_tarif', 'tarif', $condition)->row_array()['tarif'];

		} else {
			$condition       = [];
	     	$condition[]     = ['aktif', 1, 'where'];
	     	$condition[]     = ['id_jenis_izin', $p['id_jenis_izin'], 'where'];
	     	$condition[]     = ['final', 1, 'where'];
	     	$get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
	     	$grf = $get_ret_formula->row_array();

	     	$fnl = str_replace('$var', $p['id_permohonan'], $grf['query']);
	     	$query_fnl = $this->db->query($fnl);
	     	$res['tarif'] = $query_fnl->row_array()['total'];
		}

		return $res['tarif'];
	}

    function detail() {
    	$no_permohonan 		= $this->input->get('no_permohonan');

    	$condition 			= array();
		$condition[] 		= array('no_permohonan', $no_permohonan, 'where');
		$dPer				= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'id_perusahaan, id_permohonan, id_jenis_izin, id_pemohon, id_aktivitas_workflow', $condition)->row_array();

		$id_user 			= $this->session->userdata('id_user');
		$id_permohonan 		= $dPer['id_permohonan'];
		$id_aktivitas_workflow = $dPer['id_aktivitas_workflow'];
		$id_perusahaan 		= $dPer['id_perusahaan'];
		$id_jenis_izin 		= $dPer['id_jenis_izin'];
		$id_pemohon 		= $dPer['id_pemohon'];

		//pemohon
		$pemohon		= $this->M_permohonan_izin->get_data_pemohon($id_pemohon)->row_array();
		$d['pemohon']   = $pemohon;

		//permohonan
		$permohonan					= $this->M_permohonan_izin->get_data_permohonan($id_jenis_izin)->row_array();
		$permohonan['jenis_izin'] 	= $this->get_jenis_izin($permohonan['id_jenis_izin']);
		$d['permohonan'] 			= $permohonan;

		//histori
		$history 		= $this->M_permohonan_izin->get_data_history($id_permohonan)->result_array();

		//perusahaan
		$dPbio['id_perusahaan'] = $dPer['id_perusahaan'];
		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
        $condition[]    = ['show_pg_be', 1, 'where'];
		$condition[]  	= ['kd_perusahaan_bio_grup', 'asc', 'order_by'];
		$dPbio['m_grup']     = $this->M_core->get_tbl('m_perusahaan_bio_grup', '*', $condition)->result_array();
		$dPbio['pbio_card']  = $this->load->view('perusahaan_card', $dPbio, true);

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
		$cPbio = $this->M_core->get_tbl('m_perusahaan_bio_cfg', 'permission', $condition)->row_array()['permission'];

		if($cPbio == 0) {
			$d['button_pbio'] = '';
			$d['perusahaan']  = '';
			$d['col_pmhn']    = 'col-md-6 col-md-offset-3';

		} 
		
		else {$d['button_pbio'] = '<a href="'.base_url('perusahaan/perusahaan_detail/'.$cPbio.'/'.$id_perusahaan).'">
				                    <button type="button" class="btn btn-warning btn-sm pull-right">
				                        <i class="fa fa-search"></i> Detail Perusahaan
				                    </button>
				                  </a>';
			$d['perusahaan'] = $dPbio['pbio_card'];
			$d['col_pmhn']   = 'col-md-6';
		}


		//syarat izin
		$dSi = [];
		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
		$cSi = $this->M_core->get_tbl('m_syarat_izin_cfg', 'permission', $condition)->row_array()['permission'];
		if($cSi == 0) {
			$dSi['permission'] = 'disabled';
		} else if($cSi == 1) {
			$dSi['permission'] = 'disabled';
		} else if($cSi == 2) {
			$dSi['permission'] = '';
		}

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = ['id_jenis_izin', $id_jenis_izin, 'where'];
		$condition[]  = ['kd_syarat_izin_grup', 'asc', 'order_by'];
		$dSi['id_permohonan'] = $id_permohonan;
		$dSi['id_jenis_izin'] = $id_jenis_izin;
		$dSi['m_grup'] 	      = $this->M_core->get_tbl('m_syarat_izin_grup', '*', $condition)->result_array();

		$condition 	  = [];
		$condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		$dSi['data_multi_ziswaf']= $this->M_core->get_tbl('t_multiple_ziswaf', '*', $condition)->result_array();

		$condition 		= array();
		$condition[] 	= array('id_nama_izin', 1, 'where');
		$condition[] 	= array('aktif', 1, 'where');
		$condition[] 	= array('show', 1, 'where');
		$dSi['option'] 	= $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'id_jenis_izin, teks_menu', $condition)->result_array();

		if($cSi == 0) {
			// $dSi['si_card'] = '';
			$dSi['si_card'] = $this->load->view('syarat_izin_card', $dSi, true);
		} else {
			$dSi['si_card'] = $this->load->view('syarat_izin_card', $dSi, true);
		}

		//rekam berkas
		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
		$cRb = $this->M_core->get_tbl('m_rekam_berkas_cfg', 'permission', $condition)->row_array()['permission'];

		if($cRb == 0) {
			$d['button_rb'] = '';

		} else {
			$d['button_rb'] = '<a href="'.base_url('rekam_berkas/rekam_berkas_detail/'.$cRb.'/'.$id_permohonan).'">
		                      <button type="button" class="btn btn-info btn-sm pull-right">
		                          <i class="fa fa-search"></i> Rekam Berkas
		                      </button>
		                    </a>';
		}


		//prepare
		$d['no_permohonan'] = $no_permohonan;
		$d['id_permohonan'] = $id_permohonan;
		$d['history'] 		= $history;
		$d['syarat_izin'] 	= $dSi['si_card'];
		$d['rekam_berkas']  = $cRb;
		$d['page']      	= 'detail';
		$d['menu']      	= 'Detail Zakat / Donasi';
		$d['title']      	= 'Detail Zakat / Donasi';
		$d['button']      	= $this->get_button($id_user, $id_aktivitas_workflow, $id_permohonan, $no_permohonan, 'btn-lg');
		$this->load->view('layout', $d);
	}

	function submit_permohonan() {
		$no_permohonan 	= $this->input->post('no_permohonan');

		$condition    = [];
        $condition[]  = ['no_permohonan', $no_permohonan, 'where'];
        $dPer 	  	  = $this->M_core->get_tbl('t_permohonan', '*', $condition)->row_array();

		// submit syarat izin
		$core_si		= 'syarat_izin';
		$smbt_si		= $this->process_all($core_si, $dPer['id_jenis_izin'], $dPer['id_permohonan']);

		// response
		$this->session->set_flashdata("tipe-alert", "success");
		$this->session->set_flashdata("teks-alert", "Data permohonan berhasil diubah");
		$this->session->set_flashdata("icon-alert", "fa fa-check-circle");

		// $no_kend 	= $this->input->post('no_kend')[0];
		// echo '<pre>';
		// var_dump($no_kend);

		redirect('permohonan_izin/detail?no_permohonan='.$no_permohonan);
	}

	// Core
	function process_all($core, $id_jenis_izin, $id_permohonan) {
		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[]  	= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$condition[]  	= ['kd_'.$core.'_grup', 'asc', 'order_by'];
		$m_grup 		= $this->M_core->get_tbl('m_'.$core.'_grup', '*', $condition)->result_array();

		/** START LOOP M_GRUP **/
		foreach($m_grup as $mgp) {
			$condition    = [];
	        $condition[]  = ['aktif', 1, 'where'];
	        $condition[]  = ['kd_'.$core.'_s', 'asc', 'order_by'];
	        $condition[]  = ['id_'.$core.'_grup', $mgp['id_'.$core.'_grup'], 'where'];
	        $m_single     = $this->M_core->get_tbl('m_'.$core.'_s', '*', $condition)->result_array();

	        /** START LOOP M_SINGLE **/
	        foreach ($m_single as $msi) {

	        	/** FILE **/
	         	if($msi['jenis_input'] == 'file') {
	     			$this->process_file($core, $id_permohonan, $msi);
	         	}

	        	/** TEXT/NUMBER/EMAIL/DATE/CURRENCY **/
	         	if(($msi['jenis_input'] == 'text') || ($msi['jenis_input'] == 'number') ||
            		($msi['jenis_input'] == 'email') || ($msi['jenis_input'] == 'date') ||
            		($msi['jenis_input'] == 'currency') || ($msi['jenis_input'] == 'textarea')) {
	     			$this->process_tne($core, $id_permohonan, $msi);
	         	}

	         	/** SELECT **/
	         	if(($msi['jenis_input'] == 'select') && ($msi['special'] == null)) {
	     			$this->process_cttn($core, $id_permohonan, $msi);
	     			$this->process_select($core, $id_permohonan, $msi);
	         	}

	         	/** SELECT SPECIAL **/
	         	if(($msi['jenis_input'] == 'select') && ($msi['special'] == 1)) {
	     			$this->process_cttn($core, $id_permohonan, $msi);
	     			$this->process_select_special($core, $id_permohonan, $msi);
	         	}

	         	/** TBL **/
	         	if($msi['jenis_input'] == 'tbl') {
	     			$this->process_cttn($core, $id_permohonan, $msi);
	     			$this->process_tbl($core, $id_permohonan, $msi);
	         	}

	        }
	        /** END LOOP M_SINGLE **/
		}
		/** END LOOP M_GRUP **/
	}

	private function process_file($core, $id_permohonan, $msi) {
		$nama_input = $_FILES[$msi['nama_'.$core]]['name'];
		$nama_fln   = $this->input->post($msi['nama_'.$core].'_fln');
		$nama_cttn  = $this->input->post($msi['nama_'.$core].'_cttn');
		$jml_input  = count($nama_input);
 		$files = $_FILES;
 		for($i=0;$i<$jml_input;$i++) {
 			$_FILES[$msi['nama_'.$core]]['name']     = $files[$msi['nama_'.$core]]['name'][$i];
            $_FILES[$msi['nama_'.$core]]['type']	 = $files[$msi['nama_'.$core]]['type'][$i];
            $_FILES[$msi['nama_'.$core]]['tmp_name'] = $files[$msi['nama_'.$core]]['tmp_name'][$i];
            $_FILES[$msi['nama_'.$core]]['error']    = $files[$msi['nama_'.$core]]['error'][$i];
            $_FILES[$msi['nama_'.$core]]['size']     = $files[$msi['nama_'.$core]]['size'][$i];

            $path 	= '/berkas/berkas_permohonan';
			$config = [
				'upload_path' 	=> '.'.$path,
				'allowed_types' => 'pdf|png|jpg|jpeg',
				// 'max_size' 		=> '6000',
				'max_size' 		=> '8000',
				'file_name' 	=> $_FILES[$msi['nama_'.$core]]['name'],
				'encrypt_name' 	=> TRUE
			];
			$this->upload->initialize($config);

			$dS[$i]['id_permohonan']		= $id_permohonan;
			$dS[$i]['id_'.$core.'_s']		= $msi['id_'.$core.'_s'];
			$dS[$i]['catatan']				= $nama_cttn[$i];
			$dS[$i]['index']				= $i+1;

			$condition    = [];
	        $condition[]  = ['aktif', 1, 'where'];
	        $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
	        $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
	        $condition[]  = ['index', $dS[$i]['index'], 'where'];
	        $t_single 	  = $this->M_core->get_tbl($msi['table_tujuan_s'], '*', $condition);


			//if new file
            if($t_single->num_rows() == 0) {
            	//if file not null
            	if($files[$msi['nama_'.$core]]['name'][$i] != null) {
            		//insert
            		if($this->upload->do_upload($msi['nama_'.$core])) {
            			$dS[$i]['file_lokasi']		= base_url().substr($path, 1);
            			$dS[$i]['file_name_asli']	= $this->upload->data('orig_name');
						$dS[$i]['file_name_hash']	= $this->upload->data('file_name');
            			$ins_dS = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dS[$i]);
            		}

            	//if file null
            	} else {
            		//if catatan not null
            		if($nama_cttn[$i] != null) {
            			//insert cttn
            			$ins_dS = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dS[$i]);
            		}
            	}

            //if old file
            } else {
            	//if file not null
            	if($files[$msi['nama_'.$core]]['name'][$i] != null) {
            		//update old set 0 && insert new
            		if($this->upload->do_upload($msi['nama_'.$core])) {
            			$dS[$i]['file_lokasi']		= base_url().substr($path, 1);
            			$dS[$i]['file_name_asli']	= $this->upload->data('orig_name');
						$dS[$i]['file_name_hash']	= $this->upload->data('file_name');
            			$upd_dS = $this->M_core->update_tbl($msi['table_tujuan_s'], ['aktif' => 0], $condition);
     					$ins_dS = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dS[$i]);
     				}

            	//if file null
            	} else {
            		//if catatan not null
            		if($nama_cttn[$i] != null) {
            			//update cttn
            			$upd_dS = $this->M_core->update_tbl($msi['table_tujuan_s'], ['catatan' => $nama_cttn[$i]], $condition);
            		}
            	}
            }
		}
	}

	private function process_tne($core, $id_permohonan, $msi) {
		$nama_input = $this->input->post($msi['nama_'.$core]);
		$jml_input  = count($nama_input);
 		$index = 1;
 		for($i=0;$i<$jml_input;$i++) {
 			//package dS
     		//dSI = data for input if null
     		//dSU = data for update/input if not null
     		//urgent
     		if($msi['tipe_data'] == 'num') {
 				$dSI[$i]['nilai_'.$msi['tipe_data']] = $this->str_clean($this->input->post($msi['nama_'.$core])[$i]);
     		} else {
     			$dSI[$i]['nilai_'.$msi['tipe_data']] = $this->input->post($msi['nama_'.$core])[$i];
     		}
 			$dSI[$i]['catatan'] 				 = $this->input->post($msi['nama_'.$core].'_cttn')[$i];
     		$dSI[$i]['id_permohonan']		     = $id_permohonan;
     		$dSI[$i]['id_'.$core.'_s']     		 = $msi['id_'.$core.'_s'];
     		$dSI[$i]['index']	    	         = $i+1;

     		if($msi['tipe_data'] == 'num') {
 				$dSU[$i]['nilai_'.$msi['tipe_data']] = $this->str_clean($this->input->post($msi['nama_'.$core])[$i]);
     		} else {
     			$dSU[$i]['nilai_'.$msi['tipe_data']] = $this->input->post($msi['nama_'.$core])[$i];
     		}
     		$dSU[$i]['catatan'] 				 = $this->input->post($msi['nama_'.$core].'_cttn')[$i];
     		$dSU[$i]['id_permohonan']		     = $id_permohonan;
     		$dSU[$i]['id_'.$core.'_s']         	 = $msi['id_'.$core.'_s'];
     		$dSU[$i]['index']	    	         = $i+1;


     		//check t_single
     		$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
		    $condition[]  = ['index', $dSU[$i]['index'], 'where'];
     		$t_single 	  = $this->M_core->get_tbl($msi['table_tujuan_s'], '*', $condition);


     		//if data null
     		if($t_single->num_rows() == 0) {

     			//if data filled
     			if($dSI[$i]['nilai_'.$msi['tipe_data']] != null) {
         			$ins_dSI = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dSI[$i]);
         			unset($dSI[$i]);

     			//if data not filled
     			} else {
     				//if cttn not null
        			if($dSI[$i]['catatan'] != null) {
        				$ins_dSI = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dSI[$i]);
        				unset($dSI[$i]);
        			}
     			}

     		//if data not null
     		} else {
     			unset($dSI[$i]);
     			$dST = $t_single->row_array();

     			//if data changed
     			if($dSU[$i]['nilai_'.$msi['tipe_data']] != $dST['nilai_'.$msi['tipe_data']]) {
        			$upd_dSU = $this->M_core->update_tbl($msi['table_tujuan_s'], ['aktif' => 0], $condition);
        			$ins_dSU = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dSU[$i]);
        			unset($dSU[$i]);

     			//if data not changed
     			} else {
     				//if cttn not null
        			if($dSU[$i]['catatan'] != null) {
        				$upd_dSU = $this->M_core->update_tbl($msi['table_tujuan_s'], ['catatan' => $dSU[$i]['catatan']], $condition);
        				unset($dSU[$i]);
        			}
     			}
     		}
 		}
	}

	private function process_select($core, $id_permohonan, $msi) {
		$nama_input = $this->input->post($msi['nama_'.$core]);

		//get m_plural
 		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
	    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
 		$m_plural  	  = $this->M_core->get_tbl('m_'.$core.'_p', '*', $condition)->result_array();

		//get m_plural
		foreach($m_plural as $mpl) {
			$idPM[$mpl['id_'.$core.'_p']] = $mpl['id_'.$core.'_p'];
		}

 		//get m_plural post
 		$jml_input  = count($nama_input);
 		$idP  = [];
		$idPP = [];
 		for($i=0;$i<$jml_input;$i++) {
 			$idP[$i] 		  = $nama_input[$i];
 			$idPP[$idP[$i]]   = $nama_input[$i];
 		}

 		//detect m_plural (1) true [m == p]
 		$idP1 = array_intersect($idPM, $idPP);
 		//detect m_plural (0) false [m != p]
 		$idP0 = array_diff($idPM, $idPP);

 		//proccess p1
 		foreach($idP1 as $k1 => $v1) {
 			//get t_plural by P1
     		$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
		    $condition[]  = ['id_'.$core.'_p', $v1, 'where'];
     		$t_plural  	  = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);

     		if($t_plural->num_rows() == 0) {
     			$dP[$v1]['nilai_'.$mpl['tipe_data']] = 1;
         		$dP[$v1]['id_permohonan']		    = $id_permohonan;
         		$dP[$v1]['id_'.$core.'_s']     		= $msi['id_'.$core.'_s'];
         		$dP[$v1]['id_'.$core.'_p']     		= $v1;
         		$dP[$v1]['index']	    	        = 1;

         		//get m_bio_p check
         		$condition     = [];
			    $condition[]   = ['aktif', 1, 'where'];
			    $condition[]   = ['id_'.$core.'_p', $v1, 'where'];
         		$m_plural  	   = $this->M_core->get_tbl('m_'.$core.'_p', '*', $condition)->row_array();
         		$mpl['idmsi']  = $m_plural['id_'.$core.'_s'];

         		if($mpl['idmsi'] == $msi['id_'.$core.'_s']) {
         			$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$v1]);
         		}

     		} else {
     			//do nothing
     		}
 		}

 		//proccess p0
 		foreach($idP0 as $k0 => $v0) {
 			//get t_plural by P0
     		$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
		    $condition[]  = ['id_'.$core.'_p', $v0, 'where'];
     		$t_plural  	  = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);

     		if($t_plural->num_rows() == 1) {
     			//get m_bio_p check
         		$condition     = [];
			    $condition[]   = ['aktif', 1, 'where'];
			    $condition[]   = ['id_'.$core.'_p', $v0, 'where'];
         		$m_plural  	   = $this->M_core->get_tbl('m_'.$core.'_p', '*', $condition)->row_array();
         		$mpl['idpmsi'] = $m_plural['id_'.$core.'_s'];

         		if($mpl['idpmsi'] == $msi['id_'.$core.'_s']) {
         			$condition    = [];
				    $condition[]  = ['aktif', 1, 'where'];
					$condition[]  = ['id_permohonan', $id_permohonan, 'where'];
					$condition[]  = ['id_'.$core.'_p', $v0, 'where'];
					
         			$upd_dS = $this->M_core->update_tbl($msi['table_tujuan_p'], ['aktif' => 0], $condition);
         		}

     		} else {
     			//do nothing
     		}
 		}
	}

	private function process_select_special($core, $id_permohonan, $msi) {
		$nama_input_num    = $this->input->post($msi['nama_'.$core].'_num');
		$nama_input_string = $this->input->post($msi['nama_'.$core].'_string');

 		$dP = [];
 		$jml_input_num  = count($nama_input_num);
 		for($i=0; $i<$jml_input_num; $i++) {
 			$dP[$i]['nilai_num'] 			  = $nama_input_num[$i];
 			$dP[$i]['nilai_string'] 		  = $nama_input_string[$i];
 			$dP[$i]['id_permohonan']		  = $id_permohonan;
 			$dP[$i]['id_'.$core.'_s']     	  = $msi['id_'.$core.'_s'];
 			$dP[$i]['id_'.$core.'_p']     	  = 0;
 			$dP[$i]['index']	    	      = 1;


 			//get t_single
	 		$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $dP[$i]['id_'.$core.'_s'], 'where'];
		    $condition[]  = ['id_'.$core.'_p', $dP[$i]['id_'.$core.'_p'], 'where'];
		    $condition[]  = ['index', $dP[$i]['index'], 'where'];
	 		$t_single  	  = $this->M_core->get_tbl('t_'.$core.'_p', '*', $condition);

 			if($t_single->num_rows() == 0) {
 				$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$i]);

 			} else {
 				// $tsi = $t_single->row_array();
 				// if($tsi['nilai_num'] != $dP[$i]['nilai_num']) {
 				// 	$condition   = [];
 				// 	$condition[] = ['aktif', 1, 'where'];
 				// 	$condition[] = ['id_permohonan', $tsi['id_permohonan'], 'where'];
 				// 	$condition[] = ['id_'.$core.'_s', $tsi['id_'.$core.'_s'], 'where'];
 				// 	$upd_dP = $this->M_core->update_tbl($msi['table_tujuan_p'], ['aktif' => 0], $condition);
 				// 	$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$i]);
 			}

 		}
	}

	private function process_tbl($core, $id_permohonan, $msi) {
		//get m_single
 		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
		$condition[]  = ['jenis_input', 'tbl', 'where'];
		$condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
 		$m_single  	  = $this->M_core->get_tbl('m_'.$core.'_s', '*', $condition)->result_array();

 		foreach($m_single as $msi) {
 			//get m_plural
 			$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
     		$m_plural  	  = $this->M_core->get_tbl('m_'.$core.'_p', '*', $condition)->result_array();

     		foreach($m_plural as $mpl) {
     			$nmPM      = $mpl['nama_'.$core.'_p'];
     			$idPM      = $mpl['id_'.$core.'_p'];
     			$jml_nmPM  = count($nmPM);

     			for($i=0;$i<$jml_nmPM;$i++) {
         			$nama_input_p  = $this->input->post($mpl['nama_'.$core.'_p']);
         			$jml_input_p   = count($nama_input_p);

					for($i2=0;$i2<$jml_input_p;$i2++) {
						$dP[$i2][$idPM]['id_permohonan']            = $id_permohonan;
     					$dP[$i2][$idPM]['id_'.$core.'_s']   		= $msi['id_'.$core.'_s'];
         				$dP[$i2][$idPM]['id_'.$core.'_p']   		= $idPM;
         				$dP[$i2][$idPM]['index']   					= $i2+1;

         				if($mpl['tipe_data'] == 'num') {
			 				$dP[$i2][$idPM]['nilai_'.$mpl['tipe_data']] = $this->str_clean($this->input->post($mpl['nama_'.$core.'_p'])[$i2]);
			     		} else {
			     			$dP[$i2][$idPM]['nilai_'.$mpl['tipe_data']] = $this->input->post($mpl['nama_'.$core.'_p'])[$i2];
			     		}

						$condition    = [];
					    $condition[]  = ['aktif', 1, 'where'];
					    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
					    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
					    $condition[]  = ['id_'.$core.'_p', $idPM, 'where'];
					    $condition[]  = ['index', $dP[$i2][$idPM]['index'], 'where'];
		         		$t_plural  	  = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);

	         			if($t_plural->num_rows() == 0) {
 							$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$i2][$idPM]);
	         			} else {
	         				$dPT = $t_plural->row_array();
	         				if($dPT['nilai_'.$mpl['tipe_data']] != $dP[$i2][$idPM]['nilai_'.$mpl['tipe_data']]) {
	         					$upd_dP = $this->M_core->update_tbl($msi['table_tujuan_p'], ['aktif' => 0], $condition);
	         					$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$i2][$idPM]);
	         				}
	         			}
					}
         		}
     		}
 		}
	}

	private function process_cttn($core, $id_permohonan, $msi) {
		$nama_cttn = $this->input->post($msi['nama_'.$core].'_cttn');
		$jml_cttn  = count($nama_cttn);
		$index = 1;
		for($i=0;$i<$jml_cttn;$i++) {
			$dC[$i]['catatan'] 		    = $this->input->post($msi['nama_'.$core].'_cttn')[$i];
			$dC[$i]['id_permohonan']	= $id_permohonan;
			$dC[$i]['id_'.$core.'_s']   = $msi['id_'.$core.'_s'];
			$dC[$i]['index']	    	= 1;

			//check t_single
			$condition    = [];
	        $condition[]  = ['aktif', 1, 'where'];
	        $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
	        $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
	        $condition[]  = ['index', $dC[$i]['index'], 'where'];
			$t_single 	  = $this->M_core->get_tbl($msi['table_tujuan_s'], '*', $condition);

 			//if data exist
 			if($t_single->num_rows() == 0) {
 				//if cttn filled
				if($dC[$i]['catatan'] != null) {
 					$ins_dC = $this->M_core->insert_tbl_normal($msi['table_tujuan_s'], $dC[$i]);
 				}

 			//if data doesnt exist
 			} else {
 				$dST = $t_single->row_array();
 				//if cttn changed
 				if($dC[$i]['catatan'] != $dST['catatan']) {
 					$upd_dC = $this->M_core->update_tbl($msi['table_tujuan_s'], ['catatan' => $dC[$i]['catatan']], $condition);
 				}
 			}
		}
	}

	// Tools
	public function del_tbl_row($core) {
		$d = [];
		$res = [];
		$d['id_permohonan']     = $this->input->post('id_permohonan');
		$d['id_'.$core.'_s']    = $this->input->post('id_'.$core.'_s');
		$d['index']        		= $this->input->post('index');

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = ['id_permohonan', $d['id_permohonan'], 'where'];
		$condition[]  = ['id_'.$core.'_s', $d['id_'.$core.'_s'], 'where'];
		$condition[]  = ['index', $d['index'], 'where'];

		$upd_tbl_row  = $this->M_core->update_tbl('t_'.$core.'_p', ['aktif' => 0], $condition);

		if($upd_tbl_row) {
			$res['msg'] = true;
		} else {
			$res['msg'] = false;
		}

		echo json_encode($res);
	}

	public function show_file($core) {
		$id           = $this->input->post('id');
		$index        = $this->input->post('index');

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
        $condition[]  = ['id_'.$core.'_f_t', $id, 'where'];
        $condition[]  = ['index', $index, 'where'];
		$dfile  	  = $this->M_core->get_tbl('t_'.$core.'_f', '*', $condition)->row_array();

		$explode_file = explode('.', $dfile['file_name_hash']);
		$format_file  = $explode_file[1];

		if($format_file == 'pdf') {
			$obj = '<iframe width="100%" height="500px" type="application/pdf" frameborder="0"
						src="https://docs.google.com/gview?embedded=true&url='.$dfile['file_lokasi'].'/'.$dfile['file_name_hash'].'">
			   			
			  		</iframe>';
			// $obj = '<object width="100%" height="500px" type="application/pdf" frameborder="0"
			// 			data="'.$dfile['file_lokasi'].'/'.$dfile['file_name_hash'].'">
			//    			<p>Your web browser doesnt have a PDF plugin</p>
			//   		</object>';
		} else {
			$obj = '<img width="100%" height="100%" src="'.$dfile['file_lokasi'].'/'.$dfile['file_name_hash'].'">';
		}

		echo $obj;
	}

	public function show_file_cr() {
		if ($this->input->post('test') == 'test') {
			$id_permohonan 	= $this->input->post('permohonan');

			$condition 			= [];
			$condition[] 		= ['id_permohonan', $id_permohonan, 'where'];
			$id_nama_izin 		= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'id_nama_izin', $condition)->row_array()['id_nama_izin'];
			if ($id_nama_izin == 3) {
				$skrd 	= '/berkas/core/images/pdf/iptm_skrd.pdf';
			} elseif ($id_nama_izin == 6) {
				$skrd 	= '/berkas/core/images/pdf/imb_skrd.pdf';
			}

			$obj = '<object width="100%" height="500px" type="application/pdf"
				data="'.base_url().$skrd.'">
	  		</object>';
		} else {


			$id           = $this->input->post('id');
			$d_berkas     = $this->M_permohonan_izin->get_data_berkas($id)->row_array();
			$explode_file = explode('.', $d_berkas['nama_file_hash']);
			$format_file  = $explode_file[1];

			if($format_file == 'pdf') {
				$obj = '<object width="100%" height="500px" type="application/pdf"
							data="'.$d_berkas['lokasi_file'].'/'.$d_berkas['nama_file_hash'].'">
				   			<p>Showing pdf error</p>
				  		</object>';
			} else {
				$obj = '<img width="100%" height="100%" src="'.$d_berkas['lokasi_file'].'/'.$d_berkas['nama_file_hash'].'">';
			}
		}

		echo $obj;
	}

	public function save_cttn($id_permohonan) {
		$idt          = $this->input->post('idt');
		$index        = $this->input->post('index');
		$pk        	  = $this->input->post('pk');
		$tbl          = $this->input->post('tbl');
		$idm          = $this->input->post('idm');
		$cttn         = $this->input->post('cttn');

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = [$pk, $idt, 'where'];
        $condition[]  = ['index', $index, 'where'];
        $check  	  = $this->M_core->get_tbl($tbl, '*', $condition)->num_rows();

        $response = json_encode(false);

        if($check == 0) {
        	$d['id_permohonan']		= $id_permohonan;
			$d['id_syarat_izin_s']	= $idm;
			$d['catatan']			= $cttn;
			$d['index']				= 1;
			$ins_cttn = $this->M_core->insert_tbl_normal($tbl, $d);
			$response = json_encode(true);
        } else {
        	$upd_cttn = $this->M_core->update_tbl($tbl, ['catatan' => $cttn], $condition);
        	$response = json_encode(true);
        }

		echo $response;
	}

	public function syarat_action($action) {
		$id 	= $this->input->post('id');
		$type 	= $this->input->post('type');

		$catatan 				= $this->input->post('catatan');

		if ($action == 'update-syarat') {
			$data 	= array(
						'catatan' 	=> $catatan
					);
		}

		if ($type == 'file') {
			$condition 	= array();
			$condition[0] 	= 'id_berkas_permohonan';
			$condition[1] 	= $id;
			$condition[2] 	= 'where';
			$this->M_permohonan_izin->update_data('t_berkas_permohonan', $condition, $data);
		} elseif ($type == 'text') {
			$condition[0] 	= 'id_syarat_permohonan';
			$condition[1] 	= $id;
			$condition[2] 	= 'where';
			$this->M_permohonan_izin->update_data('t_syarat_permohonan', $condition, $data);
		}

		echo json_encode(array('sukses' => $catatan));

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

	private function get_button($id_user, $id_aktivitas_workflow, $id_permohonan, $no_permohonan, $size) {
		$response 	= '';
		$id_user 	= $this->session->userdata('id_user');

		$now_segment= $this->uri->segment(2);
		if ($now_segment == "detail") {
			$condition 		= array();
			$condition[] 	= array('mdc.kd_decision !=', 'dtl', 'where');
			$get_decision 	= $this->M_permohonan_izin->get_decision($id_user, $id_aktivitas_workflow, $condition)->result_array();
		} elseif ($now_segment == "ret_perhitungan") {
			$condition 		= array();
			$condition[] 	= array('mdc.kd_decision !=', 'phtg_skrd', 'where');
			$get_decision 	= $this->M_permohonan_izin->get_decision($id_user, $id_aktivitas_workflow, $condition)->result_array();
		} elseif ($now_segment == "ret_lihat_perhitungan") {
			$condition 		= array();
			$condition[] 	= array('mdc.kd_decision !=', 'lh_phtg_skrd', 'where');
			$get_decision 	= $this->M_permohonan_izin->get_decision($id_user, $id_aktivitas_workflow, $condition)->result_array();
		} else {
			$get_decision 	= $this->M_permohonan_izin->get_decision($id_user, $id_aktivitas_workflow)->result_array();
		}

		foreach ($get_decision as $gd) {
			$link 		= 0;
			$label 		= 0;
			$onclick	= 0;

			$url 		= '';
			$costum 	= array();
			if ($gd['type'] == 'int') {
				if ($gd['kd_decision'] == 'aprv') {
					$cust 	= array(
								'btn_color' 	=> 'btn-success',
								'btn_icon' 		=> 'fa fa-check',
								'btn_title'		=> 'Setujui'
							);
				} elseif ($gd['kd_decision'] == 'pndg') {
					$cust 	= array(
								'btn_color' 	=> 'btn-warning',
								'btn_icon' 		=> 'fa fa-circle-o-notch',
								'btn_title'		=> 'Pending'
							);
				} elseif ($gd['kd_decision'] == 'dtl') {
					$cust 	= array(
								'btn_color' 	=> 'btn-primary',
								'btn_icon' 		=> 'fa fa-search',
								'btn_title'		=> 'Detail Permohonan'
							);
					$url 	= 'permohonan_izin/detail';
					$link 	= 1;
				} elseif ($gd['kd_decision'] == 'vw') {
					$cust 	= array(
								'btn_color' 	=> 'btn-default',
								'btn_icon' 		=> 'ti ti-eye',
								'btn_title'		=> 'Lihat'
							);
				} elseif ($gd['kd_decision'] == 'rjct') {
					$cust 	= array(
								'btn_color' 	=> 'btn-danger',
								'btn_icon' 		=> 'fa fa-times',
								'btn_title'		=> 'Tolak'
							);
				} elseif ($gd['kd_decision'] == 'phtg_skrd') {
					$cust 	= array(
								'btn_color' 	=> 'btn-info',
								'btn_icon' 		=> 'fa fa-superscript',
								'btn_title'		=> 'Hitung SKRD'
							);
					$url 	= 'permohonan_izin/ret_perhitungan';
					$link 	= 1;
				} elseif ($gd['kd_decision'] == 'lh_phtg_skrd') {
					$cust 	= array(
								'btn_color' 	=> 'btn-info',
								'btn_icon' 		=> 'fa fa-superscript',
								'btn_title'		=> 'Lihat SKRD'
							);
					$url 	= 'permohonan_izin/ret_lihat_perhitungan';
					$link 	= 1;
				} elseif ($gd['kd_decision'] == 'pdg_ver') {
					$cust 	= array(
								'btn_color' 	=> 'btn-warning',
								'btn_icon' 		=> 'fa fa-circle-o-notch',
								'btn_title'		=> 'Verifikasi Ulang'
							);
				} elseif ($gd['kd_decision'] == 'prm_pbyr') {
					$cust 	= array(
								'btn_color' 	=> 'btn-success',
								'btn_icon' 		=> 'fa fa-check',
								'btn_title'		=> 'Setujui'
							);
				}  elseif ($gd['kd_decision'] == 'ctk_skrd') {
					$cust 	= array(
								'btn_color' 	=> 'btn-primary',
								'btn_icon' 		=> 'fa fa-print',
								'btn_title'		=> 'Cetak SKRD'
							);
				} elseif ($gd['kd_decision'] == 'prbk') {
					$cust 	= array(
								'lbl_color' 	=> 'label-success',
								'lbl_title'		=> 'PENDING'
							);
					$label 	= 1;
				} elseif ($gd['kd_decision'] == 'pvw_draft') {
					$cust 	= array(
								'btn_color' 	=> 'btn-info',
								'btn_icon' 		=> 'fa fa-file-text',
								'btn_title'		=> 'Preview Kwitansi',
								'btn_function'	=> 'showDraft(this)'
							);
					$onclick = 1;
				} elseif ($gd['kd_decision'] == 'pvw_sertif') {
					$cust 	= array(
								'btn_color' 	=> 'btn-danger',
								'btn_icon' 		=> 'fa fa-file-pdf-o',
								'btn_title'		=> 'Preview Sertifikat',
								'btn_function'	=> 'showDraftSertif(this)'
							);
					$onclick = 1;
				} elseif ($gd['kd_decision'] == 'hps') {
					$cust 	= array(
								'btn_color' 	=> 'btn-danger',
								'btn_icon' 		=> 'fa fa-times',
								'btn_title'		=> 'Hapus'
							);
				} else {
					$cust 	= array(
								'btn_color' 	=> 'btn-default',
								'btn_icon' 		=> 'fa fa-search',
								'btn_title'		=> 'Not Found'
							);
				}

				if($link == 1) {
					$response 	.= '<a class="link-action" href="'.base_url($url).'?no_permohonan='.strtolower($no_permohonan).'">
										<button style="margin-right:5px;" type="button" class="btn '.$size.' btn-icon waves-effect '.$cust['btn_color'].' m-b-5 tooltip-hover"
										  	title="'.$cust['btn_title'].'"> <i class="'.$cust['btn_icon'].'"></i>
										</button>
									</a>';

				} elseif ($label == 1) {
					$response 	.= '<label class="label '.$cust['lbl_color'].'">'.$cust['lbl_title'].'</label>';

				} elseif ($onclick == 1) {
					$response 	.= '<button style="margin-right:5px;" type="button" data-id="'.$id_permohonan.'"
										class="btn '.$size.' btn-icon waves-effect '.$cust['btn_color'].' m-b-5 tooltip-hover tooltipstered"
										onclick="'.$cust['btn_function'].'"
										title="'.$cust['btn_title'].'"> <i class="'.$cust['btn_icon'].'"></i>
                              		</button>';

				} else {
					$response 	.= '<button style="margin-right:5px;"
										data-decision="'.$gd['id_workflow_decision'].'"
										data-aktivitas="'.$gd['id_aktivitas_workflow'].'"
										data-permohonan="'.$id_permohonan.'"
										data-action="'.$gd['kd_decision'].'"
											type="button" class="action btn '.$size.' btn-icon waves-effect '.$cust['btn_color'].' m-b-5 tooltip-hover"
									  		title="'.$cust['btn_title'].'"> <i class="'.$cust['btn_icon'].'"></i>
									</button>';
				}
			}

		};

		return $response;
	}

	public function select_delegasi($id_aktivitas_workflow) {
		$response 	= '';
		$response 	.= '<select class="form-control" name="id_user_select[]">';
        $response	.= '<option value="0">-Pilih Evaluator-</option>';

        $list_data 	= $this->M_permohonan_izin->get_userDelegation($id_aktivitas_workflow)->result_array();
        foreach ($list_data as $lD) {
        	$jml_tugas 	= 0;
        	$condition 	= [];
        	$condition[] = ['mak_param', 'verifikasi', 'where'];
        	$condition[] = ['id_user', $lD['id_user'], 'where'];
			// $jml_tugas	= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'count(id_permohonan) as jml_tugas', $condition)->row_array()['jml_tugas'];
			// $response	.= '<option value="'.$lD['id_user'].'">'.$lD['nm_user'].'('.$jml_tugas.')</option>';
			$response	.= '<option value="'.$lD['id_user'].'">'.$lD['nm_user'].'</option>';
        }

		$response 	.= '</select>';

		echo json_encode($response);
	}

	// function select_delegasits($id_aktivitas_workflow) {
	// 	$response 	= '';
	// 	$response 	.= '<select class="form-control" name="id_user_select[]">';
 //        $response	.= '<option value="0">-Pilih Evaluator-</option>';

 //        $list_data 	= $this->M_permohonan_izin->get_userDelegationts($id_aktivitas_workflow);
 //  //       foreach ($list_data as $lD) {
 //  //       	$jml_tugas 	= 0;
 //  //       	$condition 	= [];
 //  //       	$condition[] = ['mak_param', 'verifikasi', 'where'];
 //  //       	$condition[] = ['id_user', $lD['id_user'], 'where'];
	// 	// 	$jml_tugas	= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'id_permohonan', $condition)->num_rows();
	// 	// 	$response	.= '<option value="'.$lD['id_user'].'">'.$lD['nm_user'].'('.$jml_tugas.')</option>';
 //  //       }

	// 	// $response 	.= '</select>';

	// 	echo $list_data;
	// }

	private function get_next_workflow($id_jenis_izin, $id_aktivitas_workflow_now=null) {
		$list_workflow= $this->M_permohonan_izin->get_workflow($id_jenis_izin)->result_array();
		$jml_workflow = $this->M_permohonan_izin->get_workflow($id_jenis_izin)->num_rows();

		$next_aktivitas 			= $this->M_permohonan_izin->get_workflow($id_jenis_izin, 1)->row_array()['id_aktivitas_workflow'];

		foreach ($list_workflow as $lw => $value) {
			if ($list_workflow[$lw]['id_aktivitas_workflow'] == $id_aktivitas_workflow_now) {
				$next_aktivitas 	= $list_workflow[$lw+1]['id_aktivitas_workflow'];
			// } else {
				// $next_aktivitas 	= $this->M_permohonan_izin->get_workflow($id_jenis_izin, 'desc')->row_array()['id_aktivitas_workflow'];
			}
		}

		return $next_aktivitas;
	}

	private function get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow_now) {
		$condition 		= array();
		$condition[] 	= array('aktif', 1, 'where');
		$condition[] 	= array('id_workflow_decision', $id_workflow_decision, 'where');
		$next_aktivitas	= $this->M_permohonan_izin->get_master_spec('t_workflow_decision', 'direct_id_aktivitas_workflow', $condition)->row_array()['direct_id_aktivitas_workflow'];

		if (!$next_aktivitas) {
			$next_aktivitas = $this->get_next_workflow($id_jenis_izin, $id_aktivitas_workflow_now);
		}

		return $next_aktivitas;
	}

	private function get_next_user($id_aktivitas_workflow) {
		$count_user			= $this->M_permohonan_izin->get_user($id_aktivitas_workflow)->num_rows();
		$list_user			= $this->M_permohonan_izin->get_user($id_aktivitas_workflow)->result_array();

		$next_user 			= $this->M_permohonan_izin->get_user($id_aktivitas_workflow)->row_array()['id_user'];
		$last_user 			= $this->M_permohonan_izin->get_last_histori($id_aktivitas_workflow)->row_array()['id_user'];

		foreach ($list_user as $lu => $value) {
			if (($list_user[$lu]['id_user'] == $last_user) && ($lu+1 < $count_user)) {
				$next_user 	= $list_user[$lu+1]['id_user'];
			} else {
				break;
			}
		}

		return $next_user;
	}

	private function get_last_user($id_aktivitas_workflow, $id_permohonan) {
		$last_user 			= $this->M_permohonan_izin->get_last_histori($id_aktivitas_workflow, $id_permohonan)->row_array()['id_user'];

		return $last_user;
	}

	private function send_response($data) {
		$condition 	= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$condition[] 	= ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
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
				$receiver1 		= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'no_hp', $condition)->row_array()['no_hp'];

				// reciever
				$condition 		= [];
				$condition[] 	= ['id_pemohon', $data['id_pemohon'], 'where'];
				$receiver2 		= $this->M_permohonan_izin->get_master_spec('t_pemohon', 'no_hp', $condition)->row_array()['no_hp'];
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


			if ($dac['method'] == 'send_email') {
				$data_mg['rcv'] = $receiver;
				$data_mg['msg'] = $message;
				$data_mg['sj'] 	= $subject;

				$this->$dac['method']($data_mg);

			} else if ($dac['method'] == 'send_sms') {
				$data_mg1['rcv'] = $receiver1;
				$data_mg1['msg'] = $message;
				$data_mg1['sj']  = $subject;

				$data_mg2['rcv'] = $receiver2;
				$data_mg2['msg'] = $message;
				$data_mg2['sj']  = $subject;

				$this->$dac['method']($data_mg1);
				if ($receiver1 != $receiver2) {
					$this->$dac['method']($data_mg2);
				}
			}
			
			
		}
	}

	public function try_sms($no) {
    	$data_mg1['rcv'] = "$no";
		$data_mg1['msg'] = 'TEST MSG';
		$data_mg1['sj']  = 'TEST SBJ';
		
		$this->send_sms($data_mg1);
		
		echo 'test sms brader';
		echo $no;
	}

	 function send_email($data) {
		// $url = "http://182.253.11.251/production/epermit_api/api/send_email";
		// $post_data = [
		//     "rcv"   => $data['rcv'],
		//     "sj"    => $data['sj'],
		//     "msg"   => $data['msg'],
		//     "token" => '59079ec0d587c937c6e2d31e5dd2eb4e'
		// ];

		// $output = $this->curl->simple_post($url, $post_data);

		$this->load->library('email');

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://mail.yayasanyamini.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'info@yayasanyamini.com';
        $config['smtp_pass']    = 'Re2Mi3Do1';
        $config['charset']    = 'utf-8';
        // $config['newline']    = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      
        
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");  
        
        $this->email->from('info@yayasanyamini.com', 'Info Yayasan Yamini');
        $this->email->to('arifintkj26@gmail.com'); 
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');  
        
        $output = $this->email->send();
        
        // echo $this->email->print_debugger();
	}

	private function send_sms($data) {
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
		curl_exec($curlHandle);
		curl_close($curlHandle);
	}

	function api_bayar_permohonan() {
		$id_permohonan 			= $this->input->post('permohonan');
		$id_aktivitas_workflow 	= $this->input->post('aktivitas');
		$nominal 				= $this->input->post('nominal');
		$kode_bayar 			= $this->input->post('kode_bayar');

		$dhp = [];
		$dhp['id_permohonan'] 	= $id_permohonan;
		$dhp['kode_bayar'] 		= $kode_bayar;
		$dhp['nominal'] 		= $nominal;
		$dhp['tgl_bayar'] 		= date('Y-m-d H:i:s');
		$ins_dhp 				= $this->M_core->insert_tbl_normal('t_histori_pembayaran', $dhp);

		$condition 			= [];
		$condition[] 		= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
		$condition[] 		= ['type', 'ext', 'where'];
		$condition[] 		= ['aktif', 1, 'where'];
		$condition[] 		= ['1', 'limit'];
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
		$v_permohonan_izin 	= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', 'no_permohonan, id_pemohon, id_user_fe, id_nama_izin', $condition)->row_array();
		$no_permohonan   	= $v_permohonan_izin['no_permohonan'];
		$id_pemohon			= $v_permohonan_izin['id_pemohon'];
		$id_user_fe			= $v_permohonan_izin['id_user_fe'];
		$id_nama_izin		= $v_permohonan_izin['id_nama_izin'];

		$id_aktivitas_workflow_next	= $this->get_next_workflow_2($id_workflow_decision, $id_jenis_izin, $id_aktivitas_workflow);
		$id_user_next 				= $this->get_next_user($id_aktivitas_workflow_next);

		$data 	= array(
					'id_permohonan' 	=> $id_permohonan,
					'id_user' 			=> $id_user_next,
					'id_aktivitas_workflow'	=> $id_aktivitas_workflow_next,
					'catatan'			=> '',
					'id_workflow_decision'	=> $id_workflow_decision
				);

		$this->M_permohonan_izin->insert_histori($data);

		// terbitkan nomor izin & send notif
		$data['no_permohonan'] 			= $no_permohonan;
		$data['id_permohonan'] 			= $id_permohonan;
		$data['id_pemohon'] 			= $id_pemohon;
		$data['id_user_fe'] 			= $id_user_fe;
		$data['id_aktivitas_workflow'] 	= $id_aktivitas_workflow;
		$data['id_workflow_decision'] 	= $id_workflow_decision;
		$data['id_jenis_izin'] 			= $id_jenis_izin;
		$data['id_nama_izin'] 			= $id_nama_izin;
		
		$this->cek_config_terbit($data);
		$this->cek_config_terbit_skrd($data);
		$this->cek_config_ret_save($data);
		$this->cek_config_frz_skrd($data);
		$this->send_response($data);


		$this->session->set_flashdata("tipe-alert", "success");
		$this->session->set_flashdata("teks-alert", "Telah berhasil dibayar");
		$this->session->set_flashdata("icon-alert", "fa fa-check-circle");

		redirect('admin/test_api_pbyr');
	}

	private function cek_config_terbit($data) {
		$condition 			 = [];
		$condition[] 		 = ['aktif', 1, 'where'];
		$condition[] 		 = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
		$condition[] 		 = ['id_aktivitas_workflow', $data['id_aktivitas_workflow'], 'where'];
		$condition[] 		 = ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$check_cfg 			= $this->M_permohonan_izin->get_master_spec('m_izin_terbit_cfg', 'id_izin_terbit_cfg', $condition)->row_array();
		if ($check_cfg) {
			$this->terbit_noizin($data['id_permohonan']);
		}

	}

	private function cek_config_terbit_skrd($data) {
		$condition 			 = [];
		$condition[] 		 = ['aktif', 1, 'where'];
		$condition[] 		 = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
		$condition[] 		 = ['id_aktivitas_workflow', $data['id_aktivitas_workflow'], 'where'];
		$condition[] 		 = ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$check_cfg 			= $this->M_permohonan_izin->get_master_spec('m_skrd_terbit_cfg', 'id_skrd_terbit_cfg', $condition)->row_array();
		if ($check_cfg) {
			// var_dump('test bro');
			// var_dump($data);
			// exit();
			$this->terbit_noskrd($data['id_permohonan'], $data['id_nama_izin']);
			$this->terbit_kdbyr($data['id_permohonan'], $data['id_nama_izin']);
		}

	}


	private function cek_config_ret_save($data) {
		$condition 			 = [];
		$condition[] 		 = ['aktif', 1, 'where'];
		$condition[] 		 = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
		$condition[] 		 = ['id_aktivitas_workflow', $data['id_aktivitas_workflow'], 'where'];
		$condition[] 		 = ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$check_cfg 			= $this->M_permohonan_izin->get_master_spec('m_ret_save_cfg', 'id_ret_save_cfg', $condition)->row_array();
		if ($check_cfg) {
			$this->ret_submit_perhitungan_s($data['no_permohonan']);
		}

	}

	private function cek_config_frz_skrd($data) {
		$condition 			 = [];
		$condition[] 		 = ['aktif', 1, 'where'];
		$condition[] 		 = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
		$condition[] 		 = ['id_aktivitas_workflow', $data['id_aktivitas_workflow'], 'where'];
		$condition[] 		 = ['id_workflow_decision', $data['id_workflow_decision'], 'where'];
		$check_cfg 			= $this->M_permohonan_izin->get_master_spec('m_skrd_frz_cfg', 'id_skrd_frz_cfg', $condition)->row_array();
		if ($check_cfg) {
			$this->ret_generate_skrd($data['id_permohonan'], 1);
		}

	}

	private function get_workflow_spec($id_aktivitas_workflow, $id_aktivitas) {
		$condition 		= [];
		$condition[] 	= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
		$id_workflow 	= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_workflow', $condition)->row_array()['id_workflow'];

		$condition 		= [];
		$condition[] 	= ['id_workflow', $id_workflow, 'where'];
		$condition[] 	= ['id_aktivitas', $id_aktivitas, 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_aktivitas_workflow_next	= $this->M_permohonan_izin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow', $condition)->row_array()['id_aktivitas_workflow'];

		return $id_aktivitas_workflow_next;
	}

	public function terbit_ulang() {
		// $no_permohonan 	= $this->input->get('no_permohonan');

		$array 	= $this->M_admin->query('select a.id_permohonan from v_permohonan_izin a where a.id_aktivitas = 14 and NOT EXISTS( select * FROM t_izin_terbit b where a.id_permohonan = b.id_permohonan ) ORDER BY `a`.`id_permohonan` ASC')->result_array();


		foreach ($array as $ar) {
			// $no_permohonan 	= $a;
			// $condition 	= [];
			// $condition[] 	= ['no_permohonan', $no_permohonan, 'where'];
			// $id_permohonan	= $this->M_permohonan_izin->get_master_spec('t_permohonan', 'id_permohonan', $condition)->row_array()['id_permohonan'];

			$this->terbit_noizin($ar['id_permohonan']);
			echo $ar['id_permohonan'].', ';
		}
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
	        'Januari','Februari','Maret','April','Juni','Juli','Agustus','September',
	        'Oktober','November','Desember',
	    ];
	    $date = date ($date_format, $timestamp);
	    $date = preg_replace ($pattern, $replace, $date);
	    $date = "{$date} {$suffix}";

	    return $date;
	}

	function terbit_noizin($id_permohonan) {
		$condition 	= [];
		$condition[] 	= ['id_permohonan', $id_permohonan, 'where'];
		$dPer 			= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();

		// redefine
		$id_jenis_izin 	= $dPer['id_jenis_izin'];

		$condition 			= [];
		$condition[] 		= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$condition[] 		= ['aktif', 1, 'where'];
		$flags  			= $this->M_permohonan_izin->get_master_spec('t_flagging_izin', '*', $condition)->result_array();

		$id_formula_source 	= [];
		foreach ($flags as $fl) {
			$skip 	= 0;
			$ftext  			= $fl['text'];
			$id_formula_source 	= explode(', ', $fl['id_formula_sources']);

			foreach ($id_formula_source as $ifs) {
				$condition 			= [];
				$condition[] 		= ['id_formula_source', $ifs, 'where'];
				$condition[] 		= ['aktif', 1, 'where'];
				$fsource  			= $this->M_permohonan_izin->get_master_spec('t_formula_source', '*', $condition)->result_array();

				foreach ($fsource as $fsr) {
					$dPer['formula']= $fsr['formula'];
					$val 			= $this->$fsr['method']($dPer, $fsr['id_formula_source']);
					if ($val == 'FALSE') {
						continue 3;
					}

					$ftext 			= preg_replace('/#'.$fsr['id_formula_source'].'#/', $val, $ftext);

				}
			}

			// echo $ftext.'<br>';
			if ($fl['no_izin'] == 1) {
				$condition 		= [];
				$condition[] 	= ['id_jenis_izin', $dPer['id_jenis_izin'], 'where'];
				$condition[] 	= ['aktif', 1, 'where'];


				$masa_berlaku	= $this->M_permohonan_izin->get_master_spec('m_masa_izin_cfg', 'masa_berlaku', $condition)->row_array()['masa_berlaku'];
				$berlaku_sd 	= date("Y-m-d", strtotime(date("Y-m-d") . " + ".$masa_berlaku." year"));

				$data 	= [
							'id_permohonan' 	=> $id_permohonan,
							'no_izin' 			=> $ftext,
							'jml_tercetak'		=> 0,
							'tgl_terbit' 		=> date("Y-m-d"),
							'masa_berlaku' 		=> $masa_berlaku,
							'berlaku_sd' 		=> $berlaku_sd
						];

				$this->M_admin->insert_data('t_izin_terbit', $data);
			}

			$data 	= [
						'id_flagging_izin' 	=> $fl['id_flagging_izin'],
						'id_permohonan' 	=> $dPer['id_permohonan'],
						'text' 				=> $ftext
					];

			$this->M_admin->insert_data('t_flagging_data', $data);
		}

	}

	function terbit_noizin_sp($id_permohonan) {
		$execute 		= ['FIS32'];
		$condition 	= [];
		$condition[] 	= ['id_permohonan', $id_permohonan, 'where'];
		$dPer 			= $this->M_permohonan_izin->get_master_spec('v_permohonan_izin', '*', $condition)->row_array();

		// redefine
		$id_jenis_izin 	= $dPer['id_jenis_izin'];

		$condition 			= [];
		$condition[] 		= ['id_jenis_izin', $id_jenis_izin, 'where'];
		$condition[] 		= ['aktif', 1, 'where'];
		$flags  			= $this->M_permohonan_izin->get_master_spec('t_flagging_izin', '*', $condition)->result_array();

		// echo '<pre>';
		// var_dump($flags);
		$id_formula_source 	= [];
		foreach ($flags as $fl) {
			if (in_array($fl['kode_formula'], $execute)) {

			$skip 	= 0;
			$ftext  			= $fl['text'];
			$id_formula_source 	= explode(', ', $fl['id_formula_sources']);

			foreach ($id_formula_source as $ifs) {
				$condition 			= [];
				$condition[] 		= ['id_formula_source', $ifs, 'where'];
				$condition[] 		= ['aktif', 1, 'where'];
				$fsource  			= $this->M_permohonan_izin->get_master_spec('t_formula_source', '*', $condition)->result_array();

				foreach ($fsource as $fsr) {
					$dPer['formula']= $fsr['formula'];
					$val 			= $this->$fsr['method']($dPer, $fsr['id_formula_source']);
					if ($val == 'FALSE') {
						continue 3;
					}

					$ftext 			= preg_replace('/#'.$fsr['id_formula_source'].'#/', $val, $ftext);

				}
			}

			echo $ftext.'<br>';
			if ($fl['no_izin'] == 1) {
				$condition 		= [];
				$condition[] 	= ['id_jenis_izin', $dPer['id_jenis_izin'], 'where'];
				$condition[] 	= ['aktif', 1, 'where'];


				$masa_berlaku	= $this->M_permohonan_izin->get_master_spec('m_masa_izin_cfg', 'masa_berlaku', $condition)->row_array()['masa_berlaku'];
				$berlaku_sd 	= date("Y-m-d", strtotime(date("Y-m-d") . " + ".$masa_berlaku." year"));

				$data 	= [
							'id_permohonan' 	=> $id_permohonan,
							'no_izin' 			=> $ftext,
							'jml_tercetak'		=> 0,
							'tgl_terbit' 		=> date("Y-m-d"),
							'masa_berlaku' 		=> $masa_berlaku,
							'berlaku_sd' 		=> $berlaku_sd
						];

				$this->M_admin->insert_data('t_izin_terbit', $data);
			}

			$data 	= [
						'id_flagging_izin' 	=> $fl['id_flagging_izin'],
						'id_permohonan' 	=> $dPer['id_permohonan'],
						'text' 				=> $ftext
					];

			$this->M_admin->insert_data('t_flagging_data', $data);

			}
		}

	}

	function terbit_noskrd($id_permohonan, $id_nama_izin) {
		// kd izin
		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
	    $condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
 		$kd_nama_izin = $this->M_core->get_tbl('m_nama_izin', 'kd_nama_izin', $condition)->row_array()['kd_nama_izin'];

 		// check noskrd last
		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
 		$check 	      = $this->M_core->get_tbl('t_skrd_terbit', '*', $condition);
 		
 		$y = date('Y');
		$m = date('m'); 
 	
 		if($check->num_rows() == 0) {					
 			$no_skrd = $kd_nama_izin.substr($y, -2).$m.'1';

 		} else {
 			$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_skrd_terbit', 'desc', 'order_by'];
	 		$no_skrd_last = $this->M_core->get_tbl('t_skrd_terbit', 'no_skrd', $condition)->row_array()['no_skrd'];
	 			
	 		$frz = substr($no_skrd_last, 0, 6);

	 		if($frz == $kd_nama_izin.substr($y, -2).$m) {
	 			$last_num     = substr($no_skrd_last, 6);
	 			$no_skrd  	  = $kd_nama_izin.substr($y, -2).$m.$last_num+1;

	 		} else {
	 			$no_skrd 	  = $kd_nama_izin.substr($y, -2).$m.'1';
	 		}

	 		
 		}

		$data   = [];
		$data['id_permohonan'] 	= $id_permohonan;
		$data['no_skrd'] 		= $no_skrd;
		$data['jml_tercetak'] 	= '';
		$data['tgl_terbit'] 	= date('Y-m-d');
		$data['masa_berlaku'] 	= '';
		$data['berlaku_sd']	 	= '';
		$data['aktif'] 			= 1;

		$insert = $this->M_core->insert_tbl_normal('t_skrd_terbit', $data);
	}

	function terbit_kdbyr($id_permohonan, $id_nama_izin) {
		// kd izin		
		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
	    $condition[]  = ['id_nama_izin', $id_nama_izin, 'where'];
 		$kd_nama_izin = $this->M_core->get_tbl('m_nama_izin', 'kd_nama_izin', $condition)->row_array()['kd_nama_izin'];

		// check noskrd last
		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
 		$check 	      = $this->M_core->get_tbl('t_kode_bayar', '*', $condition);
 		
 		$y = date('Y');
		$m = date('m'); 
 	
 		if($check->num_rows() == 0) {					
 			$kode_bayar = $kd_nama_izin.substr($y, -2).$m.'1';

 		} else {
 			$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_kode_bayar', 'desc', 'order_by'];
	 		$kode_bayar_last = $this->M_core->get_tbl('t_kode_bayar', 'kode_bayar', $condition)->row_array()['kode_bayar'];
	 		
	 		$frz = substr($kode_bayar_last, 0, 6);

	 		if($frz == $kd_nama_izin.substr($y, -2).$m) {
	 			$last_num     = substr($kode_bayar_last, 6);
	 			$kode_bayar   = $kd_nama_izin.substr($y, -2).$m.$last_num+1;

	 		} else {
	 			$kode_bayar   = $kd_nama_izin.substr($y, -2).$m.'1';
	 		}
 		}

		$data   = [];
		$data['id_permohonan'] 	= $id_permohonan;
		$data['kode_bayar'] 	= $kode_bayar;
		$data['tgl_terbit'] 	= date('Y-m-d');
		$data['masa_berlaku'] 	= '';
		$data['berlaku_sd']	 	= '';	
		$data['aktif'] 			= 1;		

		$insert = $this->M_core->insert_tbl_normal('t_kode_bayar', $data);
	}

	function fniz_siup($data, $idf) {
		$kode_ref 	= $this->fkls_prsh($data, $idf);

		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['kode_ref', $kode_ref, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

		$condition 	= [];
		// $condition[] 	= ['id_nama_izin', $data['id_nama_izin'], 'where'];
		$condition[] 	= ['kode_ref', $kode_ref, 'where'];
		$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
		$count 		= $tdata['count'];

		// insert for incs
		$datai 	= [
					'id_formula_source' => $idf,
					'kode_ref' 			=> $kode_ref,
					'count' 			=> 1
					// 'id_nama_izin' 		=> $data['id_nama_izin']
				];

		$data 	= [
					'count' 			=> $count+1
				];

		$condition 		= [];
		$condition[0] 	= 'id_flagging_count';
		$condition[1] 	= $tdata['id_flagging_count'];
		$condition[2] 	= 'where';

		if ($tdata) {
			$this->M_admin->update_data('t_flagging_count', $condition, $data);
		} else {
			$this->M_admin->insert_data('t_flagging_count', $datai);
			$count 	= $datai['count'] - 1;
		}

		// end free_num
		}

		return str_pad($count+1, 5, '0', STR_PAD_LEFT);
	}

	function fniz_sipa($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['id_nama_izin', $data['id_nama_izin'], 'where'];
		$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
		$count 		= $tdata['count'];

		// insert for incs
		$kode_ref 	= null;
		$datai 	= [
					'id_formula_source' => $idf,
					'kode_ref' 			=> $kode_ref,
					'count' 			=> 1,
					'id_nama_izin' 		=> $data['id_nama_izin']
				];

		$data 	= [
					'count' 			=> $count+1
				];

		$condition 		= [];
		$condition[0] 	= 'id_flagging_count';
		$condition[1] 	= $tdata['id_flagging_count'];
		$condition[2] 	= 'where';

		if ($tdata) {
			$this->M_admin->update_data('t_flagging_count', $condition, $data);
		} else {
			$this->M_admin->insert_data('t_flagging_count', $datai);
			$count 	= $datai['count'] - 1;
		}

		return str_pad($count+1, 5, '0', STR_PAD_LEFT);
	}

	function fniz_iujk($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['id_nama_izin', $data['id_nama_izin'], 'where'];
		$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
		$count 		= $tdata['count'];

		// insert for incs
		$kode_ref 	= null;
		$datai 	= [
					'id_formula_source' => $idf,
					'kode_ref' 			=> $kode_ref,
					'count' 			=> 1,
					'id_nama_izin' 		=> $data['id_nama_izin']
				];

		$data 	= [
					'count' 			=> $count+1
				];

		$condition 		= [];
		$condition[0] 	= 'id_flagging_count';
		$condition[1] 	= $tdata['id_flagging_count'];
		$condition[2] 	= 'where';

		if ($tdata) {
			$this->M_admin->update_data('t_flagging_count', $condition, $data);
		} else {
			$this->M_admin->insert_data('t_flagging_count', $datai);
			$count 	= $datai['count'] - 1;
		}

		return str_pad($count+1, 5, '0', STR_PAD_LEFT);
	}

	function fiujk_sbu($data, $idf) {
		$formula_r 	= [];
		$formula_r 	= explode(' & ', $data['formula']);

		$formula1 	= explode(', ', $formula_r[0]);
		$formula2 	= explode(', ', $formula_r[1]);

		$data['formula'] 	= null;
		foreach ($formula1 as $f => $v) {
			$data['formula'][$formula1[$f]]	= $formula2[$f];
		}


		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][$data['id_jenis_izin']], 'where'];
		$dRkb 			= $this->M_permohonan_izin->get_master_spec('m_rekam_berkas_s', 'tipe_data, id_rekam_berkas_s, table_tujuan_s', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_rekam_berkas_s', $dRkb['id_rekam_berkas_s'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dRkb['table_tujuan_s'], 'nilai_'.$dRkb['tipe_data'], $condition)->row_array()['nilai_'.$dRkb['tipe_data']];

		return $value;
	}

	function fniz_tdp($data, $idf) {
		$kode_ref 	= $this->ftdp_bu($data, $idf);

		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['kode_ref', $kode_ref, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

		$condition 	= [];
		$condition[]= ['id_formula_source', $idf, 'where'];
		$condition[]= ['kode_ref', $kode_ref, 'where'];
		$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
		$count 		= $tdata['count'];

		// insert for incs
		$datai 	= [
					'id_formula_source' => $idf,
					'kode_ref' 			=> $kode_ref,
					'count' 			=> 1,
					'id_nama_izin' 		=> $data['id_nama_izin']
				];

		$data 	= [
					'count' 			=> $count+1
				];

		$condition 		= [];
		$condition[0] 	= 'id_flagging_count';
		$condition[1] 	= $tdata['id_flagging_count'];
		$condition[2] 	= 'where';

		if ($tdata) {
			$this->M_admin->update_data('t_flagging_count', $condition, $data);
		} else {
			$this->M_admin->insert_data('t_flagging_count', $datai);
			$count 	= $datai['count'] - 1;
		}

		// end frev
		}

		return str_pad($count+1, 5, '0', STR_PAD_LEFT);
	}

	function fkls_prsh($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_s, tipe_data', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		$sign  		= '';
		if ($value > 0 && $value <= 50000000) {
			$sign 	= 'Pm';
		} elseif ($value >= 51000000 && $value <= 500000000) {
			$sign 	= 'PK';
		} elseif ($value >= 501000000 && $value <= 10000000000) {
			$sign 	= 'PM';
		} elseif ($value > 10000000000) {
			$sign 	= 'PB';
		}
		return $sign;
	}

	function ftdp_bu($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_perusahaan_bio_p= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_p'], 'id_perusahaan_bio_p', $condition)->row_array()['id_perusahaan_bio_p'];

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_p', $id_perusahaan_bio_p, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_p', 'nama_perusahaan_bio_p', $condition)->row_array()['nama_perusahaan_bio_p'];

		$sign  		= '';
		if ($value == 'perorangan') {
			$sign 	= '5';
		} elseif ($value == 'pma') {
			$sign 	= '1';
		} elseif ($value == 'pt') {
			$sign 	= '1';
		} elseif ($value == 'cv') {
			$sign 	= '3';
		} elseif ($value == 'koperasi') {
			$sign 	= '2';
		} elseif ($value == 'bentuk_usaha_lain') {
			$sign 	= '4';
		}

		return $sign;
	}


	function ftdp_kbli($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_p'], 'nilai_string', $condition)->row_array()['nilai_string'];

		$value 			= substr($value, 0, 2);

		return $value;
	}

	function faiz_agd($data, $idf) {
		$sign 	= $this->ftdp_bu($data, $idf);

		if ($sign == 1) {
			$condition 	= [];
			$condition[]	= ['id_formula_source', $idf, 'where'];
			$condition[]	= ['aktif', 1, 'where'];
			$condition[]	= ['text', 'asc', 'order_by'];
			$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

			if ($frev) {
				$count 	= intval($frev['text'])-1;

					$data 	= [
						'aktif' 			=> 0
					];

				$condition 		= [];
				$condition[0] 	= 'id_free_num';
				$condition[1] 	= $frev['id_free_num'];
				$condition[2] 	= 'where';

				$this->M_admin->update_data('t_free_num', $condition, $data);
			} else {

				$condition 	= [];
				$condition[] 	= ['id_formula_source', $idf, 'where'];
				$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
				$count 		= $tdata['count'];

				// insert for incs
				$kode_ref 	= null;
				$datai 	= [
							'id_formula_source' => $idf,
							'kode_ref' 			=> $kode_ref,
							'count' 			=> 1,
							'id_nama_izin' 		=> $data['id_nama_izin']
						];

				$data 	= [
							'count' 			=> $count+1
						];

				$condition 		= [];
				$condition[0] 	= 'id_flagging_count';
				$condition[1] 	= $tdata['id_flagging_count'];
				$condition[2] 	= 'where';
				if ($tdata) {
					$this->M_admin->update_data('t_flagging_count', $condition, $data);
				} else {
					$this->M_admin->insert_data('t_flagging_count', $datai);
					$count 	= $datai['count'] - 1;
				}

			// end frev
			}
			return str_pad($count+1, 4, '0', STR_PAD_LEFT);
		} else {
			return 'FALSE';
		}

	}

	function fagd_dt($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$date  		= $this->M_permohonan_izin->get_master_spec('t_permohonan', 'tgl_permohonan', $condition)->row_array()['tgl_permohonan'];

		$month 	 	= array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

		return $month[date('n', strtotime($date))].'/'.date('Y', strtotime($date));
	}

	function fnizg_tdp($data, $idf) {

		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

		$condition 	= [];
		$condition[] 	= ['id_formula_source', $idf, 'where'];
		$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
		$count 		= $tdata['count'];

		// insert for incs
		$kode_ref 	= null;
		$datai 	= [
					'id_formula_source' => $idf,
					'kode_ref' 			=> $kode_ref,
					'count' 			=> 1,
					'id_nama_izin' 		=> $data['id_nama_izin']
				];

		$data 	= [
					'count' 			=> $count+1
				];

		$condition 		= [];
		$condition[0] 	= 'id_flagging_count';
		$condition[1] 	= $tdata['id_flagging_count'];
		$condition[2] 	= 'where';

		if ($tdata) {
			$this->M_admin->update_data('t_flagging_count', $condition, $data);
		} else {
			$this->M_admin->insert_data('t_flagging_count', $datai);
			$count 	= $datai['count'] - 1;
		}

		// end frev
		}

		return str_pad($count+1, 5, '0', STR_PAD_LEFT);
	}

	function fkls_prshj($data, $idf)	 {
		$value 	= $this->fkls_prsh($data, $idf);

		$sign  		= '';
		if ($value 	== 'Pm') {
			$sign 	= 'MIKRO';
		} elseif ($value == 'PK') {
			$sign 	= 'KECIL';
		} elseif ($value == 'PM') {
			$sign 	= 'MENENGAH';
		} elseif ($value == 'PB') {
			$sign 	= 'BESAR';
		}

		return $sign;
	}

	function ftdp_lama($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'tipe_data, id_perusahaan_bio_s, table_tujuan_s', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		return $value;
	}

	function fcek_tdpl($data, $idf) {
		$data['formula']= explode(', ', $data['formula']);

		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][0], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'tipe_data, id_perusahaan_bio_s, table_tujuan_s', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		$kbli_l 		= substr($value, 5, 2);

		$data['formula']= $data['formula'][1];
		$kbli 	= $this->ftdp_kbli($data, $idf);

		$skip 	= '';
		if ($kbli_l == $kbli) {
			$skip 	= 'FALSE';
		}

		return $skip;
	}

	function fcek_tdpl2($data, $idf) {
		$data['formula']= explode(', ', $data['formula']);

		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][0], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'tipe_data, id_perusahaan_bio_s, table_tujuan_s', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		$kbli_l 		= substr($value, 5, 2);

		$data['formula']= $data['formula'][1];
		$kbli 	= $this->ftdp_kbli($data, $idf);

		$skip 	= '';
		if ($kbli_l != $kbli) {
			$skip 	= 'FALSE';
		}

		return $skip;
	}



	function fju_iujk($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'id_syarat_izin_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_s', $dPrh['id_syarat_izin_s'], 'where'];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_syarat_izin_p= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_p'], 'id_syarat_izin_p', $condition)->row_array()['id_syarat_izin_p'];

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_p', $id_syarat_izin_p, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_p', 'nama_syarat_izin_p', $condition)->row_array()['nama_syarat_izin_p'];

		$sign  		= '';
		if ($value == 'konsultan') {
			$sign 	= '1';
		} elseif ($value == 'konstruksi') {
			$sign 	= '2';
		}

		return $sign;
	}

	function fsd_tdp($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_s, tipe_data', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		$year 			= date('Y', strtotime($value)) + 5;
		$day 		    = date('d-m-', strtotime($value));

		$sign 			= $day.$year;

		$sign 			= $this->indonesian_date($sign);

		return $sign;
	}

	function fsd_tdpdu($data, $idf) {
		$data['formula']= explode(', ', $data['formula']);


		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][1], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_s, tipe_data', $condition)->row_array();

		$data['formula']= $data['formula'][0];
		$berlaku_sd 	= $this->fsd_tdp($data, $idf);

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		$year1 			= substr($berlaku_sd, -5, 4);
		$year2 			= date('Y', strtotime($value));

		$prpj 			= intval(($year1-$year2)/5);
		$prpj 			= $prpj-1;

		return str_pad($prpj, 2, '0', STR_PAD_LEFT);
	}

	function fsd_tdp2($data, $idf) {
		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_s, tipe_data', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		if (strtotime($value) < strtotime('+3 months', strtotime('now'))) {
			$year 			= date('Y', strtotime($value)) + 5;
			$day 		    = date('d-m-', strtotime($value));

			$sign 			= $day.$year;
		} else {
			$sign 			= date('d-m-Y', strtotime($value));
		}

		$sign 			= $this->indonesian_date($sign);

		return $sign;
	}

	function fsd_tdpdu2($data, $idf) {
		$data['formula']= explode(', ', $data['formula']);


		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][1], 'where'];
		$dPrh 			= $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', 'id_perusahaan_bio_s, table_tujuan_s, tipe_data', $condition)->row_array();

		$data['formula']= $data['formula'][0];
		$berlaku_sd 	= $this->fsd_tdp2($data, $idf);

		$condition 		= [];
		$condition[] 	= ['id_perusahaan_bio_s', $dPrh['id_perusahaan_bio_s'], 'where'];
		$condition[] 	= ['id_perusahaan', $data['id_perusahaan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dPrh['table_tujuan_s'], 'nilai_'.$dPrh['tipe_data'], $condition)->row_array()['nilai_'.$dPrh['tipe_data']];

		$year1 			= substr($berlaku_sd, -5, 4);
		$year2 			= date('Y', strtotime($value));

		$prpj 			= intval(($year1-$year2)/5);
		$prpj 			= $prpj-1;

		return str_pad($prpj, 2, '0', STR_PAD_LEFT);
	}

	function fiujk_lama($data, $idf) {
		$formula_r 	= [];
		$formula_r 	= explode(' & ', $data['formula']);

		$formula1 	= explode(', ', $formula_r[0]);
		$formula2 	= explode(', ', $formula_r[1]);

		$data['formula'] 	= null;
		foreach ($formula1 as $f => $v) {
			$data['formula'][$formula1[$f]]	= $formula2[$f];
		}

		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][$data['id_jenis_izin']], 'where'];
		$dSya 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'tipe_data, id_syarat_izin_s, table_tujuan_s', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_s', $dSya['id_syarat_izin_s'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec($dSya['table_tujuan_s'], 'nilai_'.$dSya['tipe_data'], $condition)->row_array()['nilai_'.$dSya['tipe_data']];

		return $value;
	}

	function fniz_iptm($data, $idf) {
		$formula_r 	= [];
		$formula_r 	= explode(' & ', $data['formula']);

		$formula1 	= explode(', ', $formula_r[0]);
		$formula2 	= explode(', ', $formula_r[1]);

		$data['formula'] 	= null;
		foreach ($formula1 as $f => $v) {
			$data['formula'][$formula1[$f]]	= $formula2[$f];
		}


		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][$data['id_jenis_izin']], 'where'];
		$dSyr 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'tipe_data, id_syarat_izin_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_s', $dSyr['id_syarat_izin_s'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$id_syarat_izin_p= $this->M_permohonan_izin->get_master_spec($dSyr['table_tujuan_p'], 'id_syarat_izin_p', $condition)->row_array()['id_syarat_izin_p'];

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_p', $id_syarat_izin_p, 'where'];
		$kode_ref		= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_p', 'teks_judul', $condition)->row_array()['teks_judul'];

		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['kode_ref', $kode_ref, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

			$condition 	= [];
			$condition[] 	= ['id_formula_source', $idf, 'where'];
			$condition[] 	= ['kode_ref', $kode_ref, 'where'];
			$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
			$count 		= $tdata['count'];

			// insert for incs
			$datai 	= [
						'id_formula_source' => $idf,
						'kode_ref' 			=> $kode_ref,
						'count' 			=> 1,
						'id_nama_izin' 		=> $data['id_nama_izin']
					];

			$data 	= [
						'count' 			=> $count+1
					];

			$condition 		= [];
			$condition[0] 	= 'id_flagging_count';
			$condition[1] 	= $tdata['id_flagging_count'];
			$condition[2] 	= 'where';
			if ($tdata) {
				$this->M_admin->update_data('t_flagging_count', $condition, $data);
			} else {
				$this->M_admin->insert_data('t_flagging_count', $datai);
				$count 	= $datai['count'] - 1;
			}

		// end frev
		}

		return str_pad($count+1, 4, '0', STR_PAD_LEFT);
	}

	function fjiz_iptm($data, $idf) {
		$condition 	= [];
		$condition[] = ['id_jenis_izin', $data['id_jenis_izin'], 'where'];
		$value   		= $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'jenis_izin', $condition)->row_array()['jenis_izin'];

		$value 			= strtoupper($value);

		return $value;
	}

	function fjiz_imb($data, $idf) {
		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

			$condition 	= [];
			$condition[] 	= ['id_formula_source', $idf, 'where'];
			$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
			$count 		= $tdata['count'];

			// insert for incs
			$kode_ref 	= null;
			$datai 	= [
						'id_formula_source' => $idf,
						'kode_ref' 			=> $kode_ref,
						'count' 			=> 1,
						'id_nama_izin' 		=> $data['id_nama_izin']
					];

			$data 	= [
						'count' 			=> $count+1
					];

			$condition 		= [];
			$condition[0] 	= 'id_flagging_count';
			$condition[1] 	= $tdata['id_flagging_count'];
			$condition[2] 	= 'where';
			if ($tdata) {
				$this->M_admin->update_data('t_flagging_count', $condition, $data);
			} else {
				$this->M_admin->insert_data('t_flagging_count', $datai);
				$count 	= $datai['count'] - 1;
			}

		// end frev
		}
		return str_pad($count+1, 4, '0', STR_PAD_LEFT);
	}

	function fniz_sipb($data, $idf) {
		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

			$condition 	= [];
			$condition[] 	= ['id_formula_source', $idf, 'where'];
			$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
			$count 		= $tdata['count'];

			// insert for incs
			$kode_ref 	= null;
			$datai 	= [
						'id_formula_source' => $idf,
						'kode_ref' 			=> $kode_ref,
						'count' 			=> 1,
						'id_nama_izin' 		=> $data['id_nama_izin']
					];

			$data 	= [
						'count' 			=> $count+1
					];

			$condition 		= [];
			$condition[0] 	= 'id_flagging_count';
			$condition[1] 	= $tdata['id_flagging_count'];
			$condition[2] 	= 'where';
			if ($tdata) {
				$this->M_admin->update_data('t_flagging_count', $condition, $data);
			} else {
				$this->M_admin->insert_data('t_flagging_count', $datai);
				$count 	= $datai['count'] - 1;
			}

		// end frev
		}
		return str_pad($count+1, 4, '0', STR_PAD_LEFT);
	}

	function fjiz_sipb($data, $idf) {
		$formula_r 	= [];
		$formula_r 	= explode(' & ', $data['formula']);

		$formula1 	= explode(', ', $formula_r[0]);
		$formula2 	= explode(', ', $formula_r[1]);

		$data['formula'] 	= null;
		foreach ($formula1 as $f => $v) {
			$data['formula'][$formula1[$f]]	= $formula2[$f];
		}


		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][$data['id_jenis_izin']], 'where'];
		$dSyr 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'tipe_data, id_syarat_izin_s, table_tujuan_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_s', $dSyr['id_syarat_izin_s'], 'where'];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_syarat_izin_p= $this->M_permohonan_izin->get_master_spec($dSyr['table_tujuan_p'], 'id_syarat_izin_p', $condition)->row_array()['id_syarat_izin_p'];

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_p', $id_syarat_izin_p, 'where'];
		$result 		= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_p', 'nama_syarat_izin_p', $condition)->row_array()['nama_syarat_izin_p'];

		$value 			= '';
		if ($result == 'instansi') {
			$value 	= 'PB';
		} elseif ($result == 'mandiri') {
			$value 	= 'PBM';
		}
		
		return strtoupper($value);
	}

	function fniz_sipd($data, $idf) {
		$condition 	= [];
		$condition[]	= ['id_formula_source', $idf, 'where'];
		$condition[]	= ['aktif', 1, 'where'];
		$condition[]	= ['text', 'asc', 'order_by'];
		$frev   		= $this->M_permohonan_izin->get_master_spec('t_free_num', 'id_free_num, text', $condition)->row_array();

		if ($frev) {
			$count 	= intval($frev['text'])-1;

				$data 	= [
					'aktif' 			=> 0
				];

			$condition 		= [];
			$condition[0] 	= 'id_free_num';
			$condition[1] 	= $frev['id_free_num'];
			$condition[2] 	= 'where';

			$this->M_admin->update_data('t_free_num', $condition, $data);
		} else {

			$condition 	= [];
			$condition[] 	= ['id_formula_source', $idf, 'where'];
			$tdata   	= $this->M_permohonan_izin->get_master_spec('t_flagging_count', 'id_flagging_count, count', $condition)->row_array();
			$count 		= $tdata['count'];

			// insert for incs
			$kode_ref 	= null;
			$datai 	= [
						'id_formula_source' => $idf,
						'kode_ref' 			=> $kode_ref,
						'count' 			=> 1,
						'id_nama_izin' 		=> $data['id_nama_izin']
					];

			$data 	= [
						'count' 			=> $count+1
					];

			$condition 		= [];
			$condition[0] 	= 'id_flagging_count';
			$condition[1] 	= $tdata['id_flagging_count'];
			$condition[2] 	= 'where';
			if ($tdata) {
				$this->M_admin->update_data('t_flagging_count', $condition, $data);
			} else {
				$this->M_admin->insert_data('t_flagging_count', $datai);
				$count 	= $datai['count'] - 1;
			}

		// end frev
		}
		return str_pad($count+1, 4, '0', STR_PAD_LEFT);
	}

	function fjiz_sipd($data, $idf) {
		$formula_r 	= [];
		$formula_r 	= explode(' & ', $data['formula']);

		$formula1 	= explode(', ', $formula_r[0]);
		$formula2 	= explode(', ', $formula_r[1]);

		$data['formula'] 	= null;
		foreach ($formula1 as $f => $v) {
			$data['formula'][$formula1[$f]]	= $formula2[$f];
		}


		$condition 	= [];
		$condition[] 	= ['kode_formula', $data['formula'][$data['id_jenis_izin']], 'where'];
		$dSyr 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_s', 'tipe_data, id_syarat_izin_s, table_tujuan_s, table_tujuan_p', $condition)->row_array();

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_s', $dSyr['id_syarat_izin_s'], 'where'];
		$condition[] 	= ['id_permohonan', $data['id_permohonan'], 'where'];
		$condition[] 	= ['aktif', 1, 'where'];
		$id_syarat_izin_p= $this->M_permohonan_izin->get_master_spec($dSyr['table_tujuan_p'], 'id_syarat_izin_p', $condition)->row_array()['id_syarat_izin_p'];

		$condition 		= [];
		$condition[] 	= ['id_syarat_izin_p', $id_syarat_izin_p, 'where'];
		$value 			= $this->M_permohonan_izin->get_master_spec('m_syarat_izin_p', 'nama_syarat_izin_p', $condition)->row_array()['nama_syarat_izin_p'];

		return strtoupper($value);
	}

	private function str_clean($string) {
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	   return $string;
	}


}
