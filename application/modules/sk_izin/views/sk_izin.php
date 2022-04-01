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
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><?php echo $title;?></b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>

                  <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                      <tr>
                          <th>ID</th>
                          <th>No Permohonan</th>
                          <th>Tgl Permohonan</th>
                          <th>Perusahaan</th>
                          <th>Jenis Permohonan</th>
                          <th>Aksi</th>
                      </tr>
                      </thead>

                      <tbody>
                      <?php $no = 1;for($i=1;$i<30;$i++) { ?>
                      <tr>
                          <td><?php echo $no++ ?></td>
                          <td>JASULO000169</td>
                          <td>01-09-2017</td>
                          <td>PT. Kripik Wenak</td>
                          <td>SIUP</td>
                          <td>
                            <?php if($aksi == 'cetak') { ?>
                                <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Cetak"> <i class="fa fa-print"></i> 
                                </button>
                            <?php } ?>

                            <?php if($aksi == 'input') { ?>
                                <button class="btn btn-xs btn-icon waves-effect btn-primary m-b-5 tooltip-hover" 
                                  title="Input"> Input Data Pengambil
                                </button>
                            <?php } ?>

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