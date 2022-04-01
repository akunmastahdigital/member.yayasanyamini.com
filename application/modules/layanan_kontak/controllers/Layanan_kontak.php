<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layanan_kontak extends MY_Controller {
	function __construct() {
        parent::__construct();
        
	}
	
	function index() {
        show_404();
	}

	function modul_layanan($jenis) {
		if($jenis == 'pengaduan') {
			$d['menu']  = 'Pengaduan';
	        $d['page']  = 'layanan_kontak';
	        $d['title']	= 'Pengaduan';
	        $d['type']  = 'pengaduan';

		} else if($jenis == 'usulan') {
			$d['menu']  = 'Pengaduan';
	        $d['page']  = 'layanan_kontak';
	        $d['title']	= 'Usulan';
	        $d['type']  = 'usulan';

		} else if($jenis == 'pertanyaan') {
			$d['menu']  = 'Pengaduan';
	        $d['page']  = 'layanan_kontak';
	        $d['title']	= 'Pertanyaan';
	        $d['type']  = 'pertanyaan';
		} 

		$this->load->view('layout', $d);
	}

	public function modul_layanan_show($type) {
		// table
		$table          = 'v_layanan_kontak';

		// condition
		$condition 	    = [];
		$condition[]  = ['jenis_layanan', $type, 'where'];

		// datatable
		if($type == 'pengaduan') {
			$column_order   = [null, 'jenis_pengaduan', 'nama', 'no_hp', 'email', 'isi', 'date_added']; 
        	$column_search  = ['jenis_pengaduan', 'nama', 'no_hp', 'email', 'isi', 'date_added']; 
		} else {
			$column_order   = [null, 'nama', 'no_hp', 'email', 'isi', 'date_added']; 
        	$column_search  = ['nama', 'no_hp', 'email', 'isi', 'date_added'];
		}

        $order          = ['date_added' => 'desc'];

        $list_data   	= $this->M_datatables->get_datatables($table, $column_order, $column_search, $order, $condition);
        $data           = [];
        $no             = $_POST['start'];
        foreach ($list_data as $ld) {
            $no++;
            $row = [];
            $row[] = $no;
            
            if($type == 'pengaduan') {
            	$row[] = $ld->jenis_pengaduan;
            }

            $row[] = $ld->nama;
            $row[] = $ld->no_hp;
            $row[] = $ld->email;
            $row[] = $ld->isi;
            $row[] = $ld->date_added;

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


}