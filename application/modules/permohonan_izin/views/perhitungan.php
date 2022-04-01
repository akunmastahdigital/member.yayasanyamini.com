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
                    <!-- <span class="label label-danger"><?php echo $no_permohonan;?></span>
                    <span class="label label-default">13h</span> -->
                  </h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->   
      
      <!-- form retribusi -->
      <?php echo $ret;?>   

      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title">Tolak / Setujui</b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Tolak / Setujui Permohonan
                  </p>

                  <div class="row">
                    <div class="col-md-12">
                        <form id="formHis" class="form-horizontal" role="form">        

                            <div class="form-group">
                                <div class="col-md-4">
                                  <label>Catatan</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                  <textarea name="catatan" class="form-control"></textarea>
                                </div>
                            </div>

                           <div class="form-group">

                                <div class="col-md-4">
                                    <?php echo $button;?>
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

<script type="text/javascript">
  $(document).on('click', ".action", function() {
    var action    = $(this).attr("data-action");
    var permohonan= $(this).attr("data-permohonan");
    var aktivitas = $(this).attr("data-aktivitas");
    var decision  = $(this).attr("data-decision");
    var catatan   = $('#formHis').find('textarea[name="catatan"]').val();

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
</script>


<!-- ret -->
<script type="text/javascript">
  //APPEND TBL 
    $(document).on('click', ".add-row", function() {
      var jml_row   = $(this).closest('table').find('tbody tr').length;
      var content   = $(this).closest('table').find('tbody tr:eq(0)').clone();
    
      content.removeAttr('style');
      $('input, select', content).removeAttr('disabled');
      $('input', content).val('');
      $(this).closest('table').find('tbody').append(content);
    })  

    $(document).on('click', ".del-row", function() {
      var no_permohonan = $('input[name="no_permohonan"]').val();
      var index = $(this).data('index');
      var last  = $(this).data('last');

      if(last == 'y') {
        var dret          = {no_permohonan : no_permohonan, index : index};
        var type          = 'del';
        var url_control   = base_url+'permohonan_izin/ret_submit_perhitungan_k/'+type;

        $.ajax({
          type : "POST",
          url : url_control,  
          data : dret,
          datatype : "html",
          success: function(response) {
              res = JSON.parse(response);
              if(res.msg == 'not_valid') {
                // swal('Gagal !','Perhitungan gagal dilakukan','error');
              } else {
                // swal('Berhasil !','Perhitungan berhasil dilakukan','success');
                $(document).find('#ret-form').load().html(res.ret_form);
              }
          }
        })
      }

      $(this).closest('tr').remove();
    })  


  //SUBMIT
  $(document).on('click', '#ret-submit', function() {
    swal({
      title: "Apa anda yakin?",
      text: "Data yang sudah masuk tidak akan bisa kembali lagi, harap periksa kembali data yang anda masukan!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, saya yakin!",
      closeOnConfirm: false
    },
    function() {
        var dret          = $('#ret-form').serialize();
        var type          = 'ins';
        var url_control   = base_url+'permohonan_izin/ret_submit_perhitungan_k/'+type;
    
        $.ajax({
          type : "POST",
          url : url_control,  
          data : dret,
          datatype : "html",
          success: function(response) {
              res = JSON.parse(response);
              if(res.msg == 'not_valid') {
                swal('Gagal !','Perhitungan gagal dilakukan','error');
              } else {
                swal('Berhasil !','Perhitungan berhasil dilakukan','success');
                $(document).find('#ret-form').load().html(res.ret_form);
              }
          }
      })
    })
  })
</script>

<?php if($permission == 0) {?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#ret-form').find('button').css('display', 'none');
    $('#ret-form').find('input').attr('readonly', true);
  }) 
</script>
<?php } ?>