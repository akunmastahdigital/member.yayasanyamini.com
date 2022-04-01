<form id="form_syarat_izin" action="<?php echo base_url('permohonan_izin/submit_permohonan');?>" method="post" enctype="multipart/form-data">
<div class="wrapper">
  <div class="container">

      <input type="hidden" name="no_permohonan" value="<?php echo $this->input->get('no_permohonan');?>">
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
                    <span class="label label-teal"><?php echo strtoupper($no_permohonan);?></span>
                    <!-- <span class="label label-default">13h</span> -->
                  </h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->

      <!-- Alert -->
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
          <div class="<?php echo $col_pmhn;?>">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title">Data Muzakki</b> 
                  <!-- button rekam berkas -->
                  <?php echo $button_rb;?>
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Data Muzakki
                  </p>

                  <div class="row" style="height: 310px;overflow-y: auto">
                    <div class="col-md-11">

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Nama Muzakki</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" readonly value="<?php echo $pemohon['nama'];?>">
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email"><?php echo $pemohon['ak_jenis_identitas'];?></label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" readonly value="<?php echo $pemohon['no_identitas'];?>">
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Alamat</label>
                                <div class="col-md-8">
                                   <textarea type="text" class="form-control" height="30" readonly><?php echo $pemohon['alamat'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Email</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" readonly value="<?php echo $pemohon['email'];?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">No. Telp</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" readonly value="<?php echo $pemohon['no_telp'];?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Nama Izin</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" readonly value="<?php echo $permohonan['ak_nama_izin'];?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-email">Jenis Zakat</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control" readonly value="<?php echo $permohonan['jenis_izin'];?>">
                                </div>
                            </div>

                    </div>
                  </div>
              </div>
          </div>

          <?php if($perusahaan != '') { ?>
          <div class="col-sm-6">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title">Data Perusahaan</b>
                  <!-- button perusahaaan bio -->
                  <?php echo $button_pbio;?>
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Data Perusahaan
                  </p>

                  <div class="row" style="height: 420px;overflow-y: auto">
                    <div class="col-md-11">
                      <!-- perusahaan bio -->
                      <?php echo $perusahaan;?>
                    </div>
                  </div>
              </div>
          </div>
          <?php } ?>
      </div>



      <?php if($syarat_izin != '') {?>
      <div class="row">
        <div class="col-sm-12">
          <h4>Evaluasi Berkas</h4>
        </div>
      </div>
      <?php } ?>
      <!-- syarat izin -->
      <?php echo $syarat_izin;?>
     


      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title">Data Log Proses Zakat / Donasi</b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Data Log Proses Zakat / Donasi
                  </p>

                  <div class="row">
                    <div class="col-md-12">

                        <table class="table table-striped table-bordered">
                          <thead>
                          <tr>
                              <th class="col-md-1 text-center">NO</th>
                              <th class="col-md-2">Status</th>
                              <th class="col-md-2">Diurus Oleh</th>
                              <th class="col-md-2">Jabatan</th>
                              <th class="col-md-2">Waktu</th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php
                              if (!empty($history)) {
                              $no=1;
                              foreach($history as $hs) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++ ?></td>
                                    <td><?php echo $hs['nm_aktivitas_workflow']?></td>
                                    <td><?php echo $hs['nm_personil']?></td>
                                    <td><?php echo $hs['nm_jabatan']?></td>
                                    <td><?php echo date('d-m-Y H:i', strtotime($hs['waktu_in']))?></td>
                                </tr>
                            <?php  
                            } } else { ?>
                              <tr>
                                <td colspan="5" class="text-center">Belum diproses</td>
                              </tr>
                            <?php } ?>
                          </tbody>
                      </table>

                    </div>
                  </div>
              </div>
          </div>

      </div>




      <div class="row aksi_group">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title">Proses Data Ini</b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Setujui / Perbaikan
                  </p>

                  <div class="row">
                    <div class="col-md-12" id="formHis">

                        <!-- <div class="form-group">
                            <div class="col-md-4">
                              <label>Catatan</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                              <textarea name="catatan" class="form-control"></textarea>
                            </div>
                        </div> -->

                       <div class="form-group">
                            <div class="col-md-4">
                              <?php echo $button;?>
                              <!-- <button type="submit" class="btn btn-lg btn-icon waves-effect btn-danger m-b-5 tooltip-hover tooltipstered"
                                      title="Simpan Perubahan"> 
                                <i class="fa fa-save"></i>
                              </button> -->
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

</form>
<script type="text/javascript">

  var url_string = window.location.href; //window.location.href
  var url = new URL(url_string);
  var ro = url.searchParams.get("ro");
  if(ro == 'true'){
    $(".aksi_group").hide();
  }else{
    $(".aksi_group").show();
  }



  $(document).on('click', ".action", function() {
    $(this).unbind();
    var action    = $(this).attr("data-action");
    var permohonan= $(this).attr("data-permohonan");
    var aktivitas = $(this).attr("data-aktivitas");
    var decision  = $(this).attr("data-decision");
    var catatan   = $('#formHis').find('textarea[name="catatan"]').val();

    // window.location.href($.cookie("history-url"));

    $.ajax({
        url : "<?php echo base_url('permohonan_izin/akt_action')?>/"+action,
        dataType: "json",
        data: "aktivitas="+aktivitas+"&permohonan="+permohonan+"&decision="+decision+"&catatan="+catatan,
        type: "POST",
        success: function(data){
          //  window.location.href   = "<?php echo base_url('permohonan_izin');?>/"+data;
          setTimeout(function() {
            swal({
                title: "Sukses!",
                text: "Proses berhasil dilakukan!",
                type: "success"
            }, function() {
                window.history.back();
            });
          }, 1000);
        }
    })

  })

  $(document).on('click', ".act-syarat", function() {
    var action  = $(this).attr("data-action");
    var type    = $(this).attr("data-type");
    var id      = $(this).attr("data-id");
    var catatan = $(this).parent().parent().find('input[name="catatan"]').val();

    $.ajax({
        url : "<?php echo base_url('permohonan_izin/syarat_action')?>/"+action,
        dataType: "json",
        data: "id="+id+"&catatan="+catatan+"&type="+type,
        type: "POST",
        success: function(data){
          swal("Sukses!", "Catatan berhasil ditambahkan!", "success");
          // $(this).parent().parent().find('.text-notif').text("Catatan berhasil!");
        }
    })        

  })

  function showFile(e) {
    var id   = $(e).data('id');
    var data = {"id" : id};
    $.ajax({
        url : "<?php echo base_url('permohonan_izin/show_file')?>",
        dataType: "html",
        data: data,
        type: "POST",
        success: function(data){
          $('#showFileObj').load().html(data);
          $('#showFile').modal('show'); 
        }
    });   
  }

  function showDraft(e) {
    var id   = $(e).data('id');
    var data = {"id" : id};
    $.ajax({
        url : "<?php echo base_url('sk_izin/pdf_show/pvw')?>",
        dataType: "html",
        data: data,
        type: "POST",
        success: function(data){
          $('#showFileObj').load().html(data);
          $('#showFile').modal('show'); 
        }
    });    
  }

  function showDraftSertif(e) {
    var id   = $(e).data('id');
    var data = {"id" : id};
    $.ajax({
        url : "<?php echo base_url('sk_izin/pdf_show_sertif/pvw')?>",
        dataType: "html",
        data: data,
        type: "POST",
        success: function(data){
          $('#showFileObj').load().html(data);
          $('#showFile').modal('show'); 
        }
    });    
  }

</script>