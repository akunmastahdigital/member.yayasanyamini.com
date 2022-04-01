<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chained extends CI_Controller {
	function __construct() {
		parent:: __construct();
		if(!$this->session->userdata('id_user')) {
            redirect('user');
		}	
	}	

	public function pilih_provinsi() {
	    $data['provinsi']=$this->M_chained->ambil_provinsi();
	}

	// dijalankan saat provinsi di klik
	public function pilih_kabupaten($kode){
		$data['kabupaten']=$this->M_chained->ambil_kabupaten($kode);
		$this->load->view('v_drop_down_kabupaten',$data);
	}

	// dijalankan saat kabupaten di klik
	public function pilih_kecamatan($kode){
		$data['kecamatan']=$this->M_chained->ambil_kecamatan($kode);
		$this->load->view('v_drop_down_kecamatan',$data);
	}
	
	// dijalankan saat kecamatan di klik
	public function pilih_kelurahan($kode){
		$data['kelurahan']=$this->M_chained->ambil_kelurahan($kode);
		$this->load->view('v_drop_down_kelurahan',$data);
	}


	// Chained Flexible
	public function getDatach1() {
		$p['tbl_ref1']   = $this->input->post('tbl_ref1'); 
		$p['pk_ref1']    = $this->input->post('pk_ref1'); 
		$p['nm_ref1']    = $this->input->post('nm_ref1'); 
		$p['judul_ref1'] = $this->input->post('judul_ref1'); 
		$p['judul_ref2'] = $this->input->post('judul_ref2'); 
		$p['text_ref1']  = $this->input->post('text_ref1'); 
		$p['text_ref2']  = $this->input->post('text_ref2'); 
		$p['val']  	     = $this->input->post('val'); 

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
        $p['get_dch1'] = $this->M_core->get_tbl($p['tbl_ref1'], '*', $condition);

		echo $this->load->view('v_dch1', $p, true);
	}

	public function getDatach2() {
		$p['tbl_ref1']   = $this->input->post('tbl_ref1'); 
		$p['pk_ref1']    = $this->input->post('pk_ref1'); 
		$p['nm_ref1']    = $this->input->post('nm_ref1');
		$p['judul_ref1'] = $this->input->post('judul_ref1'); 
		$p['judul_ref2'] = $this->input->post('judul_ref2'); 
		$p['text_ref1']  = $this->input->post('text_ref1'); 
		$p['text_ref2']  = $this->input->post('text_ref2'); 
		$p['val']  	     = $this->input->post('val'); 

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = [$p['pk_ref1'], $p['val'], 'where'];
        $p['get_dch2'] = $this->M_core->get_tbl($p['tbl_ref1'], '*', $condition);

		echo $this->load->view('v_dch2', $p, true);
	}

	public function showCh2() {
		$p['pk_ref1']    = $this->input->post('pk_ref1'); 
		$p['tbl_ref2']   = $this->input->post('tbl_ref2'); 
		$p['pk_ref2']    = $this->input->post('pk_ref2'); 
		$p['nm_ref2']    = $this->input->post('nm_ref2'); 
		$p['judul_ref1'] = $this->input->post('judul_ref1'); 
		$p['judul_ref2'] = $this->input->post('judul_ref2'); 
		$p['text_ref1']  = $this->input->post('text_ref1'); 
		$p['text_ref2']  = $this->input->post('text_ref2'); 
		$p['kode'] 	     = $this->input->post('kode'); 

		$condition 	  = [];
		$condition[]  = ['aktif', 1, 'where'];
		$condition[]  = [$p['pk_ref1'], $p['kode'], 'where'];
        $p['get_sch2'] = $this->M_core->get_tbl($p['tbl_ref2'], '*', $condition);

		echo $this->load->view('v_sch2', $p, true);
	}
}
?>
