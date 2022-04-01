 <div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              Change Password
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title">Change Password</h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


 <div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Change Password</h3>
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

            <form method="post" action="<?php echo base_url('user/submitChangePassword');?>">
            <input id="id_user" type="hidden" name="id_user" class="form-control input-md" minlength="1" required value="<?php echo $id_user;?>">
             <div class="row">
                 <div class="col-md-12 form-group">
                    <label for="password_lama" class="col-md-3">Masukkan password lama</label>
                    <div class="col-md-4 form-group">
                        <input id="password_lama" type="password" name="password_lama" class="form-control input-md" minlength="1" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="checkbox" onchange="document.getElementById('password_lama').type = this.checked ? 'text' : 'password'"> Tampilkan
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="password_baru" class="col-md-3">Masukkan password baru</label>
                    <div class="col-md-4 form-group">
                        <input type="password" name="password_baru" class="form-control input-md" minlength="1" id="password_baru" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="checkbox" onchange="document.getElementById('password_baru').type = this.checked ? 'text' : 'password'"> Tampilkan
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="konfirm_password" class="col-md-3">Konfirmasi password baru</label>
                    <div class="col-md-4 form-group">
                        <input type="password" name="konfirm_password" class="form-control input-md" minlength="1" id="konfirm_password" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="checkbox" onchange="document.getElementById('konfirm_password').type = this.checked ? 'text' : 'password'"> Tampilkan
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="id_personil" value="<?php echo $id_user;?>">
                    
            <div class="row">
                <div class="col-md-12 form-group">
                    <button type="submit" name="submit" class="btn btn-xl btn-info" value="simpan">Simpan</button>
                    <button type="button" class="btn btn-xl btn-primary" onclick="window.history.back();">Batal</button>
                </div>
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
