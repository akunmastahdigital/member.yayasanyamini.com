<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {
	function __construct() {
        parent::__construct();

          if (!$this->session->userdata('id_user')) {
        	redirect('user/login');
        }
        
	}

	
	var $opt_jenis_input 	= [
					0 =>['value' => 'text', 'name' => "Teks"],
				 	1 =>['value' => 'number', 'name' => "Nomor"],
				 	2 =>['value' => 'file', 'name' => "File"],
				 	3 =>['value' => 'email', 'name' => "Email"],
				 	4 =>['value' => 'select', 'name' => "Select"],
				 	5 =>['value' => 'tbl', 'name' => "Tabel"],
				 	6 =>['value' => 'date', 'name' => "Date"]
			 	];	

	var $opt_tipe_data 		= [
					0 =>['value' => null, 'name' => "Null"],
					1 =>['value' => 'string', 'name' => "String"],
				 	2 =>['value' => 'num', 'name'=> "Numerik"]
			 	];	

	var $opt_akses 			= [
					0 =>['value' => 0, 'name' => "Not Allowed"],
					1 =>['value' => 1, 'name' => "Readonly"],
				 	2 =>['value' => 2, 'name'=> "Writeable"]
			 	];		
	
	function index() {
        // show_404();
        echo 'jeng';
	}

	function tutorial(){
		$d['menu']  = 'Admin';
        $d['page']  = 'tutorial_page';
        $d['title']	= 'List Tutorial';
        // $d['list_progress_user'] = $this->get_progress_user();

		$this->load->view('layout', $d);
	}

	function user_fe() {
        $d['page']      	= 'user_fe';
        $d['menu']      	= 'Pengolahan User';
        $d['title']			= 'Pengolahan User Front Office';

		$this->load->view('layout', $d);
	}

	function showPemohonNonVerification(){

		$table = 'v_user_fe_non_verification';
		$column_order   = array(null, 'id_user_fe', 'nm_user','email_user', null, null); 
        $column_search  = array('id_user_fe', 'nm_user', 'email_user'); 
        $order          = array('id_user_fe' => 'asc');

        $list_data		= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];

        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_user_fe="'.$ld->id_user_fe.'" type="checkbox" id="lbl-'.$ld->id_user_fe.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_user_fe.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_user_fe="'.$ld->id_user_fe.'" type="checkbox" id="lbl-'.$ld->id_user_fe.'" switch="none" >
                                            <label for="lbl-'.$ld->id_user_fe.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nm_user;
            $row[] = $ld->email_user;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_user_fe.'" data-action="del" data-id_user_fe="'.$ld->id_user_fe.'" class="action btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered"
					  		title="Hapus User"> <i class="fa fa-times"></i> 
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

	function showPemohonVerification(){

		$table = 'v_user_fe_verification';
		$column_order   = array(null, 'id_user_fe', 'nm_user','email_user', null, null); 
        $column_search  = array('id_user_fe', 'nm_user', 'email_user'); 
        $order          = array('id_user_fe' => 'asc');

        $list_data		= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];

        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {

                 $html_stat 	= '<span class="label label-primary label-lg">Telah Diverifikasi</span>';

        	} else {

        		$html_stat 	= '<span class="label label-danger label-lg">Belum Diverifikasi</span>';
        		
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nm_user;
            $row[] = $ld->email_user;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_user_fe.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function userfe_action($action){
		if ($action == "aktif") {
			$id_user_fe = $this->input->post('id_user_fe');
			$status =  $this->input->post('status');
			$data = [
						'aktif' => $status
					];
			$condition  	= [];
			$condition[0]   = 'id_user_fe';
			$condition[1]	= $id_user_fe;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_user_fe', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif($action == "del"){
			$id_user_fe = $this->input->post('id_user_fe');
			$data = [
						'aktif' => 3
					];
			$condition = [];
			$condition[0] = 'id_user_fe';
			$condition[1] = $id_user_fe; 
			$condition[2] = 'where';
			$this->M_admin->update_data('m_user_fe', $condition, $data);

			$response = ['status' => 'TERHAPUS'];
		}
		echo json_encode($response);
	}

	function draft_sk() {
        $d['page']      	= 'draft_sk';
        $d['menu']      	= 'Pengaturan Template';
        $d['title']			= 'Pengolahan Template';

		$this->load->view('layout', $d);
	}

	function hak_akses() {
        $d['page']      	= 'hak_akses';
        $d['menu']      	= 'Pengaturan Hak Akses';
        $d['title']			= 'Pengaturan Hak Akses';
        $d['menu1']      	= 'Pengaturan Menu';
        $d['title1']		= 'Pengaturan Menu';
        $d['getJabatan']	= $this->M_admin->getJabatan()->result();
        $d['treeMenu']		= $this->M_akses->tampilMenuTree();

        $Lcondition			= [];
        $Lcondition[]		= ['aktif', 1, 'where'];
        $Lcondition[]		= ['id_parent', 0, 'where'];
        $Lcondition[]		= ['url', '#', 'or_where'];
        $value				= 'id_menu_bo';
        $name 				= 'nm_menu';
        $d['ListMenuParent']= $this->list_bootstrap_select_2('m_menu_bo', $value, $name, $Lcondition);

		$this->load->view('layout', $d);
	}

	function hak_akses_action($action){
		if ($action == "add") {

			$nm_menu		= $this->input->post('nm_menu');
			$url 			= $this->input->post('url');
			$icon 			= $this->input->post('icon');
			$id_parent		= $this->input->post('id_parent');

			$data = [
						'nm_menu' 	=> $nm_menu,
						'url'	  	=> $url,
						'icon'	  	=> $icon,
						'id_parent' => $id_parent,
						'aktif'		=> 1

					];

			$id_menu_bo = $this->M_admin->insert_data('m_menu_bo', $data);



			$this->db->select("id_role");
			$this->db->from('m_role');
			$this->db->limit(1);
			$this->db->order_by('id_role','asc');
			$getFirstIdRole = $this->db->get()->result();

			foreach ($getFirstIdRole as $get) {
				
			}

			$cek = $get->id_role;

			$this->db->select('id_role, nm_role');
			$this->db->from('m_role');
			$jumlahId = $this->db->get()->num_rows();

			for ($i=$cek; $i <= $jumlahId + 1 ; $i++) { 
				$data1 = [

						'id_menu_bo' => $id_menu_bo,
						'aktif'		 => 0,
						'id_role'	 => $i

					];
				$this->M_admin->insert_data('m_role_menu', $data1);
			}


			$response 	= ['status' => "OK"];


		}

		elseif ($action == "detail") {
			$id_menu_bo 	= $this->input->post('id_menu_bo');

			$condition 		= [];
			$condition[]	= ['id_menu_bo', $id_menu_bo, 'where'];

			$response 		= $this->M_admin->get_master_spec('m_menu_bo', 'id_menu_bo, nm_menu, url, id_parent, icon' , $condition)->row_array();

			$Lcondition		= [];
        	$Lcondition[]		= ['aktif', 1, 'where'];
        	$Lcondition[]		= ['id_parent', 0, 'where'];
        	$Lcondition[]		= ['url', '#', 'or_where'];
        	$value			= 'id_menu_bo';
        	$name 			= 'nm_menu';

        	$response['sl_parent']= $this->list_bootstrap_select('m_menu_bo', $value, $name, $Lcondition, $response['id_parent']);


		}

		elseif ($action == "edit") {
			$id_menu_bo		= $this->input->post('id_menu_bo');
			$nm_menu		= $this->input->post('nm_menu');
			$url 			= $this->input->post('url');
			$icon 			= $this->input->post('icon');
			$id_parent		= $this->input->post('id_parent');

			$data 			= [
								'nm_menu' 	=> $nm_menu,
								'url'	  	=> $url,
								'icon'	  	=> $icon,
								'id_parent' => $id_parent,
								'aktif'		=> 1
								];

			$condition 		= [];
			$condition[0] 	= 'id_menu_bo';
			$condition[1] 	= $id_menu_bo;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_menu_bo', $condition, $data);
			
			$response 	= ['status' => "OK!"];

		}


		echo json_encode($response);
	}

	function dm_role(){
		$d['page']      	= 'dm_role';
        $d['menu']      	= 'Data Master Role';
        $d['title']			= 'Data Master Role';
        $this->load->view('layout', $d);
	}

	function showRole(){
		$table = 'm_role';
		$column_order   = array(null, 'id_role', 'nm_role', null, null); 
        $column_search  = array('id_role', 'nm_role'); 
        $order          = array('id_role' => 'asc');

        $list_data		= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];

        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_role="'.$ld->id_role.'" type="checkbox" id="lbl-'.$ld->id_role.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_role.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_role="'.$ld->id_role.'" type="checkbox" id="lbl-'.$ld->id_role.'" switch="none" >
                                            <label for="lbl-'.$ld->id_role.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nm_role;
            $row[] = $ld->level_role;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_role.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function role_action($action){
		if ($action == "aktif") {
			$id_role = $this->input->post('id_role');
			$status =  $this->input->post('status');
			$data = [
						'aktif' => $status
					];
			$condition  	= [];
			$condition[0]   = 'id_role';
			$condition[1]	= $id_role;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_role', $condition, $data);

			$response 	= ['status' => $status];

		}elseif($action == "detail"){
			$id_role = $this->input->post('id_role');
			$condition = [];
			$condition[] =  ['id_role', $id_role, 'where'];
			/*$condition[] 	= ['id_kategori_kbli', $id_kategori_kbli, 'where'];*/
			$response = $this->M_admin->get_master_spec('m_role', 'id_role, nm_role, level_role, keterangan' , $condition)->row_array();

		}elseif($action == "edit"){
			$id_role 		= $this->input->post('id_role');
			$nm_role 		= $this->input->post('nm_role');
			$level_role		= $this->input->post('level_role');
			$keterangan		= $this->input->post('keterangan');

			$data = [
					'nm_role' => $nm_role,
					'level_role' => $level_role,
					'keterangan' => $keterangan
					];


			$condtion 		= [];
			$condtion[0]	= 'id_role';
			$condition[1]	= $id_role;
			$condtion[2]	= 'where';

			$response		= $this->M_admin->update_data('m_role', $data);
		}elseif ($action == "add") {
			$nm_role 		= $this->input->post('nm_role');
			$level_role		= $this->input->post('level_role');
			$keterangan		= $this->input->post('keterangan');

			$data = [
					'nm_role' => $nm_role,
					'level_role' => $level_role,
					'keterangan' => $keterangan
					];

			$RoleId = $this->M_admin->insert_data('m_role', $data);
/*
			$data1 = [
					'id_jabatan' => $RoleId,
					'nm_jabatan' => $nm_role,
					'level_jabatan' => $level_role,
					'keterangan' => $keterangan
					];

			$inserJabatan = $this->M_admin->insert_data('m_jabatan', $data1);*/

			$jumlahMenu = $this->db->get('m_menu_bo')->num_rows();

			for ($i=1; $i <= $jumlahMenu ; $i++) { 
				$data2 = [
							'id_role' => $RoleId,
							'aktif' => 0,
							'id_menu_bo' => $i
						];

			
				$this->M_admin->insert_data('m_role_menu', $data2);

			}


			$response 	= ['status' => "OK"];

		}else{
			$response 	= ['status' => "FAIL"];
		}

		echo json_encode($response);
	}

	function atur_akses(){
		$d['page']      	= 'atur_akses';
        $d['menu']      	= 'Pengaturan Hak Akses';
        $d['title']			= 'Pengaturan Hak Akses';
        $id_role 			= $this->uri->segment(3);
        $d['id_role']		= $id_role;
        $d['getJabatan']	= $this->M_admin->getJabatan()->result();
        $d['getJabatanById']= $this->M_admin->getJabatanById($id_role)->result();
        $d['getMenuTree']	= $this->M_akses->getMenuByRole($id_role);

        
        
        $this->load->view('layout', $d);
	}

	function atur_akses_action($action){

		if ($action == "aktif") {
			$id_role 		= $this->input->post('id_role');
			$status			= $this->input->post('status');
			$id_menu_bo 	= $this->input->post('id_menu_bo');

			$data 			= ['aktif' => $status];


			$array = array('id_role' => $id_role, 'id_menu_bo' => $id_menu_bo);

			$this->db->where($array);
			$this->db->update('m_role_menu', $data);

			$response		= ['status' => $status];

		}else{
			$response		= ['status' => 'FAIL'];
		}

		echo json_encode($response);

	}




	function kbli_kategori(){
		 $d['page']      	= 'dm_kbli_kategori';
         $d['menu']      	= 'Data Master KBLI Kategori';
         $d['title']      	= 'Data Master KBLI Kategori';
         $this->load->view('layout', $d);
	}

	public function show_kbli_kategori(){
		$table          = 'm_kategori_kbli';
		
        $column_order   = array(null, 'kode_kategori', 'judul_kategori', null, null); 
        $column_search  = array('kode_kategori', 'judul_kategori'); 
        $order          = array('id_kategori_kbli' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_kategori_kbli="'.$ld->id_kategori_kbli.'" type="checkbox" id="lbl-'.$ld->id_kategori_kbli.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_kategori_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_usaha="'.$ld->id_kategori_kbli.'" type="checkbox" id="lbl-'.$ld->id_kategori_kbli.'" switch="none" >
                                            <label for="lbl-'.$ld->id_kategori_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kode_kategori;
            $row[] = $ld->judul_kategori;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_kategori_kbli.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function kbli_kategori_action($action){
		if ($action == "aktif") {
			$id_kategori_kbli 	= $this->input->post('id_kategori_kbli');
			$status 			= $this->input->post('status');
			$data 				= [
									'aktif' => $status
								];

			$condition 		= [];
			$condition[0] 	= 'id_kategori_kbli';
			$condition[1] 	= $id_kategori_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_kategori_kbli', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif ($action == "add") {
			$kode 	 	 	  = $this->input->post('kode');
			$judul  	 	  = $this->input->post('judul');
			$deskripsi		  = $this->input->post('deskripsi');


			$data 			 = [ 
								'kode_kategori' 		=> $kode,
								'judul_kategori'		=> $judul,
								'deskripsi_kategori' => $deskripsi
							];

			$this->M_admin->insert_data('m_kategori_kbli', $data);

			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "edit") {

			$id_kategori_kbli = $this->input->post('id_kategori_kbli');
			$kode_kategori 	  = $this->input->post('kode_kategori');
			$judul_kategori   = $this->input->post('judul_kategori');
			$deskripsi 		  = $this->input->post('deskripsi');

			$data 			 = [ 
								'kode_kategori'	=> $kode_kategori,
								'judul_kategori'=> $judul_kategori,
								'deskripsi_kategori' => $deskripsi,
								'aktif'		=> 1
							];

			$condition 		= [];
			$condition[0] 	= 'id_kategori_kbli';
			$condition[1] 	= $id_kategori_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_kategori_kbli', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "detail") {
			$id_kategori_kbli = $this->input->post('id_kategori_kbli');

			$condition 		= [];
			$condition[] 	= ['id_kategori_kbli', $id_kategori_kbli, 'where'];
			
			$response 		= $this
			->M_admin
			->get_master_spec('m_kategori_kbli', 'id_kategori_kbli, kode_kategori, judul_kategori, deskripsi_kategori ' , $condition)->row_array();

	     }

		echo json_encode($response);
	}



	function gol_pokok_kbli(){
		 $d['page']      	= 'dm_gol_pokok_kbli';
         $d['menu']      	= 'Data Master Golongan Pokok KBLI';
         $d['title']      	= 'Data Master Golongan Pokok KBLI';

         $Lcondition		= [];
         $Lcondition[]		= ['aktif', 1, 'where'];
         $value				= 'kode_kategori';
         $name 				= 'kode_kategori';
         
         $d['ListKategori'] = $this->list_bootstrap_select_2('m_kategori_kbli', $value, $name, $Lcondition);

         $this->load->view('layout', $d);
	}

	public function show_gol_pokok_kbli(){
		$table          = 'm_golongan_pokok_kbli';
		
        $column_order   = array(null, 'id_golongan_pokok_kbli', 'kode_golongan_pokok', 'judul_golongan_pokok', 'kode_kategori', null, null); 
        $column_search  = array('kode_golongan_pokok', 'judul_golongan_pokok', 'kode_kategori'); 
        $order          = array('id_golongan_pokok_kbli' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_golongan_pokok_kbli="'.$ld->id_golongan_pokok_kbli.'" type="checkbox" id="lbl-'.$ld->id_golongan_pokok_kbli.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_golongan_pokok_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_golongan_pokok_kbli="'.$ld->id_golongan_pokok_kbli.'" type="checkbox" id="lbl-'.$ld->id_golongan_pokok_kbli.'" switch="none" >
                                            <label for="lbl-'.$ld->id_golongan_pokok_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kode_golongan_pokok;
            $row[] = $ld->judul_golongan_pokok;
            $row[] = $ld->kode_kategori;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_golongan_pokok_kbli.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function gol_pokok_kbli_action($action){
		if ($action == "aktif") {
			$id_golongan_pokok_kbli 	= $this->input->post('id_golongan_pokok_kbli');
			$status 			= $this->input->post('status');
			$data 				= [
									'aktif' => $status
								];

			$condition 		= [];
			$condition[0] 	= 'id_golongan_pokok_kbli';
			$condition[1] 	= $id_golongan_pokok_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_golongan_pokok_kbli', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif ($action == "add") {
			$kode_golongan_pokok 	 	= $this->input->post('kode_golongan_pokok');
			$judul_golongan_pokok  	 	= $this->input->post('judul_golongan_pokok');
			$id_kategori_kbli = $this->input->post('id_kategori_kbli');


			$data 			 = [ 
								'kode_golongan_pokok' => $kode_golongan_pokok,
								'judul_golongan_pokok'=> $judul_golongan_pokok,
								'id_kategori_kbli'	=> $id_kategori_kbli,
								'aktif'				=> 1
							];

			$this->M_admin->insert_data('m_golongan_pokok_kbli', $data);

			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "edit") {

			$id_golongan_pokok_kbli = $this->input->post('id_golongan_pokok_kbli');
			$kode_golongan_pokok 	= $this->input->post('kode_golongan_pokok');
			$judul_golongan_pokok   = $this->input->post('judul_golongan_pokok');
			$id_kategori_kbli = $this->input->post('id_kategori_kbli');

			$data 			 = [ 
								'kode_golongan_pokok' 		=> $kode_golongan_pokok,
								'judul_golongan_pokok'		=> $judul_golongan_pokok,
								'aktif'		=> 1
							];

			$condition 		= [];
			$condition[0] 	= 'id_golongan_pokok_kbli';
			$condition[1] 	= $id_golongan_pokok_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_golongan_pokok_kbli', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "detail") {
			$id_golongan_pokok_kbli = $this->input->post('id_golongan_pokok_kbli');

			$condition 		= [];
			$condition[] 	= ['id_golongan_pokok_kbli', $id_golongan_pokok_kbli, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_golongan_pokok_kbli', 'id_golongan_pokok_kbli, kode_golongan_pokok, judul_golongan_pokok, kode_kategori, deskripsi_golongan_pokok',  $condition)->row_array();

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['kode_kategori !=', $response['kode_kategori'], 'where'];
			$value 			= 'kode_kategori';
			$name 			= 'kode_kategori';

	        $response['sl_kategori'] = $this->list_bootstrap_select_2('m_kategori_kbli', $value, $name, $Lcondition, $response['kode_kategori']);

	     }

		echo json_encode($response);
	}
	


	function gol_kbli(){
		 $d['page']      	= 'dm_gol_kbli';
         $d['menu']      	= 'Data Master Golongan KBLI';
         $d['title']      	= 'Data Master Golongan KBLI';

         $Lcondition		= [];
         $Lcondition[]		= ['aktif', 1, 'where'];
         $value				= 'kode_golongan_pokok';
         $name 				= 'kode_golongan_pokok';
         $d['ListGolPokok'] = $this->list_bootstrap_select_2('m_golongan_pokok_kbli', $value, $name, $Lcondition);


         $this->load->view('layout', $d);
	}

	public function show_gol_kbli(){
		$table          = 'm_golongan_kbli';
		
        $column_order   = array(null, 'id_golongan_kbli', 'kode_golongan', 'judul_golongan', 'kode_golongan_pokok', null, null); 
        $column_search  = array('kode_golongan', 'judul_golongan', 'kode_golongan_pokok'); 
        $order          = array('id_golongan_kbli' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];

        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_golongan_kbli="'.$ld->id_golongan_kbli.'" type="checkbox" id="lbl-'.$ld->id_golongan_kbli.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_golongan_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_golongan_kbli="'.$ld->id_golongan_kbli.'" type="checkbox" id="lbl-'.$ld->id_golongan_kbli.'" switch="none" >
                                            <label for="lbl-'.$ld->id_golongan_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kode_golongan;
            $row[] = $ld->judul_golongan;
            $row[] = $ld->kode_golongan_pokok;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_golongan_kbli.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function gol_kbli_action($action){

		if ($action == "aktif") {
			$id_golongan_kbli 	= $this->input->post('id_golongan_kbli');
			$status 			= $this->input->post('status');

			$data 				= [
									'aktif' => $status
								];

			$condition 		= [];
			$condition[0] 	= 'id_golongan_kbli';
			$condition[1] 	= $id_golongan_kbli;
			$condition[2] 	= 'where';

			$this->M_admin->update_data('m_golongan_kbli', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif ($action == "add") {
			$kode 	 	 	  = $this->input->post('kode');
			$judul  	 	  = $this->input->post('judul');
			$kode_golongan_pokok = $this->input->post('kode_golongan_pokok');


			$data 			 = [ 
								'kode' 				=> $kode,
								'judul'				=> $judul,
								'kode_golongan_pokok'	=> $kode_golongan_pokok,
								'aktif'				=> 1
							];

			$this->M_admin->insert_data('m_golongan_kbli', $data);

			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "edit") {

			$id_golongan_kbli = $this->input->post('id_golongan_kbli');
			$kode_golongan 	 	 	  = $this->input->post('kode_golongan');
			$judul_golongan  	 	  = $this->input->post('judul_golongan');
			$kode_golongan_pokok = $this->input->post('kode_golongan_pokok');

			$data 			 = [ 
								'kode_golongan' 		=> $kode_golongan,
								'judul_golongan'		=> $judul_golongan,
								'deskripsi_golongan'	=> $deskripsi_golongan
							];

			$condition 		= [];
			$condition[0] 	= 'id_golongan_kbli';
			$condition[1] 	= $id_golongan_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_golongan_kbli', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "detail") {
			$id_golongan_kbli 	= $this->input->post('id_golongan_kbli');

			$condition 		= [];
			$condition[] 	= ['id_golongan_kbli', $id_golongan_kbli, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_gol_kbli', 'id_golongan_kbli, kode_golongan, 
				judul_golongan, kode_golongan_pokok, deskripsi_golongan' , $condition)->row_array();

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['kode_golongan_pokok !=', $response['kode_golongan_pokok'], 'where'];
			$value 			= 'kode_golongan_pokok';
			$name 			= 'kode_golongan_pokok';

	        $response['sl_gol_pokok'] = $this->list_bootstrap_select_2('m_golongan_pokok_kbli', $value, $name, $Lcondition, $response['kode_golongan_pokok']);

	     }

		echo json_encode($response);
	}




	function sub_gol_kbli(){
		 $d['page']      	= 'dm_sub_gol_kbli';
         $d['menu']      	= 'Data Master Sub Golongan KBLI';
         $d['title']      	= 'Data Master Sub Golongan KBLI';

         $Lcondition		= [];
         $Lcondition[]		= ['aktif', 1, 'where'];
         $value				= 'kode_golongan';
         $name 				= 'kode_golongan';
         $d['ListGol'] = $this->list_bootstrap_select_2('m_golongan_kbli', $value, $name, $Lcondition);

         $this->load->view('layout', $d);
	}

	public function show_sub_gol_kbli(){
		$table          = 'm_sub_golongan_kbli';
		
        $column_order   = array(null, 'id_sub_golongan_kbli', 'kode_sub_golongan', 'judul_sub_golongan', 'kode_golongan', null, null); 
        $column_search  = array('kode_sub_golongan', 'judul_sub_golongan', 'kode_golongan'); 
        $order          = array('id_sub_golongan_kbli' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_sub_golongan_kbli="'.$ld->id_sub_golongan_kbli.'" type="checkbox" id="lbl-'.$ld->id_sub_golongan_kbli.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_sub_golongan_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_sub_golongan_kbli="'.$ld->id_sub_golongan_kbli.'" type="checkbox" id="lbl-'.$ld->id_sub_golongan_kbli.'" switch="none" >
                                            <label for="lbl-'.$ld->id_sub_golongan_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kode_sub_golongan;
            $row[] = $ld->judul_sub_golongan;
            $row[] = $ld->kode_golongan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_sub_golongan_kbli.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function sub_gol_kbli_action($action){
		if ($action == "aktif") {
			$id_sub_golongan_kbli 	= $this->input->post('id_sub_golongan_kbli');
			$status 			= $this->input->post('status');
			$data 				= [
									'aktif' => $status
								];

			$condition 		= [];
			$condition[0] 	= 'id_sub_golongan_kbli';
			$condition[1] 	= $id_sub_golongan_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_sub_golongan_kbli', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif ($action == "add") {
			$kode_subgolongan 	 = $this->input->post('kode_sub_golongan');
			$judul_subgolongan  = $this->input->post('judul_sub_golongan');
			$kode_golongan 	    = $this->input->post('kode_golongan');
			$deskripsi 	    = $this->input->post('deskripsi');


			$data 			 = [ 
								'kode_sub_golongan' 	=> $kode_sub_golongan,
								'judul_sub_golongan'	=> $judul_sub_golongan,
								'kode_golongan'	=> $kode_golongan,
								'deskripsi_subgolongan' => $deskripsi,
								'aktif'			=> 1
							];

			$this->M_admin->insert_data('m_sub_golongan_kbli', $data);

			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "edit") {

			$id_subgolongan_kbli  = $this->input->post('id_sub_golongan_kbli');
			$kode_subgolongan     = $this->input->post('kode_sub_golongan');
			$judul_subgolongan    = $this->input->post('judul_sub_golongan');
			$kode_golongan 	  	  = $this->input->post('kode_golongan');
			$deskripsi 			  = $this->input->post('deskripsi');

			$data 			 = [ 
								'kode_sub_golongan' 		  => $kode_subgolongan,
								'judul_sub_golongan'		  => $judul_subgolongan,
								'kode_golongan' => $kode_golongan,
								'deskripsi_sub_golongan'	  => $deskripsi
							];

			$condition 		= [];
			$condition[0] 	= 'id_sub_golongan_kbli';
			$condition[1] 	= $id_sub_golongan_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_sub_golongan_kbli', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "detail") {
			$id_sub_golongan_kbli 	= $this->input->post('id_sub_golongan_kbli');

			$condition 		= [];
			$condition[] 	= ['id_sub_golongan_kbli', $id_sub_golongan_kbli, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_sub_golongan_kbli', 
				'id_sub_golongan_kbli, kode_sub_golongan, judul_sub_golongan, kode_golongan, deskripsi_sub_golongan' , $condition)->row_array();

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['kode_golongan !=', $response['kode_golongan'], 'where'];
			$value 			= 'kode_golongan';
			$name 			= 'kode_golongan';

	        $response['sl_golongan'] = $this->list_bootstrap_select('m_golongan_kbli', $value, $name, $Lcondition, $response['kode_golongan']);

	     }

		echo json_encode($response);
	}




	function kel_kbli(){
		 $d['page']      	= 'dm_kelompok_kbli';
         $d['menu']      	= 'Data Master Kelompok KBLI';
         $d['title']      	= 'Data Master Kelompok KBLI';

         $Lcondition		= [];
         $Lcondition[]		= ['aktif', 1, 'where'];
         $value				= 'kode_sub_golongan';
         $name 				= 'kode_sub_golongan';
         $d['ListSubGol'] = $this->list_bootstrap_select('m_sub_golongan_kbli', $value, $name, $Lcondition);

         $this->load->view('layout', $d);
	}

	public function show_kelompok_kbli(){
		$table          = 'm_kelompok_kbli';
		
        $column_order   = array(null, 'kode_kelompok', 'judul_kelompok', 'kode_sub_golongan', null, null); 
        $column_search  = array('kode_kelompok', 'judul_kelompok', 'kode_sub_golongan'); 
        $order          = array('id_kelompok_kbli' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_kelompok_kbli="'.$ld->id_kelompok_kbli.'" type="checkbox" id="lbl-'.$ld->id_kelompok_kbli.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_kelompok_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_kelompok_kbli="'.$ld->id_kelompok_kbli.'" type="checkbox" id="lbl-'.$ld->id_kelompok_kbli.'" switch="none" >
                                            <label for="lbl-'.$ld->id_kelompok_kbli.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kode_kelompok;
            $row[] = $ld->judul_kelompok;
            $row[] = $ld->kode_sub_golongan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_kelompok_kbli.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function kelompok_kbli_action($action){
		if ($action == "aktif") {
			$id_kelompok_kbli 	= $this->input->post('id_kelompok_kbli');
			$status 			= $this->input->post('status');
			$data 				= [
									'aktif' => $status
								];

			$condition 		= [];
			$condition[0] 	= 'id_kelompok_kbli';
			$condition[1] 	= $id_kelompok_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_kelompok_kbli', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif ($action == "add") {
			$kode_kelompok 	 	 	  = $this->input->post('kode_kelompok');
			$judul_kelompok  	 	  = $this->input->post('judul_kelompok');
			$kode_sub_golongan  = $this->input->post('kode_sub_golongan');


			$data 			 = [ 
								'kode_kelompok' 	=> $kode_kelompok,
								'judul_kelompok'	=> $judul_kelompok,
								'kode_sub_golongan'	=> $kode_sub_golongan,
								'aktif'				=> 1
							];

			$this->M_admin->insert_data('m_kelompok_kbli', $data);

			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "edit") {

			$id_kelompok_kbli 	= $this->input->post('id_kelompok_kbli');
			$kode_kelompok 	  	= $this->input->post('kode_kelompok');
			$judul_kelompok  	 	  	= $this->input->post('judul_kelompok');
			$kode_sub_golongan  = $this->input->post('kode_sub_golongan');

			$data 			 = [ 
								'kode_kelompok' 		  => $kode_kelompok,
								'judul_kelompok'		  => $judul_kelompok,
								'kode_sub_golongan' => $kode_sub_golongan
							];

			$condition 		= [];
			$condition[0] 	= 'id_kelompok_kbli';
			$condition[1] 	= $id_kelompok_kbli;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_kelompok_kbli', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "detail") {
			$id_kelompok_kbli 	= $this->input->post('id_kelompok_kbli');

			$condition 		= [];
			$condition[] 	= ['id_kelompok_kbli', $id_kelompok_kbli, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_kelompok_kbli', 
				'id_kelompok_kbli, kode_kelompok, judul_kelompok, kode_sub_golongan' , $condition)->row_array();

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['kode_sub_golongan !=', $response['kode_sub_golongan'], 'where'];
			$value 			= 'kode_sub_golongan';
			$name 			= 'judul';

	        $response['sl_sub_golongan'] = $this->list_bootstrap_select('m_sub_golongan_kbli', $value, $name, $Lcondition, $response['kode_sub_golongan']);

	     }

		echo json_encode($response);
	}




	function kbli_lokal(){
		 $d['page']      	= 'dm_rangkuman_kbli';
         $d['menu']      	= 'Data Master KBLI Lokal';
         $d['title']      	= 'Data Master KBLI Lokal';

         /*$Lcondition		= [];
         $Lcondition[]		= ['aktif', 1, 'where'];
         $value				= 'id_kelompok_kbli';
         $name 				= 'judul';
         $d['ListKelompokKbli'] = $this->list_bootstrap_select_2('m_kelompok_kbli', $value, $name, $Lcondition);*/

         $this->load->view('layout', $d);
	}
	
	function showKbliLokal(){
	

		$table 			= 'm_kbli_lokal';
		$column_order 	= array(null, 'jenis_izin', 'kode', 'judul', null, null);
		$column_search  = array('jenis_izin', 'kode', 'judul'); 
		$order          = array('id_kbli_lokal' => 'asc');

		$list_data		= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
		$data 			= array();
		$no 			= $_POST['start'];

		 foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_kbli_lokal="'.$ld->id_kbli_lokal.'" type="checkbox" id="lbl-'.$ld->id_kbli_lokal.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_kbli_lokal.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_kbli_lokal="'.$ld->id_kbli_lokal.'" type="checkbox" id="lbl-'.$ld->id_kbli_lokal.'" switch="none" >
                                            <label for="lbl-'.$ld->id_kbli_lokal.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->jenis_izin;
            $row[] = $ld->kode;
            $row[] = $ld->judul;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_kbli_lokal.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	function rangkuman_kbli_action($action){
		if ($action == "aktif") {
			$id_kbli_lokal 	= $this->input->post('id_kbli_lokal');
			$status 			= $this->input->post('status');
			$data 				= [
									'aktif' => $status
								];

			$condition 		= [];
			$condition[0] 	= 'id_kbli_lokal';
			$condition[1] 	= $id_kbli_lokal;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_kbli_lokal', $condition, $data);

			$response 	= ['status' => $status];
		}

		elseif($action == "add") {
			$jenis_izin		  = $this->input->post('jenis_izin');
			$kode 	 	 	  = $this->input->post('kode');
			$judul  	 	  = $this->input->post('judul');
			


			$data 			 = [ 
								'kode' 				=> $kode,
								'judul'				=> $judul,
								'jenis_izin'		=> $jenis_izin,
								'aktif'				=> 1
							];

			$this->M_admin->insert_data('m_kbli_lokal', $data);

			
			$response 	= ['status' => "OK!"];
		}

		elseif ($action == "detail") {
			$id_kbli_lokal = $this->input->post('id_kbli_lokal');	

			$condition 		= [];
			$condition[] 	= ['id_kbli_lokal', $id_kbli_lokal, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_kbli_lokal', 'id_kbli_lokal, jenis_izin, kode, judul' , $condition)->row_array();

			/*$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_kelompok_kbli !=', $response['id_kelompok_kbli'], 'where'];
			$value 			= 'id_kelompok_kbli';
			$name 			= 'judul';

	        $response['sl_kel_golongan'] = $this->list_bootstrap_select_2('m_kelompok_kbli', $value, $name, $Lcondition, $response['id_kelompok_kbli']);
*/		}
		elseif ($action == "edit") {
			
			$id_kbli_lokal = $this->input->post('id_kbli_lokal');
			$kode 	 	 	   = $this->input->post('kode');
			$judul  	 	   = $this->input->post('judul');
			$jenis_izin   = $this->input->post('jenis_izin');

			$data 			 = [ 
								'kode' 		  => $kode,
								'judul'		  => $judul,
								'jenis_izin' => $jenis_izin
							];

			$condition 		= [];
			$condition[0] 	= 'id_kbli_lokal';
			$condition[1] 	= $id_kbli_lokal;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_kbli_lokal', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		}

		echo json_encode($response);
	}



	function coba_login($id_user) {
		$this->session->set_userdata('id_user', $id_user);

		$condition 			= array();
		$condition[] 		= array('mus.id_user', $id_user, 'where');
		$user 				= $this->M_permohonan_izin->coba_login($condition)->row_array();

		$this->session->set_flashdata("tipe-alert", "success");
		$this->session->set_flashdata("teks-alert", "Anda login sebagai ".$user['nm_user']." (".$user['nm_jabatan'].").");
		$this->session->set_flashdata("icon-alert", "fa fa-check-circle");

		$this->session->set_userdata('nm_user', $user['nm_user']);

		redirect('dashboard');
	}



	// On Function
	function dm_izin() {
		$d['page']      	= 'dm_izin';
        $d['menu']      	= 'Data Master Izin';
        $d['title']      	= 'Data Master Izin';

		$this->load->view('layout', $d);
	}

	public function show_dm_izin() {
		$table          = 'm_nama_izin';
		
        $column_order   = array(null, 'kd_nama_izin', 'nama_izin', 'akronim', 'jumlah_level', null, null); 
        $column_search  = array('kd_nama_izin', 'nama_izin', 'akronim', 'jumlah_level'); 
        $order          = array('kd_nama_izin' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-nama_izin="'.$ld->id_nama_izin.'" type="checkbox" id="lbl-'.$ld->id_nama_izin.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_nama_izin.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-nama_izin="'.$ld->id_nama_izin.'" type="checkbox" id="lbl-'.$ld->id_nama_izin.'" switch="none" >
                                            <label for="lbl-'.$ld->id_nama_izin.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kd_nama_izin;
            $row[] = $ld->nama_izin;
            $row[] = $ld->akronim;
            $row[] = $ld->jumlah_level;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_nama_izin.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_izin_action($action) {

		if ($action == "aktif") {
			$id_nama_izin 	= $this->input->post('nama_izin');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_nama_izin';
			$condition[1] 	= $id_nama_izin;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_nama_izin', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$kd_nama_izin 	= $this->input->post('kd_nama_izin');
			$akronim 	 	= $this->input->post('akronim');
			$nama_izin 	 	= $this->input->post('nama_izin');
			$tgl_dibuat 	= $this->input->post('tgl_dibuat');
			$jumlah_level 	= $this->input->post('jumlah_level');

			$data 			= [ 
								'kd_nama_izin' 	=> $kd_nama_izin,
								'akronim' 		=> $akronim,
								'nama_izin' 	=> $nama_izin,
								'tgl_dibuat' 	=> $tgl_dibuat,
								'jumlah_level' 	=> $jumlah_level
							];

			$this->M_admin->insert_data('m_nama_izin', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "add-jenis") {
			$id_nama_izin	= $this->input->post('id_nama_izin');
			$level_ke	 	= $this->input->post('level_ke');
			$id_parent	 	= $this->input->post('parent');
			$jenis_izin	 	= $this->input->post('jenis_izin');
			$teks_menu	 	= $this->input->post('teks_menu');
			$r_url	 		= $this->input->post('url');
			$param	 		= $this->input->post('param');

			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_parent, 'where'];
			$p_jiz 			= $this->M_admin->get_master_spec('m_jenis_izin', 'kd_jenis_izin' , $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['level_ke', $level_ke, 'where'];
			$condition[] 	= ['kd_jenis_izin LIKE', $p_jiz['kd_jenis_izin'].'%', 'where'];
			$max_kd_jiz		= $this->M_admin->get_max_number('m_jenis_izin', 'kd_jenis_izin', $condition);
			$kd_jenis_izin 	= intval($max_kd_jiz)+2;
			if ($max_kd_jiz == null) {
				$kd_jenis_izin 	= $p_jiz['kd_jenis_izin'].'10';	
			}

			if ($r_url == "#" || $r_url == "") {
				$url 		= $r_url;
			} else {
				$url 		= $r_url.'/'.$param;
			}

			$data 			= [ 
								'id_nama_izin' 	=> $id_nama_izin,
								'level_ke' 		=> $level_ke,
								'kd_jenis_izin'	=> $kd_jenis_izin,
								'jenis_izin' 	=> $jenis_izin,
								'teks_menu' 	=> $teks_menu,
								'url' 			=> $url,
								'aktif' 		=> 1,
								'param' 		=> $param
							];

			$this->M_admin->insert_data('m_jenis_izin', $data);

			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$kd_nama_izin 	= $this->input->post('kd_nama_izin');
			$akronim 	 	= $this->input->post('akronim');
			$nama_izin 	 	= $this->input->post('nama_izin');
			$tgl_dibuat 	= $this->input->post('tgl_dibuat');
			$jumlah_level 	= $this->input->post('jumlah_level');

			$data 			= [ 
								'kd_nama_izin' 	=> $kd_nama_izin,
								'akronim' 		=> $akronim,
								'nama_izin' 	=> $nama_izin,
								'tgl_dibuat' 	=> $tgl_dibuat,
								'jumlah_level' 	=> $jumlah_level
							];

			$condition 		= [];
			$condition[0] 	= 'id_nama_izin';
			$condition[1] 	= $id_nama_izin;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_nama_izin', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit-jenis") {
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$level_ke 		= $this->input->post('level_ke');
			$id_parent 		= $this->input->post('parent');
			$jenis_izin 	= $this->input->post('jenis_izin');
			$teks_menu 	 	= $this->input->post('teks_menu');
			$r_url 			= $this->input->post('url');
			$param 			= $this->input->post('param');

			if ($level_ke == 1) {
				$condition 		= [];
				$condition[] 	= ['id_nama_izin', $id_nama_izin, 'where'];
				$p_niz 			= $this->M_admin->get_master_spec('m_nama_izin', 'kd_nama_izin' , $condition)->row_array();								
				$p_jiz['kd_jenis_izin'] 	= $p_niz['kd_nama_izin'];
			} else {
				$condition 		= [];
				$condition[] 	= ['id_jenis_izin', $id_parent, 'where'];
				$p_jiz 			= $this->M_admin->get_master_spec('m_jenis_izin', 'kd_jenis_izin, param' , $condition)->row_array();
			}

			if ($param != $this->session->userdata('dm_izinParam')) {
				$condition 		= [];
				$condition[] 	= ['level_ke', $level_ke, 'where'];
				$condition[] 	= ['kd_jenis_izin LIKE', $p_jiz['kd_jenis_izin'].'%', 'where'];
				$max_kd_jiz		= $this->M_admin->get_max_number('m_jenis_izin', 'kd_jenis_izin', $condition);
				$kd_jenis_izin 	= intval($max_kd_jiz)+2;
				if ($max_kd_jiz == null) {
					$kd_jenis_izin 	= $p_jiz['kd_jenis_izin'].'10';	
				}
				$data['kd_jenis_izin'] 	= $kd_jenis_izin;
			}

			if ($r_url == "#" || $r_url == "") {
				$url 		= $r_url;
			} else {
				$url 		= $r_url.'/'.$param;
			}

			$data 			= [ 
								'id_nama_izin' 	=> $id_nama_izin,
								'level_ke' 		=> $level_ke,
								'jenis_izin' 	=> $jenis_izin,
								'teks_menu' 	=> $teks_menu,
								'url' 			=> $url,
								'param' 		=> $param
							];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_izin';
			$condition[1] 	= $id_jenis_izin;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_izin', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_nama_izin 	= $this->input->post('id_nama_izin');

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $id_nama_izin, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_nama_izin', 'id_nama_izin, kd_nama_izin, akronim, nama_izin, tgl_dibuat, jumlah_level' , $condition)->row_array();
		} elseif ($action == "detail-jenis") {
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');

			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];
			$jiz 			= $this->M_admin->get_master_spec('m_jenis_izin', 'id_jenis_izin, id_nama_izin, level_ke, kd_jenis_izin, jenis_izin, teks_menu, url, param' , $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $jiz['id_nama_izin'], 'where'];
			$niz 			= $this->M_admin->get_master_spec('m_nama_izin', 'id_nama_izin, nama_izin, jumlah_level' , $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_nama_izin !=', $jiz['id_nama_izin'], 'where'];
			$sl_id_nama_izin 	= $this->list_bootstrap_select('m_nama_izin', 'id_nama_izin', 'nama_izin', $condition, $jiz['id_nama_izin']);

			$level 	= [];
			for ($a=1;$a<=$niz['jumlah_level'];$a++) {
				$level[$a-1]['value']	= $a;
				$level[$a-1]['name']	= $a;
			}
			$sl_level_ke 	= $this->list_static_select($level, $jiz['level_ke']);

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $jiz['id_nama_izin'], 'where'];
			$condition[] 	= ['level_ke', $jiz['level_ke']-1, 'where'];
			$condition[] 	= ['kd_jenis_izin', 'ASC', 'order_by'];
			$list_jenis_iz	= $this->M_admin->get_master_spec('m_jenis_izin', 'id_jenis_izin, jenis_izin, kd_jenis_izin' , $condition)->result_array();
			$arr_parent 	= [];
			foreach ($list_jenis_iz as $lji) {
				$get_jenis_izin = $this->get_jenis_izin($lji['kd_jenis_izin']);
				if ($get_jenis_izin) {
					$jenis_izin 	= $get_jenis_izin;
				} else {
					$jenis_izin 	= $lji['jenis_izin'];
				}
				$arr_parent[]= ['id_jenis_izin' => $lji['id_jenis_izin'], 'jenis_izin' => $jenis_izin];
			}
			$condition 		= [];
			$condition[] 	= ['kd_jenis_izin', substr($jiz['kd_jenis_izin'], 0, -2), 'where'];
			$parent_jiz		= $this->M_admin->get_master_spec('m_jenis_izin', 'id_jenis_izin' , $condition)->row_array()['id_jenis_izin'];						
			$sl_parent 		= $this->list_array_select($arr_parent, 'id_jenis_izin', 'jenis_izin', $parent_jiz);

			$sl_url 		= str_replace('/'.$jiz['param'], '', $jiz['url']);

			$jiz['id_nama_izin']= $sl_id_nama_izin;
			$jiz['level_ke']	= $sl_level_ke;
			$jiz['parent']		= $sl_parent;
			$jiz['url'] 		= $sl_url;

			$this->session->set_userdata('dm_izinParam', $jiz['param']); //first parameter, related to action==edit-jenis
			
			$response 	= $jiz;
		} elseif($action == "prp-add-jenis") {
			$condition 		= [];
			// $condition[] 	= ['id_nama_izin', $id_nama_izin, 'where'];
			
			$list_nama_iz 	= $this->M_admin->get_master_spec('m_nama_izin', 'id_nama_izin, nama_izin' , $condition)->result_array();			
			$option_nm	= '';
			foreach ($list_nama_iz as $lni) {
				$option_nm	.= '<option value="'.$lni['id_nama_izin'].'">'.$lni['nama_izin'].'</option>';
			}

			$response 	= ['select_nm' => $option_nm];
		} elseif($action == "tg-select") {
			$id_nama_izin 	= $this->input->post('id_nama_izin');

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $id_nama_izin, 'where'];			

			$jml_level 		= $this->M_admin->get_master_spec('m_nama_izin', 'jumlah_level' , $condition)->row_array()['jumlah_level'];		

			$option_lv	= '';
			for($a=1;$a<=$jml_level;$a++) {
				$option_lv	.= '<option value="'.$a.'">'.$a.'</option>';
			}

			$response 	= ['select_lv' => $option_lv];
		} elseif($action == "tg-select-pr") {
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');

			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];
			$jiz			= $this->M_admin->get_master_spec('m_jenis_izin', 'id_jenis_izin, param' , $condition)->row_array();

			$new_param 		= hash('crc32', $jiz['id_jenis_izin'].$jiz['param'].date("Y-m-d H:i:s"));

			$response 		= ['param' => $new_param];
		} elseif($action == "tg-select-lv") {
			$id_nama_izin 	= $this->input->post('id_nama_izin');
			$level 			= $this->input->post('level');

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $id_nama_izin, 'where'];
			$condition[] 	= ['level_ke', $level-1, 'where'];
			$condition[] 	= ['kd_jenis_izin', 'ASC', 'order_by'];
			
			$list_jenis_iz	= $this->M_admin->get_master_spec('m_jenis_izin', 'id_jenis_izin, jenis_izin, kd_jenis_izin' , $condition)->result_array();			
			$option_ji	= '';
			foreach ($list_jenis_iz as $lji) {
				$get_jenis_izin = $this->get_jenis_izin($lji['kd_jenis_izin']);
				if ($get_jenis_izin) {
					$jenis_izin 	= $get_jenis_izin;
				} else {
					$jenis_izin 	= $lji['jenis_izin'];
				}
				$option_ji	.= '<option value="'.$lji['id_jenis_izin'].'">'.$jenis_izin.'</option>';
			}
			$new_param 		= hash('crc32', $id_nama_izin.$level.date("Y-m-d H:i:s"));

			$response 	= ['select_ji' => $option_ji, 'param' => $new_param];
		} elseif ($action == "data-structure") {
			$response 	= ['content' => $this->list_menuizin2()];
		}
		else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_bidang_usaha() {
		$d['page']      	= 'dm_bidang_usaha';
        $d['menu']      	= 'Data Master Bidang Usaha';
        $d['title']      	= 'Data Master Bidang Usaha';

		$this->load->view('layout', $d);
	}

	public function show_dm_bidang_usaha() {
		$table          = 'm_bidang_usaha';
		
        $column_order   = array(null, 'nama_bidang_usaha', 'keterangan', null, null); 
        $column_search  = array('nama_bidang_usaha', 'keterangan'); 
        $order          = array('id_bidang_usaha' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-bidang_usaha="'.$ld->id_bidang_usaha.'" type="checkbox" id="lbl-'.$ld->id_bidang_usaha.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_bidang_usaha.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-bidang_usaha="'.$ld->id_bidang_usaha.'" type="checkbox" id="lbl-'.$ld->id_bidang_usaha.'" switch="none" >
                                            <label for="lbl-'.$ld->id_bidang_usaha.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nama_bidang_usaha;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_bidang_usaha.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_bidang_usaha_action($action) {

		if ($action == "aktif") {
			$id_bidang_usaha 	= $this->input->post('bidang_usaha');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_bidang_usaha';
			$condition[1] 	= $id_bidang_usaha;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_bidang_usaha', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$nama_bidang_usaha 	= $this->input->post('nama_bidang_usaha');
			$keterangan 	 	= $this->input->post('keterangan');

			$data 			= [ 
								'nama_bidang_usaha' => $nama_bidang_usaha,
								'keterangan' 		=> $keterangan
							];

			$this->M_admin->insert_data('m_bidang_usaha', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_bidang_usaha 	= $this->input->post('id_bidang_usaha');
			$nama_bidang_usaha 	= $this->input->post('nama_bidang_usaha');
			$keterangan 	= $this->input->post('keterangan');


			$data 			= [ 
								'nama_bidang_usaha' => $nama_bidang_usaha,
								'keterangan' 		=> $keterangan
							];

			$condition 		= [];
			$condition[0] 	= 'id_bidang_usaha';
			$condition[1] 	= $id_bidang_usaha;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_bidang_usaha', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_bidang_usaha= $this->input->post('id_bidang_usaha');

			$condition 		= [];
			$condition[] 	= ['id_bidang_usaha', $id_bidang_usaha, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_bidang_usaha', 'id_bidang_usaha, nama_bidang_usaha, keterangan' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_jenis_identitas() {
		$d['page']      	= 'dm_jenis_identitas';
        $d['menu']      	= 'Data Master Jenis Identitas';
        $d['title']      	= 'Data Master Jenis Identitas';

		$this->load->view('layout', $d);
	}

	public function show_dm_jenis_identitas() {
		$table          = 'm_jenis_identitas';
		
        $column_order   = array(null, 'jenis_identitas', 'akronim', null, null); 
        $column_search  = array('jenis_identitas', 'akronim'); 
        $order          = array('id_jenis_identitas' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_identitas="'.$ld->id_jenis_identitas.'" type="checkbox" id="lbl-'.$ld->id_jenis_identitas.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_jenis_identitas.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_identitas="'.$ld->id_jenis_identitas.'" type="checkbox" id="lbl-'.$ld->id_jenis_identitas.'" switch="none" >
                                            <label for="lbl-'.$ld->id_jenis_identitas.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->jenis_identitas;
            $row[] = $ld->akronim;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_jenis_identitas.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_jenis_identitas_action($action) {

		if ($action == "aktif") {
			$id_jenis_identitas 	= $this->input->post('id_jenis_identitas');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_identitas';
			$condition[1] 	= $id_jenis_identitas;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_identitas', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$jenis_identitas 	= $this->input->post('jenis_identitas');
			$akronim 	 	= $this->input->post('akronim');

			$data 			= [ 
								'jenis_identitas' => $jenis_identitas,
								'akronim' 		=> $akronim
							];

			$this->M_admin->insert_data('m_jenis_identitas', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_jenis_identitas 	= $this->input->post('id_jenis_identitas');
			$jenis_identitas 	= $this->input->post('jenis_identitas');
			$akronim 	= $this->input->post('akronim');


			$data 			= [ 
								'jenis_identitas' => $jenis_identitas,
								'akronim' 		=> $akronim
							];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_identitas';
			$condition[1] 	= $id_jenis_identitas;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_identitas', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_jenis_identitas= $this->input->post('id_jenis_identitas');

			$condition 		= [];
			$condition[] 	= ['id_jenis_identitas', $id_jenis_identitas, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_jenis_identitas', 'id_jenis_identitas, jenis_identitas, akronim' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_decision() {
		$d['page']      	= 'dm_decision';
        $d['menu']      	= 'Data Master Decision';
        $d['title']      	= 'Data Master Decision';

		$this->load->view('layout', $d);
	}

	public function show_dm_decision() {
		$table          = 'm_decision';
		
        $column_order   = array(null, 'id_decision', 'nm_decision', null, null); 
        $column_search  = array('id_decision', 'nm_decision'); 
        $order          = array('id_decision' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_decision="'.$ld->id_decision.'" type="checkbox" id="lbl-'.$ld->id_decision.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_decision.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_decision="'.$ld->id_decision.'" type="checkbox" id="lbl-'.$ld->id_decision.'" switch="none" >
                                            <label for="lbl-'.$ld->id_decision.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kd_decision;
            $row[] = $ld->nm_decision;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_decision.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_decision_action($action) {

		if ($action == "aktif") {
			$id_decision 	= $this->input->post('id_decision');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_decision';
			$condition[1] 	= $id_decision;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_decision', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$kd_decision 	= $this->input->post('kd_decision');
			$nm_decision 	= $this->input->post('nm_decision');

			$data 			= [ 
								'kd_decision' => $kd_decision,
								'nm_decision' 		=> $nm_decision
							];

			$this->M_admin->insert_data('m_decision', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_decision 	= $this->input->post('id_decision');
			$kd_decision 	= $this->input->post('kd_decision');
			$nm_decision 	= $this->input->post('nm_decision');


			$data 			= [ 
								'kd_decision' => $kd_decision,
								'nm_decision' => $nm_decision
							];

			$condition 		= [];
			$condition[0] 	= 'id_decision';
			$condition[1] 	= $id_decision;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_decision', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_decision= $this->input->post('id_decision');

			$condition 		= [];
			$condition[] 	= ['id_decision', $id_decision, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_decision', 'id_decision, kd_decision, nm_decision' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}



	function dm_aktivitas() {
		$d['page']      	= 'dm_aktivitas';
        $d['menu']      	= 'Data Master Aktivitas';
        $d['title']      	= 'Data Master Aktivitas';

		$this->load->view('layout', $d);
	}

	public function show_dm_aktivitas() {
		$table          = 'm_aktivitas';
		
        $column_order   = array(null, 'id_aktivitas', 'kd_aktivitas', 'nama_aktivitas', 'param', null, null); 
        $column_search  = array('id_aktivitas', 'kd_aktivitas', 'nama_aktivitas', 'param',); 
        $order          = array('kd_aktivitas' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_aktivitas="'.$ld->id_aktivitas.'" type="checkbox" id="lbl-'.$ld->id_aktivitas.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_aktivitas.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_aktivitas="'.$ld->id_aktivitas.'" type="checkbox" id="lbl-'.$ld->id_aktivitas.'" switch="none" >
                                            <label for="lbl-'.$ld->id_aktivitas.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kd_aktivitas;
            $row[] = $ld->nama_aktivitas;
            $row[] = $ld->param;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_aktivitas.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_aktivitas_action($action) {

		if ($action == "aktif") {
			$id_aktivitas 	= $this->input->post('id_aktivitas');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_aktivitas';
			$condition[1] 	= $id_aktivitas;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_aktivitas', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$kd_aktivitas 	= $this->input->post('kd_aktivitas');
			$nama_aktivitas = $this->input->post('nama_aktivitas');
			$param 	= $this->input->post('param');

			$data 			= [ 
								'kd_aktivitas' 	=> $kd_aktivitas,
								'nama_aktivitas'=> $nama_aktivitas,
								'param' 		=> $param
							];

			$this->M_admin->insert_data('m_aktivitas', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_aktivitas 	= $this->input->post('id_aktivitas');
			$kd_aktivitas 	= $this->input->post('kd_aktivitas');
			$nama_aktivitas = $this->input->post('nama_aktivitas');
			$param 	= $this->input->post('param');


			$data 			= [ 
								'kd_aktivitas' 	=> $kd_aktivitas,
								'nama_aktivitas'=> $nama_aktivitas,
								'param' 		=> $param
							];

			$condition 		= [];
			$condition[0] 	= 'id_aktivitas';
			$condition[1] 	= $id_aktivitas;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_aktivitas', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_aktivitas= $this->input->post('id_aktivitas');

			$condition 		= [];
			$condition[] 	= ['id_aktivitas', $id_aktivitas, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_aktivitas', 'id_aktivitas, kd_aktivitas, nama_aktivitas, param' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
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
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_unitkerja() {
		$d['page']      	= 'dm_unitkerja';
        $d['menu']      	= 'Data Master Unitkerja';
        $d['title']      	= 'Data Master Unitkerja';

		$this->load->view('layout', $d);
	}

	public function show_dm_unitkerja() {
		$table          = 'm_unitkerja';
		
        $column_order   = array(null, 'kd_unitkerja', 'nm_unitkerja', 'group_unitkerja', 'kd_group', 'keterangan', null, null); 
        $column_search  = array('kd_unitkerja', 'nm_unitkerja', 'group_unitkerja', 'kd_group', 'keterangan'); 
        $order          = array('id_unitkerja' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_unitkerja="'.$ld->id_unitkerja.'" type="checkbox" id="lbl-'.$ld->id_unitkerja.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_unitkerja.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_unitkerja="'.$ld->id_unitkerja.'" type="checkbox" id="lbl-'.$ld->id_unitkerja.'" switch="none" >
                                            <label for="lbl-'.$ld->id_unitkerja.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kd_unitkerja;
            $row[] = $ld->nm_unitkerja;
            $row[] = $ld->group_unitkerja;
            $row[] = $ld->kd_group;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_unitkerja.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_unitkerja_action($action) {

		if ($action == "aktif") {
			$id_unitkerja = $this->input->post('id_unitkerja');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_unitkerja';
			$condition[1] 	= $id_unitkerja;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_unitkerja', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$kd_unitkerja 	= $this->input->post('kd_unitkerja');
			$nm_unitkerja 	= $this->input->post('nm_unitkerja');
			$group_unitkerja= $this->input->post('group_unitkerja');
			$kd_group   	= $this->input->post('kd_group');
			$keterangan 	= $this->input->post('keterangan');

			$data 			= [ 
								'kd_unitkerja' 	=> $kd_unitkerja,
								'nm_unitkerja' 	=> $nm_unitkerja,
								'group_unitkerja' 	=> $group_unitkerja,
								'kd_group'  	=> $kd_group,
								'keterangan'    => $keterangan
							];

			$this->M_admin->insert_data('m_unitkerja', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_unitkerja 	= $this->input->post('id_unitkerja');
			$kd_unitkerja 	= $this->input->post('kd_unitkerja');
			$nm_unitkerja 	= $this->input->post('nm_unitkerja');
			$group_unitkerja= $this->input->post('group_unitkerja');
			$kd_group 		= $this->input->post('kd_group');
			$keterangan 	= $this->input->post('keterangan');


			$data 			= [ 
								'kd_unitkerja' 	=> $kd_unitkerja,
								'nm_unitkerja' => $nm_unitkerja,
								'group_unitkerja' => $group_unitkerja,
								'kd_group' => $kd_group,
								'keterangan'    => $keterangan
							];

			$condition 		= [];
			$condition[0] 	= 'id_unitkerja';
			$condition[1] 	= $id_unitkerja;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_unitkerja', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_unitkerja  	= $this->input->post('id_unitkerja');

			$condition 		= [];
			$condition[] 	= ['id_unitkerja', $id_unitkerja, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_unitkerja', 'id_unitkerja, kd_unitkerja, nm_unitkerja, group_unitkerja, kd_group, keterangan' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_jenis_usaha() {
		$d['page']      	= 'dm_jenis_usaha';
        $d['menu']      	= 'Data Master Jenis Usaha';
        $d['title']      	= 'Data Master Jenis Usaha';

		$Lcondition 	= [];
		$Lcondition[] 	= ['aktif', 1, 'where'];
		$value 			= 'id_bidang_usaha';
		$name 			= 'nama_bidang_usaha';
        $d['L_bu']     	= $this->list_bootstrap_select('m_bidang_usaha', $value, $name, $Lcondition);
		$this->load->view('layout', $d);
	}

	public function show_dm_jenis_usaha() {
		$table          = 'v_jenis_usaha';
		
        $column_order   = array(null, 'nama_jenis_usaha', 'nama_bidang_usaha', 'keterangan', null, null); 
        $column_search  = array('nama_bidang_usaha', 'nama_jenis_usaha'); 
        $order          = array('id_jenis_usaha' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_usaha="'.$ld->id_jenis_usaha.'" type="checkbox" id="lbl-'.$ld->id_jenis_usaha.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_jenis_usaha.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_usaha="'.$ld->id_jenis_usaha.'" type="checkbox" id="lbl-'.$ld->id_jenis_usaha.'" switch="none" >
                                            <label for="lbl-'.$ld->id_jenis_usaha.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nama_jenis_usaha;
            $row[] = $ld->nama_bidang_usaha;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_jenis_usaha.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_jenis_usaha_action($action) {

		if ($action == "aktif") {
			$id_jenis_usaha 	= $this->input->post('id_jenis_usaha');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_usaha';
			$condition[1] 	= $id_jenis_usaha;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_usaha', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$jenis_usaha 	= $this->input->post('jenis_usaha');
			$id_bidang_usaha= $this->input->post('id_bidang_usaha');
			$keterangan 	= $this->input->post('keterangan');

			$data 			= [ 
								'nama_jenis_usaha' 	=> $jenis_usaha,
								'id_bidang_usaha' 	=> $id_bidang_usaha,
								'keterangan' 		=> $keterangan
							];

			$this->M_admin->insert_data('m_jenis_usaha', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_jenis_usaha = $this->input->post('id_jenis_usaha');
			$jenis_usaha 	= $this->input->post('jenis_identitas');
			$id_bidang_usaha= $this->input->post('id_bidang_usaha');
			$keterangan 	= $this->input->post('keterangan');


			$data 			= [ 
								'nama_jenis_usaha'		=> $jenis_usaha,
								'id_bidang_usaha' 	=> $id_bidang_usaha,
								'keterangan' 		=> $keterangan
							];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_usaha';
			$condition[1] 	= $id_jenis_usaha;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_usaha', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_jenis_usaha = $this->input->post('id_jenis_usaha');

			$condition 		= [];
			$condition[] 	= ['id_jenis_usaha', $id_jenis_usaha, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_jenis_usaha', 'id_jenis_usaha, nama_jenis_usaha, id_bidang_usaha, keterangan' , $condition)->row_array();

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_bidang_usaha !=', $response['id_bidang_usaha'], 'where'];
			$value 			= 'id_bidang_usaha';
			$name 			= 'nama_bidang_usaha';
	        $response['sl_bidang_usaha'] = $this->list_bootstrap_select('m_bidang_usaha', $value, $name, $Lcondition, $response['id_bidang_usaha']);

		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_personil() {
		$d['page']      	= 'dm_personil';
        $d['menu']      	= 'Data Master Personil';
        $d['title']      	= 'Data Master Personil';

		$Lcondition 	= [];
		$Lcondition[] 	= ['aktif', 1, 'where'];
		$value 			= 'id_unitkerja';
		$name 			= 'nm_unitkerja';
        $d['L_uk']     	= $this->list_bootstrap_select('m_unitkerja', $value, $name, $Lcondition);

		$Lcondition 	= [];
		$Lcondition[] 	= ['aktif', 1, 'where'];
		$value 			= 'id_jabatan';
		$name 			= 'nm_jabatan';
        $d['L_ja']     	= $this->list_bootstrap_select('m_jabatan', $value, $name, $Lcondition);        

		$this->load->view('layout', $d);
	}

	public function show_dm_personil() {
		$table          = 'v_personil';
		
        $column_order   = array(null, 'nm_personil', 'nm_unitkerja', 'nm_jabatan', 'nip', 'keterangan', null, null); 
        $column_search  = array('nm_personil', 'nm_unitkerja', 'nm_jabatan', 'nip', 'keterangan',); 
        $order          = array('id_personil' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_personil="'.$ld->id_personil.'" type="checkbox" id="lbl-'.$ld->id_personil.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_personil.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_personil="'.$ld->id_personil.'" type="checkbox" id="lbl-'.$ld->id_personil.'" switch="none" >
                                            <label for="lbl-'.$ld->id_personil.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nm_personil;
            $row[] = $ld->nm_unitkerja;
            $row[] = $ld->nm_jabatan;
            $row[] = $ld->nip;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_personil.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_personil_action($action) {

		if ($action == "aktif") {
			$id_personil= $this->input->post('id_personil');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_personil';
			$condition[1] 	= $id_personil;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_personil', $condition, $data);

			$condition 		= [];
			$condition[0] 	= 'id_user';
			$condition[1] 	= $id_personil;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_personil', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$nm_personil 	= $this->input->post('nm_personil');
			$id_unitkerja 	= $this->input->post('id_unitkerja');
			$id_jabatan 	= $this->input->post('id_jabatan');
			$nip 			= $this->input->post('nip');
			$keterangan 	= $this->input->post('keterangan');

			$data 			= [ 
								'nm_personil' 	=> $nm_personil,
								'id_unitkerja' 	=> $id_unitkerja,
								'id_jabatan' 	=> $id_jabatan,
								'nip' 			=> $nip,
								'keterangan' 	=> $keterangan
							];

			$this->M_admin->insert_data('m_personil', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_personil 	= $this->input->post('id_personil');
			$nm_personil 	= $this->input->post('nm_personil');
			$id_unitkerja 	= $this->input->post('id_unitkerja');
			$id_jabatan 	= $this->input->post('id_jabatan');
			$nip 			= $this->input->post('nip');
			$keterangan 	= $this->input->post('keterangan');


			$data 			= [ 
								'nm_personil' 	=> $nm_personil,
								'id_unitkerja' 	=> $id_unitkerja,
								'id_jabatan' 	=> $id_jabatan,
								'nip' 			=> $nip,
								'keterangan' 	=> $keterangan
							];

			$condition 		= [];
			$condition[0] 	= 'id_personil';
			$condition[1] 	= $id_personil;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_personil', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_personil 	= $this->input->post('id_personil');

			$condition 		= [];
			$condition[] 	= ['id_personil', $id_personil, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_personil', 'id_personil, nm_personil, id_unitkerja, id_jabatan, nip, keterangan' , $condition)->row_array(); 

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_unitkerja !=', $response['id_unitkerja'], 'where'];
			$value 			= 'id_unitkerja';
			$name 			= 'nm_unitkerja';
	        $response['sl_unitkerja'] = $this->list_bootstrap_select('m_unitkerja', $value, $name, $Lcondition, $response['id_unitkerja']);

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_jabatan !=', $response['id_jabatan'], 'where'];
			$value 			= 'id_jabatan';
			$name 			= 'nm_jabatan';
	        $response['sl_jabatan'] = $this->list_bootstrap_select('m_jabatan', $value, $name, $Lcondition, $response['id_jabatan']);	        

		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_workflow() {
		$d['page']      	= 'dm_workflow';
        $d['menu']      	= 'Data Master Workflow';
        $d['title']      	= 'Data Master Workflow';

		$Lcondition 	= [];
		$Lcondition[] 	= ['aktif', 1, 'where'];
		$value 			= 'id_bidang_usaha';
		$name 			= 'nama_bidang_usaha';
        $d['L_bu']     	= $this->list_bootstrap_select('m_bidang_usaha', $value, $name, $Lcondition);
		$this->load->view('layout', $d);
	}

	public function show_dm_workflow() {
		$table          = 'v_jenis_usaha';
		
        $column_order   = array(null, 'nama_jenis_usaha', 'nama_bidang_usaha', 'keterangan', null, null); 
        $column_search  = array('nama_bidang_usaha', 'nama_jenis_usaha'); 
        $order          = array('id_jenis_usaha' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_usaha="'.$ld->id_jenis_usaha.'" type="checkbox" id="lbl-'.$ld->id_jenis_usaha.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_jenis_usaha.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_jenis_usaha="'.$ld->id_jenis_usaha.'" type="checkbox" id="lbl-'.$ld->id_jenis_usaha.'" switch="none" >
                                            <label for="lbl-'.$ld->id_jenis_usaha.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nama_jenis_usaha;
            $row[] = $ld->nama_bidang_usaha;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_jenis_usaha.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_workflow_action($action) {

		if ($action == "aktif") {
			$id_jenis_usaha 	= $this->input->post('id_jenis_usaha');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_usaha';
			$condition[1] 	= $id_jenis_usaha;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_usaha', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$jenis_usaha 	= $this->input->post('jenis_usaha');
			$id_bidang_usaha= $this->input->post('id_bidang_usaha');
			$keterangan 	= $this->input->post('keterangan');

			$data 			= [ 
								'nama_jenis_usaha' 	=> $jenis_usaha,
								'id_bidang_usaha' 	=> $id_bidang_usaha,
								'keterangan' 		=> $keterangan
							];

			$this->M_admin->insert_data('m_jenis_usaha', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_jenis_usaha = $this->input->post('id_jenis_usaha');
			$jenis_usaha 	= $this->input->post('jenis_identitas');
			$id_bidang_usaha= $this->input->post('id_bidang_usaha');
			$keterangan 	= $this->input->post('keterangan');


			$data 			= [ 
								'nama_jenis_usaha'		=> $jenis_usaha,
								'id_bidang_usaha' 	=> $id_bidang_usaha,
								'keterangan' 		=> $keterangan
							];

			$condition 		= [];
			$condition[0] 	= 'id_jenis_usaha';
			$condition[1] 	= $id_jenis_usaha;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_jenis_usaha', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_jenis_usaha = $this->input->post('id_jenis_usaha');

			$condition 		= [];
			$condition[] 	= ['id_jenis_usaha', $id_jenis_usaha, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('m_jenis_usaha', 'id_jenis_usaha, nama_jenis_usaha, id_bidang_usaha, keterangan' , $condition)->row_array();

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_bidang_usaha !=', $response['id_bidang_usaha'], 'where'];
			$value 			= 'id_bidang_usaha';
			$name 			= 'nama_bidang_usaha';
	        $response['sl_bidang_usaha'] = $this->list_bootstrap_select('m_bidang_usaha', $value, $name, $Lcondition, $response['id_bidang_usaha']);

		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function ki_workflow_izin() {
		$d['page']      	= 'ki_workflow_izin';
        $d['menu']      	= 'Konfigurasi Workflow Izin';
        $d['title']      	= 'Konfigurasi Workflow Izin';
        $d['list_menu'] 	= $this->list_menuizin();

		$this->load->view('layout', $d);
	}

	public function show_ki_workflow_izin() {
		$table          = 't_workflow';

		$id_jenis_izin 	= $this->input->post('jenis_izin');
		$condition 		= [];
		$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];	
		
        $column_order   = array(null, 'kd_workflow', 'nm_workflow', 'keterangan', null, null); 
        $column_search  = array('kd_workflow', 'nm_workflow', 'keterangan'); 
        $order          = array('id_workflow' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	if ($ld->aktif == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_workflow="'.$ld->id_workflow.'" type="checkbox" id="lblak-'.$ld->id_workflow.'" checked switch="none" >
                                            <label for="lblak-'.$ld->id_workflow.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_workflow="'.$ld->id_workflow.'" type="checkbox" id="lblak-'.$ld->id_workflow.'" switch="none" >
                                            <label for="lblak-'.$ld->id_workflow.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}       	     	

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->kd_workflow;
            $row[] = $ld->nm_workflow;
            $row[] = $ld->keterangan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_workflow.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
					  		title="Ubah"> <i class="fa fa-pencil"></i> 
					</button>';

            $data[] = $row;
        }

        $output = array(
	            "draw" => $_POST['draw'],
	            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
	            "recordsTotal" => $this->M_admin->count_all($table, $condition),
	            "data" => $data,
            );
        echo json_encode($output);		
	}

	public function ki_workflow_izin_action($action) {

		if ($action == "aktif") {
			$id_workflow 	= $this->input->post('id_workflow');
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$status 		= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$data_res	= [
							'aktif' => 0
						];			

			$condition 		= [];
			$condition[0] 	= 'id_jenis_izin';
			$condition[1] 	= $id_jenis_izin;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_workflow', $condition, $data_res);

			$condition 		= [];
			$condition[0] 	= 'id_workflow';
			$condition[1] 	= $id_workflow;
			$condition[2] 	= 'where';			
			$this->M_admin->update_data('t_workflow', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$kd_workflow	= $this->input->post('kd_workflow');
			$nm_workflow 	= $this->input->post('nm_workflow');
			$keterangan 	= $this->input->post('keterangan');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'id_jenis_izin' => $id_jenis_izin,
								'kd_workflow' 	=> $kd_workflow,
								'nm_workflow' 	=> $nm_workflow,
								'keterangan' 	=> $keterangan,
								'aktif' 		=> $aktif
							];

			$this->M_admin->insert_data('t_workflow', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_workflow 	= $this->input->post('id_workflow');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$kd_workflow	= $this->input->post('kd_workflow');
			$nm_workflow 	= $this->input->post('nm_workflow');
			$keterangan 	= $this->input->post('keterangan');
			$aktif 			= $this->input->post('aktif');


			$data 			= [ 
								'id_jenis_izin' => $id_jenis_izin,
								'kd_workflow' 	=> $kd_workflow,
								'nm_workflow' 	=> $nm_workflow,
								'keterangan' 	=> $keterangan,
								'aktif' 		=> $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_workflow';
			$condition[1] 	= $id_workflow;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_workflow', $condition, $data);
			
			$response 	= ['status' => $data];
			// $response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_workflow 	= $this->input->post('id_workflow');

			$condition 		= [];
			$condition[] 	= ['id_workflow', $id_workflow, 'where'];

			$response 		= $this->M_admin->get_master_spec('t_workflow',  'id_jenis_izin, id_workflow, kd_workflow, nm_workflow, keterangan, aktif', $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_workflow', $id_workflow, 'where'];	
			$condition[] 	= ['aktif', 1, 'where'];	
			$condition[] 	= ['kd_aktivitas_workflow', 'ASC', 'order_by'];	
			$ak_workflow 	= $this->M_admin->get_master_spec('t_aktivitas_workflow',  'id_aktivitas_workflow, kd_aktivitas_workflow, nm_aktivitas_workflow', $condition)->result_array();

			$content 		= '';
			foreach ($ak_workflow as $akw) {
				$content 	.= 
							'<li class="dd-item dd3-item" data-id="'.$akw['id_aktivitas_workflow'].'">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">
                                    '.$akw['nm_aktivitas_workflow'].'
                                </div>
                          	</li>';
			}			

	        $response['ck_aktif']  		= $response['aktif'] == 1 ? true : false;
	        $response['aktivitas_workflow'] = $content;
		} elseif ($action == "get_jenis_izin") {
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];	
			$dZ 			= $this->M_admin->get_master_spec('m_jenis_izin',  'id_nama_izin, kd_jenis_izin', $condition)->row_array();		

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $dZ['id_nama_izin'], 'where'];	
			$nZ 			= $this->M_admin->get_master_spec('m_nama_izin',  'nama_izin, akronim', $condition)->row_array();

			$jenis_izin 	= $this->get_jenis_izin($dZ['kd_jenis_izin']);

			$response 		= [
								'jenis_izin' => $nZ['akronim'].' '.$jenis_izin, 
								'nama_izin' => $nZ['nama_izin']
							];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function ki_aktivitas_workflow() {
		$d['page']      	= 'ki_aktivitas_workflow';
        $d['menu']      	= 'Konfigurasi Aktivitas Workflow';
        $d['title']      	= 'Konfigurasi Aktivitas Workflow';
        // $d['list_menu'] 	= $this->list_menuizin();
        $d['opt_akses']		= $this->list_static_select($this->opt_akses);

		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];	        
        $d['SL_aktivitas'] 	= $this->list_bootstrap_select('m_aktivitas', 'id_aktivitas', 'nama_aktivitas', $condition);

		$this->load->view('layout', $d);
	}

	// id_aktivitas_workflow
	// kd_aktivitas_workflow
	// nm_aktivitas_workflow
	// id_workflow
	// id_aktivitas
	// aktif

	public function show_ki_aktivitas_workflow($table) {
		if ($table == "table1") {
			$table          = 'v_aktivitas_workflow';

			$kd_workflow 	= $this->input->post('kd_workflow');
			$condition 		= [];
			$condition[] 	= ['kd_workflow', $kd_workflow, 'where'];	
			
	        $column_order   = array(null, 'kd_aktivitas_workflow', 'nm_aktivitas_workflow', 'nama_aktivitas', null, null); 
	        $column_search  = array('kd_aktivitas_workflow', 'nm_aktivitas_workflow', 'nama_aktivitas'); 
	        $order          = array('kd_aktivitas_workflow' => 'asc');

	        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = array();
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {
	        	if ($ld->aktif == 1) {
	        		$html_stat 	= '<input class="action" data-action="aktif-ak" data-id_aktivitas_workflow="'.$ld->id_aktivitas_workflow.'" type="checkbox" id="lblak-'.$ld->id_aktivitas_workflow.'" checked switch="none" >
	                                            <label for="lblak-'.$ld->id_aktivitas_workflow.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	} else {
	        		$html_stat 	= '<input class="action" data-action="aktif-ak" data-id_aktivitas_workflow="'.$ld->id_aktivitas_workflow.'" type="checkbox" id="lblak-'.$ld->id_aktivitas_workflow.'" switch="none" >
	                                            <label for="lblak-'.$ld->id_aktivitas_workflow.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	}       	     	

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $ld->kd_aktivitas_workflow;
	            $row[] = $ld->nm_aktivitas_workflow;
	            $row[] = $ld->nama_aktivitas;
	            $row[] = $html_stat;
				$row[] = '&nbsp;<button 
								type="button" data-id="'.$ld->id_aktivitas_workflow.'" data-action="atur" data-atur="pj" class="action btn btn-xs btn-icon waves-effect btn-brown m-b-5 tooltip-hover tooltipstered"
						  		title="Atur Penanggung Jawab"> <i class="fa fa-users"></i> 
						</button>
						&nbsp;<button 
								type="button" data-id="'.$ld->id_aktivitas_workflow.'" data-action="atur" data-atur="ad" class="action btn btn-xs btn-icon waves-effect btn-purple m-b-5 tooltip-hover tooltipstered"
						  		title="Atur Decision"> <i class="fa fa-balance-scale"></i> 
						</button>
						&nbsp;<button 
								type="button" data-id="'.$ld->id_aktivitas_workflow.'" data-action="edit-ak" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
					  			title="Ubah"> <i class="fa fa-pencil"></i> 
						</button>';

	            $data[] = $row;
	        }

	        $output = array(
		            "draw" => $_POST['draw'],
		            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
		            "recordsTotal" => $this->M_admin->count_all($table, $condition),
		            "data" => $data,
	            );
		} elseif ($table == "table2") {
			$table          = 'v_user';

			$id_aktivitas_workflow 	= $this->input->post('aktivitas_workflow');
			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];							
			$condition[] 	= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];							
			$user_workflow_r= $this->M_admin->get_master_spec('t_user_workflow',  'id_user', $condition)->result_array();
			foreach ($user_workflow_r as $ur) {
						$user_workflow[] 	= $ur['id_user'];
					}


			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];	
			$condition[] 	= ['id_user', !empty($user_workflow) ? $user_workflow : '', 'where_in'];			

	        $column_order   = array(null, 'nm_user', 'nm_jabatan', null); 
	        $column_search  = array('nm_user', 'nm_jabatan'); 
	        $order          = array('id_user' => 'asc');

	        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = array();
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {     	     	

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $ld->nm_user;
	            $row[] = $ld->nm_jabatan;
				$row[] = '&nbsp;<button 
								type="button" data-id="'.$ld->id_user.'" data-action="del" class="action btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered"
			  					title="Hapus"> <i class="fa fa-times"></i> 
							</button>';

	            $data[] = $row;
	        }

	        $output = array(
		            "draw" => $_POST['draw'],
		            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
		            "recordsTotal" => $this->M_admin->count_all($table, $condition),
		            "data" => $data,
	            );			
		} elseif ($table == "table3") {
			$table          = 'v_workflow_decision';

			$id_aktivitas_workflow 	= $this->input->post('aktivitas_workflow');
			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];							
			$condition[] 	= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];		

	        $column_order   = array(null, 'kd_workflow_decision', 'nm_workflow_decision', 'direct_nm_aktivitas_workflow', 'nm_decision', null); 
	        $column_search  = array('kd_workflow_decision', 'nm_workflow_decision', 'direct_nm_aktivitas_workflow', 'nm_decision'); 
	        $order          = array('kd_workflow_decision' => 'asc');

	        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = array();
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {     	     	

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $ld->kd_workflow_decision;
	            $row[] = $ld->nm_workflow_decision;
	            $row[] = $ld->direct_nm_aktivitas_workflow;
	            $row[] = $ld->nm_decision;
				$row[] = '&nbsp;<button 
								type="button" data-id="'.$ld->id_workflow_decision.'" data-action="del" class="action btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered"
			  					title="Hapus"> <i class="fa fa-times"></i> 
							</button>';

	            $data[] = $row;
	        }

	        $output = array(
		            "draw" => $_POST['draw'],
		            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
		            "recordsTotal" => $this->M_admin->count_all($table, $condition),
		            "data" => $data,
	            );			
		}		

        echo json_encode($output);		
	}

	public function ki_aktivitas_workflow_action($action) {

		if ($action == "pj") {
			$id_aktivitas_workflow 	= $this->input->post('id_aktivitas_workflow');

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];							
			$condition[] 	= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];							
			$user_workflow_r= $this->M_admin->get_master_spec('t_user_workflow',  'id_user', $condition)->result_array();
			foreach ($user_workflow_r as $ur) {
						$user_workflow[] 	= $ur['id_user'];
					}		

			$condition 		= [];
			$condition[] 	= ['mu.aktif', 1, 'where'];	
			$condition[] 	= ['mu.id_user', !empty($user_workflow) ? $user_workflow : '', 'where_not_in'];	
			$list_user 		= $this->M_admin->list_user($condition)->result_array();

			$option 		= '';
			foreach ($list_user as $lu) {
				$option 	.= '<option value="'.$lu['id_user'].'">'.$lu['nm_user'].' ('.$lu['nm_jabatan'].')'.'</option>';
			}

			$response 	= ['select' => $option];
		} elseif ($action == "ad") {
			$id_aktivitas_workflow 	= $this->input->post('id_aktivitas_workflow');	

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];	
			$condition[] 	= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];	
			$id_workflow 	= $this->M_admin->get_master_spec('t_aktivitas_workflow', 'id_workflow', $condition)->row_array()['id_workflow'];

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];	
			$condition[] 	= ['id_workflow', $id_workflow, 'where'];	
			$condition[] 	= ['kd_aktivitas_workflow', 'asc', 'order_by'];	
			$list_workflow 	= $this->M_admin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow, nm_aktivitas_workflow', $condition)->result_array();			

			$condition 		= [];
			$condition[] 	= ['aktif', 1, 'where'];	
			$list_decision 	= $this->M_admin->get_master_spec('m_decision', 'id_decision, nm_decision', $condition)->result_array();						

			$option_wk		= '<option value="">- Pilih Workflow -</option>';
			foreach ($list_workflow as $lw) {
				$option_wk	.= '<option value="'.$lw['id_aktivitas_workflow'].'">'.$lw['nm_aktivitas_workflow'].'</option>';
			}

			$option_ad		= '';
			foreach ($list_decision as $ld) {
				$option_ad	.= '<option value="'.$ld['id_decision'].'">'.$ld['nm_decision'].'</option>';
			}			

			$response 	= ['select_wk' => $option_wk, 'select_ad' => $option_ad];
		} elseif ($action == "add-pj") {
			$id_aktivitas_workflow 	= $this->input->post('id_aktivitas_workflow');
			$id_user	= $this->input->post('id_user');

			$data 		= [];
			for ($a=0;$a<count($id_user);$a++) {
				$data[]			= [ 
									'id_aktivitas_workflow'	=> $id_aktivitas_workflow,
									'id_user' 	=> $id_user[$a],
									'aktif' 	=> 1
								];
			}

			$this->M_admin->insert_data_batch('t_user_workflow', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "add-ad") {
			$id_aktivitas_workflow 		= $this->input->post('id_aktivitas_workflow');
			$id_decision				= $this->input->post('id_decision');
			$nm_workflow_decision		= $this->input->post('nm_workflow_decision');
			$direct_id_aktivitas_workflow= $this->input->post('direct_id_aktivitas_workflow');

			$data	= [ 
						'id_aktivitas_workflow'	=> $id_aktivitas_workflow,
						'id_decision' 			=> $id_decision,
						'nm_workflow_decision' 	=> $nm_workflow_decision,
						'direct_id_aktivitas_workflow' 	=> $direct_id_aktivitas_workflow,
						'aktif' 				=> 1
					];

			$this->M_admin->insert_data('t_workflow_decision', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "del-pj") {
			$id_user	= $this->input->post('id_user');

			$data 			= [ 
								'aktif' 			=> 3
							];

			$condition 		= [];
			$condition[0] 	= 'id_user';
			$condition[1] 	= $id_user;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_user_workflow', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "del-ad") {
			$id_workflow_decision= $this->input->post('id_workflow_decision');

			$data 			= [ 
								'aktif' 			=> 3
							];

			$condition 		= [];
			$condition[0] 	= 'id_workflow_decision';
			$condition[1] 	= $id_workflow_decision;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_workflow_decision', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "get_jenis_izin") {
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];	
			$dZ 			= $this->M_admin->get_master_spec('m_jenis_izin',  'id_nama_izin, kd_jenis_izin', $condition)->row_array();		

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $dZ['id_nama_izin'], 'where'];	
			$nZ 			= $this->M_admin->get_master_spec('m_nama_izin',  'nama_izin, akronim', $condition)->row_array();

			$jenis_izin 	= $this->get_jenis_izin($dZ['kd_jenis_izin']);

			$response 		= [
								'jenis_izin' => $nZ['akronim'].' '.$jenis_izin, 
								'nama_izin' => $nZ['nama_izin']
							];
		} elseif ($action == "get_nest") {
			$kd_workflow 	= $this->input->post('kd_workflow');

			$condition 		= [];
			$condition[] 	= ['kd_workflow', $kd_workflow, 'where'];							
			$tw 			= $this->M_admin->get_master_spec('t_workflow',  'id_workflow, nm_workflow', $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_workflow', $tw['id_workflow'], 'where'];	
			$condition[] 	= ['aktif', 1, 'where'];	
			$condition[] 	= ['kd_aktivitas_workflow', 'ASC', 'order_by'];	
			$ak_workflow 	= $this->M_admin->get_master_spec('t_aktivitas_workflow',  'id_aktivitas_workflow, kd_aktivitas_workflow, nm_aktivitas_workflow', $condition)->result_array();

			$content 		= '';
			foreach ($ak_workflow as $akw) {
				$content 	.= 
							'<li class="dd-item dd3-item" data-id="'.$akw['id_aktivitas_workflow'].'">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">
                                    '.$akw['nm_aktivitas_workflow'].'
                                </div>
                          	</li>';
			}

			$this->session->set_userdata('last_order_aw', $ak_workflow);

			$response 		= ['content' => $content, 'id_workflow' => $tw['id_workflow'], 'nm_workflow' => '<b>'.$tw['nm_workflow'].'</b>'];
		} elseif ($action == "sv_order") {
			$nData			= json_decode($this->input->post('data'), true);
			$id_workflow 	= $this->input->post('id_workflow');

			$akw 			= $this->session->userdata('last_order_aw');

			$data 		= [];
			$data_r		= [];
			foreach ($nData as $key => $value) {
				$data_r[] 	= [
								'id_aktivitas_workflow' 	=> $nData[$key]['id'],
								'kd_aktivitas_workflow' 	=> null
							];
				$data[]		= [
								'id_aktivitas_workflow' 	=> $nData[$key]['id'],
								'kd_aktivitas_workflow' 	=> $akw[$key]['kd_aktivitas_workflow']
							];
			}

			$this->M_admin->update_data_batch('t_aktivitas_workflow', 'id_aktivitas_workflow', $data_r); //set null
			$this->M_admin->update_data_batch('t_aktivitas_workflow', 'id_aktivitas_workflow', $data);

			$response 	= ['status' => "OK!"];
		} elseif ($action == "add-ak") {
			$kd_workflow 		= $this->input->post('kd_workflow');

			$perusahaan_cfg 	= $this->input->post('perusahaan_cfg');
			$berkas_cfg 		= $this->input->post('berkas_cfg');
			$syarat_cfg 		= $this->input->post('syarat_cfg');

			$condition 		= [];
			$condition[] 	= ['kd_workflow', $kd_workflow, 'where'];
			$id_workflow 	= $this->M_admin->get_master_spec('t_workflow', 'id_workflow', $condition)->row_array()['id_workflow'];

			$nm_aktivitas_workflow	= $this->input->post('nm_aktivitas_workflow');
			$id_aktivitas		= $this->input->post('id_aktivitas');

			$data	= [ 
						'id_workflow'	=> $id_workflow,
						'nm_aktivitas_workflow' => $nm_aktivitas_workflow,
						'id_aktivitas' 	=> $id_aktivitas,
						'aktif' 		=> 1
					];

			$id_aktivitas_workflow 	= $this->M_admin->insert_data('t_aktivitas_workflow', $data);

			$this->M_admin->insert_data('m_perusahaan_bio_cfg', ['id_aktivitas_workflow' => $id_aktivitas_workflow, 'permission' => $perusahaan_cfg]); // perusahaan
			$this->M_admin->insert_data('m_syarat_izin_cfg', ['id_aktivitas_workflow' => $id_aktivitas_workflow, 'permission' => $berkas_cfg]); // rekam berkas
			$this->M_admin->insert_data('m_rekam_berkas_cfg', ['id_aktivitas_workflow' => $id_aktivitas_workflow, 'permission' => $syarat_cfg]); // syarat izin
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit-ak") {
			$id_aktivitas_workflow	= $this->input->post('id_aktivitas_workflow');
			$id_aktivitas 			= $this->input->post('id_aktivitas');
			$nm_aktivitas_workflow 	= $this->input->post('nm_aktivitas_workflow');

			$perusahaan_cfg 	= $this->input->post('perusahaan_cfg');
			$berkas_cfg 		= $this->input->post('berkas_cfg');
			$syarat_cfg 		= $this->input->post('syarat_cfg');

			$id_perusahaan_bio_cfg 	= $this->input->post('id_perusahaan_bio_cfg');
			$id_rekam_berkas_cfg 	= $this->input->post('id_rekam_berkas_cfg');
			$id_syarat_izin_cfg 	= $this->input->post('id_syarat_izin_cfg');			

			$data 			= [ 
								'nm_aktivitas_workflow' => $nm_aktivitas_workflow,
								'id_aktivitas' 			=> $id_aktivitas								
							];

			$condition 		= [];
			$condition[0] 	= 'id_aktivitas_workflow';
			$condition[1] 	= $id_aktivitas_workflow;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_aktivitas_workflow', $condition, $data);

			if ($id_perusahaan_bio_cfg == '') {
				$this->M_admin->insert_data('m_perusahaan_bio_cfg', ['id_aktivitas_workflow' => $id_aktivitas_workflow, 'permission' => $perusahaan_cfg]); // perusahaan
			} else {
				$this->M_admin->update_data('m_perusahaan_bio_cfg', ['id_perusahaan_bio_cfg', $id_perusahaan_bio_cfg, 'where'] ,['permission' => $perusahaan_cfg]); // perusahaan
			}
			if ($id_rekam_berkas_cfg == '') {
				$this->M_admin->insert_data('m_rekam_berkas_cfg', ['id_aktivitas_workflow' => $id_aktivitas_workflow, 'permission' => $berkas_cfg]); // syarat izin
			} else {
				$this->M_admin->update_data('m_rekam_berkas_cfg', ['id_rekam_berkas_cfg', $id_rekam_berkas_cfg, 'where'] ,['permission' => $berkas_cfg]); // syarat izin			
			}
			if ($id_syarat_izin_cfg == '') {
				$this->M_admin->insert_data('m_syarat_izin_cfg', ['id_aktivitas_workflow' => $id_aktivitas_workflow, 'permission' => $syarat_cfg]); // rekam berkas
			} else {
				$this->M_admin->update_data('m_syarat_izin_cfg', ['id_syarat_izin_cfg', $id_syarat_izin_cfg, 'where'] ,['permission' => $syarat_cfg]); // rekam berkas
			}
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail-ak") {
			$id_aktivitas_workflow = $this->input->post('id_aktivitas_workflow');

			$condition 		= [];
			$condition[] 	= ['id_aktivitas_workflow', $id_aktivitas_workflow, 'where'];
			
			$data 			= $this->M_admin->get_master_spec('t_aktivitas_workflow', 'id_aktivitas_workflow, id_workflow, id_aktivitas, aktif, nm_aktivitas_workflow' , $condition)->row_array();

			$condition[] 	= ['aktif', 1, 'where'];
			$dPcfg 			= $this->M_admin->get_master_spec('m_perusahaan_bio_cfg', 'id_perusahaan_bio_cfg, id_aktivitas_workflow, permission, aktif' , $condition)->row_array();
			if (!$dPcfg) {
				$dPcfg['permission'] 	= 0;
				$data['id_perusahaan_bio_cfg']	= '';
			} else {
				$data['id_perusahaan_bio_cfg']	= $dPcfg['id_perusahaan_bio_cfg'];
			}
			$dRcfg 			= $this->M_admin->get_master_spec('m_rekam_berkas_cfg', 'id_rekam_berkas_cfg, id_aktivitas_workflow, permission, aktif' , $condition)->row_array();
			if (!$dRcfg) {
				$dRcfg['permission'] 	= 0;
				$data['id_rekam_berkas_cfg']	= '';
			} else {
				$data['id_rekam_berkas_cfg']	= $dRcfg['id_rekam_berkas_cfg'];
			}
			$dScfg 			= $this->M_admin->get_master_spec('m_syarat_izin_cfg', 'id_syarat_izin_cfg, id_aktivitas_workflow, permission, aktif' , $condition)->row_array();
			if (!$dScfg) {
				$dScfg['permission'] 	= 0;
				$data['id_syarat_izin_cfg']	= '';
			} else {
				$data['id_syarat_izin_cfg']	= $dScfg['id_syarat_izin_cfg'];
			}

			$data['pcfg'] 	= $this->list_static_select($this->opt_akses, $dPcfg['permission']);
			$data['rcfg'] 	= $this->list_static_select($this->opt_akses, $dRcfg['permission']);
			$data['scfg'] 	= $this->list_static_select($this->opt_akses, $dScfg['permission']);
			
			$condition 		= [];
			$condition[] 	= ['id_aktivitas !=', $data['id_aktivitas'], 'where'];
			$data['id_aktivitas'] = $this->list_bootstrap_select('m_aktivitas', 'id_aktivitas', 'nama_aktivitas', $condition, $data['id_aktivitas']);

			$response 		= $data;
		} elseif ($action == "aktif-ak") {
			$id_aktivitas_workflow	= $this->input->post('aktivitas_workflow');
			$status 				= $this->input->post('status');

			$data 			= [ 
								'aktif' => $status
							];

			$condition 		= [];
			$condition[0] 	= 'id_aktivitas_workflow';
			$condition[1] 	= $id_aktivitas_workflow;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('t_aktivitas_workflow', $condition, $data);
			
			$response 	= ['status' => $status];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}			

	function ki_berkas_prsh() {
		$d['page']      	= 'ki_berkas_prsh';
        $d['menu']      	= 'Konfigurasi Berkas Perusahaan';
        $d['title']      	= 'Konfigurasi Berkas Perusahaan';
		$d['list_menu'] 	= $this->list_menuizin();

		$d['sl_jenis_input']= $this->list_static_select($this->opt_jenis_input);
        $d['sl_tipe_data'] 	= $this->list_static_select($this->opt_tipe_data);        

		$this->load->view('layout', $d);
	}

	public function ki_berkas_prsh_action($action) {

		if ($action == 'get_dt_group') {
			$condition 		= [];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$datag 			= $this->M_admin->get_master_spec('m_perusahaan_bio_grup', 'id_perusahaan_bio_grup, kd_perusahaan_bio_grup, teks_judul, teks_subjudul', $condition)->result_array();
			$grup_perusahaan= '';
			$no 			= 1;
			foreach ($datag as $dg) {
				$dp['datag']['teks_judul'] 	= $dg['teks_judul'];
				$dp['datag']['hc'] 			= $dg['kd_perusahaan_bio_grup'];
				$dp['datag']['id'] 			= $dg['id_perusahaan_bio_grup'];
				$dp['datag']['no'] 			= $no;
				$dp['page']		 			= 'accord';
				$grup_perusahaan	.= $this->load->view('ki_berkas_prsh_grup', $dp, TRUE);
				$no++;
			}

			$response 	= ['datag' => $grup_perusahaan];			
		} elseif ($action == 'get_dt_child') {
			$dp['page']		 	= 'dt_child';

			$response			= $this->load->view('ki_berkas_prsh_grup', $dp, TRUE);
		} elseif ($action == 'add') {
			$perusahaan_bio_grup 		= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$teks_judul 	= $this->input->post('teks_judul');
			$teks_subjudul 	= $this->input->post('teks_subjudul');
			$show_first 	= $this->input->post('show_first');
			$show_pg_fe 	= $this->input->post('show_pg_fe');
			$show_pg_be 	= $this->input->post('show_pg_be');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'perusahaan_bio_grup' 		=> $perusahaan_bio_grup,
								'teks_judul' 	=> $teks_judul,
								'teks_subjudul' => $teks_subjudul,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$this->M_admin->insert_data('m_perusahaan_bio_grup', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == 'edit') {
			$id_perusahaan_bio_grup	= $this->input->post('id_perusahaan_bio_grup');
			$teks_judul		= $this->input->post('teks_judul');
			$teks_subjudul 	= $this->input->post('teks_subjudul');
			$show_first 	= $this->input->post('show_first');
			$show_pg_fe 	= $this->input->post('show_pg_fe');
			$show_pg_be 	= $this->input->post('show_pg_be');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'teks_judul' 	=> $teks_judul,
								'teks_subjudul'	=> $teks_subjudul,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_perusahaan_bio_grup';
			$condition[1] 	= $id_perusahaan_bio_grup;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_perusahaan_bio_grup', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_perusahaan_bio_grup = $this->input->post('id_perusahaan_bio_grup');

			$condition 		= [];
			$condition[] 	= ['id_perusahaan_bio_grup', $id_perusahaan_bio_grup, 'where'];
			
			$select 		= '
								id_perusahaan_bio_grup,
								teks_judul,
								teks_subjudul,
								show_first,
								show_pg_fe,
								show_pg_be,
								aktif
					 		';
			$response 		= $this->M_admin->get_master_spec('m_perusahaan_bio_grup', $select, $condition)->row_array();

	        $response['ck_show_first'] = $response['show_first'] == 1 ? true : false;
	        $response['ck_show_pg_fe'] = $response['show_pg_fe'] == 1 ? true : false;
	        $response['ck_show_pg_be'] 		= $response['show_pg_be'] == 1 ? true : false;
	        $response['ck_aktif']  		= $response['aktif'] == 1 ? true : false;
		} elseif ($action == "add-child") {
			$id_perusahaan_bio_grup = $this->input->post('id_group');

			$nama_perusahaan_bio		 	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$kode_formula	 	= $this->input->post('kode_formula');

			$teks_judul	 		= $this->input->post('teks_judul');
			$sub_teks_judul	 	= $this->input->post('sub_teks_judul');

			$jenis_input	 	= $this->input->post('jenis_input');
			$teks_judul_tbl	 	= $this->input->post('teks_judul_tbl');
			$teks_judul_select	= $this->input->post('teks_judul_select');
			$tipe_data	 		= $this->input->post('tipe_data');

			$table_tujuan_s	 	= $this->input->post('table_tujuan_s');
			$pk_tujuan_s	 	= $this->input->post('pk_tujuan_s');
			$table_tujuan_p	 	= $this->input->post('table_tujuan_p');
			$pk_tujuan_p	 	= $this->input->post('pk_tujuan_p');

			$attribute	 		= $this->input->post('attribute');
			$table_refrensi	 	= $this->input->post('table_refrensi');
			$pk_refrensi	 	= $this->input->post('pk_refrensi');
			$nm_refrensi	 	= $this->input->post('nm_refrensi');

			$keterangan	 		= $this->input->post('keterangan');

			$wajib_isi	 		= $this->input->post('wajib_isi');
			$multivalue	 		= $this->input->post('multivalue');
			$special	 		= $this->input->post('special');
			$show_first	 		= $this->input->post('show_first');
			$show_select	 	= $this->input->post('show_select');
			$show_tbl_be	 	= $this->input->post('show_tbl_be');
			$show_tbl_fe	 	= $this->input->post('show_tbl_fe');
			$show_pg_be	 		= $this->input->post('show_pg_be');
			$show_pg_fe	 		= $this->input->post('show_pg_fe');
			$aktif	 			= $this->input->post('aktif');

			if ($jenis_input == "tbl" || $jenis_input == "select") {
				$tipe_data 	= null;
			}

			// input _s
			$data 			= [ 
								'id_perusahaan_bio_grup' => $id_perusahaan_bio_grup,
								'nama_perusahaan_bio' 		=> $nama_perusahaan_bio,
								'kode_formula' 	=> $nama_perusahaan_bio.'1',
								'teks_judul' 	=> $teks_judul,
								'sub_teks_judul'=> $sub_teks_judul,
								'jenis_input' 	=> $jenis_input,
								'tipe_data' 	=> $tipe_data,
								'table_tujuan_s'=> $table_tujuan_s,
								'pk_tujuan_s' 	=> $pk_tujuan_s,
								'table_tujuan_p'=> $table_tujuan_p,
								'pk_tujuan_p' 	=> $pk_tujuan_p,
								'attribute' 	=> $attribute,
								'table_refrensi'=> $table_refrensi,
								'pk_refrensi' 	=> $pk_refrensi,
								'nm_refrensi' 	=> $nm_refrensi,
								'keterangan' 	=> $keterangan,
								'wajib_isi' 	=> $wajib_isi == null ? 0 : $wajib_isi,
								'multivalue' 	=> $multivalue == null ? 0 : $multivalue,
								'special' 		=> $special == null ? 0 : $special,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_select' 	=> $show_select == null ? 0 : $show_select,
								'show_tbl_be' 	=> $show_tbl_be == null ? 0 : $show_tbl_be,
								'show_tbl_fe' 	=> $show_tbl_fe == null ? 0 : $show_tbl_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];
			// insert and get id
			$id_perusahaan_bio_s 	= $this->M_admin->insert_data('m_perusahaan_bio_s', $data);

			// input _p
			if ($jenis_input == "tbl") {
				$data 	= [];
				for ($a=0;$a<count($teks_judul_tbl);$a++) {
					$data[] 	= [
								'id_perusahaan_bio_s' => $id_perusahaan_bio_s,
								'nama_perusahaan_bio_p' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis')),
								'kode_formula' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis').'1'), //belum
								'teks_judul' 	=> $teks_judul_tbl[$a],
								'keterangan'	=> '', //belum
								'jenis_input'	=> 'text', //belum
								'tipe_data'		=> 'string', //belum
								'wajib_isi' 	=> 0, //belum
								'aktif' 		=> 1 //belum
							];
				}

				$this->M_admin->insert_data_batch('m_perusahaan_bio_p', $data);
			} elseif ($jenis_input == "select") {
				$data 	= [];
				for ($a=0;$a<count($teks_judul_select);$a++) {
					$data[] 	= [
								'id_perusahaan_bio_s' => $id_perusahaan_bio_s,
								'nama_perusahaan_bio_p' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis')),
								'kode_formula' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis').'1'), //belum
								'teks_judul' 	=> $teks_judul_select[$a],
								'keterangan'	=> '', //belum
								'jenis_input'	=> 'text', //belum
								'tipe_data'		=> 'string', //belum
								'wajib_isi' 	=> 0, //belum
								'aktif' 		=> 1 //belum
							];
				}

				$this->M_admin->insert_data_batch('m_perusahaan_bio_p', $data);
			}
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail-child") {
			$id_perusahaan_bio_s = $this->input->post('id_perusahaan_bio_s');

			$condition 		= [];
			$condition[] 	= ['id_perusahaan_bio_s', $id_perusahaan_bio_s, 'where'];
			
			$select 		= '
								id_perusahaan_bio_s,
								id_perusahaan_bio_grup,
								nama_perusahaan_bio,
								kode_formula,
								teks_judul,
								sub_teks_judul,
								jenis_input,
								tipe_data,
								table_tujuan_s,
								pk_tujuan_s,
								table_tujuan_p,
								pk_tujuan_p,
								attribute,
								table_refrensi,
								pk_refrensi,
								nm_refrensi,
								keterangan,
								wajib_isi,
								multivalue,
								special,
								show_first,
								show_select,
								show_tbl_be,
								show_tbl_fe,
								show_pg_be,
								show_pg_fe,
								aktif
					 		';
			$response 		= $this->M_admin->get_master_spec('m_perusahaan_bio_s', $select, $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_perusahaan_bio_s', $id_perusahaan_bio_s, 'where'];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$select 		= '
								id_perusahaan_bio_p,
								teks_judul
					 		';
			$data_tbl 		= $this->M_admin->get_master_spec('m_perusahaan_bio_p', $select, $condition)->result_array();			
			$response['jl_teks_judul_tbl'] 		= count($data_tbl);
			$opt_tbl 		= $this->list_tags_select($data_tbl, 'teks_judul', 'id_perusahaan_bio_p');
			$response['sl_teks_judul_tbl'] 		= $opt_tbl['option'];
			$response['lbl_teks_judul_tbl'] 	= $opt_tbl['label'];

			// set temp session, last value
			$this->session->set_userdata('last_valtbl', $data_tbl);

			$condition 		= [];
			$condition[] 	= ['id_perusahaan_bio_s', $id_perusahaan_bio_s, 'where'];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$select 		= '
								id_perusahaan_bio_p,
								teks_judul
					 		';
			$data_select 	= $this->M_admin->get_master_spec('m_perusahaan_bio_p', $select, $condition)->result_array();						
			$response['jl_teks_judul_select'] 	= count($data_select);
			$opt_select		= $this->list_tags_select($data_select, 'teks_judul', 'id_perusahaan_bio_p');
			$response['sl_teks_judul_select'] 	= $opt_select['option'];
			$response['lbl_teks_judul_select'] 	= $opt_select['label'];

			// set temp session, last value
			$this->session->set_userdata('last_valselect', $data_select);

			$response['sl_jenis_input'] = $this->list_static_select($this->opt_jenis_input, $response['jenis_input']);
	        $response['sl_tipe_data']   = $this->list_static_select($this->opt_tipe_data, $response['tipe_data']);	

	        $response['ck_wajib_isi'] 	= $response['wajib_isi'] == 1 ? true : false;
	        $response['ck_multivalue'] 	= $response['multivalue'] == 1 ? true : false;
	        $response['ck_special'] 	= $response['special'] == 1 ? true : false;
	        $response['ck_show_first'] 	= $response['show_first'] == 1 ? true : false;
	        $response['ck_show_select'] = $response['show_select'] == 1 ? true : false;
	        $response['ck_show_tbl_be'] = $response['show_tbl_be'] == 1 ? true : false;
	        $response['ck_show_tbl_fe'] = $response['show_tbl_fe'] == 1 ? true : false;
	        $response['ck_show_pg_be'] 	= $response['show_pg_be'] == 1 ? true : false;
	        $response['ck_show_pg_fe'] 	= $response['show_pg_fe'] == 1 ? true : false;
	        $response['ck_aktif'] 		= $response['aktif'] == 1 ? true : false;
		} elseif ($action == 'edit-child') {
			$id_perusahaan_bio_s 	= $this->input->post('id_perusahaan_bio_s');
			$id_perusahaan_bio_grup = $this->input->post('id_group');

			$nama_perusahaan_bio		 	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$kode_formula	 	= $this->input->post('kode_formula');

			$teks_judul	 		= $this->input->post('teks_judul');
			$sub_teks_judul	 	= $this->input->post('sub_teks_judul');

			$jenis_input	 	= $this->input->post('jenis_input');
			$tipe_data	 		= $this->input->post('tipe_data');
			$teks_judul_tbl	 	= $this->input->post('teks_judul_tbl');
			$teks_judul_select	= $this->input->post('teks_judul_select');

			$table_tujuan_s	 	= $this->input->post('table_tujuan_s');
			$pk_tujuan_s	 	= $this->input->post('pk_tujuan_s');
			$table_tujuan_p	 	= $this->input->post('table_tujuan_p');
			$pk_tujuan_p	 	= $this->input->post('pk_tujuan_p');

			$attribute	 		= $this->input->post('attribute');
			$table_refrensi	 	= $this->input->post('table_refrensi');
			$pk_refrensi	 	= $this->input->post('pk_refrensi');
			$nm_refrensi	 	= $this->input->post('nm_refrensi');

			$keterangan	 		= $this->input->post('keterangan');

			$wajib_isi	 		= $this->input->post('wajib_isi');
			$multivalue	 		= $this->input->post('multivalue');
			$special	 		= $this->input->post('special');
			$show_first	 		= $this->input->post('show_first');
			$show_select	 	= $this->input->post('show_select');
			$show_tbl_be	 	= $this->input->post('show_tbl_be');
			$show_tbl_fe	 	= $this->input->post('show_tbl_fe');
			$show_pg_be	 		= $this->input->post('show_pg_be');
			$show_pg_fe	 		= $this->input->post('show_pg_fe');
			$aktif	 			= $this->input->post('aktif');

			if ($jenis_input == "tbl" || $jenis_input == "select") {
				$tipe_data 	= null;
			}

			// input _s
			$data 			= [ 
								'id_perusahaan_bio_grup' => $id_perusahaan_bio_grup,
								'nama_perusahaan_bio' 		=> $nama_perusahaan_bio,
								'kode_formula' 	=> $nama_perusahaan_bio.'1',
								'teks_judul' 	=> $teks_judul,
								'sub_teks_judul'=> $sub_teks_judul,
								'jenis_input' 	=> $jenis_input,
								'tipe_data' 	=> $tipe_data,
								'table_tujuan_s'=> $table_tujuan_s,
								'pk_tujuan_s' 	=> $pk_tujuan_s,
								'table_tujuan_p'=> $table_tujuan_p,
								'pk_tujuan_p' 	=> $pk_tujuan_p,
								'attribute' 	=> $attribute,
								'table_refrensi'=> $table_refrensi,
								'pk_refrensi' 	=> $pk_refrensi,
								'nm_refrensi' 	=> $nm_refrensi,
								'keterangan' 	=> $keterangan,
								'wajib_isi' 	=> $wajib_isi == null ? 0 : $wajib_isi,
								'multivalue' 	=> $multivalue == null ? 0 : $multivalue,
								'special' 		=> $special == null ? 0 : $special,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_select' 	=> $show_select == null ? 0 : $show_select,
								'show_tbl_be' 	=> $show_tbl_be == null ? 0 : $show_tbl_be,
								'show_tbl_fe' 	=> $show_tbl_fe == null ? 0 : $show_tbl_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_perusahaan_bio_s';
			$condition[1] 	= $id_perusahaan_bio_s;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_perusahaan_bio_s', $condition, $data);

			if ($jenis_input == "tbl") {
				$last_valtbl 	= $this->session->userdata('last_valtbl');

				$last_tblid 	= [];
				foreach ($last_valtbl as $lv) {
					$last_tblid[] 	= $lv['id_perusahaan_bio_p'];
				}

				for ($a=0;$a<count($last_tblid);$a++) {
					if (!in_array($last_tblid[$a], $teks_judul_tbl)) {
						$condition 		= [];
						$condition[0] 	= 'id_perusahaan_bio_p';
						$condition[1] 	= $last_tblid[$a];
						$condition[2] 	= 'where';
						$this->M_admin->update_data('m_perusahaan_bio_p', $condition, ['aktif' => 3]);
					}
				}
				
				for ($a=0;$a<count($teks_judul_tbl);$a++) {
					if (!in_array($teks_judul_tbl[$a], $last_tblid)) {
						$data 	= [];
						$data 	= [
									'id_perusahaan_bio_s' => $id_perusahaan_bio_s,
									'nama_perusahaan_bio_p' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis')),
									'kode_formula' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis').'1'), //belum
									'teks_judul' 	=> $teks_judul_tbl[$a],
									'keterangan'	=> '', //belum
									'jenis_input'	=> 'text', //belum
									'tipe_data'		=> 'string', //belum
									'wajib_isi' 	=> 0, //belum
									'aktif' 		=> 1 //belum
								];
					$this->M_admin->insert_data('m_perusahaan_bio_p', $data);
					}
				}

			} elseif ($jenis_input == "select") {
				$last_valselect	= $this->session->userdata('last_valselect');

				$last_selectid 	= [];
				foreach ($last_valselect as $lv) {
					$last_selectid[] 	= $lv['id_perusahaan_bio_p'];
				}

				for ($a=0;$a<count($last_selectid);$a++) {
					if (!in_array($last_selectid[$a], $teks_judul_select)) {
						$condition 		= [];
						$condition[0] 	= 'id_perusahaan_bio_p';
						$condition[1] 	= $last_selectid[$a];
						$condition[2] 	= 'where';
						$this->M_admin->update_data('m_perusahaan_bio_p', $condition, ['aktif' => 3]);
					}
				}

				for ($a=0;$a<count($teks_judul_select);$a++) {
					if (!in_array($teks_judul_select[$a], $last_selectid)) {
						$data 	= [];
						$data 	= [
									'id_perusahaan_bio_s' => $id_perusahaan_bio_s,
									'nama_perusahaan_bio_p' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis')),
									'kode_formula' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis').'1'), //belum
									'teks_judul' 	=> $teks_judul_select[$a],
									'keterangan'	=> '', //belum
									'jenis_input'	=> 'text', //belum
									'tipe_data'		=> 'string', //belum
									'wajib_isi' 	=> 0, //belum
									'aktif' 		=> 1 //belum
								];
					$this->M_admin->insert_data('m_perusahaan_bio_p', $data);
					}
				}
			}			
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == 'aktif_ch') {
			$id_perusahaan_bio_s	= $this->input->post('perusahaan_bio_s');
			$status 				= $this->input->post('status');

			$data 			= [ 
								'aktif' => $status
							];

			$condition 		= [];
			$condition[0] 	= 'id_perusahaan_bio_s';
			$condition[1] 	= $id_perusahaan_bio_s;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_perusahaan_bio_s', $condition, $data);
			
			$response 	= ['status' => $status];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	public function show_ki_berkas_prsh_grup($table) {
		$output = array();
		if ($table == 'table1') {
			$table          = 'm_perusahaan_bio_s';

			$id_perusahaan_bio_grup	= $this->input->post('id_group');
			$condition 		= [];
			$condition[] 	= ['id_perusahaan_bio_grup', $id_perusahaan_bio_grup, 'where'];	
			$condition[] 	= ['aktif !=', 3, 'where'];	
			
	        $column_order   = array(null, 'kd_perusahaan_bio_s', 'teks_judul', 'jenis_input', null, null); 
	        $column_search  = array('kd_perusahaan_bio_s', 'teks_judul', 'jenis_input'); 
	        $order          = array('kd_perusahaan_bio_s' => 'asc');

	        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = array();
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {
	        	if ($ld->aktif == 1) {
	        		$html_stat 	= '<input class="action" data-action="aktif_ch" data-id="'.$ld->id_perusahaan_bio_s.'" type="checkbox" id="lbpbs-'.$ld->id_perusahaan_bio_s.'" checked switch="none" >
	                                            <label for="lbpbs-'.$ld->id_perusahaan_bio_s.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	} else {
	        		$html_stat 	= '<input class="action" data-action="aktif_ch" data-id="'.$ld->id_perusahaan_bio_s.'" type="checkbox" id="lbpbs-'.$ld->id_perusahaan_bio_s.'" switch="none" >
	                                            <label for="lbpbs-'.$ld->id_perusahaan_bio_s.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	}       	     	

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $ld->kd_perusahaan_bio_s;
	            $row[] = $ld->teks_judul;
	            $row[] = $ld->jenis_input;
	            $row[] = $html_stat;
				$row[] = '&nbsp;<button 
								type="button" data-id="'.$ld->id_perusahaan_bio_s.'" data-action="edit-child" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
						  		title="Ubah"> <i class="fa fa-pencil"></i> 
						</button>';

	            $data[] = $row;
	        }

	        $output = array(
		            "draw" => $_POST['draw'],
		            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
		            "recordsTotal" => $this->M_admin->count_all($table, $condition),
		            "data" => $data,
	            );
		}

        echo json_encode($output);			
	}

	function ki_syarat_izin() {
		$d['page']      	= 'ki_syarat_izin';
        $d['menu']      	= 'Konfigurasi Syarat Izin';
        $d['title']      	= 'Konfigurasi Syarat Izin';
		$d['list_menu'] 	= $this->list_menuizin();

		$d['sl_jenis_input']= $this->list_static_select($this->opt_jenis_input);
        $d['sl_tipe_data'] 	= $this->list_static_select($this->opt_tipe_data);        

		$this->load->view('layout', $d);
	}

	public function ki_syarat_izin_action($action) {

		if ($action == "get_jenis_izin") {
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];	
			$dZ 			= $this->M_admin->get_master_spec('m_jenis_izin',  'id_nama_izin, kd_jenis_izin', $condition)->row_array();		

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $dZ['id_nama_izin'], 'where'];	
			$nZ 			= $this->M_admin->get_master_spec('m_nama_izin',  'nama_izin, akronim', $condition)->row_array();

			$jenis_izin 	= $this->get_jenis_izin($dZ['kd_jenis_izin']);

			$response 		= [
								'jenis_izin' => $nZ['akronim'].' '.$jenis_izin, 
								'nama_izin' => $nZ['nama_izin']
							];
		} elseif ($action == 'get_dt_group') {
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$condition 		= [];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];
			$datag 			= $this->M_admin->get_master_spec('m_syarat_izin_grup', 'id_syarat_izin_grup, kd_syarat_izin_grup, teks_judul, teks_subjudul', $condition)->result_array();
			$grup_perusahaan= '';
			$no 			= 1;
			foreach ($datag as $dg) {
				$dp['datag']['teks_judul'] 	= $dg['teks_judul'];
				$dp['datag']['hc'] 			= $dg['kd_syarat_izin_grup'];
				$dp['datag']['id'] 			= $dg['id_syarat_izin_grup'];
				$dp['datag']['no'] 			= $no;
				$dp['page']		 			= 'accord';
				$grup_perusahaan	.= $this->load->view('ki_syarat_izin_grup', $dp, TRUE);
				$no++;
			}

			$response 	= ['datag' => $grup_perusahaan];			
		} elseif ($action == 'get_dt_child') {
			$dp['page']		 	= 'dt_child';

			$response			= $this->load->view('ki_syarat_izin_grup', $dp, TRUE);
		} elseif ($action == 'add') {
			$syarat_izin_grup	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$teks_judul 	= $this->input->post('teks_judul');
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$teks_subjudul 	= $this->input->post('teks_subjudul');
			$show_first 	= $this->input->post('show_first');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'syarat_izin_grup' => $syarat_izin_grup,
								'id_jenis_izin' => $id_jenis_izin,
								'teks_judul' 	=> $teks_judul,
								'teks_subjudul' => $teks_subjudul,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$this->M_admin->insert_data('m_syarat_izin_grup', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == 'edit') {
			$id_syarat_izin_grup	= $this->input->post('id_syarat_izin_grup');
			$teks_judul		= $this->input->post('teks_judul');
			$teks_subjudul 	= $this->input->post('teks_subjudul');
			$show_first 	= $this->input->post('show_first');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'teks_judul' 	=> $teks_judul,
								'teks_subjudul'	=> $teks_subjudul,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_syarat_izin_grup';
			$condition[1] 	= $id_syarat_izin_grup;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_syarat_izin_grup', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_syarat_izin_grup = $this->input->post('id_syarat_izin_grup');

			$condition 		= [];
			$condition[] 	= ['id_syarat_izin_grup', $id_syarat_izin_grup, 'where'];
			
			$select 		= '
								id_syarat_izin_grup,
								teks_judul,
								teks_subjudul,
								show_first,
								aktif
					 		';
			$response 		= $this->M_admin->get_master_spec('m_syarat_izin_grup', $select, $condition)->row_array();

	        $response['ck_show_first'] = $response['show_first'] == 1 ? true : false;
	        $response['ck_aktif']  		= $response['aktif'] == 1 ? true : false;
		} elseif ($action == "add-child") {
			$id_syarat_izin_grup = $this->input->post('id_group');

			$nama_syarat_izin	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$kode_formula	 	= $this->input->post('kode_formula');

			$teks_judul	 		= $this->input->post('teks_judul');
			$sub_teks_judul	 	= $this->input->post('sub_teks_judul');

			$jenis_input	 	= $this->input->post('jenis_input');
			$teks_judul_tbl	 	= $this->input->post('teks_judul_tbl');
			$teks_judul_select	= $this->input->post('teks_judul_select');
			$tipe_data	 		= $this->input->post('tipe_data');

			$table_tujuan_s	 	= $this->input->post('table_tujuan_s');
			$pk_tujuan_s	 	= $this->input->post('pk_tujuan_s');
			$table_tujuan_p	 	= $this->input->post('table_tujuan_p');
			$pk_tujuan_p	 	= $this->input->post('pk_tujuan_p');

			$attribute	 		= $this->input->post('attribute');
			$table_refrensi	 	= $this->input->post('table_refrensi');
			$pk_refrensi	 	= $this->input->post('pk_refrensi');
			$nm_refrensi	 	= $this->input->post('nm_refrensi');

			$keterangan	 		= $this->input->post('keterangan');

			$wajib_isi	 		= $this->input->post('wajib_isi');
			$multivalue	 		= $this->input->post('multivalue');
			$special	 		= $this->input->post('special');
			$show_first	 		= $this->input->post('show_first');
			$show_select	 	= $this->input->post('show_select');
			$show_tbl_be	 	= $this->input->post('show_tbl_be');
			$show_tbl_fe	 	= $this->input->post('show_tbl_fe');
			$show_pg_be	 		= $this->input->post('show_pg_be');
			$show_pg_fe	 		= $this->input->post('show_pg_fe');
			$aktif	 			= $this->input->post('aktif');

			if ($jenis_input == "tbl" || $jenis_input == "select") {
				$tipe_data 	= null;
			}

			// input _s
			$data 			= [ 
								'id_syarat_izin_grup' => $id_syarat_izin_grup,
								'nama_syarat_izin' 		=> $nama_syarat_izin,
								'kode_formula' 	=> $nama_syarat_izin.'1',
								'teks_judul' 	=> $teks_judul,
								'sub_teks_judul'=> $sub_teks_judul,
								'jenis_input' 	=> $jenis_input,
								'tipe_data' 	=> $tipe_data,
								'table_tujuan_s'=> $table_tujuan_s,
								'pk_tujuan_s' 	=> $pk_tujuan_s,
								'table_tujuan_p'=> $table_tujuan_p,
								'pk_tujuan_p' 	=> $pk_tujuan_p,
								'attribute' 	=> $attribute,
								'table_refrensi'=> $table_refrensi,
								'pk_refrensi' 	=> $pk_refrensi,
								'nm_refrensi' 	=> $nm_refrensi,
								'keterangan' 	=> $keterangan,
								'wajib_isi' 	=> $wajib_isi == null ? 0 : $wajib_isi,
								'multivalue' 	=> $multivalue == null ? 0 : $multivalue,
								'special' 		=> $special == null ? 0 : $special,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_select' 	=> $show_select == null ? 0 : $show_select,
								'show_tbl_be' 	=> $show_tbl_be == null ? 0 : $show_tbl_be,
								'show_tbl_fe' 	=> $show_tbl_fe == null ? 0 : $show_tbl_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];
			// insert and get id
			$id_syarat_izin_s 	= $this->M_admin->insert_data('m_syarat_izin_s', $data);

			// input _p
			if ($jenis_input == "tbl") {
				$data 	= [];
				for ($a=0;$a<count($teks_judul_tbl);$a++) {
					$data[] 	= [
								'id_syarat_izin_s' => $id_syarat_izin_s,
								'nama_syarat_izin_p' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis')),
								'kode_formula' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis').'1'), //belum
								'teks_judul' 	=> $teks_judul_tbl[$a],
								'keterangan'	=> '', //belum
								'jenis_input'	=> 'text', //belum
								'tipe_data'		=> 'string', //belum
								'wajib_isi' 	=> 0, //belum
								'aktif' 		=> 1 //belum
							];
				}

				$this->M_admin->insert_data_batch('m_syarat_izin_p', $data);
			} elseif ($jenis_input == "select") {
				$data 	= [];
				for ($a=0;$a<count($teks_judul_select);$a++) {
					$data[] 	= [
								'id_syarat_izin_s' => $id_syarat_izin_s,
								'nama_syarat_izin_p' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis')),
								'kode_formula' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis').'1'), //belum
								'teks_judul' 	=> $teks_judul_select[$a],
								'keterangan'	=> '', //belum
								'jenis_input'	=> 'text', //belum
								'tipe_data'		=> 'string', //belum
								'wajib_isi' 	=> 0, //belum
								'aktif' 		=> 1 //belum
							];
				}

				$this->M_admin->insert_data_batch('m_syarat_izin_p', $data);
			}
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail-child") {
			$id_syarat_izin_s = $this->input->post('id_syarat_izin_s');

			$condition 		= [];
			$condition[] 	= ['id_syarat_izin_s', $id_syarat_izin_s, 'where'];
			
			$select 		= '
								id_syarat_izin_s,
								id_syarat_izin_grup,
								nama_syarat_izin,
								kode_formula,
								teks_judul,
								sub_teks_judul,
								jenis_input,
								tipe_data,
								table_tujuan_s,
								pk_tujuan_s,
								table_tujuan_p,
								pk_tujuan_p,
								attribute,
								table_refrensi,
								pk_refrensi,
								nm_refrensi,
								keterangan,
								wajib_isi,
								multivalue,
								special,
								show_first,
								show_select,
								show_tbl_be,
								show_tbl_fe,
								show_pg_be,
								show_pg_fe,
								aktif
					 		';
			$response 		= $this->M_admin->get_master_spec('m_syarat_izin_s', $select, $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_syarat_izin_s', $id_syarat_izin_s, 'where'];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$select 		= '
								id_syarat_izin_p,
								teks_judul
					 		';
			$data_tbl 		= $this->M_admin->get_master_spec('m_syarat_izin_p', $select, $condition)->result_array();			
			$response['jl_teks_judul_tbl'] 		= count($data_tbl);
			$opt_tbl 		= $this->list_tags_select($data_tbl, 'teks_judul', 'id_syarat_izin_p');
			$response['sl_teks_judul_tbl'] 		= $opt_tbl['option'];
			$response['lbl_teks_judul_tbl'] 	= $opt_tbl['label'];

			// set temp session, last value
			$this->session->set_userdata('last_valtbl', $data_tbl);

			$condition 		= [];
			$condition[] 	= ['id_syarat_izin_s', $id_syarat_izin_s, 'where'];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$select 		= '
								id_syarat_izin_p,
								teks_judul
					 		';
			$data_select 	= $this->M_admin->get_master_spec('m_syarat_izin_p', $select, $condition)->result_array();						
			$response['jl_teks_judul_select'] 	= count($data_select);
			$opt_select		= $this->list_tags_select($data_select, 'teks_judul', 'id_syarat_izin_p');
			$response['sl_teks_judul_select'] 	= $opt_select['option'];
			$response['lbl_teks_judul_select'] 	= $opt_select['label'];

			// set temp session, last value
			$this->session->set_userdata('last_valselect', $data_select);

			$response['sl_jenis_input'] = $this->list_static_select($this->opt_jenis_input, $response['jenis_input']);
	        $response['sl_tipe_data']   = $this->list_static_select($this->opt_tipe_data, $response['tipe_data']);	

	        $response['ck_wajib_isi'] 	= $response['wajib_isi'] == 1 ? true : false;
	        $response['ck_multivalue'] 	= $response['multivalue'] == 1 ? true : false;
	        $response['ck_special'] 	= $response['special'] == 1 ? true : false;
	        $response['ck_show_first'] 	= $response['show_first'] == 1 ? true : false;
	        $response['ck_show_select'] = $response['show_select'] == 1 ? true : false;
	        $response['ck_show_tbl_be'] = $response['show_tbl_be'] == 1 ? true : false;
	        $response['ck_show_tbl_fe'] = $response['show_tbl_fe'] == 1 ? true : false;
	        $response['ck_show_pg_be'] 	= $response['show_pg_be'] == 1 ? true : false;
	        $response['ck_show_pg_fe'] 	= $response['show_pg_fe'] == 1 ? true : false;
	        $response['ck_aktif'] 		= $response['aktif'] == 1 ? true : false;
		} elseif ($action == 'edit-child') {
			$id_syarat_izin_s 	= $this->input->post('id_syarat_izin_s');
			$id_syarat_izin_grup = $this->input->post('id_group');

			$nama_syarat_izin		 	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$kode_formula	 	= $this->input->post('kode_formula');

			$teks_judul	 		= $this->input->post('teks_judul');
			$sub_teks_judul	 	= $this->input->post('sub_teks_judul');

			$jenis_input	 	= $this->input->post('jenis_input');
			$tipe_data	 		= $this->input->post('tipe_data');
			$teks_judul_tbl	 	= $this->input->post('teks_judul_tbl');
			$teks_judul_select	= $this->input->post('teks_judul_select');

			$table_tujuan_s	 	= $this->input->post('table_tujuan_s');
			$pk_tujuan_s	 	= $this->input->post('pk_tujuan_s');
			$table_tujuan_p	 	= $this->input->post('table_tujuan_p');
			$pk_tujuan_p	 	= $this->input->post('pk_tujuan_p');

			$attribute	 		= $this->input->post('attribute');
			$table_refrensi	 	= $this->input->post('table_refrensi');
			$pk_refrensi	 	= $this->input->post('pk_refrensi');
			$nm_refrensi	 	= $this->input->post('nm_refrensi');

			$keterangan	 		= $this->input->post('keterangan');

			$wajib_isi	 		= $this->input->post('wajib_isi');
			$multivalue	 		= $this->input->post('multivalue');
			$special	 		= $this->input->post('special');
			$show_first	 		= $this->input->post('show_first');
			$show_select	 	= $this->input->post('show_select');
			$show_tbl_be	 	= $this->input->post('show_tbl_be');
			$show_tbl_fe	 	= $this->input->post('show_tbl_fe');
			$show_pg_be	 		= $this->input->post('show_pg_be');
			$show_pg_fe	 		= $this->input->post('show_pg_fe');
			$aktif	 			= $this->input->post('aktif');

			if ($jenis_input == "tbl" || $jenis_input == "select") {
				$tipe_data 	= null;
			}

			// input _s
			$data 			= [ 
								'id_syarat_izin_grup' => $id_syarat_izin_grup,
								'nama_syarat_izin' 		=> $nama_syarat_izin,
								'kode_formula' 	=> $nama_syarat_izin.'1',
								'teks_judul' 	=> $teks_judul,
								'sub_teks_judul'=> $sub_teks_judul,
								'jenis_input' 	=> $jenis_input,
								'tipe_data' 	=> $tipe_data,
								'table_tujuan_s'=> $table_tujuan_s,
								'pk_tujuan_s' 	=> $pk_tujuan_s,
								'table_tujuan_p'=> $table_tujuan_p,
								'pk_tujuan_p' 	=> $pk_tujuan_p,
								'attribute' 	=> $attribute,
								'table_refrensi'=> $table_refrensi,
								'pk_refrensi' 	=> $pk_refrensi,
								'nm_refrensi' 	=> $nm_refrensi,
								'keterangan' 	=> $keterangan,
								'wajib_isi' 	=> $wajib_isi == null ? 0 : $wajib_isi,
								'multivalue' 	=> $multivalue == null ? 0 : $multivalue,
								'special' 		=> $special == null ? 0 : $special,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_select' 	=> $show_select == null ? 0 : $show_select,
								'show_tbl_be' 	=> $show_tbl_be == null ? 0 : $show_tbl_be,
								'show_tbl_fe' 	=> $show_tbl_fe == null ? 0 : $show_tbl_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_syarat_izin_s';
			$condition[1] 	= $id_syarat_izin_s;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_syarat_izin_s', $condition, $data);

			if ($jenis_input == "tbl") {
				$last_valtbl 	= $this->session->userdata('last_valtbl');

				$last_tblid 	= [];
				foreach ($last_valtbl as $lv) {
					$last_tblid[] 	= $lv['id_syarat_izin_p'];
				}

				for ($a=0;$a<count($last_tblid);$a++) {
					if (!in_array($last_tblid[$a], $teks_judul_tbl)) {
						$condition 		= [];
						$condition[0] 	= 'id_syarat_izin_p';
						$condition[1] 	= $last_tblid[$a];
						$condition[2] 	= 'where';
						$this->M_admin->update_data('m_syarat_izin_p', $condition, ['aktif' => 3]);
					}
				}
				
				for ($a=0;$a<count($teks_judul_tbl);$a++) {
					if (!in_array($teks_judul_tbl[$a], $last_tblid)) {
						$data 	= [];
						$data 	= [
									'id_syarat_izin_s' => $id_syarat_izin_s,
									'nama_syarat_izin_p' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis')),
									'kode_formula' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis').'1'), //belum
									'teks_judul' 	=> $teks_judul_tbl[$a],
									'keterangan'	=> '', //belum
									'jenis_input'	=> 'text', //belum
									'tipe_data'		=> 'string', //belum
									'wajib_isi' 	=> 0, //belum
									'aktif' 		=> 1 //belum
								];
					$this->M_admin->insert_data('m_syarat_izin_p', $data);
					}
				}

			} elseif ($jenis_input == "select") {
				$last_valselect	= $this->session->userdata('last_valselect');

				$last_selectid 	= [];
				foreach ($last_valselect as $lv) {
					$last_selectid[] 	= $lv['id_syarat_izin_p'];
				}

				for ($a=0;$a<count($last_selectid);$a++) {
					if (!in_array($last_selectid[$a], $teks_judul_select)) {
						$condition 		= [];
						$condition[0] 	= 'id_syarat_izin_p';
						$condition[1] 	= $last_selectid[$a];
						$condition[2] 	= 'where';
						$this->M_admin->update_data('m_syarat_izin_p', $condition, ['aktif' => 3]);
					}
				}

				for ($a=0;$a<count($teks_judul_select);$a++) {
					if (!in_array($teks_judul_select[$a], $last_selectid)) {
						$data 	= [];
						$data 	= [
									'id_syarat_izin_s' => $id_syarat_izin_s,
									'nama_syarat_izin_p' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis')),
									'kode_formula' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis').'1'), //belum
									'teks_judul' 	=> $teks_judul_select[$a],
									'keterangan'	=> '', //belum
									'jenis_input'	=> 'text', //belum
									'tipe_data'		=> 'string', //belum
									'wajib_isi' 	=> 0, //belum
									'aktif' 		=> 1 //belum
								];
					$this->M_admin->insert_data('m_syarat_izin_p', $data);
					}
				}
			}						
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == 'aktif_ch') {
			$id_syarat_izin_s	= $this->input->post('syarat_izin_s');
			$status 			= $this->input->post('status');

			$data 			= [ 
								'aktif' => $status
							];

			$condition 		= [];
			$condition[0] 	= 'id_syarat_izin_s';
			$condition[1] 	= $id_syarat_izin_s;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_syarat_izin_s', $condition, $data);
			
			$response 	= ['status' => $status];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	public function show_ki_syarat_izin_grup($table) {
		$output = array();
		if ($table == 'table1') {
			$table          = 'm_syarat_izin_s';

			$id_syarat_izin_grup	= $this->input->post('id_group');
			$condition 		= [];
			$condition[] 	= ['id_syarat_izin_grup', $id_syarat_izin_grup, 'where'];	
			$condition[] 	= ['aktif !=', 3, 'where'];	
			
	        $column_order   = array(null, 'kd_syarat_izin_s', 'teks_judul', 'jenis_input', null, null); 
	        $column_search  = array('kd_syarat_izin_s', 'teks_judul', 'jenis_input'); 
	        $order          = array('kd_syarat_izin_s' => 'asc');

	        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = array();
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {
	        	if ($ld->aktif == 1) {
	        		$html_stat 	= '<input class="action" data-action="aktif_ch" data-id="'.$ld->id_syarat_izin_s.'" type="checkbox" id="lbpbs-'.$ld->id_syarat_izin_s.'" checked switch="none" >
	                                            <label for="lbpbs-'.$ld->id_syarat_izin_s.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	} else {
	        		$html_stat 	= '<input class="action" data-action="aktif_ch" data-id="'.$ld->id_syarat_izin_s.'" type="checkbox" id="lbpbs-'.$ld->id_syarat_izin_s.'" switch="none" >
	                                            <label for="lbpbs-'.$ld->id_syarat_izin_s.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	}       	     	

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $ld->kd_syarat_izin_s;
	            $row[] = $ld->teks_judul;
	            $row[] = $ld->jenis_input;
	            $row[] = $html_stat;
				$row[] = '&nbsp;<button 
								type="button" data-id="'.$ld->id_syarat_izin_s.'" data-action="edit-child" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
						  		title="Ubah"> <i class="fa fa-pencil"></i> 
						</button>';

	            $data[] = $row;
	        }

	        $output = array(
		            "draw" => $_POST['draw'],
		            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
		            "recordsTotal" => $this->M_admin->count_all($table, $condition),
		            "data" => $data,
	            );
		}

        echo json_encode($output);			
	}	

	function ki_rekam_berkas() {
		$d['page']      	= 'ki_rekam_berkas';
        $d['menu']      	= 'Konfigurasi Rekam Berkas';
        $d['title']      	= 'Konfigurasi Rekam Berkas';
		$d['list_menu'] 	= $this->list_menuizin();

		$d['sl_jenis_input']= $this->list_static_select($this->opt_jenis_input);
        $d['sl_tipe_data'] 	= $this->list_static_select($this->opt_tipe_data);        

		$this->load->view('layout', $d);
	}

	public function ki_rekam_berkas_action($action) {

		if ($action == "get_jenis_izin") {
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$condition 		= [];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];	
			$dZ 			= $this->M_admin->get_master_spec('m_jenis_izin',  'id_nama_izin, kd_jenis_izin', $condition)->row_array();		

			$condition 		= [];
			$condition[] 	= ['id_nama_izin', $dZ['id_nama_izin'], 'where'];	
			$nZ 			= $this->M_admin->get_master_spec('m_nama_izin',  'nama_izin, akronim', $condition)->row_array();

			$jenis_izin 	= $this->get_jenis_izin($dZ['kd_jenis_izin']);

			$response 		= [
								'jenis_izin' => $nZ['akronim'].' '.$jenis_izin, 
								'nama_izin' => $nZ['nama_izin']
							];
		} elseif ($action == 'get_dt_group') {
			$id_jenis_izin 	= $this->input->post('jenis_izin');
			$condition 		= [];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];
			$datag 			= $this->M_admin->get_master_spec('m_rekam_berkas_grup', 'id_rekam_berkas_grup, kd_rekam_berkas_grup, teks_judul, teks_subjudul', $condition)->result_array();
			$grup_perusahaan= '';
			$no 			= 1;
			foreach ($datag as $dg) {
				$dp['datag']['teks_judul'] 	= $dg['teks_judul'];
				$dp['datag']['hc'] 			= $dg['kd_rekam_berkas_grup'];
				$dp['datag']['id'] 			= $dg['id_rekam_berkas_grup'];
				$dp['datag']['no'] 			= $no;
				$dp['page']		 			= 'accord';
				$grup_perusahaan	.= $this->load->view('ki_rekam_berkas_grup', $dp, TRUE);
				$no++;
			}

			$response 	= ['datag' => $grup_perusahaan];			
		} elseif ($action == 'get_dt_child') {
			$dp['page']		 	= 'dt_child';

			$response			= $this->load->view('ki_rekam_berkas_grup', $dp, TRUE);
		} elseif ($action == 'add') {
			$rekam_berkas_grup 	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$id_jenis_izin 	= $this->input->post('id_jenis_izin');
			$teks_judul 	= $this->input->post('teks_judul');
			$teks_subjudul 	= $this->input->post('teks_subjudul');
			$show_first 	= $this->input->post('show_first');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'rekam_berkas_grup' => $rekam_berkas_grup,
								'id_jenis_izin' 	=> $id_jenis_izin,
								'teks_judul' 	=> $teks_judul,
								'teks_subjudul' => $teks_subjudul,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$this->M_admin->insert_data('m_rekam_berkas_grup', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == 'edit') {
			$id_rekam_berkas_grup	= $this->input->post('id_rekam_berkas_grup');
			$teks_judul		= $this->input->post('teks_judul');
			$teks_subjudul 	= $this->input->post('teks_subjudul');
			$show_first 	= $this->input->post('show_first');
			$aktif 			= $this->input->post('aktif');

			$data 			= [ 
								'teks_judul' 	=> $teks_judul,
								'teks_subjudul'	=> $teks_subjudul,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_rekam_berkas_grup';
			$condition[1] 	= $id_rekam_berkas_grup;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_rekam_berkas_grup', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_rekam_berkas_grup = $this->input->post('id_rekam_berkas_grup');

			$condition 		= [];
			$condition[] 	= ['id_rekam_berkas_grup', $id_rekam_berkas_grup, 'where'];
			
			$select 		= '
								id_rekam_berkas_grup,
								teks_judul,
								teks_subjudul,
								show_first,
								aktif
					 		';
			$response 		= $this->M_admin->get_master_spec('m_rekam_berkas_grup', $select, $condition)->row_array();

	        $response['ck_show_first'] = $response['show_first'] == 1 ? true : false;
	        $response['ck_aktif']  		= $response['aktif'] == 1 ? true : false;
		} elseif ($action == "add-child") {
			$id_rekam_berkas_grup = $this->input->post('id_group');

			$nama_rekam_berkas		 	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$kode_formula	 	= $this->input->post('kode_formula');

			$teks_judul	 		= $this->input->post('teks_judul');
			$sub_teks_judul	 	= $this->input->post('sub_teks_judul');

			$jenis_input	 	= $this->input->post('jenis_input');
			$teks_judul_tbl	 	= $this->input->post('teks_judul_tbl');
			$teks_judul_select	= $this->input->post('teks_judul_select');
			$tipe_data	 		= $this->input->post('tipe_data');

			$table_tujuan_s	 	= $this->input->post('table_tujuan_s');
			$pk_tujuan_s	 	= $this->input->post('pk_tujuan_s');
			$table_tujuan_p	 	= $this->input->post('table_tujuan_p');
			$pk_tujuan_p	 	= $this->input->post('pk_tujuan_p');

			$attribute	 		= $this->input->post('attribute');
			$table_refrensi	 	= $this->input->post('table_refrensi');
			$pk_refrensi	 	= $this->input->post('pk_refrensi');
			$nm_refrensi	 	= $this->input->post('nm_refrensi');

			$keterangan	 		= $this->input->post('keterangan');

			$wajib_isi	 		= $this->input->post('wajib_isi');
			$multivalue	 		= $this->input->post('multivalue');
			$special	 		= $this->input->post('special');
			$show_first	 		= $this->input->post('show_first');
			$show_select	 	= $this->input->post('show_select');
			$show_tbl_be	 	= $this->input->post('show_tbl_be');
			$show_tbl_fe	 	= $this->input->post('show_tbl_fe');
			$show_pg_be	 		= $this->input->post('show_pg_be');
			$show_pg_fe	 		= $this->input->post('show_pg_fe');
			$aktif	 			= $this->input->post('aktif');

			if ($jenis_input == "tbl" || $jenis_input == "select") {
				$tipe_data 	= null;
			}

			// input _s
			$data 			= [ 
								'id_rekam_berkas_grup' => $id_rekam_berkas_grup,
								'nama_rekam_berkas' 		=> $nama_rekam_berkas,
								'kode_formula' 	=> $nama_rekam_berkas.'1',
								'teks_judul' 	=> $teks_judul,
								'sub_teks_judul'=> $sub_teks_judul,
								'jenis_input' 	=> $jenis_input,
								'tipe_data' 	=> $tipe_data,
								'table_tujuan_s'=> $table_tujuan_s,
								'pk_tujuan_s' 	=> $pk_tujuan_s,
								'table_tujuan_p'=> $table_tujuan_p,
								'pk_tujuan_p' 	=> $pk_tujuan_p,
								'attribute' 	=> $attribute,
								'table_refrensi'=> $table_refrensi,
								'pk_refrensi' 	=> $pk_refrensi,
								'nm_refrensi' 	=> $nm_refrensi,
								'keterangan' 	=> $keterangan,
								'wajib_isi' 	=> $wajib_isi == null ? 0 : $wajib_isi,
								'multivalue' 	=> $multivalue == null ? 0 : $multivalue,
								'special' 		=> $special == null ? 0 : $special,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_select' 	=> $show_select == null ? 0 : $show_select,
								'show_tbl_be' 	=> $show_tbl_be == null ? 0 : $show_tbl_be,
								'show_tbl_fe' 	=> $show_tbl_fe == null ? 0 : $show_tbl_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];
			// insert and get id
			$id_rekam_berkas_s 	= $this->M_admin->insert_data('m_rekam_berkas_s', $data);

			// input _p
			if ($jenis_input == "tbl") {
				$data 	= [];
				for ($a=0;$a<count($teks_judul_tbl);$a++) {
					$data[] 	= [
								'id_rekam_berkas_s' => $id_rekam_berkas_s,
								'nama_rekam_berkas_p' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis')),
								'kode_formula' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis').'1'), //belum
								'teks_judul' 	=> $teks_judul_tbl[$a],
								'keterangan'	=> '', //belum
								'jenis_input'	=> 'text', //belum
								'tipe_data'		=> 'string', //belum
								'wajib_isi' 	=> 0, //belum
								'aktif' 		=> 1 //belum
							];
				}

				$this->M_admin->insert_data_batch('m_rekam_berkas_p', $data);
			} elseif ($jenis_input == "select") {
				$data 	= [];
				for ($a=0;$a<count($teks_judul_select);$a++) {
					$data[] 	= [
								'id_rekam_berkas_s' => $id_rekam_berkas_s,
								'nama_rekam_berkas_p' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis')),
								'kode_formula' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis').'1'), //belum
								'teks_judul' 	=> $teks_judul_select[$a],
								'keterangan'	=> '', //belum
								'jenis_input'	=> 'text', //belum
								'tipe_data'		=> 'string', //belum
								'wajib_isi' 	=> 0, //belum
								'aktif' 		=> 1 //belum
							];
				}

				$this->M_admin->insert_data_batch('m_rekam_berkas_p', $data);
			}
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail-child") {
			$id_rekam_berkas_s = $this->input->post('id_rekam_berkas_s');

			$condition 		= [];
			$condition[] 	= ['id_rekam_berkas_s', $id_rekam_berkas_s, 'where'];
			
			$select 		= '
								id_rekam_berkas_s,
								id_rekam_berkas_grup,
								nama_rekam_berkas,
								kode_formula,
								teks_judul,
								sub_teks_judul,
								jenis_input,
								tipe_data,
								table_tujuan_s,
								pk_tujuan_s,
								table_tujuan_p,
								pk_tujuan_p,
								attribute,
								table_refrensi,
								pk_refrensi,
								nm_refrensi,
								keterangan,
								wajib_isi,
								multivalue,
								special,
								show_first,
								show_select,
								show_tbl_be,
								show_tbl_fe,
								show_pg_be,
								show_pg_fe,
								aktif
					 		';
			$response 		= $this->M_admin->get_master_spec('m_rekam_berkas_s', $select, $condition)->row_array();

			$condition 		= [];
			$condition[] 	= ['id_rekam_berkas_s', $id_rekam_berkas_s, 'where'];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$select 		= '
								id_rekam_berkas_p,
								teks_judul
					 		';
			$data_tbl 		= $this->M_admin->get_master_spec('m_rekam_berkas_p', $select, $condition)->result_array();			
			$response['jl_teks_judul_tbl'] 		= count($data_tbl);
			$opt_tbl 		= $this->list_tags_select($data_tbl, 'teks_judul', 'id_rekam_berkas_p');
			$response['sl_teks_judul_tbl'] 		= $opt_tbl['option'];
			$response['lbl_teks_judul_tbl'] 	= $opt_tbl['label'];

			// set temp session, last value
			$this->session->set_userdata('last_valtbl', $data_tbl);

			$condition 		= [];
			$condition[] 	= ['id_rekam_berkas_s', $id_rekam_berkas_s, 'where'];
			$condition[] 	= ['aktif !=', 3, 'where'];
			$select 		= '
								id_rekam_berkas_p,
								teks_judul
					 		';
			$data_select 	= $this->M_admin->get_master_spec('m_rekam_berkas_p', $select, $condition)->result_array();						
			$response['jl_teks_judul_select'] 	= count($data_select);
			$opt_select		= $this->list_tags_select($data_select, 'teks_judul', 'id_rekam_berkas_p');
			$response['sl_teks_judul_select'] 	= $opt_select['option'];
			$response['lbl_teks_judul_select'] 	= $opt_select['label'];

			// set temp session, last value
			$this->session->set_userdata('last_valselect', $data_select);

			$response['sl_jenis_input'] = $this->list_static_select($this->opt_jenis_input, $response['jenis_input']);
	        $response['sl_tipe_data']   = $this->list_static_select($this->opt_tipe_data, $response['tipe_data']);	

	        $response['ck_wajib_isi'] 	= $response['wajib_isi'] == 1 ? true : false;
	        $response['ck_multivalue'] 	= $response['multivalue'] == 1 ? true : false;
	        $response['ck_special'] 	= $response['special'] == 1 ? true : false;
	        $response['ck_show_first'] 	= $response['show_first'] == 1 ? true : false;
	        $response['ck_show_select'] = $response['show_select'] == 1 ? true : false;
	        $response['ck_show_tbl_be'] = $response['show_tbl_be'] == 1 ? true : false;
	        $response['ck_show_tbl_fe'] = $response['show_tbl_fe'] == 1 ? true : false;
	        $response['ck_show_pg_be'] 	= $response['show_pg_be'] == 1 ? true : false;
	        $response['ck_show_pg_fe'] 	= $response['show_pg_fe'] == 1 ? true : false;
	        $response['ck_aktif'] 		= $response['aktif'] == 1 ? true : false;
		} elseif ($action == 'edit-child') {
			$id_rekam_berkas_s 	= $this->input->post('id_rekam_berkas_s');
			$id_rekam_berkas_grup = $this->input->post('id_group');

			$nama_rekam_berkas		 	= hash('crc32', $this->input->post('teks_judul').date('YmdHis'));
			$kode_formula	 	= $this->input->post('kode_formula');

			$teks_judul	 		= $this->input->post('teks_judul');
			$sub_teks_judul	 	= $this->input->post('sub_teks_judul');

			$jenis_input	 	= $this->input->post('jenis_input');
			$tipe_data	 		= $this->input->post('tipe_data');
			$teks_judul_tbl	 	= $this->input->post('teks_judul_tbl');
			$teks_judul_select	= $this->input->post('teks_judul_select');

			$table_tujuan_s	 	= $this->input->post('table_tujuan_s');
			$pk_tujuan_s	 	= $this->input->post('pk_tujuan_s');
			$table_tujuan_p	 	= $this->input->post('table_tujuan_p');
			$pk_tujuan_p	 	= $this->input->post('pk_tujuan_p');

			$attribute	 		= $this->input->post('attribute');
			$table_refrensi	 	= $this->input->post('table_refrensi');
			$pk_refrensi	 	= $this->input->post('pk_refrensi');
			$nm_refrensi	 	= $this->input->post('nm_refrensi');

			$keterangan	 		= $this->input->post('keterangan');

			$wajib_isi	 		= $this->input->post('wajib_isi');
			$multivalue	 		= $this->input->post('multivalue');
			$special	 		= $this->input->post('special');
			$show_first	 		= $this->input->post('show_first');
			$show_select	 	= $this->input->post('show_select');
			$show_tbl_be	 	= $this->input->post('show_tbl_be');
			$show_tbl_fe	 	= $this->input->post('show_tbl_fe');
			$show_pg_be	 		= $this->input->post('show_pg_be');
			$show_pg_fe	 		= $this->input->post('show_pg_fe');
			$aktif	 			= $this->input->post('aktif');

			if ($jenis_input == "tbl" || $jenis_input == "select") {
				$tipe_data 	= null;
			}

			// input _s
			$data 			= [ 
								'id_rekam_berkas_grup' => $id_rekam_berkas_grup,
								'nama_rekam_berkas' 		=> $nama_rekam_berkas,
								'kode_formula' 	=> $nama_rekam_berkas.'1',
								'teks_judul' 	=> $teks_judul,
								'sub_teks_judul'=> $sub_teks_judul,
								'jenis_input' 	=> $jenis_input,
								'tipe_data' 	=> $tipe_data,
								'table_tujuan_s'=> $table_tujuan_s,
								'pk_tujuan_s' 	=> $pk_tujuan_s,
								'table_tujuan_p'=> $table_tujuan_p,
								'pk_tujuan_p' 	=> $pk_tujuan_p,
								'attribute' 	=> $attribute,
								'table_refrensi'=> $table_refrensi,
								'pk_refrensi' 	=> $pk_refrensi,
								'nm_refrensi' 	=> $nm_refrensi,
								'keterangan' 	=> $keterangan,
								'wajib_isi' 	=> $wajib_isi == null ? 0 : $wajib_isi,
								'multivalue' 	=> $multivalue == null ? 0 : $multivalue,
								'special' 		=> $special == null ? 0 : $special,
								'show_first' 	=> $show_first == null ? 0 : $show_first,
								'show_select' 	=> $show_select == null ? 0 : $show_select,
								'show_tbl_be' 	=> $show_tbl_be == null ? 0 : $show_tbl_be,
								'show_tbl_fe' 	=> $show_tbl_fe == null ? 0 : $show_tbl_fe,
								'show_pg_be' 	=> $show_pg_be == null ? 0 : $show_pg_be,
								'show_pg_fe' 	=> $show_pg_fe == null ? 0 : $show_pg_fe,
								'aktif' 		=> $aktif == null ? 0 : $aktif
							];

			$condition 		= [];
			$condition[0] 	= 'id_rekam_berkas_s';
			$condition[1] 	= $id_rekam_berkas_s;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_rekam_berkas_s', $condition, $data);

			if ($jenis_input == "tbl") {
				$last_valtbl 	= $this->session->userdata('last_valtbl');

				$last_tblid 	= [];
				foreach ($last_valtbl as $lv) {
					$last_tblid[] 	= $lv['id_rekam_berkas_p'];
				}

				for ($a=0;$a<count($last_tblid);$a++) {
					if (!in_array($last_tblid[$a], $teks_judul_tbl)) {
						$condition 		= [];
						$condition[0] 	= 'id_rekam_berkas_p';
						$condition[1] 	= $last_tblid[$a];
						$condition[2] 	= 'where';
						$this->M_admin->update_data('m_rekam_berkas_p', $condition, ['aktif' => 3]);
					}
				}
				
				for ($a=0;$a<count($teks_judul_tbl);$a++) {
					if (!in_array($teks_judul_tbl[$a], $last_tblid)) {
						$data 	= [];
						$data 	= [
									'id_rekam_berkas_s' => $id_rekam_berkas_s,
									'nama_rekam_berkas_p' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis')),
									'kode_formula' 	=> hash('crc32', $teks_judul_tbl[$a].date('YmdHis').'1'), //belum
									'teks_judul' 	=> $teks_judul_tbl[$a],
									'keterangan'	=> '', //belum
									'jenis_input'	=> 'text', //belum
									'tipe_data'		=> 'string', //belum
									'wajib_isi' 	=> 0, //belum
									'aktif' 		=> 1 //belum
								];
					$this->M_admin->insert_data('m_rekam_berkas_p', $data);
					}
				}

			} elseif ($jenis_input == "select") {
				$last_valselect	= $this->session->userdata('last_valselect');

				$last_selectid 	= [];
				foreach ($last_valselect as $lv) {
					$last_selectid[] 	= $lv['id_rekam_berkas_p'];
				}

				for ($a=0;$a<count($last_selectid);$a++) {
					if (!in_array($last_selectid[$a], $teks_judul_select)) {
						$condition 		= [];
						$condition[0] 	= 'id_rekam_berkas_p';
						$condition[1] 	= $last_selectid[$a];
						$condition[2] 	= 'where';
						$this->M_admin->update_data('m_rekam_berkas_p', $condition, ['aktif' => 3]);
					}
				}

				for ($a=0;$a<count($teks_judul_select);$a++) {
					if (!in_array($teks_judul_select[$a], $last_selectid)) {
						$data 	= [];
						$data 	= [
									'id_rekam_berkas_s' => $id_rekam_berkas_s,
									'nama_rekam_berkas_p' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis')),
									'kode_formula' 	=> hash('crc32', $teks_judul_select[$a].date('YmdHis').'1'), //belum
									'teks_judul' 	=> $teks_judul_select[$a],
									'keterangan'	=> '', //belum
									'jenis_input'	=> 'text', //belum
									'tipe_data'		=> 'string', //belum
									'wajib_isi' 	=> 0, //belum
									'aktif' 		=> 1 //belum
								];
					$this->M_admin->insert_data('m_rekam_berkas_p', $data);
					}
				}
			}			
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == 'aktif_ch') {
			$id_rekam_berkas_s	= $this->input->post('rekam_berkas_s');
			$status 				= $this->input->post('status');

			$data 			= [ 
								'aktif' => $status
							];

			$condition 		= [];
			$condition[0] 	= 'id_rekam_berkas_s';
			$condition[1] 	= $id_rekam_berkas_s;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_rekam_berkas_s', $condition, $data);
			
			$response 	= ['status' => $status];
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	public function show_ki_rekam_berkas_grup($table) {
		$output = array();
		if ($table == 'table1') {
			$table          = 'm_rekam_berkas_s';

			$id_rekam_berkas_grup	= $this->input->post('id_group');
			$condition 		= [];
			$condition[] 	= ['id_rekam_berkas_grup', $id_rekam_berkas_grup, 'where'];	
			$condition[] 	= ['aktif !=', 3, 'where'];	
			
	        $column_order   = array(null, 'kd_rekam_berkas_s', 'teks_judul', 'jenis_input', null, null); 
	        $column_search  = array('kd_rekam_berkas_s', 'teks_judul', 'jenis_input'); 
	        $order          = array('kd_rekam_berkas_s' => 'asc');

	        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
	        $data           = array();
	        $no             = $_POST['start'];
	        foreach ($list_data as $ld) {
	        	if ($ld->aktif == 1) {
	        		$html_stat 	= '<input class="action" data-action="aktif_ch" data-id="'.$ld->id_rekam_berkas_s.'" type="checkbox" id="lbpbs-'.$ld->id_rekam_berkas_s.'" checked switch="none" >
	                                            <label for="lbpbs-'.$ld->id_rekam_berkas_s.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	} else {
	        		$html_stat 	= '<input class="action" data-action="aktif_ch" data-id="'.$ld->id_rekam_berkas_s.'" type="checkbox" id="lbpbs-'.$ld->id_rekam_berkas_s.'" switch="none" >
	                                            <label for="lbpbs-'.$ld->id_rekam_berkas_s.'" data-on-label="On"
	                                                   data-off-label="Off"></label>';
	        	}       	     	

	            $no++;
	            $row = array();
	            $row[] = $no;
	            $row[] = $ld->kd_rekam_berkas_s;
	            $row[] = $ld->teks_judul;
	            $row[] = $ld->jenis_input;
	            $row[] = $html_stat;
				$row[] = '&nbsp;<button 
								type="button" data-id="'.$ld->id_rekam_berkas_s.'" data-action="edit-child" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
						  		title="Ubah"> <i class="fa fa-pencil"></i> 
						</button>';

	            $data[] = $row;
	        }

	        $output = array(
		            "draw" => $_POST['draw'],
		            "recordsFiltered" => $this->M_admin->count_filtered($table, $column_order, $column_search, $order, $condition),
		            "recordsTotal" => $this->M_admin->count_all($table, $condition),
		            "data" => $data,
	            );
		}

        echo json_encode($output);			
	}	

	function user_bo() {
        $d['page']      	= 'user_bo';
        $d['menu']      	= 'Pengolahan User';
        $d['title']			= 'Pengolahan User Back Office';

        $Lcondition			= [];
        $Lcondition[]		= ['aktif', 1, 'where'];
        $Lcondition[]		= ['id_role !=', 1, 'where'];
        $Lcondition[]		= ['id_role !=', 2, 'where'];
        $value				= 'id_role';
        $name 				= 'nm_role';
        $d['ListRole']     	= $this->list_bootstrap_select('m_role', $value, $name, $Lcondition);

        $Lcondition			= [];
        $Lcondition[]		= ['aktif', 1, 'where'];
        $Lcondition[]		= ['id_unitkerja !=', 1, 'where'];
        $Lcondition[]		= ['id_unitkerja !=', 2, 'where'];
        $value				= 'id_unitkerja';
        $name 				= 'nm_unitkerja';
        $d['ListKelompok'] = $this->list_bootstrap_select('m_unitkerja', $value, $name, $Lcondition);

		$Lcondition			= [];
        $Lcondition[]		= ['aktif', 1, 'where'];
		$Lcondition[] 		= ['id_kabupaten', '26065', 'where'];
        $value				= 'id_kecamatan';
        $name 				= 'nama_kecamatan';
        $d['ListCluster'] = $this->list_bootstrap_select('m_kecamatan', $value, $name, $Lcondition);

		$Lcondition			= [];
        $Lcondition[]		= ['aktif', 1, 'where'];
        $value				= 'id_target';
        $name 				= 'nm_target';
        $d['ListKelas'] = $this->list_bootstrap_select('m_target', $value, $name, $Lcondition);
       
		$this->load->view('layout', $d);
	}

	function show_userbo(){
		$table = 'm_user';

		$condition = [];
		$condition[] = ['id_role !=', 1, 'where'];
		$condition[] = ['id_role !=', 2, 'where'];
		$condition[] = ['aktif', 1, 'where'];
		$condition[] = ['aktif !=', 0, 'where'];

		$column_order   = array(null, 'nm_user', 'no_wa', 'url_website', null); 
        $column_search  = array('nm_user', 'no_wa', 'url_website'); 
        $order          = array('nm_user' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = array();
        $no             = $_POST['start'];

         foreach ($list_data as $ld) {
            $no++;
            $row = array();
            $row[] = '<div class="text-center"><img style="width: 40%;" src="'.$ld->img.'"></div>';
            $row[] = $ld->nm_user;
            $row[] = $ld->no_wa;
            $row[] = $ld->url_website;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_user.'" data-img="'.$ld->img.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
					  		title="Ubah"> <i class="fa fa-pencil"></i> Ubah
					</button><br><button 
					type="button" data-id="'.$ld->id_user.'" data-nama="'.$ld->nm_user.'" data-action="del" class="m-t-5 action btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered"
					  title="Hapus"> <i class="fa fa-trash"></i> Hapus
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

	function userbo_action($action){
		if ($action == "aktif") {
			$id_user 	= $this->input->post('id_user');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_user';
			$condition[1] 	= $id_user;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_user', $condition, $data);

			$condition 		= [];
			$condition[0] 	= 'id_jabatan';
			$condition[1] 	= $id_user;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_personil', $condition, $data);

			$response 	= ['status' => $status];
		}
		elseif ($action == "add") {
			$id_user	= $this->input->post('id_user');
			$id_personil	= $this->input->post('id_personil');
			$nm_user	= $this->input->post('nm_user');
			$no_wa	= $this->input->post('no_wa');
			$email	= $this->input->post('email');
			$id_role	= $this->input->post('id_role');
			$id_kelas	= $this->input->post('id_kelas');
			$id_kecamatan	= $this->input->post('id_kecamatan');
			$id_kelompok	= $this->input->post('id_kelompok');
			$url_website	= $this->input->post('url_website');
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');


			$data_personil 	 = [ 
				'id_target' 	=> $id_kelas,
				'kd_wilayah' 	=> $id_kecamatan,
				'id_unitkerja'	=> $id_kelompok,
				'id_jabatan'	=> $id_kelompok,
				'nm_personil' 	=> $nm_user,
				'aktif'			=> 1

			];

			$id_personil = $this->M_admin->insert_data('m_personil', $data_personil);

			$data1 			 = [ 
								'nm_user' 		=> $nm_user,
								'id_role' 		=> $id_role,
								'username'		=> $username,
								'sandi_user'	=> $this->encrypt->encode($password),
								'aktif'			=> 1, 
								'id_personil'   => $id_personil,
								'no_wa' 	=> $no_wa,
								'email' 	=> $email,
								'url_website' => $url_website,

							];

			$this->M_admin->insert_data('m_user', $data1);
			
			$response 	= ['status' => "OK!"];
		}
		elseif($action == "del"){
			$id_user = $this->input->post('data');
			$data = [
						'aktif' => 0
					];
			$condition = [];
			$condition[0] = 'id_user';
			$condition[1] = $id_user; 
			$condition[2] = 'where';
			$this->M_admin->update_data('m_user', $condition, $data);

			$response = ['status' => 'TERHAPUS'];
		}

		elseif ($action == "edit") {

			$id_user	= $this->input->post('id_user');
			$id_personil	= $this->input->post('id_personil');
			$nm_user	= $this->input->post('nm_user');
			$no_wa	= $this->input->post('no_wa');
			$email	= $this->input->post('email');
			$id_role	= $this->input->post('id_role');
			$id_kelas	= $this->input->post('id_kelas');
			$id_kecamatan	= $this->input->post('id_kecamatan');
			$id_kelompok	= $this->input->post('id_kelompok');
			$url_website	= $this->input->post('url_website');
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');


			$data_user 		= [ 
								
								'nm_user' 	=> $nm_user,
								'no_wa' 	=> $no_wa,
								'email' 	=> $email,
								'url_website' => $url_website,
								'id_role' 	=> $id_role,
							];

			$data_personil 	 = [ 
								'id_target' 	=> $id_kelas,
								'kd_wilayah' 	=> $id_kecamatan,
								'id_unitkerja'	=> $id_kelompok,

							];

			$condition 		= [];
			$condition[0] 	= 'id_user';
			$condition[1] 	= $id_user;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_user', $condition, $data_user);

			$condition 		= [];
			$condition[0] 	= 'id_personil';
			$condition[1] 	= $id_personil;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_personil', $condition, $data_personil);
			
			$response 	= ['status' => "OK!"];
		}
		elseif ($action == "detail") {
			$id_user = $this->input->post('id_user');
			$id_personil = $this->input->post('id_personil');

			$condition 		= [];
			$condition[] 	= ['id_user', $id_user, 'where'];
			
			$response 		= $this->M_admin->get_master_spec('v_user', '*' , $condition)->row_array();
			$response['sandi_user'] = $this->encrypt->decode($response['sandi_user']);

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_role !=', 1, 'where'];
			$Lcondition[] 	= ['id_role !=', 2, 'where'];
			$Lcondition[] 	= ['id_role !=', $response['id_role'], 'where'];
			$value 			= 'id_role';
			$name 			= 'nm_role';

	        $response['sl_role'] = $this->list_bootstrap_select('m_role', $value, $name, $Lcondition, $response['id_role']);

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_target !=', $response['id_target'], 'where'];
			$value 			= 'id_target';
			$name 			= 'nm_target';

	        $response['sl_target'] = $this->list_bootstrap_select('m_target', $value, $name, $Lcondition, $response['id_target']);

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_kabupaten', '26065', 'where'];
			$Lcondition[] 	= ['id_kecamatan !=', $response['id_kecamatan'], 'where'];
			$value 			= 'id_kecamatan';
			$name 			= 'nama_kecamatan';

	        $response['sl_kecamatan'] = $this->list_bootstrap_select('m_kecamatan', $value, $name, $Lcondition, $response['id_kecamatan']);

			$Lcondition 	= [];
			$Lcondition[] 	= ['aktif', 1, 'where'];
			$Lcondition[] 	= ['id_unitkerja !=', 1, 'where'];
			$Lcondition[] 	= ['id_unitkerja !=', 2, 'where'];
			$Lcondition[] 	= ['id_unitkerja !=', $response['id_unitkerja'], 'where'];
			$value 			= 'id_unitkerja';
			$name 			= 'nm_unitkerja';

	        $response['sl_unitkerja'] = $this->list_bootstrap_select('m_unitkerja', $value, $name, $Lcondition, $response['id_unitkerja']);

	       
	     }

		echo json_encode($response);
	}

	function dm_nilai_koef() {
		$d['page']      	= 'dm_nilai_koef';
        $d['menu']      	= 'Data Master Retribusi';
        $d['title']      	= 'Data Master Retribusi Nilai Koef';

		$this->load->view('layout', $d);
	}

	public function show_dm_nilai_koef() {
		$table          = 'v_nilai_koef';
		
        $column_order   = array(null, 'nama_izin', 'jenis_izin', 'jenis_koef', 'item_koef', 'nilai_koef', 'satuan', null); 
        $column_search  = array('nama_izin', 'jenis_izin', 'jenis_koef', 'item_koef', 'nilai_koef', 'satuan'); 
        $order          = array('id_ret_nilai_koef' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_ret_nilai_koef="'.$ld->id_ret_nilai_koef.'" type="checkbox" id="lbl-'.$ld->id_ret_nilai_koef.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_ret_nilai_koef.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_ret_nilai_koef="'.$ld->id_ret_nilai_koef.'" type="checkbox" id="lbl-'.$ld->id_ret_nilai_koef.'" switch="none" >
                                            <label for="lbl-'.$ld->id_ret_nilai_koef.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}
		
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nama_izin;
            $row[] = $ld->jenis_izin;
            $row[] = $ld->jenis_koef;
            $row[] = $ld->item_koef;
            $row[] = $ld->nilai_koef;
            $row[] = $ld->satuan;
            $row[] = $html_stat;
			// $row[] = '&nbsp;<button 
			// 				type="button" data-id="'.$ld->id_ret_nilai_koef.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
			// 		  		title="Ubah"> <i class="fa fa-pencil"></i> 
			// 		</button>';

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

	public function dm_nilai_koef_action($action) {

		if ($action == "aktif") {
			$id_ret_nilai_koef 	= $this->input->post('id_ret_nilai_koef');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_ret_nilai_koef';
			$condition[1] 	= $id_ret_nilai_koef;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_ret_nilai_koef', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$id_ret_jenis_koef 	= $this->input->post('id_ret_jenis_koef');
			$item_koef 			= $this->input->post('item_koef');
			$nilai_koef 		= $this->input->post('nilai_koef');
			$id_jenis_izin 		= $this->input->post('id_jenis_izin');
			$satuan 			= $this->input->post('satuan');
			$satuan 			= $this->input->post('satuan');

			$data 			= [ 
								'id_ret_jenis_koef' 	=> $id_ret_jenis_koef,
								'item_koef'				=> $item_koef,
								'nilai_koef'			=> $nilai_koef,
								'id_jenis_izin'			=> $id_jenis_izin,
								'satuan'				=> $satuan,
								'satuan' 			=> $satuan
							];

			$this->M_admin->insert_data('m_ret_nilai_koef', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_ret_nilai_koef 	= $this->input->post('id_ret_nilai_koef');
			$id_ret_jenis_koef 	= $this->input->post('id_ret_jenis_koef');
			$item_koef 			= $this->input->post('item_koef');
			$nilai_koef 		= $this->input->post('nilai_koef');
			$id_jenis_izin 		= $this->input->post('id_jenis_izin');
			$satuan 			= $this->input->post('satuan');


			$data 			= [ 
								'id_ret_jenis_koef' 	=> $id_ret_jenis_koef,
								'item_koef'				=> $item_koef,
								'nilai_koef'			=> $nilai_koef,
								'id_jenis_izin'			=> $id_jenis_izin,
								'satuan'				=> $satuan,
								'satuan' 				=> $satuan
							];

			$condition 		= [];
			$condition[0] 	= 'id_ret_nilai_koef';
			$condition[1] 	= $id_ret_nilai_koef;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_ret_nilai_koef', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_ret_nilai_koef= $this->input->post('id_ret_nilai_koef');

			$condition 		= [];
			$condition[] 	= ['id_ret_nilai_koef', $id_ret_nilai_koef, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_ret_nilai_koef', 'id_ret_nilai_koef, id_ret_jenis_koef, item_koef, nilai_koef, id_jenis_izin, satuan' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}	

	function dm_rettarif() {
		$d['page']      	= 'dm_rettarif';
        $d['menu']      	= 'Data Master Retribusi';
        $d['title']      	= 'Data Master Retribusi Jenis Tarif';

		$this->load->view('layout', $d);
	}

	public function show_dm_rettarif() {
		$table          = 'm_ret_jenis_tarif';
		
        $column_order   = array(null, 'item_group', 'item', 'nilai_tarif', 'kode', 'satuan', null); 
        $column_search  = array('item_group', 'item', 'nilai_tarif', 'kode', 'satuan'); 
        $order          = array('id_ret_jenis_tarif' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_ret_jenis_tarif="'.$ld->id_ret_jenis_tarif.'" type="checkbox" id="lbl-'.$ld->id_ret_jenis_tarif.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_ret_jenis_tarif.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_ret_jenis_tarif="'.$ld->id_ret_jenis_tarif.'" type="checkbox" id="lbl-'.$ld->id_ret_jenis_tarif.'" switch="none" >
                                            <label for="lbl-'.$ld->id_ret_jenis_tarif.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->item_group;
            $row[] = $ld->item;
            $row[] = $ld->nilai_tarif;
            $row[] = $ld->kode;
            $row[] = $ld->satuan;
            $row[] = $html_stat;
			$row[] = '&nbsp;<button 
							type="button" data-id="'.$ld->id_ret_jenis_tarif.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
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

	public function dm_rettarif_action($action) {

		if ($action == "aktif") {
			$id_ret_jenis_tarif 	= $this->input->post('id_ret_jenis_tarif');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_ret_jenis_tarif';
			$condition[1] 	= $id_ret_jenis_tarif;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_ret_jenis_tarif', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$item_group 	= $this->input->post('item_group');
			$item = $this->input->post('item');
			$nilai_tarif = $this->input->post('nilai_tarif');
			$kode = $this->input->post('kode');
			$satuan 	= $this->input->post('satuan');

			$data 			= [ 
								'item_group' 	=> $item_group,
								'item'			=> $item,
								'nilai_tarif'	=> $nilai_tarif,
								'kode'			=> $kode,
								'satuan' 		=> $satuan
							];

			$this->M_admin->insert_data('m_ret_jenis_tarif', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_ret_jenis_tarif = $this->input->post('id_ret_jenis_tarif');
			$item_group 		= $this->input->post('item_group');
			$item 				= $this->input->post('item');
			$nilai_tarif 		= $this->input->post('nilai_tarif');
			$kode 				= $this->input->post('kode');
			$satuan 			= $this->input->post('satuan');

			$data 			= [ 
								'item_group' 	=> $item_group,
								'item'			=> $item,
								'nilai_tarif'	=> $nilai_tarif,
								'kode'			=> $kode,
								'satuan' 		=> $satuan
							];

			$condition 		= [];
			$condition[0] 	= 'id_ret_jenis_tarif';
			$condition[1] 	= $id_ret_jenis_tarif;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_ret_jenis_tarif', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_ret_jenis_tarif= $this->input->post('id_ret_jenis_tarif');

			$condition 		= [];
			$condition[] 	= ['id_ret_jenis_tarif', $id_ret_jenis_tarif, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_ret_jenis_tarif', 'id_ret_jenis_tarif, item_group, item, nilai_tarif, kode, satuan' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}

	function dm_tarif() {
		$d['page']      	= 'dm_tarif';
        $d['menu']      	= 'Data Master Retribusi';
        $d['title']      	= 'Data Master Retribusi Nilai Tarif';

		$this->load->view('layout', $d);
	}

	public function show_dm_tarif() {
		$table          = 'v_tarif';
		
        $column_order   = array(null, 'nama_izin', 'jenis_izin', 'tarif', null); 
        $column_search  = array('nama_izin', 'jenis_izin', 'tarif'); 
        $order          = array('id_ret_tarif' => 'asc');

        $list_data   	= $this->M_admin->get_datatables($table, $column_order, $column_search, $order);
        $data           = array();
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
        	$status 	= $ld->aktif;

        	if ($status == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_ret_tarif="'.$ld->id_ret_tarif.'" type="checkbox" id="lbl-'.$ld->id_ret_tarif.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_ret_tarif.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_ret_tarif="'.$ld->id_ret_tarif.'" type="checkbox" id="lbl-'.$ld->id_ret_tarif.'" switch="none" >
                                            <label for="lbl-'.$ld->id_ret_tarif.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ld->nama_izin;
            $row[] = $ld->jenis_izin;
            $row[] = $ld->tarif;
            $row[] = $html_stat;
			// $row[] = '&nbsp;<button 
			// 				type="button" data-id="'.$ld->id_ret_tarif.'" data-action="edit" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered"
			// 		  		title="Ubah"> <i class="fa fa-pencil"></i> 
			// 		</button>';

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

	public function dm_tarif_action($action) {

		if ($action == "aktif") {
			$id_ret_jenis_tarif 	= $this->input->post('id_ret_jenis_tarif');
			$status 	= $this->input->post('status');
			$data 		= [
							'aktif' => $status
						];

			$condition 		= [];
			$condition[0] 	= 'id_ret_jenis_tarif';
			$condition[1] 	= $id_ret_jenis_tarif;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_ret_jenis_tarif', $condition, $data);

			$response 	= ['status' => $status];
		} elseif ($action == "add") {
			$item_group 	= $this->input->post('item_group');
			$item = $this->input->post('item');
			$nilai_tarif = $this->input->post('nilai_tarif');
			$kode = $this->input->post('kode');
			$satuan 	= $this->input->post('satuan');

			$data 			= [ 
								'item_group' 	=> $item_group,
								'item'			=> $item,
								'nilai_tarif'	=> $nilai_tarif,
								'kode'			=> $kode,
								'satuan' 		=> $satuan
							];

			$this->M_admin->insert_data('m_ret_jenis_tarif', $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "edit") {
			$id_ret_jenis_tarif = $this->input->post('id_ret_jenis_tarif');
			$item_group 		= $this->input->post('item_group');
			$item 				= $this->input->post('item');
			$nilai_tarif 		= $this->input->post('nilai_tarif');
			$kode 				= $this->input->post('kode');
			$satuan 			= $this->input->post('satuan');

			$data 			= [ 
								'item_group' 	=> $item_group,
								'item'			=> $item,
								'nilai_tarif'	=> $nilai_tarif,
								'kode'			=> $kode,
								'satuan' 		=> $satuan
							];

			$condition 		= [];
			$condition[0] 	= 'id_ret_jenis_tarif';
			$condition[1] 	= $id_ret_jenis_tarif;
			$condition[2] 	= 'where';
			$this->M_admin->update_data('m_ret_jenis_tarif', $condition, $data);
			
			$response 	= ['status' => "OK!"];
		} elseif ($action == "detail") {
			$id_ret_jenis_tarif= $this->input->post('id_ret_jenis_tarif');

			$condition 		= [];
			$condition[] 	= ['id_ret_jenis_tarif', $id_ret_jenis_tarif, 'where'];
			
			$response 	= $this->M_admin->get_master_spec('m_ret_jenis_tarif', 'id_ret_jenis_tarif, item_group, item, nilai_tarif, kode, satuan' , $condition)->row_array();
		} else {
			$response 	= ['status' => "FAIL!"];
		}

		echo json_encode($response);
	}



	function olah_permohonan() {
		$d['menu']  = 'Pengolahan Permohonan';
        $d['page']  = 'olah_permohonan';
        $d['title']	= 'Pengolahan Permohonan';
        $d['list_menuizin'] = $this->list_menuizin3();
        $d['total'] 		= $this->permohonan_total(0, 'normal');

		$this->load->view('layout', $d);
	}

	function permohonan_show() {
		$table          = 'v_permohonan_izin_all';		

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
			$condition[]  = ['date(tgl_permohonan) >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}

		if($date_end != '') {
			$condition[]  = ['date(tgl_permohonan) <=', date('Y-m-d', strtotime($date_end)), 'where'];
		}

        $column_order   = [null, 'no_permohonan', 'tgl_permohonan', 'nama_pemohon', 'nilai_string', 'nama_izin', 'nm_aktivitas_workflow', 'waktu_in', 'waktu_in', 'aktif']; 
        $column_search  = ['no_permohonan', 'tgl_permohonan', 'nama_pemohon', 'nilai_string', 'nama_izin', 'nm_aktivitas_workflow', 'waktu_in']; 
        $order          = ['aktif' => 'desc', 'tgl_permohonan' => 'asc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];

        foreach ($list_data as $ld) {
        	if ($ld->aktif == 1) {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_permohonan="'.$ld->id_permohonan.'" type="checkbox" id="lbl-'.$ld->id_permohonan.'" checked switch="none" >
                                            <label for="lbl-'.$ld->id_permohonan.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	} else {
        		$html_stat 	= '<input class="action" data-action="aktif" data-id_permohonan="'.$ld->id_permohonan.'" type="checkbox" id="lbl-'.$ld->id_permohonan.'" switch="none" >
                                            <label for="lbl-'.$ld->id_permohonan.'" data-on-label="On"
                                                   data-off-label="Off"></label>';
        	}


            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $ld->no_permohonan;
            $row[] = date('Y-m-d', strtotime($ld->tgl_permohonan));
            $row[] = $ld->nama_pemohon;
            $row[] = $ld->nilai_string;
            $row[] = $this->get_jenis_izin2($ld->id_jenis_izin);
            $row[] = $ld->nm_aktivitas_workflow;
            $row[] = $ld->waktu_in;
            $row[] = $this->get_sla($ld->waktu_in)['label'];
            // $row[] = $this->histori_datetime($ld->id_permohonan)['argo_label'];
            $row[] = $html_stat;

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

	function permohonan_total($type) {
		$table          = 'v_permohonan_izin_all';

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
			$condition[]  = ['date(tgl_permohonan) >=', date('Y-m-d', strtotime($date_start)), 'where'];
		}

		if($date_end != '') {
			$condition[]  = ['date(tgl_permohonan) <=', date('Y-m-d', strtotime($date_end)), 'where'];
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

	function permohonan_aktivasi() {
		$d['id_permohonan'] = $this->input->post('id_permohonan');
		$d['status'] 		= $this->input->post('status');
		
		$condition    = [];
	    $condition[]  = ['id_permohonan', $d['id_permohonan'], 'where'];
		
		// update status	
		$update = $this->M_core->update_tbl('t_permohonan', ['aktif' => $d['status']], $condition);	

		// get data
		$dvpi = $this->M_core->get_tbl('v_permohonan_izin_all', '*', $condition)->row_array();

		// package data
		$data['id_permohonan'] 	= $dvpi['id_permohonan'];
		$data['id_pemohon'] 	= $dvpi['id_pemohon'];
		$data['id_user_fe'] 	= $dvpi['id_user_fe'];
		
		if($d['status'] == 0) {
			$data['param'] = 7;
		} else {
			$data['param'] = 8;
		}
		
		// send response		
		$this->send_response($data);

		echo json_encode($d);
	}

	private function send_response($data) {
		// drm
		$condition 		= [];
		$condition[] 	= ['id_message', $data['param'], 'where'];
		$drm 			= $this->M_permohonan_izin->get_master_spec('m_response_message', '*', $condition)->row_array();

		// reciever1
		$condition 		= [];
		$condition[] 	= ['id_user_fe', $data['id_user_fe'], 'where'];
		$receiver1 		= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'email_user', $condition)->row_array()['email_user'];
		
		// reciever2
		$condition 		= [];
		$condition[] 	= ['id_user_fe', $data['id_user_fe'], 'where'];
		$receiver2 		= $this->M_permohonan_izin->get_master_spec('m_user_fe', 'no_hp', $condition)->row_array()['no_hp'];
		
		// reciever3
		$condition 		= [];
		$condition[] 	= ['id_pemohon', $data['id_pemohon'], 'where'];
		$receiver3 		= $this->M_permohonan_izin->get_master_spec('t_pemohon', 'no_hp', $condition)->row_array()['no_hp'];


		// subject
		$subject 		= $drm['subject'];

		// message
		$query 			= $drm['query'];
		$query 			= preg_replace('/#id_permohonan#/', $data['id_permohonan'], $query); //id_permohonan

		// preg replace
		$message 		= $drm['message'];
		$formula 		= explode(", ", $drm['formula']);
		$data_source 	= $this->M_admin->query($query)->result_array();
		foreach ($data_source as $ds) {
			foreach ($formula as $fr) {
				$message 	= preg_replace('/#'.$fr.'#/', $ds[$fr], $message);
			}
		}

		// package response
		$data_mg1 	= [];
		$data_mg2 	= [];

		$data_mg1['rcv'] = $receiver1;
		$data_mg1['msg'] = $message;
		$data_mg1['sj']  = $subject;

		$data_mg2['rcv'] = $receiver2;
		$data_mg2['msg'] = $message;
		$data_mg2['sj']  = $subject;

		$data_mg3['rcv'] = $receiver3;
		$data_mg3['msg'] = $message;
		$data_mg3['sj']  = $subject;

		// send response
		$this->send_email($data_mg1);
		$this->send_sms($data_mg2);
		$this->send_sms($data_mg3);	
	}

	private function send_email($data) {
		$url = "http://182.253.11.251/production/epermit_api/api/send_email"; 
		$post_data = [ 
		    "rcv"   => $data['rcv'], 
		    "sj"    => $data['sj'], 
		    "msg"   => $data['msg'], 
		    "token" => '59079ec0d587c937c6e2d31e5dd2eb4e'
		];

		$output = $this->curl->simple_post($url, $post_data);
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




	














	//Tools
	private function get_sla($datetime) {
		// sla 7 hari
		$sla = 7;

		$t1 		= strtotime($datetime);
		$t2 		= strtotime(date('Y-m-d H:i:s'));
		$diff 		= $t2 - $t1;
		$diff_hours = $diff / ( 60 * 60 );
		
		$day = $diff_hours / 24;

		// labeling
		if((int)$day > $sla) {
			$label = 'label label-danger';
		} else {
			$label = 'label label-success';
		}

		// if null
		if($datetime == '') {
			$val = '-';
		} else {
			$val = (int)$day;
		}

		$res['label'] = '<span class="'.$label.'">'.$val.' Hari</span>';

		return $res;
	}


	private function get_jenis_izin($kd_jenis_izin) {
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
		return $response;
	}	

	private function get_jenis_izin2($id_jenis_izin) {
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

	private function list_menuizin() {
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


				$body 	.= '<li><a class="prev-default " href="#">'.$ni['akronim'].'</a>
					            <ul>
					            change-'.$ni['kd_nama_izin'].
					            '</ul>
							</li>';
			} else {
				$body 	.= '<li><a class="prev-default " href="#">'.$ni['akronim'].'</a></li>';
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

						$content 	.= '<li><a class="prev-default " href="#">'.$ji['teks_menu'].'</a>
							            <ul>
							            change-'.$ji['kd_jenis_izin'].
							            '</ul>
									</li>';
					} else {
						$content 	.= '<li><a data-kd_izin="'.$ji['kd_jenis_izin'].'" data-izin="'.$ji['id_jenis_izin'].'" class="prev-default get-syarat" href="#">'.$ji['teks_menu'].'</a></li>';
					}
				}
				$body 			= preg_replace('/change-'.$kd_helperjn[$k]['kd'].'/', $content, $body);
				unset($kd_helperjn[$k]);
			}
		}		

		return '<ul class="collapsibleList">'.$body.'</ul>';		
	}

	private function list_menuizin2() {
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


				$body 	.= '<li><a class="prev-default " href="#">'.$ni['akronim'].'</a>
					            <ul>
					            change-'.$ni['kd_nama_izin'].
					            '</ul>
							</li>';
			} else {
				$body 	.= '<li><a class="prev-default " href="#">'.$ni['akronim'].'</a></li>';
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

						$content 	.= '<li><a class="prev-default " href="#">'.$ji['teks_menu'].'</a>&nbsp;
										<button type="button" data-id="'.$ji['id_jenis_izin'].'" data-action="edit-jenis" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered" title="Ubah"> 
											<i class="fa fa-pencil"></i> 
										</button>
							            <ul>
							            change-'.$ji['kd_jenis_izin'].
							            '</ul>
									</li>';
					} else {
						$content 	.= '<li><a data-kd_izin="'.$ji['kd_jenis_izin'].'" data-izin="'.$ji['id_jenis_izin'].'" class="prev-default get-syarat" href="#">'.$ji['teks_menu'].'</a>
										&nbsp;
										<button type="button" data-id="'.$ji['id_jenis_izin'].'" data-action="edit-jenis" class="action btn btn-xs btn-icon waves-effect btn-info m-b-5 tooltip-hover tooltipstered" title="Ubah"> 
											<i class="fa fa-pencil"></i> 
										</button>
										</li>';
					}
				}
				$body 			= preg_replace('/change-'.$kd_helperjn[$k]['kd'].'/', $content, $body);
				unset($kd_helperjn[$k]);
			}
		}		

		return '<ul class="collapsibleList">'.$body.'</ul>';		
	}		

	private function list_menuizin3() {
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

	private function list_static_select($option_arr, $value=null) {
		$option 	= '';
			foreach ($option_arr as $oar) {
				$selected= $oar['value'] == $value ? 'selected' : '';
				$option .= '<option '.$selected.' value="'.$oar['value'].'">'.$oar['name'].'</option>';
			}

		return $option;
	}

	private function list_array_select($array, $value, $name, $id=null) {
		$option 	= '';
		if ($id) {
			foreach ($array as $arr) {
				$selected= $arr[$value] == $id ? 'selected' : '';
				$option .= '<option '.$selected.' value="'.$arr[$value].'">'.$arr[$name].'</option>';
			}
		} else {
			foreach ($array as $arr) {
				$option 	.= '<option value="'.$arr[$value].'">'.$arr[$name].'</option>';
			}
		}

		return $option;
	}	

	private function list_bootstrap_select($table, $value, $name, $Lcondition, $id=null) {
		$list_data 	= $this->M_admin->get_master_spec($table, $value.' ,'.$name, $Lcondition)->result_array();

		$option 	= '';

		if ($id) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];			
			$condition[]= [$value, $id, 'where'];		
			$ld 		= $this->M_admin->get_master_spec($table, $value.' ,'.$name, $condition)->row_array();

			// $option 	.= '<select name="'.$value.'" class="selectpicker" data-style="btn-default" id="'.$value.'">';

			$option 	.= '<option selected value="'.$ld[$value].'">'.$ld[$name].'</option>';
		}

		foreach ($list_data as $ld) {
			$option 	.= '<option value="'.$ld[$value].'">'.$ld[$name].'</option>';
		}

		if ($id) {
			// $option 	.= '</option>';
		}

		return $option;
	}

	private function list_bootstrap_select_2($table, $value, $name, $Lcondition, $id=null) {

		$option 	= '';
		$option 	.= '<option value="0">- Pilih -</option>';
		$list_data 	= $this->M_admin->get_master_spec($table, $value.' ,'.$name, $Lcondition)->result_array();

		

		if ($id) {
			$condition 	= [];
			$condition[]= ['aktif', 1, 'where'];			
			$condition[]= [$value, $id, 'where'];		
			$ld 		= $this->M_admin->get_master_spec($table, $value.' ,'.$name, $condition)->row_array();

			// $option 	.= '<select name="'.$value.'" class="selectpicker" data-style="btn-default" id="'.$value.'">';

			$option 	.= '<option selected value="'.$ld[$value].'">'.$ld[$name].'</option>';
		}

		foreach ($list_data as $ld) {
			$option 	.= '<option value="'.$ld[$value].'">'.$ld[$name].'</option>';
		}

		if ($id) {
			// $option 	.= '</option>';
		}

		return $option;
	}

	private function list_tags_select($array, $name, $id) {
		$data['option'] 	= [];
		$data['label'] 		= [];
		foreach ($array as $ar) {
			$data['option'][]	= [ 'id' => $ar[$id], 'text' => $ar[$name]];
			$data['label'][]	= $ar[$name];
		}
		
		return $data;
	}

	function test_api_pbyr() {
		$condition 		= [];
		$condition[] 	= ['mak_param', 'pembayaran', 'where'];
		
		$response 	= $this->M_admin->get_master_spec('v_permohonan_izin', '*' , $condition)->row_array();		
        $d['option_nopor'] 	= $this->M_admin->get_master_spec('v_permohonan_izin', 'no_permohonan' , $condition)->result_array();		

		$d['data'] 			= $response;
		$d['page']      	= 'page_bayar';
        $d['menu']      	= 'Konfirmasi Pembayaran';
        $d['title']			= 'Konfirmasi Pembayaran';

		$this->load->view('layout', $d);
	}

	function testPDF() {
		$pdf = new TCPDF('P', 'cm', 'A4', 'true');
	  	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	    $pdf->setPrintHeader(false);
	    $pdf->setPrintFooter(false);
	    $pdf->SetHeaderMargin(false);
	    $pdf->SetFooterMargin(false);
	    $pdf->setMargins(1.5, 0.8, 1);
	    $pdf->AddPage();
	    $pdf->SetFont('times', '', '11');  
	    $data_pdf[]    = [];
	    $c_draft   = $this->load->view('sk_izin/zly_ssrd_iptm_new', $data_pdf, TRUE);
	    $pdf->writeHTML($c_draft, true, false, true, false, '');

	    $pdf->AddPage();
	    $pdf->SetFont('times', '', '11'); 
	    $c_draft   = $this->load->view('sk_izin/zly_skrd_iptm_new', $data_pdf, TRUE);
	    $pdf->writeHTML($c_draft, true, false, true, false, '');
	    
	    $pdf->Output("Draft Izin", 'I'); 
	 }

	public function call_data_permohonan() {
		$no_permohonan 	= $this->input->post('no_permohonan');

		$condition 		= [];
		$condition[] 	= ['no_permohonan', $no_permohonan, 'where'];
		
		$response 	= $this->M_admin->get_master_spec('v_permohonan_izin', '*' , $condition)->row_array();

		$id_jenis_izin 	= $response['id_jenis_izin'];
		$condition 		= [];
		$condition[] 	= ['id_jenis_izin', $id_jenis_izin, 'where'];	
		$dZ 			= $this->M_admin->get_master_spec('m_jenis_izin',  'id_nama_izin, kd_jenis_izin', $condition)->row_array();		
		$condition 		= [];
		$condition[] 	= ['id_nama_izin', $dZ['id_nama_izin'], 'where'];	
		$nZ 			= $this->M_admin->get_master_spec('m_nama_izin',  'nama_izin, akronim', $condition)->row_array();

		$jenis_izin 	= $this->get_jenis_izin($dZ['kd_jenis_izin']);

		$response['nama_izin'] 	= $nZ['nama_izin'].' '.$jenis_izin;
		echo json_encode($response);	
	}

	function sendEmail(){
		$d['page']      	= 'sendingEmail';
        $d['menu']      	= 'Sending Email';
        $d['title']			= 'Sending Email';

        $this->load->view('layout', $d);
	}

	function detailDashboard(){
		$d['page']      	= 'detailDashboard';
        $d['menu']      	= 'Detail Dashboard';
        $d['title']			= 'Detail Dashboad';
       // $d['collapse']		= $this->collapse();
        $this->load->view('layout', $d);
	}
	function detailDashboardAction($action){
		
		if ($action == "getAktivitas") {
			$condition 		= [];
			$condition[]	= ['aktif', 1, 'where'];
			$getAktivitas	= $this->M_admin->get_master_spec('m_aktivitas', 'id_aktivitas, nama_aktivitas', $condition)->result_array();
			$viewAktivitas	= '';
			$no 			= 0;
			foreach ($getAktivitas as $ga) {
				$g['dataAktivitas']['id_aktivitas'] 	= $ga['id_aktivitas'];
				$g['dataAktivitas']['nama_aktivitas']	= $ga['nama_aktivitas'];
				$g['dataAktivitas']['no'] 				= $no;
				$g['page']		 						= 'aktivitas';
				$g['getJumlahTotal']					= $this->db->query('select id_permohonan FROM v_show_permohonan where id_aktivitas = '.$ga['id_aktivitas'].' ')->num_rows();
				$viewAktivitas						   .= $this->load->view('detailPermeja', $g, TRUE); 
				$no++;
			}
			$response		= ['dataAktivitas' => $viewAktivitas];
		}elseif ($action == "getDetailPermeja") {
			$dp['page']		 	= 'detailPermeja';
			

			$response			= $this->load->view('detailPermeja', $dp, TRUE);

		}

		else{
			$response		= ['status' => 'FAIL!'];
		}
		echo json_encode($response);

	}

	function showDataDetail(){
		//$id_aktivitas = 4;
		$id_aktivitas 	= $this->input->post('id_aktivitas');
		$getData = $this->db->query('select 
							id_user,
							id_aktivitas,
							nm_user,
							count(id_permohonan) as `jml`

							from v_for_detail_dashboard 

							where id_aktivitas = '.$id_aktivitas.'

							group by id_user, id_aktivitas');
		
		$getDataPermeja = $getData->result_array();
		$cek = $getData->num_rows();

		$data = '';
		if ($cek > 0) {
		$i = 0;
		foreach ($getDataPermeja as $gp) {

			$data .=	'<tr align="center">
	             <td>'.$gp['nm_user'].'</td>
	             <td>'.$gp['jml'].'</td>
				</tr>';
			$i++;
		}

	}else{

		$data .=	'<tr align="center">
             <td colspan="2">Data No Available</td>
			</tr>';
	}

		echo $data;

	}


	function dataDashboard() {
        $d['page']      = 'dataDashboard';

        //on progress
		$d['onProgress'] = $this->db->query('select id_permohonan from v_dashboard where aktif = 1 
				and id_aktivitas in (4, 5, 6, 7, 8, 9, 10, 11, 15, 19, 22, 23, 25, 27, 28, 29, 30, 31, 32, 33, 36, 37)')
		->num_rows();

		//Terhapus
		$d['terhapus'] = $this->db->query('select id_permohonan from v_dashboard
			where aktif != 1 or aktif IS NULL or id_aktivitas = 0 or id_aktivitas is null')->num_rows();

		//di pending
		$d['jml_di_pending'] = $this->db->query('select id_permohonan from v_dashboard
			where id_aktivitas = 20 and aktif = 1')->num_rows();

		//di tolak
		$d['jml_di_tolak'] = $this->db->query('select id_permohonan from v_dashboard
			where id_aktivitas = 38 and (aktif = 1 or aktif = 0)')->num_rows();

		//terbit
		$d['jml_di_terbit']  = $this->db->query('select id_permohonan from v_dashboard where id_aktivitas = 14 and aktif = 1')->num_rows();

		//semua
        $condition 	   	 = [];
		$d['jml_semua']  = $this->M_core->get_tbl('v_dashboard', 'id_permohonan', $condition)->num_rows();


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

