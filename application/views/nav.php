<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
                <a href="#" class="logo" style="background: #fff; padding: 0px 20px;">
                    <img src="<?php echo base_url()?>berkas/core/images/logo-YAMINI-transparan.png" alt="" height="50">

                </a>&nbsp;&nbsp;
                Web Back Office Ziswaf Yamini
            </div>
            <!-- End Logo container-->


            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">

                    <?php 
                    $id_user = $this->session->userdata('id_user');
                    $getJumlah = $this->M_permohonan_izin->getPermohonanPerUser($id_user)->num_rows();
                    $getData = $this->M_permohonan_izin->getPermohonanPerUser($id_user)->result();
                    ?>

                    <li class="dropdown navbar-c-items">
                         <!-- <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge up bg-danger"><?php echo $getJumlah;?></span>
                        </a> -->

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
                                        <span class="name">Permohonan</span>
                                        <span class="desc"><?php echo $getJumlah . ' permohonan perlu di tindaklanjuti'?> </span>
                                    </div>
                                </a>
                            </li>
                           
                            <li class="all-msgs text-center">
                                <p class="m-0"><a href="#"></a></p>
                            </li>
                        </ul>
                    </li>


                    <li class="dropdown navbar-c-items">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo $this->session->userdata('img') ;?>" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li class="text-center">
                                <h5>Hi, <?php echo $this->session->userdata('nm_user');?></h5>
                            </li>
                            <li><a href="<?php echo base_url('user/changeProfil');?>"><i class="ti-user m-r-5"></i> 
                                Ubah Data Diri</a>
                            </li>
                            <li><a href="<?php echo base_url('user/changePassword');?>"><i class="ti-settings m-r-5"></i> 
                                Change Password</a>
                            </li>
                            <li><a href="<?php echo base_url('user/logout');?>"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                        </ul>
                    </li>

                    <?php if ($this->session->userdata('id_role') == '25') { ?>

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
                    <?php } ?>

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

            <?php  echo $this->session->userdata('menu');?>


            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->
