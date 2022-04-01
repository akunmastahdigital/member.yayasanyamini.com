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

      <div class="row text-center">
          <div class="col-sm-12">
              <h3 class="m-t-20">Pencarian / Filter</h3>
              <div class="border center-block m-b-20"></div>
          </div>
      </div>

      <div class="row">
                    <div class="col-sm-12">
                        <form role="form" class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <select class="selectpicker show-tick" data-style="btn-default">
                                        <option value="0" disabled selected>Target</option>
                                        <option value="1">Tercapai</option>
                                        <option value="2">Belum Tercapat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <select class="selectpicker show-tick" data-style="btn-default">
                                        <option value="">Class</option>
                                        <option value="1">Class 1</option>
                                        <option value="2">Class 2</option>
                                        <option value="3">Class 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <select class="selectpicker show-tick" data-style="btn-default">
                                        <option value="">Cluster</option>
                                        <option value="1">Pulogadung</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 m-b-30 text-center m-t-10">
                                <button type="submit" class="btn btn-purple waves-effect waves-light"><i class="mdi mdi-magnify m-r-5"></i>Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end row -->

      <div class="row">
        <?php foreach ($list_progress_user as $lpu) { ?>
          <div class="col-lg-3 col-md-4">
            <div class="text-center card-box">
              <div class="member-card">
                <div class="thumb-lg member-thumb m-b-10 pull-right m-r-10" style="box-shadow:none">
                    <img src="<?php echo base_url() ?>berkas/core/images/users/avatar-3.jpg" class="  img-circle img-thumbnail" alt="profile-image">
                    <!-- <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i> -->
                </div>
                <h4 class="m-b-10 text-left"><?php echo $lpu['nm_user'] ?></h4>

                <div class="text-left m-t-10 m-b-10">
                  <!-- <p class="text-muted font-13"><strong>Kelas :</strong> <span class="m-l-15">1</span></p> -->

                  <p class="text-muted font-13"><strong>Cluster :</strong><span class="m-l-15"><?php echo $lpu['nama_kecamatan'] ?></span></p>

                  <p class="text-muted font-13"><strong>Target :</strong><span class="m-l-15 label label-danger"><?php echo "Rp " . number_format($lpu['jmlh_target'], 0,',','.') ?></span></p>

                  <p class="text-muted font-13"><strong>Peresentase Saat Ini :</strong></p>
                </div>

                <div class="progress progress-lg m-t-10 m-b-10">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo round($lpu['persentase']) > 100 ? "100" : round($lpu['persentase']) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($lpu['persentase']) > 100 ? "100" : round($lpu['persentase']) ?>%;">
                        <?php echo round($lpu['persentase']) ?>%
                    </div>
                </div>
                <hr>

                <div class="row m-b-10">
                  <div class="col-md-5 font-13">
                    <h5><?php 
                        if($lpu['total_ziswaf'] != null){
                          echo $lpu['total_ziswaf'];
                        }else{
                          echo "0";
                        }
						
                      ?></h5>
                    Jmlh Transaksi
                  </div>
                  <div class="col-md-7 font-13">
                    <h5><?php echo "Rp " . number_format($lpu['jmlh_uang'], 0,',','.') ?></h5>
                    jmlh Uang
                  </div>
                </div>

              </div> <!-- end member-card -->

            </div> <!-- end card-box -->
          </div>
        <?php } ?>
      </div>


  <?php $this->load->view('copyright'); ?>
  </div>
</div>

<!-- List menu izin -->
<style type="text/css">
  .collapsibleList li{
    list-style-image : url('<?php echo base_url();?>berkas/plugins/collapsiblelists/img/button.png');
    cursor : auto;
  }

  li.collapsibleListOpen{
    list-style-image : url('<?php echo base_url();?>berkas/plugins/collapsiblelists/img/button-open.png');
    cursor : pointer;
  }

  li.collapsibleListClosed{
    list-style-image : url('<?php echo base_url();?>berkas/plugins/collapsiblelists/img/button-closed.png');
    cursor : pointer;
  }

  ul.collapsibleList {
    padding-left:15px;
  }
</style>

<script src="<?php echo base_url()?>berkas/plugins/collapsiblelists/CollapsibleLists.js"></script>
<script type="text/javascript">
  CollapsibleLists.apply();
</script>