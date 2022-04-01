<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perusahaan extends MY_Controller {
	function __construct() {
        parent::__construct();
        // if (!$this->session->userdata('id_user')) {
        // 	redirect();
        // }
	}

	function perusahaan_detail($permission, $id_perusahaan) {
		$d['page']      	= 'perusahaan_detail';
		$d['menu']      	= 'Detail Perusahaan';
		$d['title']      	= 'Detail Perusahaan';

		//perusahaan bio
		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
		$condition[]  	= ['kd_perusahaan_bio_grup', 'asc', 'order_by'];
		$dPbio['id_perusahaan'] = $id_perusahaan;
		$dPbio['permission']    = $permission; 
		$dPbio['m_grup']        = $this->M_core->get_tbl('m_perusahaan_bio_grup', '*', $condition)->result_array();
		$dPbio['pbio_card']     = $this->load->view('perusahaan_card', $dPbio, true);
		
		//prepare
		$d['pbio_card'] = $dPbio['pbio_card'];

		$this->load->view('layout', $d);
	}

	function perusahaan_submit() {
		$id_perusahaan  = $this->input->post('id_perusahaan');
		$permission  	= $this->input->post('permission');
		$id_user_fe     = $this->session->userdata('id_user_fe');
		
		//package new_id_perusahaan
    	if($id_perusahaan == 0) {
			$dPrsh['id_user_fe'] = $id_user_fe;
			$insertPrsh 		 = $this->M_core->insert_tbl_normal('t_perusahaan', $dPrsh);
			$new_id_perusahaan 	 = $this->db->insert_id();
		} else {
			$new_id_perusahaan 	 = $id_perusahaan;
		}

		//submit perusahaan bio
		$core_pbio		= 'perusahaan_bio';
		$smbt_pbio		= $this->process_all($core_pbio, $new_id_perusahaan);

		$this->session->set_flashdata("tipe-alert", "success");
		$this->session->set_flashdata("teks-alert", "Data perusahaan berhasil disimpan!");
		$this->session->set_flashdata("icon-alert", "fa fa-check-circle");
		// redirect('perusahaan/perusahaan_detail/'.$permission.'/'.$id_perusahaan);
		redirect($this->session->userdata('list_permohonan'));
	}

	// Core
	function process_all($core, $id_perusahaan) {
		$condition 		= [];
		$condition[] 	= ['aktif', 1, 'where'];
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
	     			$this->process_file($core, $id_perusahaan, $msi);
	         	}

	        	/** TEXT/NUMBER/EMAIL/DATE/CURRENCY **/
	         	if(($msi['jenis_input'] == 'text') || ($msi['jenis_input'] == 'number') || 
		            ($msi['jenis_input'] == 'email') || ($msi['jenis_input'] == 'date') || 
		            ($msi['jenis_input'] == 'currency')) {
	     			$this->process_tne($core, $id_perusahaan, $msi);
	         	} 

	         	/** SELECT **/
	         	if(($msi['jenis_input'] == 'select') && ($msi['special'] == null)) {
	     			$this->process_cttn($core, $id_perusahaan, $msi);
	     			$this->process_select($core, $id_perusahaan, $msi);	         		
	         	}

	         	/** SELECT SPECIAL **/
	         	if(($msi['jenis_input'] == 'select') && ($msi['special'] == 1)) {
	     			$this->process_cttn($core, $id_perusahaan, $msi);
	     			$this->process_select_special($core, $id_perusahaan, $msi);	         		
	         	}

	         	/** TBL **/
	         	if($msi['jenis_input'] == 'tbl') {
	     			$this->process_cttn($core, $id_perusahaan, $msi);
	     			$this->process_tbl($core, $id_perusahaan, $msi);
	         	}

	        } 
	        /** END LOOP M_SINGLE **/
		}
		/** END LOOP M_GRUP **/
	}

	private function process_file($core, $id_perusahaan, $msi) {
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
				'allowed_types' => 'doc|docx|pdf|png|jpg|jpeg',
				'max_size' 		=> '6000',
				'file_name' 	=> $_FILES[$msi['nama_'.$core]]['name'],
				'encrypt_name' 	=> TRUE
			];
			$this->upload->initialize($config);

			$dS[$i]['id_perusahaan']		= $id_perusahaan;
			$dS[$i]['id_'.$core.'_s']		= $msi['id_'.$core.'_s'];
			$dS[$i]['catatan']				= $nama_cttn[$i];
			$dS[$i]['index']				= $i+1;

			$condition    = [];
	        $condition[]  = ['aktif', 1, 'where'];
	        $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
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

	private function process_tne($core, $id_perusahaan, $msi) {
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
     		$dSI[$i]['id_perusahaan']		     = $id_perusahaan;
     		$dSI[$i]['id_'.$core.'_s']     		 = $msi['id_'.$core.'_s'];
     		$dSI[$i]['index']	    	         = $i+1;

     		if($msi['tipe_data'] == 'num') {
 				$dSU[$i]['nilai_'.$msi['tipe_data']] = $this->str_clean($this->input->post($msi['nama_'.$core])[$i]);
     		} else {
     			$dSU[$i]['nilai_'.$msi['tipe_data']] = $this->input->post($msi['nama_'.$core])[$i];
     		}
     		$dSU[$i]['catatan'] 				 = $this->input->post($msi['nama_'.$core].'_cttn')[$i];
     		$dSU[$i]['id_perusahaan']		     = $id_perusahaan;
     		$dSU[$i]['id_'.$core.'_s']         	 = $msi['id_'.$core.'_s'];
     		$dSU[$i]['index']	    	         = $i+1;


     		//check t_single
     		$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
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

	private function process_select($core, $id_perusahaan, $msi) {
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
		    $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $msi['id_'.$core.'_s'], 'where'];
		    $condition[]  = ['id_'.$core.'_p', $v1, 'where'];
     		$t_plural  	  = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);

     		if($t_plural->num_rows() == 0) {
     			$dP[$v1]['nilai_'.$mpl['tipe_data']] = 1;
         		$dP[$v1]['id_perusahaan']		    = $id_perusahaan;
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
			$condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
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
					$condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
					$condition[]  = ['id_'.$core.'_p', $v0, 'where'];

         			$upd_dS = $this->M_core->update_tbl($msi['table_tujuan_p'], ['aktif' => 0], $condition);
         		}

     		} else {
     			//do nothing
     		}
 		}
	}

	private function process_select_special($core, $id_perusahaan, $msi) {
		$nama_input_num    = $this->input->post($msi['nama_'.$core].'_num');	
		$nama_input_string = $this->input->post($msi['nama_'.$core].'_string');	

 		$dP = [];
 		$jml_input_num  = count($nama_input_num);
 		for($i=0; $i<$jml_input_num; $i++) {
 			$dP[$i]['nilai_num'] 			  = $nama_input_num[$i];
 			$dP[$i]['nilai_string'] 		  = $nama_input_string[$i];
 			$dP[$i]['id_perusahaan']		  = $id_perusahaan;
 			$dP[$i]['id_'.$core.'_s']     	  = $msi['id_'.$core.'_s'];
 			$dP[$i]['id_'.$core.'_p']     	  = 0;
 			$dP[$i]['index']	    	      = 1;


 			//get t_single
	 		$condition    = [];
		    $condition[]  = ['aktif', 1, 'where'];
		    $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
		    $condition[]  = ['id_'.$core.'_s', $dP[$i]['id_'.$core.'_s'], 'where'];
		    $condition[]  = ['id_'.$core.'_p', $dP[$i]['id_'.$core.'_p'], 'where'];
		    $condition[]  = ['index', $dP[$i]['index'], 'where'];
	 		$t_single  	  = $this->M_core->get_tbl('t_'.$core.'_p', '*', $condition);

 			if($t_single->num_rows() == 0) {
 				$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$i]);
 			
 			} else {
 				$tsi = $t_single->row_array();
 				if($tsi['nilai_num'] != $dP[$i]['nilai_num']) {
 					$condition   = [];
 					$condition[] = ['aktif', 1, 'where'];
 					$condition[] = ['id_perusahaan', $tsi['id_perusahaan'], 'where'];
 					$condition[] = ['id_'.$core.'_s', $tsi['id_'.$core.'_s'], 'where'];
 					$upd_dP = $this->M_core->update_tbl($msi['table_tujuan_p'], ['aktif' => 0], $condition);
 					$ins_dP = $this->M_core->insert_tbl_normal($msi['table_tujuan_p'], $dP[$i]);
 				}

 			}
 		}
	}

	private function process_tbl($core, $id_perusahaan, $msi) {
		//get m_single
 		$condition    = [];
	    $condition[]  = ['aktif', 1, 'where'];
	    $condition[]  = ['jenis_input', 'tbl', 'where'];
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
						$dP[$i2][$idPM]['id_perusahaan']            = $id_perusahaan;
     					$dP[$i2][$idPM]['id_'.$core.'_s']   		= $msi['id_'.$core.'_s'];
         				$dP[$i2][$idPM]['id_'.$core.'_p']   		= $idPM;
         				$dP[$i2][$idPM]['index']   					= $i2+1;
						if($mpl['tipe_data'] == 'num') {
			 				$dP[$i2][$idPM]['nilai_'.$mpl['tipe_data']] = $this->str_clean($this->input->post($mpl['nama_'.$core.'_p'])[$i2]);
			     		} else if($mpl['tipe_data'] == 'date') {
			     			$dP[$i2][$idPM]['nilai_'.$mpl['tipe_data']] = date('Y-m-d', strtotime($this->input->post($mpl['nama_'.$core.'_p'])[$i2]));
			     		} else {
			     			$dP[$i2][$idPM]['nilai_'.$mpl['tipe_data']] = $this->input->post($mpl['nama_'.$core.'_p'])[$i2];			     			
			     		}

						$condition    = [];
					    $condition[]  = ['aktif', 1, 'where'];
					    $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
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

	private function process_cttn($core, $id_perusahaan, $msi) {
		$nama_cttn = $this->input->post($msi['nama_'.$core].'_cttn');
		$jml_cttn  = count($nama_cttn);
		$index = 1;
		for($i=0;$i<$jml_cttn;$i++) {
			$dC[$i]['catatan'] 		    = $this->input->post($msi['nama_'.$core].'_cttn')[$i];
			$dC[$i]['id_perusahaan']	= $id_perusahaan;
			$dC[$i]['id_'.$core.'_s']   = $msi['id_'.$core.'_s'];
			$dC[$i]['index']	    	= 1;

			//check t_single
			$condition    = [];
	        $condition[]  = ['aktif', 1, 'where'];
	        $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
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

	private function str_clean($string) {
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	   return $string;
	}

	public function ctrlApi() {
		$param = $_POST['param'];
		echo json_encode(true);
	}


}