<style type="text/css">
  .flleft{
    float: left;
  } 
  .flright{
    float: right;
  } 
  .width50{
    width: 50%;
  }
</style>

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
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title">
                    <b><?php echo $title;?></b> 
                  </h4>
                  <button type="button" data-action="add" class="action btn btn-sm waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Retribusi Jenis Tarif"> 
                    <i class="fa fa-plus"></i> Tambah Retribusi Jenis Tarif
                  </button>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>
                  <table id="datatables-ss" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                          <th>ID</th>
                          <th>Item Group</th>
                          <th>Item</th>
                          <th>Nilai Tarif</th>
                          <th>Kode</th>
                          <th>Satuan</th>
                          <th>Status</th>
                          <th>Action</th>
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

<form id="form-field">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Retribusi Jenis Tarif</h4>
            </div>
            <div class="modal-body">
                <input name="id_ret_jenis_tarif" type="hidden">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item_group" class="control-label">Item Group</label>
                            <input name="item_group" type="text" class="form-control" id="item_group">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item" class="control-label">Item</label>
                            <input name="item" type="text" class="form-control" id="item">
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nilai_tarif" class="control-label">Nilai Tarif</label>
                            <input name="nilai_tarif" type="text" class="form-control" id="nilai_tarif">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 width50 flleft">
                        <div class="form-group">
                            <label for="kode" class="control-label">Kode</label>
                            <input name="kode" type="text" class="form-control" id="kode">
                        </div>
                    </div>
                     <div class="col-md-6 width50 flright">
                        <div class="form-group">
                            <label for="satuan" class="control-label">Satuan</label>
                            <input name="satuan" type="text" class="form-control" id="satuan">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="button" data-action="simpan" class="action btn btn-info waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
  </div>
</form>

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
  var   urlDb   = "<?php echo base_url('admin/show_dm_rettarif')?>";
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
                "orderable": true
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
      $('#form-field').children('.modal').find('.modal-title').text("Tambah Retribusi Jenis Tarif");
      $('#form-field').children('.modal').modal('show');
        
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/dm_rettarif_action')?>/"+"detail",
        dataType: "json",
        data: "id_ret_jenis_tarif="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_ret_jenis_tarif"]').val(data.id_ret_jenis_tarif);
          $('#form-field').find('input[name="item_group"]').val(data.item_group);
          $('#form-field').find('input[name="item"]').val(data.item);
          $('#form-field').find('input[name="nilai_tarif"]').val(data.nilai_tarif);
          $('#form-field').find('input[name="kode"]').val(data.kode);
          $('#form-field').find('input[name="satuan"]').val(data.satuan);
        }
      })
      $('#form-field').children('.modal').find('.modal-title').text("Ubah Retribusi Jenis Tarif");
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

        if (action == "aktif") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
            var id_ret_jenis_tarif= $(this).attr('data-id_ret_jenis_tarif');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/dm_rettarif_action')?>/"+action,
              dataType: "json",
              data: 'id_ret_jenis_tarif='+id_ret_jenis_tarif+'&status='+status,
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
              }
            })
        } else if (action == "add") {
          mode  = "add";
          show_modal();
        } else if (action == "edit") {
          mode  = "edit";
          var data  = $(this).attr('data-id');
          show_modal(data);
        } else if (action == "simpan") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm    = $('#form-field').serialize();

          $.ajax({
            url : "<?php echo base_url('admin/dm_rettarif_action')?>/"+mode,
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: nama+' telah disimpan',
                  type: "success",
                });
                reset_default();
            }
          })
        }
    })

</script>