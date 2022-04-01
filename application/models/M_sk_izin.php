<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_sk_izin extends CI_Model {

	function get_n_bio($id_perusahaan, $id_perusahaan_bio_s) {
		$cond_ms   = [];
  		$cond_ms[] = ['aktif', 1, 'where'];
  		$cond_ms[] = ['multivalue', 0, 'where'];
  		$cond_ms[] = ['id_perusahaan_bio_s', $id_perusahaan_bio_s, 'where'];
		$mbs  	  = $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_s', '*', $cond_ms)->row_array();	

		if($mbs['jenis_input'] == 'text') {
			$cond_ts   = [];
  			$cond_ts[] = ['aktif', 1, 'where'];
  			$cond_ts[] = ['id_perusahaan_bio_s', $id_perusahaan_bio_s, 'where'];
			$cond_ts[] = ['id_perusahaan', $id_perusahaan, 'where'];
			$cond_ts[] = ['index', 1, 'where'];
			$tbs  	  = $this->M_permohonan_izin->get_master_spec($mbs['table_tujuan_s'], '*', $cond_ts)->row_array();
			$nbio 	  = $tbs['nilai_'.$mbs['tipe_data']];
		
		} else if($mbs['jenis_input'] == 'select') {
				$cond_tp   = [];
  				$cond_tp[] = ['aktif', 1, 'where'];
  				$cond_tp[] = ['id_perusahaan_bio_s', $id_perusahaan_bio_s, 'where'];
  				$cond_tp[] = ['id_perusahaan', $id_perusahaan, 'where'];
				$tbp  	   = $this->M_permohonan_izin->get_master_spec($mbs['table_tujuan_s'], '*', $cond_tp)->row_array();

				$cond_mp   = [];
  				$cond_mp[] = ['aktif', 1, 'where'];
  				$cond_mp[] = ['id_perusahaan_bio_p', $tbp['id_perusahaan_bio_p'], 'where'];
				$mbp  	   = $this->M_permohonan_izin->get_master_spec('m_perusahaan_bio_p', '*', $cond_mp)->row_array();
				$nbio      = $mbp['teks_judul'];
		
		} else {
			$nbio = '';
		}
		
		return $nbio;  		
	}

}