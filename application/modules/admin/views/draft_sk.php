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

                  <div class="row">
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Pilih Jenis Izin</label>
                                <div class="col-md-8">
                                  <select class="form-control">
                                      <option>-Pilih-</option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email"></label>
                                <div class="col-md-8">
                                   <select class="form-control">
                                      <option>-Pilih-</option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email"></label>
                                <div class="col-md-8">
                                   <select class="form-control">
                                      <option>-Pilih-</option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email"></label>
                                <div class="col-md-8">
                                   <button class="btn btn-success">Pilih</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Nama Penandatangan</label>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" value="Mr. Cholis">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email"></label>
                                <div class="col-md-8">
                                   <button class="btn btn-success">Simpan</button>
                                </div>
                            </div>


                        </form>
                    </div>
                  </div>
              </div>
          </div>
      </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>