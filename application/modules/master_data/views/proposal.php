<div class="wrapper">
    <div class="container">
  
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="active">
                                <?php echo $menu;?>
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title"><?php echo $title;?></h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
  
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="text-center card-box">
                                <div class="member-card">
                                    <div class="thumb-xl member-thumb m-b-10 center-block">
                                        <img src="<?php echo $data_user['img'] ?>" class="img-circle img-thumbnail" alt="profile-image">
                                        <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
                                    </div>

                                    <div class="">
                                        <h4 class="m-b-5">Relawan 1</h4>
                                        <!-- <p>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <span>(29)</span>
                                        </p> -->
                                    </div>
<!-- 
                                    <button type="button" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light">Follow</button>
                                    <button type="button" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light">Message</button>

                                    <p class="text-muted font-13 m-t-20">
                                        Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.
                                    </p> -->

                                    <hr/>

                                    <div class="text-left">
                                        <p class="text-muted font-13"><strong>Nama :</strong> <span class="m-l-15"><?php echo $data_user['nm_user'] ?></span></p>

                                        <p class="text-muted font-13"><strong>No Hp :</strong><span class="m-l-15"><?php echo $data_user['no_wa'] ?></span></p>

                                        <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $data_user['email'] ?></span></p>
                                    </div>

                                </div> <!-- end member-card -->

                            </div> <!-- end card-box -->


                        </div> <!-- end col -->

                        <div class="col-md-8 col-lg-9">
                            <h4 class="m-t-0 text-uppercase">List Proposal</h4>
                            <div class="border m-b-30"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-lg-4">
                                    <div class="property-card">
                                        <div class="property-image" style="background: url('<?php echo base_url() ?>berkas/marketing-kit/thumbnail-proposal.JPG') center center / cover no-repeat;">
                                            <!-- <span class="property-label label label-warning">20 November 2021</span> -->
                                        </div>

                                        <div class="property-content">
                                            <div class="listingInfo">
                                                <div class="">
                                                    <h3 class="text-overflow"><a href="#" class="text-dark">Proposal ZISWAF Yamini 1442 H</a></h3>
                                                    <!-- <p class="text-muted text-overflow"><i class="mdi mdi-map-marker-radius m-r-5"></i>Pulogadung Indonesia</p> -->

                                                    <!-- <div class="row text-center">
                                                        <div class="col-xs-6">
                                                            <h4>280</h4>
                                                            <p class="text-overflow" title="Square Feet">Target</p>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <h4>Perusahaan</h4>
                                                            <p class="text-overflow" title="Bedrooms">Peruntukan</p>
                                                        </div>
                                                    </div> -->

                                                    <div class="m-t-20">
                                                        <a type="button" class="btn btn-success btn-block waves-effect waves-light" href="<?php echo base_url() ?>berkas/marketing-kit/Proposal ZISWAF Yamini 1442 H.pdf" download="Proposal ZISWAF Yamini 1442 H.pdf" target="_blank">Klik Untuk Download Proposal</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end. Card actions -->
                                        </div>
                                        <!-- /inner row -->
                                    </div>
                                    <!-- End property item -->
                                </div>
                                
                                <!-- end col -->
                            </div> <!--end row -->
                        </div>
                        <!-- end col -->

                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->


    </div>
  </div>
