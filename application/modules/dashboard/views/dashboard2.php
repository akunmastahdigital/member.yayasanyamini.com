<div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              Dashboard
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title">Dashboard</h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


      <div class="row">
          <div class="col-lg-6">
              <div class="card-box">
                  <h4 class="header-title m-t-0 m-b-20">Progress Ziswaf</h4>
                  <div class="text-center">
                    <div class="member-card">
                    <div class="thumb-lg member-thumb m-b-10 pull-right m-r-10" style="box-shadow:none">
                        <img src="
                        <?php 

                        if ($data_user != null){
                            echo $data_user['img'];
                        }else{
                            echo base_url()."berkas/core/images/users/avatar-3.jpg";
                        }
                        
                        ?>" class="img-thumbnail" alt="profile-image" style="width:100px;height:100px">
                        <!-- <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i> -->
                    </div>
                    <h4 class="m-b-10 text-left"><?php echo $result['nm_user'] ?></h4>

                    <div class="text-left m-t-10 m-b-10">
                        <!-- <p class="text-muted font-13"><strong>Kelas :</strong> <span class="m-l-15">1</span></p> -->

                        <p class="text-muted font-13"><strong>Cluster :</strong><span class="m-l-15"><?php echo $result['nama_kecamatan'] ?></span></p>

                        <p class="text-muted font-13"><strong>Target :</strong><span class="m-l-15 label label-danger"><?php echo "Rp " . number_format($result['jmlh_target'], 0,',','.') ?></span></p>

                        <p class="text-muted font-13"><strong>Peresentase Saat Ini :</strong></p>
                    </div>

                    <div class="progress progress-lg m-t-10 m-b-10">
                        <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo round($result['persentase']) > 100 ? "100" : round($result['persentase']) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($result['persentase']) > 100 ? "100" : round($result['persentase']) ?>%;">
                            <?php echo round($result['persentase']) ?>%
                        </div>
                    </div>
                    <hr>

                    <div class="row m-b-10">
                        <div class="col-md-5 font-13">
                        <h5><?php echo $result['total_ziswaf'] ?></h5>
                        Jmlh Transaksi
                        </div>
                        <div class="col-md-7 font-13">
                        <h5><?php echo "Rp " . number_format($result['jmlh_uang'], 0,',','.') ?></h5>
                        jmlh Uang
                        </div>
                    </div>

                    </div> <!-- end member-card -->

                </div> <!-- end card-box -->
              </div>
          </div><!-- end col -->

          <div class="col-lg-6">
              <div class="card-box">

                  <h4 class="header-title m-t-0">Info Muzakki Terkini</h4>
                 
                    <div class="table-responsive">
                    <table id="datatables-ss" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>No</th>
                            <!-- <th>Tanggal</th> -->
                            <!-- <th>Nama Muzakki</th> -->
                            <th>Nama Relawan</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <!-- <th class="center">Aksi</th> -->
                        </tr>
                        </thead>
                        <tbody>
                            <?php //echo $data_table ?>
                        </tbody>
                    </table>

                    </div> <!-- table-responsive -->
                    
              </div>
          </div><!-- end col -->

      </div>
      <!-- end row -->


      <?php $this->load->view('copyright');?>

  </div>
</div>
<style>
.dataTables_filter, .dataTables_info { display: none; }
</style>
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
  var   urlDb   = "<?php echo base_url('dashboard/show_permohonan_khusus')?>";
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
          "lengthChange": false,
          searching: false, paging: false, info: false,
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
