<div class="wrapper">
  <div class="container">

      <!-- Page-Title -->
      <div class="row">
          <div class="col-sm-12">
              <div class="page-title-box">
                  <div class="btn-group pull-right">
                      <ol class="breadcrumb hide-phone p-0 m-0">
                          <li class="active">
                              <?php echo $title;?>
                          </li>
                      </ol>
                  </div>
                  <h4 class="page-title"><?php echo $menu;?></h4>
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><b>User Pemohon Belum di Verifikasi</b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      User Pemohon Belum di Verifikasi
                  </p>

                  <table id="datatables-ss" class="table table-striped table-bordered">
                      <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>Aksi</th>
                      </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>


      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><b>User Pemohon Sudah di Verifikasi</b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      User Pemohon Telah di Verifikasi
                  </p>

                  <table id="datatables-ss1" class="table table-striped table-bordered">
                      <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>Aksi</th>
                      </tr>
                      </thead>


                  </table>
              </div>
          </div>
      </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>

<!-- Datatables -->
<script src="<?php echo base_url()?>berkas/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.bootstrap.js"></script>

<script type="text/javascript">
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
  var   urlDb   = "<?php echo base_url('admin/showPemohonNonVerification')?>";
  var   totalClmn;
  var   table1;
  $(document).ready(function() {
      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      table1  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb,
              "type": "POST"
          },
          "columnDefs": [ 
            { 
                "targets": [ 0 ], 
                "orderable": false 
            }, { 
                "targets": [ totalClmn-1 ], 
                "orderable": false 
            }, { 
                "targets": [ totalClmn-2 ], 
                "orderable": false 
            }
          ],
          "fnDrawCallback": function( oSettings ) {
             $('.tooltip-hover').tooltipster();
          }
      });
  });

  var mode;
  function show_modal(data) {

    if (mode == "add") {
      $('#form-field').children('.modal').find('.modal-title').text("Tambah User BackOffice");
      $('#form-field').children('.modal').modal('show');
        
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/userbo_action')?>/"+"detail",
        dataType: "json",
        data: "id_user="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_user"]').val(data.id_user);
          $('#form-field').find('input[name="id_personil"]').val(data.id_personil);
          $('#form-field').find('input[name="nm_user"]').val(data.nm_user);
          $('#form-field').find('input[name="nip"]').val(data.nip);
          $('#form-field').find('select[name="id_role"]').html(data.sl_role);
          $('#form-field').find('select[name="id_role"]').selectpicker("refresh");
          $('#form-field').find('input[name="username"]').val(data.username);
          $('#form-field').find('input[name="sandi_user"]').val(data.sandi_user);
          $('#form-field').find('input[name="keterangan"]').val(data.keterangan);
        }
      })
      $('#form-field').children('.modal').find('.modal-title').text("Ubah User BackOffice");
      $('#form-field').children('.modal').modal('show');
        
    }
  }

  function reset_default() {
    $('#form-field')[0].reset();
    mode  = undefined;
    table1.ajax.reload(null,false);
    $('#form-field').children('.modal').modal('hide');
  }

  $(document).on('click', ".action", function() {
        var self        = this;

        var action  = $(this).attr('data-action');
        var id_user_fe     = $(this).attr('data-id_user_fe');
        var nama           = $(this).closest("tr").find("td:eq(1)").text();

        if (action == "aktif") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
            var id_user_fe     = $(this).attr('data-id_user_fe');
            var nama           = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/userfe_action')?>/"+action,
              dataType: "json",
              data: 'id_user_fe='+id_user_fe+'&status='+status,
              type: "POST",
              success: function(data) {
                if (data.status == 1) {
                  var text    = 'aktifkan';

                } else if (data.status == 0) {
                  var text    = 'nonaktifkan';

                }
                  swal({
                    title: "Berhasil!",
                    text: nama+' telah di'+text,
                    type: "success",
                  });

                   table1.ajax.reload(null,false);
                   table2.ajax.reload(null,false);
              }
            })
        } else if(action == "hapus"){
          
        }
    })

</script>


<script type="text/javascript">
  // Datatables
 

  // My Datatables
  var   urlDb1   = "<?php echo base_url('admin/showPemohonVerification')?>";
  var   totalClmn;
  var   table2;
  $(document).ready(function() {
      totalClmn = parseInt($("#datatables-ss1").find('tr:nth-child(1) th').length);
      table2  = $('#datatables-ss1').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb1,
              "type": "POST"
          },
          "columnDefs": [ 
            { 
                "targets": [ 0 ], 
                "orderable": false 
            }, { 
                "targets": [ totalClmn-1 ], 
                "orderable": false 
            }, { 
                "targets": [ totalClmn-2 ], 
                "orderable": false 
            }
          ],
          "fnDrawCallback": function( oSettings ) {
             $('.tooltip-hover').tooltipster();
          }
      });
  });

  var mode;
 /* function show_modal(data) {

    if (mode == "add") {
      $('#form-field').children('.modal').find('.modal-title').text("Tambah User BackOffice");
      $('#form-field').children('.modal').modal('show');
        
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/userbo_action')?>/"+"detail",
        dataType: "json",
        data: "id_user="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_user"]').val(data.id_user);
          $('#form-field').find('input[name="id_personil"]').val(data.id_personil);
          $('#form-field').find('input[name="nm_user"]').val(data.nm_user);
          $('#form-field').find('input[name="nip"]').val(data.nip);
          $('#form-field').find('select[name="id_role"]').html(data.sl_role);
          $('#form-field').find('select[name="id_role"]').selectpicker("refresh");
          $('#form-field').find('input[name="username"]').val(data.username);
          $('#form-field').find('input[name="sandi_user"]').val(data.sandi_user);
          $('#form-field').find('input[name="keterangan"]').val(data.keterangan);
        }
      })
      $('#form-field').children('.modal').find('.modal-title').text("Ubah User BackOffice");
      $('#form-field').children('.modal').modal('show');
        
    }
  }*/

  function reset_default() {
    $('#form-field')[0].reset();
    mode  = undefined;
    table1.ajax.reload(null,false);
    $('#form-field').children('.modal').modal('hide');
  }

  $(document).on('click', ".action", function() {
        var self        = this;

        var action  = $(this).attr('data-action');
        var id_user_fe     = $(this).attr('data-id_user_fe');
        var nama           = $(this).closest("tr").find("td:eq(1)").text();
        if (action == "aktif") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
           

            $.ajax({
              url : "<?php echo base_url('admin/userfe_action')?>/"+action,
              dataType: "json",
              data: 'id_user_fe='+id_user_fe+'&status='+status,
              type: "POST",
              success: function(data) {
                if (data.status == 1) {
                  var text    = 'aktifkan';

                } else if (data.status == 0) {
                  var text    = 'nonaktifkan';

                }
                  swal({
                    title: "Berhasil!",
                    text: nama+' telah di'+text,
                    type: "success",
                  });

                   table1.ajax.reload(null,false);
              }
            })
        } if (action == "del") {
               swal({
                  title: "Apakah anda yakin?",
                  text: 'Anda Akan Menghapus User '+id_user_fe,
                  html: true,
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: 'btn-warning',
                  confirmButtonText: "Ya!",
                  closeOnConfirm: false
                } , function () {
                     $.ajax({
                         url : "<?php echo base_url('admin/userfe_action')?>/"+action,
                         dataType: "json",   //expect json to be returned
                         data: "id_user_fe="+id_user_fe,
                         type: "POST",
                         success: function(data){
                             table1.ajax.reload(null, false);
                         }
                     })
                  swal("Ya!", 'Anda Menghapus User Ini.', "success");
              });
        }
    })

</script>

