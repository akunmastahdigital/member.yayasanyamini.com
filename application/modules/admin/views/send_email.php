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
        <div class="col-md-12">
          <div class="card-box table-responsive">

            <h4 class="m-t-0 header-title"><b><?php echo $title;?><b> 
              <span class="label label-info total"></span>
              <div class="button-list" style="float: right;">
              </div>
            </h4>

            <p class="text-muted font-13 m-b-30">
               
            </p>

            <div class="col-md-12">
                <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box m-t-20">
                                                <div class="">
                                                    <form role="form">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control" placeholder="To">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <!-- <div class="col-md-6">
                                                                    <input type="email" class="form-control" placeholder="Cc">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="email" class="form-control" placeholder="Bcc">
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Subject">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="cek">
                                                              

                                                            </div>
                                                        </div>

                                                        <div class="btn-toolbar form-group m-b-0">
                                                            <div class="pull-right">
                                                                <button type="button" class="btn btn-success waves-effect waves-light m-r-5"><i class="fa fa-floppy-o"></i></button>
                                                                <button type="button" class="btn btn-success waves-effect waves-light m-r-5"><i class="fa fa-trash-o"></i></button>
                                                                <button class="btn btn-purple waves-effect waves-light"> <span>Send</span> <i class="fa fa-send m-l-10"></i> </button>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
            </div>

          </div>
        </div>
      </div>


  <?php $this->load->view('copyright'); ?>
  </div>
</div>



  
