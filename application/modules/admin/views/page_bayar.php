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
        <div class="col-md-8 col-md-offset-2" >
          <?php if($this->session->flashdata('teks-alert') != '') { ?>
            <!--alert-->
            <div class="alert <?php echo $this->session->flashdata('tipe-alert');?>-border btn-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="<?php echo $this->session->flashdata('icon-alert');?>"></i> <?php echo $this->session->flashdata('teks-alert');?>
            </div>
          <?php } ?>
        </div>
      </div>      


      <div class="row">
          <div class="col-md-6 col-md-offset-3">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><?php echo $title;?></b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>

                  <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url('permohonan_izin/api_bayar_permohonan');?>">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Pilih Nomor Permohonan</label>
                                <div class="col-md-8">
                                  <select id="no_permohonan" name="no_permohonan" class="form-control">
                                      <option>-Pilih-</option>
                                      <?php foreach ($option_nopor as $np) { ?>
                                        <option value="<?php echo $np['no_permohonan'];?>"><?php echo $np['no_permohonan'];?></option>
                                      <?php } ?>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Nama Pemohon</label>
                                <div class="col-md-8">
                                  <input name="nama_pemohon" type="text" class="form-control" readonly placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Nama Izin</label>
                                <div class="col-md-8">
                                  <input name="nama_izin" type="text" class="form-control" readonly placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Kode Bayar</label>
                                <div class="col-md-8">
                                  <input name="kode_bayar" type="text" class="form-control" placeholder="Isi dengan kode bayar">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Nominal</label>
                                <div class="col-md-8">
                                  <input name="nominal" type="number" class="form-control" placeholder="Isi dengan nominal pembayaran">
                                </div>
                            </div>
                            <input name="permohonan" type="hidden" value="<?php echo $data['id_permohonan'];?>">
                            <input name="aktivitas" type="hidden" value="<?php echo $data['id_aktivitas_workflow'];?>">
                            <button class="btn btn-md btn-primary col col-md-12" type="submit">Bayar</button>
                        </form>
                    </div>
                  </div>
              </div>
          </div>
      </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>

<script type="text/javascript">
 $(document).on('change', "#no_permohonan", function() {
    var   permohonan  = $(this).val();

    $.ajax({
        url : "<?php echo base_url('admin/call_data_permohonan')?>",
        dataType: "json",
        data: "no_permohonan="+permohonan,
        type: "POST",
        success: function(data){
          $('input[name="permohonan"]').val(data.id_permohonan);
          $('input[name="aktivitas"]').val(data.id_aktivitas_workflow);
          $('input[name="nama_pemohon"]').val(data.nama_pemohon);
          $('input[name="nama_izin"]').val(data.nama_izin);
        }
    })        

  })  
</script>