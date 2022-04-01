<!-- Jquery filer css -->



<div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              <?php echo ucfirst((string)"Lapor Zakat / Donasi");?>
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title"><?php echo ucfirst((string)"Lapor Zakat / Donasi");?></h4>
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
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>List Zakat / Donasi</b> <span class="pull-right">Relawan : <label class="label label-sm label-info"><?php echo $nama_user ?></label> </span>
                </h4>
                
                <p class="text-muted font-13 m-b-30">
                    Dibawah ini List Lapor Zakat / Donasi
                </p>

                <table id="datatables-ss" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>No Ziswaf</th>
                        <th>Tanggal</th>
                        <th>Nama Muzakki</th>
                        <th>Nama Relawan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th class="center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php //echo $data_table ?>
                    </tbody>
                </table>
          </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Zakat / Donasi</b> 
                </h4>

                <p class="text-muted font-13 m-b-30">
                    Tambah Lapor Zakat / Donasi
                </p>

                <form class="form-horizontal col-md-11" role="form" method="post" action="<?php echo base_url()?>permohonan_izin/submit_manual" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama Relawan</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="nm_user" value="<?php echo $this->session->userdata('nm_user');?>" required readonly>
                        <input type="hidden" class="form-control hidden" name="id_user" value="<?php echo $this->session->userdata('id_user');?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="example-email">Jenis Ziswaf</label>
                    <div class="col-md-10">
                        <select id="ziswaf" name="jenis_ziswaf" class="selectpicker form-control" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($option as $opt) {
                                echo "<option value='".$opt['id_jenis_izin']."'>".$opt['teks_menu']."";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group hidden" id="infaq_form">
                    <label class="col-md-2 control-label" for="example-email">Jenis infaq</label>
                    <div class="col-md-10">
                        <select id="infaq" name="jenis_infaq" class="selectpicker form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Sedekah Quran">Sedekah Quran</option>
                            <option value="Bingkisan untuk guru ngaji">Bingkisan untuk guru ngaji</option>
                            <option value="Beasiswa Pendidikan Quran Yatim Piatu">Beasiswa Pendidikan Quran Yatim Piatu</option>
                            <option value="Training guru Quran">Training guru Quran</option>
                            <option value="BBQ">BBQ</option>
                            <option value="Pengembangan Dakwah Qur'an">Pengembangan Dakwah Qur'an</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama Muzakki</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" value="" placeholder="Fulan" name="nama_muzakki" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Alamat Muzakki</label>
                    <div class="col-md-10">
                        <textarea heigh="30" type="text" class="form-control" value="" placeholder="" name="alamat_muzakki"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">No Hp Muzakki</label>
                    <div class="col-md-10">
                        <input type="number" class="form-control" value="" placeholder="08*******" name="no_hp_muzakki">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Email Muzakki</label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" value="" placeholder="Fulan@mail.com" name="email_muzakki">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Jumlah Transaksi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control uang" placeholder="Rp 100.000" name="jmlh_transaksi" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Tanggal Transaksi</label>
                    <div class="col-md-10">
                        <input type="date" class="form-control" placeholder="" name="tgl_transaksi" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Upload Bukti Bayar</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control" name="file_upload" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Keterangan</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="keterangan" rows="4"></textarea>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-info btn-md"><i class="fa fa-send"></i> Lapor</button>
                </div>



            </form>

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
                <h4 class="modal-title">Preview Draft</h4>
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

<!-- Jquery filer js -->
<!-- <script src="<?php //echo base_url()?>berkas/plugins/jquery.filer/js/jquery.filer.min.js"></script> -->

<!-- page specific js -->
<!-- <script src="<?php //echo base_url()?>berkas/core/pages/jquery.property-add.init.js"></script> -->

<!-- Datatables -->
<script src="<?php echo base_url()?>berkas/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">

$('#ziswaf').change(function() {
    opt = $(this).val();
    console.log(opt);
    if (opt=="5") {
        console.log("show");
        $("#infaq_form").removeClass('hidden')
    }else{
        console.log("hide");
        $("#infaq_form").addClass('hidden')
    }
});

  // Datatables
  $(function() {
      $.extend( true, $.fn.dataTable.defaults, {
          autoWidth: false,
          dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
          language: {
              search: '<span>Filter:</span> _INPUT_',
              lengthMenu: '<span>Show:</span> _MENU_',
              paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
          },
          drawCallback: function () {
              $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
          },
          preDrawCallback: function() {
              $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
          }
      } );
  } );

  $.fn.dataTable.pipeline = function ( opts ) {
  var conf = $.extend( {
      pages: 5,     
      url: '',      
      data: null,
      method: 'GET' 
  }, opts );

  var cacheLower = -1;
  var cacheUpper = null;
  var cacheLastRequest = null;
  var cacheLastJson = null;

  return function ( request, drawCallback, settings ) {
      var ajax          = false;
      var requestStart  = request.start;
      var drawStart     = request.start;
      var requestLength = request.length;
      var requestEnd    = requestStart + requestLength;
       
      if ( settings.clearCache ) {
          ajax = true;
          settings.clearCache = false;
      }
      else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
          ajax = true;
      }
      else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
      ) {
          ajax = true;
      }
       
      cacheLastRequest = $.extend( true, {}, request );

      if ( ajax ) {
          if ( requestStart < cacheLower ) {
              requestStart = requestStart - (requestLength*(conf.pages-1));

              if ( requestStart < 0 ) {
                  requestStart = 0;
              }
          }
           
          cacheLower = requestStart;
          cacheUpper = requestStart + (requestLength * conf.pages);

          request.start = requestStart;
          request.length = requestLength*conf.pages;

          if ( $.isFunction ( conf.data ) ) {
              var d = conf.data( request );
              if ( d ) {
                  $.extend( request, d );
              }
          }
          else if ( $.isPlainObject( conf.data ) ) {
              $.extend( request, conf.data );
          }

          settings.jqXHR = $.ajax( {
              "type":     conf.method,
              "url":      conf.url,
              "data":     request,
              "dataType": "json",
              "cache":    false,
              "success":  function ( json ) {
                  cacheLastJson = $.extend(true, {}, json);

                  if ( cacheLower != drawStart ) {
                      json.data.splice( 0, drawStart-cacheLower );
                  }
                  if ( requestLength >= -1 ) {
                      json.data.splice( requestLength, json.data.length );
                  }
                   
                  drawCallback( json );
              }
          } );
      }
        else {
              json = $.extend( true, {}, cacheLastJson );
              json.draw = request.draw; 
              json.data.splice( 0, requestStart-cacheLower );
              json.data.splice( requestLength, json.data.length );
   
              drawCallback(json);
            }
        }
  };

  $.fn.dataTable.Api.register( 'clearPipeline()', function () {
      return this.iterator( 'table', function ( settings ) {
          settings.clearCache = true;
      } );
  } );

  // My Datatables
  var   urlDb   = "<?php echo base_url('permohonan_izin/show_permohonan_khusus')?>";
  var   totalClmn;
  var   tbl_vrKs;
  var   page    = '<?php echo $this->uri->segment(3);?>';
  $(document).ready(function() {
      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      tbl_vrKs  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 
          "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],

          "ajax": {
              "url": urlDb,
              "type": "POST",
              "data": function(param) {
                  param.page          = page
              }
          },
          "columnDefs": [ 
            { 
                "targets": [ 0 ], 
                "orderable": false 
            }, { 
                "targets": [ totalClmn-1 ], 
                "orderable": false 
            }
          ],
          "fnDrawCallback": function( oSettings ) {
             $('.tooltip-hover').tooltipster();
          }
      });
  })

  $(document).on('.click', 'link-action', function() {
    $.cookie("history-url", window.location.href);
    alert($.cookie("history-url"));
  })

  $(document).on('click', ".action", function() {
    var action    = $(this).attr("data-action");
    var permohonan= $(this).attr("data-permohonan");
    var aktivitas = $(this).attr("data-aktivitas");
    var decision  = $(this).attr("data-decision");

    var no_prmh   = $(this).closest("tr").find("td:eq(1)").text();
    var about     = " nomor permohonan "+no_prmh;

    if (action == "ctk_skrd") {
      $.ajax({
          url : "<?php echo base_url('permohonan_izin/ret_lihat_skrd')?>",
          dataType: "html",
          data: "permohonan="+permohonan+"&test=test",
          type: "POST",
          success: function(data){
            $('#showFileObj').load().html(data);
            $('#showFile').modal('show'); 
          }
      });   
    } else {     

      if (action == 'aprv') {
        var text_act  = "menyetujui";
      } else if (action == 'pndg') {
        var text_act  = "memending";
      } else if (action == 'rjct') {
        var text_act  = "menolak";
      } else if (action == 'vw') {
        var text_act  = "sudah melihat";
      }

      swal({
          title: "Apakah anda yakin?",
          text: 'Anda '+text_act+' '+about+'.',
          html: true,
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-warning',
          confirmButtonText: "Ya!",
          closeOnConfirm: false
      }, function () {
          $.ajax({
              url : "<?php echo base_url('permohonan_izin/akt_action')?>/"+action,
              dataType: "json",   //expect json to be returned
              data: "aktivitas="+aktivitas+"&permohonan="+permohonan+"&decision="+decision+"&page="+page,
              type: "POST",
              success: function(data){
                  tbl_vrKs.ajax.reload(null, false);
                  $('.jml_tugas').text(data);
              }
          })
          swal("Ya!", 'Anda '+text_act+' permohonan ini.', "success");
      })
    }
  })

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

  var htmlButton    = '';
  $('#datatables-ss').on( 'draw.dt', function () {
    $('.init-spin').each(function( index ) {
        var user        = $(this).data('user');
        var awk         = $(this).data('awk');
        var permohonan  = $(this).data('permohonan');
        var phn         = $(this).data('phn');
        var size        = $(this).data('size');
        var self        = this;
        function getButton(user, awk, permohonan, phn, size, html) {
            $(self).html(html);
        }
        getButtonAjax(user, awk, permohonan, phn, size, getButton);
    });
  });

  function getButtonAjax(user, awk, permohonan, phn, size, callback) {
    var only_detail = 1;
    var data = 'user='+user+'&awk='+awk+'&permohonan='+permohonan+'&phn='+phn+'&size='+size+'&only_detail='+only_detail;
    $.ajax({
        url : "<?php echo base_url('permohonan_izin/get_button_ajax')?>",
        dataType: "json",
        data: data,
        type: "POST",
        success: function(data){
            callback(user, awk, permohonan, phn, size, data);
        }
    });  
  }

</script>