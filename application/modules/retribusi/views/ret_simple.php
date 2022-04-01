<form id="ret-form">
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Tarif</b> 
            </h4>
            <p class="text-muted font-13 m-b-30">
                Nilai Tarif
            </p>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center">Jenis Izin</th>
                          <th class="text-center">Nilai Tarif</th>
                        </tr>
                      </thead>
                  <tbody>
                    <tr>
                        <td>
                          <?php echo $nama_izin.' - '.$jenis_izin;?>
                        </td>
                        <td>
                          <div class="col-md-2"> Rp. </div> 
                          <div class="col-md-10">
                            <input class="text-right form-control" type="text" 
                            value="<?php echo number_format($tarif);?>" readonly>
                          </div>
                        </td>
                    </tr>                       
                    </tbody>
                  <tfoot>
                        <tr>
                          <td class="text-right"><b>JUMLAH RETRIBUSI</b></td>
                        <td>
                          <div class="col-md-2"> Rp. </div> 
                          <div class="col-md-10">
                            <input class="text-right form-control" type="text" 
                            value="<?php echo number_format($tarif);?>" readonly>
                            <input class="text-right form-control" name="tarif" type="hidden" 
                            value="<?php echo $tarif;?>" readonly>
                          </div> 
                          </td>
                        </tr>
                  </tfoot>                        
                </table>                        
              </div>
              
              <!-- 
              <div class="col-md-12">
                <button type="button" class="pull-right btn waves-effect btn-danger m-b-5" id="ret-submit"> 
                  <i class="fa fa-calculator"></i> Simpan Nilai Retribusi
                </button>
              </div> 
              -->


            </div>
        </div>
    </div>
</div>    
</form>
<script type="text/javascript">
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
          var no_permohonan = "<?php echo $this->input->get('no_permohonan')?>"; 
          var dret      = $('#ret-form').serialize();
          var url_control   = base_url+'permohonan_izin/ret_submit_perhitungan_s/'+no_permohonan;
      
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
                  $('#ret-submit').css('display', 'none');
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