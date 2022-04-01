<div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              <?php echo $title;?>
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title"><?php echo $menu;?></h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><b><?php echo $title;?></b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>

                  <table id="datatable" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                          <th>Nama</th>
                          <th>Username</th>
                          <th>Jabatan</th>
                          <th>Departemen</th>
                          <th>Bagian</th>
                          <th>Aksi</th>
                      </tr>
                      </thead>

                      <tbody>
                      <?php $no = 1;for($i=1;$i<30;$i++) { ?>
                      <tr>
                          <td>Malik Zayn</td>
                          <td>mzayb</td>
                          <td>Dirjen</td>
                          <td>Telekomunikasi (ULO)</td>
                          <td>Verifikator</td>
                          <td>
                            <button class="btn btn-xs btn-icon waves-effect btn-warning m-b-5 tooltip-hover" 
                                  title="Edit"> <i class="fa fa-pencil"></i> 
                              </button>
                            <button class="btn btn-xs btn-icon waves-effect btn-danger m-b-5 tooltip-hover" 
                                  title="Hapus"> <i class="fa fa-remove"></i> 
                              </button>
                          </td>
                          <!-- <td>
                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Lihat"> <i class="ti ti-eye"></i> 
                              </button>

                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Setujui"> <i class="fa fa-check"></i> 
                              </button>

                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Pending"> <i class="fa fa-circle-o-notch"></i> 
                              </button>

                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Tolak"> <i class="fa fa-times"></i> 
                              </button>

                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Reposisi"> <i class="fa fa-mail-reply"></i> 
                              </button>

                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Disposisi"> <i class="fa fa-mail-forward"></i> 
                              </button>

                              <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Detail Permohonan"> <i class="fa fa-search"></i> 
                              </button>

                          </td> -->
                      </tr>
                      <?php } ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>