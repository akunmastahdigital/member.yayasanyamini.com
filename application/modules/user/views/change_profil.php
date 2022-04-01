<div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              Ubah Data Diri
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title">Ubah Data Diri</h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


 <div class="row">
    <div class="">
        <div class="panel panel-color panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Ubah Data Diri</h3>
            </div>
    <div class="panel-body">
        <div class="table-responsive">

                   <?php
                            if ($this->session->flashdata('psn') <> '' ) {
                                

                        ?>

                            <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert" style="background-color: red">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <i class="mdi mdi-alert"></i>
                                                <strong><?php echo $this->session->flashdata('psn')?></strong> 
                                            </div>
                        <?php
                        }
                        ?>   

            <form class="form-horizontal col-md-11" role="form" method="post" action="<?php echo base_url()?>user/submit_data_diri" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="nm_user" value="<?php echo $this->session->userdata('nm_user');?>" required>
                        <input type="hidden" class="form-control hidden" name="id_user" value="<?php echo $this->session->userdata('id_user');?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">No Whatsapp</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" placeholder="08*********" value="<?php echo $dPer['no_wa'] ?>" name="no_wa" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Email</label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" placeholder="Fulan@mail.com"  value="<?php echo $dPer['email'] ?>" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">URL Website</label>
                    <div class="col-md-10">
                        <input type="url_website" class="form-control" placeholder="tanpa spasi"  value="<?php echo $dPer['url_website'] ?>" name="url_website" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Foto Profil</label>
                    <?php if($dPer['img'] != null or $dPer['img'] != ''){
                        echo '<div class="col-md-6">
                                 <img style="width:20%" class="img-thumbnail img-responsie img_profil" src="'.$dPer['img'].'">
                                 <input type="file" class="form-control hidden upload_foto" data-name="foto">
                                 <button type="button" class="btn btn-danger btn-sm btn-ubah" style="position:relative; margin-left:7px;"><i class="fa fa-refresh"></i> Ganti Foto</button>
                                 <button type="button" class="btn btn-brown btn-sm btn-batal hidden" style="position:relative; margin-left:7px;"><i class="fa fa-refresh"></i> Batal</button>
                              </div>';
                    }else{
                        echo '<div class="col-md-10">
                                <input type="file" class="form-control" name="foto">
                              </div>';
                    } ?>

                    
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-primary btn-md"><i class="fa fa-floppy-o"></i> Simpan</button>&nbsp;
                    <a href="<?php echo base_url() ?>dashboard/relawan" class="btn btn-warning btn-md"><i class="fa fa-arrow-left"></i> Batal</a>
                </div>



            </form>

            </div> <!-- table-responsive -->
        </div>
    </div>
</div>
                            <!-- end col -->

        </div>            <!-- end row -->
    </div>
</div>


<script>

$(document).on('click', ".btn-ubah", function() {
    $(this).addClass('hidden');
    $(".btn-batal").removeClass('hidden');
    $(".upload_foto").removeClass('hidden');
    $(".img_profil").addClass('hidden');
    
    var name = $(".upload_foto").attr('data-name');
    $(".upload_foto").attr('name', name);
    
})

$(document).on('click', ".btn-batal", function() {
    $(this).addClass('hidden');
    $(".btn-ubah").removeClass('hidden');
    $(".upload_foto").addClass('hidden');
    $(".img_profil").removeClass('hidden');
    $(".upload_foto").attr('name', '');
    
})

</script>