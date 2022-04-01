<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="index.html" class="logo">-->
                    <!--Zircos-->
                <!--</a>-->
                <!-- Image Logo -->
                <a href="index.html" class="logo">
                    <img src="<?php echo base_url()?>berkas/core/images/dpmptsp/icon_dpmptsp.png" alt="" height="50">

                </a>
                Modul Back Office E-Permit DPM-PTSP Kota Bekasi
            </div>
            <!-- End Logo container-->


            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">

                    <li class="dropdown navbar-c-items">
                         <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge up bg-danger">4</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                            <li class="text-center">
                                <h5>Pemberitahuan</h5>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-info">
                                        <i class="mdi mdi-account"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Verifikasi</span>
                                        <span class="desc">5 file perlu di verifikasi</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-danger">
                                        <i class="mdi mdi-comment"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Review</span>
                                        <span class="desc">5 file perlu di review</span>
                                    </div>
                                </a>
                            </li>
                            <li class="all-msgs text-center">
                                <p class="m-0"><a href="#"></a></p>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown navbar-c-items">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url()?>berkas/core/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li class="text-center">
                                <h5>Hi, <?php echo $this->session->userdata('nm_user');?></h5>
                            </li>
                            <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Settings</a></li>
                            <li><a href="<?php echo base_url('user/logout');?>"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                        </ul>

                    </li>

                    <li class="dropdown navbar-c-items">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url()?>berkas/core/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list" style="height:500px;overflow-y:auto;">
                            <?php $list_user    = $this->M_permohonan_izin->coba_login()->result_array(); ?>
                            <?php 
                            foreach ($list_user as $lu) { ?>
                                <li><a href="<?php echo base_url('admin/coba_login')."/".$lu['id_user']?>"><?php echo $lu['nm_user']." (".$lu['nm_jabatan'].") ";?></a></li>
                            <?php } ?>
                        </ul>

                    </li>
                </ul>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
            <!-- end menu-extras -->

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
        <div class="container">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="<?php echo base_url('dashboard')?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-playlist-check"></i>Proses Permohonan</a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url('permohonan_izin/disposisi/disposisi')?>">Disposisi ke Evaluator</a></li>
                            <li><a href="<?php echo base_url('permohonan_izin/verifikasi')?>">Verifikasi Permohonan</a></li>
                            <li class="has-submenu">
                                <a href="#">Persetujuan Permohonan (SKPD)</a>
                                <ul class="submenu">
                                    <li class="has-submenu">
                                        <a href="#">Perhitungan SKRD (PUPR)</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url('permohonan_izin/disposisi/pupr_kasi')?>">Perhitungan SKRD (Kasi)</a></li>
                                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/pupr_staf')?>">Perhitungan SKRD (Staf)</a></li>
                                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/pupr_kabid')?>">Perhitungan SKRD (Kabid)</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#">Perhitungan SKRD (Perkim)</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url('permohonan_izin/disposisi/perkim_kasi')?>">Perhitungan SKRD (Kasi)</a></li>
                                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/perkim_staf')?>">Perhitungan SKRD (Staf)</a></li>
                                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/perkim_kabid')?>">Perhitungan SKRD (Kabid)</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo base_url('permohonan_izin/disposisi/skpd_kasi')?>">Persetujuan Permohonan (Kasi)</a></li>
                                    <li><a href="<?php echo base_url('permohonan_izin/evaluasi/skpd_staf')?>">Persetujuan Permohonan (Staf)</a></li>
                                    <li><a href="<?php echo base_url('permohonan_izin/evaluasi/skpd_kabid')?>">Persetujuan Permohonan (Kabid)</a></li>
                                    <li class="has-submenu">
                                        <a href="#">Persetujuan SKRD (Bapenda)</a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/bapenda_kasi')?>">Persetujuan SKRD (Kasi)</a></li>
                                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/bapenda_kabid')?>">Persetujuan SKRD (Kabid)</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/kabid_admin')?>">Persetujuan Permohonan (Kabid Admin)</a></li>
                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/kabid_teknis')?>">Persetujuan Permohonan (Kabid Teknis)</a></li>
                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/ka_tu')?>">Persetujuan Permohonan (Ka TU)</a></li>
                            <li><a href="<?php echo base_url('permohonan_izin/pembayaran')?>">Verifikasi Pembayaran (Staf Pembayaran)</a></li>
                            <li><a href="<?php echo base_url('permohonan_izin/evaluasi/kadis')?>">Persetujuan Permohonan (Kadis)</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-file-document"></i>SK Izin</a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url('sk_izin/cetak')?>">Cetak SK Izin</a></li>
                            <li><a href="<?php echo base_url('sk_izin/pengambilan')?>">Pengambilan</a></li>
                            <li><a href="<?php echo base_url('sk_izin/arsip')?>">Arsip</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-clock"></i>Timeline</a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url('timeline/batas_waktu/lewat')?>">Lewat Batas Waktu</a></li>
                            <li><a href="<?php echo base_url('timeline/batas_waktu/dalam')?>">Dalam Batas Waktu</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-comment-multiple-outline"></i>Layanan Kontak</a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url('layanan_kontak/modul_layanan/pengaduan')?>">Pengaduan</a></li>
                            <li><a href="<?php echo base_url('layanan_kontak/modul_layanan/usulan')?>">Usulan</a></li>
                            <li><a href="<?php echo base_url('layanan_kontak/modul_layanan/pertanyaan')?>">Pertanyaan</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-file-multiple"></i>Laporan</a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url('laporan/rekap_perizinan')?>">Lap. Rekap Perizinan</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-database"></i>Master Data</a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url('master_data/permohonan_izin/SIUP')?>">Permohonan SIUP</a></li>
                            <li><a href="<?php echo base_url('master_data/permohonan_izin/TDP')?>">Permohonan TDP</a></li>
                            <li><a href="<?php echo base_url('master_data/permohonan_izin/IPTM')?>">Permohonan IPTM</a></li>
                            <li><a href="<?php echo base_url('master_data/permohonan_izin/Ditolak')?>">Permohonan Ditolak</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-worker"></i>Admin</a>
                        <ul class="submenu">
                            <li class="has-submenu"><a href="#">Data Master</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url('admin/dm_izin')?>">Izin</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_bidang_usaha')?>">Bidang Usaha</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_jenis_usaha')?>">Jenis Usaha</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_jenis_identitas')?>">Jenis Identitas</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_jabatan')?>">Jabatan</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_unitkerja')?>">Unit Kerja</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_personil')?>">Personil</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_aktivitas')?>">Aktivitas</a></li>
                                    <li><a href="<?php echo base_url('admin/dm_decision')?>">Decision</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu"><a href="<?php echo base_url()?>">Konfigurasi Izin</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url('admin/ki_syarat_izin')?>">Syarat Izin</a></li>
                                    <li><a href="<?php echo base_url('admin/ki_rekam_berkas')?>">Rekam Berkas Izin</a></li>
                                    <li><a href="<?php echo base_url('admin/ki_berkas_prsh')?>">Berkas Perusahaan</a></li>
                                    <li><a href="<?php echo base_url('admin/ki_workflow_izin')?>">Workflow Izin</a></li>
                                    <li><a href="<?php echo base_url('admin/ki_aktivitas_workflow')?>">Aktivitas Workflow</a></li>
                                </ul>
                            </li>

                            <li><a href="<?php echo base_url('admin/draft_sk')?>">Pengaturan Template Draft SK</a></li>
                            <li class="has-submenu"><a href="<?php echo base_url('admin/hak_akses')?>">Pengelolaan User</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url('admin/user_bo')?>">Pengelolaan User Back Office</a></li>
                                    <li><a href="<?php echo base_url('admin/user_fe')?>">Pengelolaan User Pemohon</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('admin/hak_akses')?>">Pengaturan Hak Akses</a></li>
                            <li><a href="<?php echo base_url('admin/test_api_pbyr')?>">Test API Pembayaran</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->