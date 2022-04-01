<?php $this->load->view('head'); ?>

<body>



	<?php 

	if ($page == 'login') {

		$this->load->view('nav-login');

		$this->load->view('login');

	
	} else {

		$this->load->view('nav');





		if($page == 'dashboard') {

			$this->load->view('dashboard');

		} elseif ($page == 'dataDashboard') {
			
			$this->load->view('dataDashboard');

		} elseif ($page == 'dashboard2') {
			
			$this->load->view('dashboard2');

		} elseif ($page == 'dashboard1') {
			
			$this->load->view('dashboard1');

		} elseif ($page == 'dashboard-staff') {
			
			$this->load->view('dashboard-staff');

		}  elseif ($page == 'detailDashboard') {
			
			$this->load->view('detail_dashboard');

		} else if($page == 'disposisi') {

			$this->load->view('disposisi');

		} else if($page == 'verifikasi') {

			$this->load->view('verifikasi');

		} else if($page == 'evaluasi') {

			$this->load->view('evaluasi'); 

        } else if($page == 'detail') {

			$this->load->view('detail');

		} else if($page == 'input manual') {

			$this->load->view('input_manual');

		} else if($page == 'perhitungan') {

			$this->load->view('perhitungan');



		} else if($page == 'perusahaan_detail') {

			$this->load->view('perusahaan_detail');

		} else if($page == 'rekam_berkas_detail') {

			$this->load->view('rekam_berkas_detail');



		} else if($page == 'sk_izin') {

			$this->load->view('sk_izin');



		} else if($page == 'sk_izin_cetak') {

			$this->load->view('cetak_draft');

		} else if($page == 'sk_izin_pengambilan') {

			$this->load->view('pengambilan_izin');

		}else if($page == 'cetak_iptm') {

			$this->load->view('cetakIptm');

		} else if($page == 'sk_izin_arsip') {

			$this->load->view('arsip_izin');





		} else if($page == 'timeline') {

			$this->load->view('timeline');


		} else if($page == 'sendingEmail'){

			$this->load->view('send_email');
		
		} else if($page == 'layanan_kontak') {

			$this->load->view('layanan_kontak');

			



		} else if($page == 'laporan') {

			$this->load->view('laporan');

		} else if($page == 'laporan_jml') {

			$this->load->view('laporan_jml');

		} else if($page == 'laporan_dcs') {

			$this->load->view('laporan_dcs');

		} elseif ($page == 'laporan_disclaimer') {
		
			$this->load->view('laporan_disclaimer');
		
		} elseif ($page == 'laporan_ret') {
		
			$this->load->view('laporan_ret');
		
		} elseif ($page == 'laporanPerizin') {
		
			$this->load->view('laporan_perizin');
		
		} 


		else if($page == 'md_permohonan_izin') {

			$this->load->view('master_data');

		}else if($page == 'md_progress_zakat') {

			$this->load->view('progress_zakat');

		} else if($page == 'md_proposal') {

			$this->load->view('proposal');

		} else if($page == 'md_program') {

			$this->load->view('program');

		} else if($page == 'md_tools_marketing') {

			$this->load->view('tools_marketing');

		} else if($page == 'md_social_media') {

			$this->load->view('social_media');

		} else if($page == 'tutorial_page') {

			$this->load->view('tutorial');

		}	 
		else if($page == 'change_password') {

			$this->load->view('user/change_password');
		}
		else if($page == 'change_profil') {

			$this->load->view('user/change_profil');
		} else if($page == 'user_bo') {

			$this->load->view('admin/user_bo');



		}else if($page == 'dm_role') {

			$this->load->view('dm_role');

		

		} 
		else if($page == 'atur_akses') {

			$this->load->view('atur_akses');

		

		}else if($page == 'hak_akses') {

			$this->load->view('hak_akses');

		

		}else if ($page == 'dm_kbli_kategori') {

			$this->load->view('dm_kbli_kategori');

		} else if ($page == 'dm_gol_pokok_kbli') {

			$this->load->view('dm_gol_pokok_kbli');

		}else if ($page == 'dm_gol_kbli') {

			$this->load->view('dm_gol_kbli');

		}else if ($page == 'dm_sub_gol_kbli') {

			$this->load->view('dm_sub_gol_kbli');

		}else if ($page == 'dm_kelompok_kbli') {

			$this->load->view('dm_kelompok_kbli');

		}else if ($page == 'dm_rangkuman_kbli') {

			$this->load->view('dm_rangkuman_kbli');

		} 







		

		else if($page == 'draft_sk') {

			$this->load->view('draft_sk');

		

		} else if($page == 'user_fe') {

			$this->load->view('user_fe');



		} else if($page == 'dm_izin') {

			$this->load->view('dm_izin');

		} else if($page == 'dm_bidang_usaha') {

			$this->load->view('dm_bidang_usaha');

		} else if($page == 'dm_jenis_identitas') {

			$this->load->view('dm_jenis_identitas');

		} else if($page == 'dm_decision') {

			$this->load->view('dm_decision');

		} else if($page == 'dm_aktivitas') {

			$this->load->view('dm_aktivitas');

		} else if($page == 'dm_jabatan') {

			$this->load->view('dm_jabatan');

		} else if($page == 'dm_unitkerja') {

			$this->load->view('dm_unitkerja');

		} else if($page == 'dm_jenis_usaha') {

			$this->load->view('dm_jenis_usaha');

		} else if($page == 'dm_personil') {

			$this->load->view('dm_personil');

		} else if($page == 'dm_workflow') {

			$this->load->view('dm_workflow');



		} else if($page == 'dm_tarif') {

			$this->load->view('dm_tarif');

		} else if($page == 'dm_rettarif') {

			$this->load->view('dm_rettarif');

		} else if($page == 'dm_nilai_koef') {

			$this->load->view('dm_nilai_koef');



		} else if($page == 'ki_syarat_izin') {

			$this->load->view('ki_syarat_izin');

		} else if($page == 'ki_rekam_berkas') {

			$this->load->view('ki_rekam_berkas');

		} else if($page == 'ki_berkas_prsh') {

			$this->load->view('ki_berkas_prsh');

		} else if($page == 'ki_workflow_izin') {

			$this->load->view('ki_workflow_izin');

		} else if($page == 'ki_aktivitas_workflow') {

			$this->load->view('ki_aktivitas_workflow');

		} 

		else if($page == 'olah_permohonan') {

			$this->load->view('olah_permohonan');

		} 



		// elseif (condition) {
		// 	# code...
		// }



		// test bayar

		elseif ($page == 'page_bayar') {

			$this->load->view('page_bayar');

		}

		

	} 

	?>



<?php $this->load->view('footer'); ?>

</body>

</html>