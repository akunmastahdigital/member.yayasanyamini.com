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
                  <h4 class="page-title"><?php echo $title;?>
                    <!-- <span class="label label-danger">Here</span>
                    <span class="label label-default">13h</span> -->
                  </h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->

      <?php if($this->session->flashdata('teks-alert') != '') { ?>
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="alert alert-icon alert-<?php echo $this->session->flashdata('tipe-alert');?> alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="<?php echo $this->session->flashdata('icon-alert');?>"></i>
            <strong><?php echo $this->session->flashdata('teks-alert');?></strong>
        </div>
      </div>
      <?php } ?>

      <!-- perusahaan bio -->
      <?php echo $pbio_card?>

      <!-- showFileModal -->
      <div id="showFile" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      <h4 class="modal-title">Show File</h4>
                  </div>
                  <div class="modal-body" id="showFileObj">
                  <!-- load berkas here -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                  </div>
              </div><!-- /.showFileModal-content -->
          </div><!-- /.showFileModal-dialog -->
      </div><!-- /.showFileModal -->
  <?php $this->load->view('copyright'); ?>
  </div>
</div>
