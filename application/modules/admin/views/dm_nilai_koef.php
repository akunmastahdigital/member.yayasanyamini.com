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
                  <!-- <button type="button" data-action="add" class="action btn btn-sm waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Retribusi Nilai Koef"> 
                    <i class="fa fa-plus"></i> Tambah Retribusi Nilai Koef
                  </button> -->

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>
                  <table id="datatables-ss" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nama Izin</th>
                          <th>Jenis Izin</th>
                          <th>Jenis Koef</th>
                          <th>Item Koef</th>
                          <th>Nilai Koef</th>
                          <th>Satuan</th>
                          <th>Status</th>
                          <!-- <th>Action</th> -->
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
                <h4 class="modal-title">Retribusi Nilai Koef</h4>
            </div>
            <div class="modal-body">
                <input name="id_jenis_izin" type="hidden">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_nama_izin" class="control-label">Nama Izin</label>
                            <select name="id_nama_izin" data-action="trigger-select" class="action selectpicker" data-style="btn-default" id="id_nama_izin" >
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="level_ke" class="control-label">Level</label>
                            <select name="level_ke" data-action="trigger-select-lv" class="action selectpicker" data-style="btn-default" id="level_ke" >
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="parent" class="control-label">Parent Izin</label>
                            <select name="parent" data-action="trigger-select-pr" class="action selectpicker" data-style="btn-default" id="parent" >
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="jenis_izin" class="control-label">Nama Jenis Izin</label>
                            <input name="jenis_izin" type="text" class="form-control" id="jenis_izin" placeholder="Contoh : Perorangan">
                        </div>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="teks_menu" class="control-label">Teks Menu di Frontend</label>
                            <input name="teks_menu" type="text" class="form-control" id="teks_menu" placeholder="Contoh : Perorangan">
                        </div>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="url" class="control-label">URL Akses di Frontend</label>
                            <input name="url" type="text" class="form-control" id="url" placeholder="permohonan/izin" value="permohonan/izin">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="param" class="control-label">Param</label>
                            <input name="param" type="text" class="form-control" id="param" readonly>
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
  var   urlDb   = "<?php echo base_url('admin/show_dm_nilai_koef')?>";
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
      $('#form-field').children('.modal').find('.modal-title').text("Tambah Retribusi Nilai Koef");
      $('#form-field').children('.modal').modal('show');
        
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/dm_nilai_koef_action')?>/"+"detail",
        dataType: "json",
        data: "id_ret_nilai_koef="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_ret_nilai_koef"]').val(data.id_ret_nilai_koef);
          $('#form-field').find('input[name="id_ret_jenis_koef"]').val(data.id_ret_jenis_koef);
          $('#form-field').find('input[name="item_koef"]').val(data.item_koef);
          $('#form-field').find('input[name="nilai_koef"]').val(data.nilai_koef);
          $('#form-field').find('input[name="id_jenis_izin"]').val(data.id_jenis_izin);
          $('#form-field').find('input[name="satuan"]').val(data.satuan);
        }
      })
      $('#form-field').children('.modal').find('.modal-title').text("Ubah Retribusi Nilai Koef");
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
            var id_ret_nilai_koef= $(this).attr('data-id_ret_nilai_koef');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/dm_nilai_koef_action')?>/"+action,
              dataType: "json",
              data: 'id_ret_nilai_koef='+id_ret_nilai_koef+'&status='+status,
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
            url : "<?php echo base_url('admin/dm_nilai_koef_action')?>/"+mode,
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