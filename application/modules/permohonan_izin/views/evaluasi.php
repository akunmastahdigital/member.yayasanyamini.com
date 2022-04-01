<div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              <?php echo ucfirst((string)$page);?>
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title"><?php echo ucfirst((string)$page);?></h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><b>Data yang belum di <?php echo $page;?></b> 
                      <span class="label label-danger jml_tugas"><?php echo $jml_tugas;?></span>
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Dibawah ini adalah list data yang belum di <?php echo $page;?>
                  </p>

                  <form id="formS" method="POST" action="<?php echo base_url('permohonan_izin/verifikasi');?>">
                  <table id="datatables-ss" class="table table-striped table-bordered">
                      <thead>
                      <tr>
                          <th>ID</th>
                          <th>No Ziswaf</th>
                          <th>Tanggal</th>
                          <th>Nama Muzakki</th>
                          <th>Nama Relawan</th>
                          <th>Jenis</th>
                          <th>Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>

              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><b>Data yang sudah di <?php echo $page;?></b> 
                  <button type="button" class="pull-right btn btn-success btn-sm">Export Excel</button>&nbsp; <button type="button" class="pull-right btn btn-danger btn-sm m-r-5">Export PDF</button>
                      <span class="label label-danger jml_tugas"><?php echo $jml_done;?></span>
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      Dibawah ini adalah history data yang sudah <?php echo $page;?>
                  </p>

                  <table id="datatables-ss1" class="table table-striped table-bordered">
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
                    </tbody>
                  </table>
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
<!-- Datatables -->
<script src="<?php echo base_url()?>berkas/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
  // Datatables
  $(function() {
      $.extend( true, $.fn.dataTable.defaults, {
          autoWidth: false,
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
  var   urlDb   = "<?php echo base_url('permohonan_izin/show_permohonan')?>";
  var   totalClmn;
  var   tbl_vrKs;
  var   page    = '<?php echo $this->uri->segment(3);?>';
  $(document).ready(function() {
      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      tbl_vrKs  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',
          "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

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

  //------------------------------------------------- 
  // Datatables for history

  // My Datatables for history
  var   urlDb1   = "<?php echo base_url('permohonan_izin/show_permohonan_khusus')?>";
  var   totalClmn1;
  var   tbl_vrKs2;
  var   page2    = '<?php echo $this->uri->segment(3);?>';
  $(document).ready(function() {
      totalClmn1 = parseInt($("#datatables-ss1").find('tr:nth-child(1) th').length);
      tbl_vrKs2  = $('#datatables-ss1').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 
          "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],

          "ajax": {
              "url": urlDb1,
              "type": "POST",
              "data": function(param) {
                  param.page2          = page2
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
      } else if (action == 'hps') {
        var text_act  = "yakin ingin menghapus";
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