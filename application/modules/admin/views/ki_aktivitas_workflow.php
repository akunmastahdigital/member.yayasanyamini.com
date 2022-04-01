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
          <div class="col-md-4 col-md-offset-4">
              <div class="panel">
                  <div class="panel-body">
                      <div class="input-group m-t-10">
                          <input type="email" id="kd_workflow" name="kd_workflow" class="form-control" placeholder="Masukan kode workflow" value="<?php echo $this->input->get('kd_workflow') ? $this->input->get('kd_workflow') : '';?>">
                          <span class="input-group-btn">
                          <button type="button" data-action="src-wkflw" class="action btn waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                          </span>
                      </div>                  
                  </div>
              </div>
          </div>      
      </div>      
      <div class="row" id="page-ap" style="display: block;">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title nm_workflow">
                    <b><?php echo $title;?></b> 
                  </h4>
                  <button type="button" data-action="add-ak" class="action btn btn-sm waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Syarat Izin"> 
                    <i class="fa fa-plus"></i> Tambah Aktivitas
                  </button>
                  <button type="button" data-action="order" class="m-r-10 action btn btn-sm waves-effect btn-inverse m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Syarat Izin"> 
                    <i class="fa fa-wrench"></i> Urutkan Aktivitas
                  </button>                  

                  <p class="text-muted font-13 m-b-30 jenis_izin">
                      <?php echo $title;?>
                  </p>
                  <table id="datatables-ss" class="table table-bordered">
                    <thead>
                      <tr>
                          <th>ID</th>
                          <th>Kode Workflow</th>
                          <th>Nama Workflow</th>
                          <th>Aktivitas</th>
                          <th>Status</th>
                          <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>     
              </div>
          </div>
      </div>

      <div class="row" id="page-ao" style="display: none;">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title nm_workflow">
                    <b><?php echo $title;?></b> 
                  </h4>
                  <button type="button" id="sv_order" data-id="" data-action="sv_order" class="action btn btn-sm waves-effect btn-info m-b-5 tooltip-hover pull-right submit btn-modal" title="Simpan Perubahan"> 
                    <i class="fa fa-floppy-o"></i> Simpan
                  </button>   
                  <button type="button" data-action="order-cancel" class="m-r-10 action btn btn-sm waves-effect btn-danger m-b-5 tooltip-hover pull-right submit btn-modal" title="Cancel Perubahan"> 
                    <i class="fa fa-mail-reply-all"></i> Cancel
                  </button>                

                  <p class="text-muted font-13 m-b-30 jenis_izin">
                      <?php echo $title;?>
                  </p>
                  <div class="row m-t-20" style="background-color: #f3f3f3;">
                      <div class="custom-dd-empty dd" id="nestable_list_2" style="margin:10px">
                          <input type="hidden" id="nestable_list_2_output">
                          <ol class="dd-list">
                              <!-- Contents -->
                          </ol>
                      </div>     
                  </div>     
              </div>
          </div>
      </div>  

  <?php $this->load->view('copyright'); ?>

  </div>
</div>

<form class="form-field" id="form-field-ak">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Aktivitas</h4>
            </div>
            <div class="modal-body">
                <input name="id_aktivitas_workflow" type="hidden">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nm_aktivitas_workflow" class="control-label">Nama Aktivitas Workflow</label>
                            <input name="nm_aktivitas_workflow" type="text" class="form-control" id="nm_aktivitas_workflow">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="id_aktivitas" class="control-label">Jenis Aktivitas</label>
                            <select name="id_aktivitas" class="selectpicker" data-style="btn-default" id="id_aktivitas" >
                                <?php echo $SL_aktivitas;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="id_perusahaan_bio_cfg" type="hidden">
                            <label for="perusahaan_cfg" class="control-label">Akses Bio Perusahaan</label>
                            <select name="perusahaan_cfg" class="selectpicker" data-style="btn-default" id="perusahaan_cfg" >
                                <?php echo $opt_akses;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="id_rekam_berkas_cfg" type="hidden">
                            <label for="berkas_cfg" class="control-label">Akses Rekam Berkas</label>
                            <select name="berkas_cfg" class="selectpicker" data-style="btn-default" id="berkas_cfg" >
                                <?php echo $opt_akses;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="id_syarat_izin_cfg" type="hidden">
                            <label for="syarat_cfg" class="control-label">Akses Syarat Izin</label>
                            <select name="syarat_cfg" class="selectpicker" data-style="btn-default" id="syarat_cfg" >
                                <?php echo $opt_akses;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="button" data-action="simpan-ak" class="action btn btn-info waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
  </div>
</form>

<form class="form-field" id="form-field-pj">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Penanggung Jawab</h4>
            </div>
            <div class="modal-body">
                <input name="id_aktivitas_workflow" type="hidden">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_user" class="control-label">User</label>
                            <div class="input-group">
                              <select name="id_user[]" class="selectpicker form-control" multiple data-selected-text-format="count > 1" data-live-search="true" data-style="btn-default" id="id_user">
                              </select>
                              <span class="input-group-btn">
                                <button type="button" data-action="add" class="action btn waves-effect waves-light btn-primary"><i class="fa fa-paper-plane-o"></i></button>
                              </span>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
                <!-- <div class="row"> -->
                    <div class="col-md-8">
                      <table id="datatables2-ss" class="table table-bordered">
                        <thead>
                          <tr>
                              <th>ID</th>
                              <th>Nama User</th>
                              <th>Jabatan</th>
                              <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>                             
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <!-- <button type="button" data-action="simpan" class="action btn btn-info waves-effect waves-light">Simpan</button> -->
            </div>
        </div>
    </div>
  </div>
</form>
<form class="form-field" id="form-field-ad">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Decision</h4>
            </div>
            <div class="modal-body">
                <input name="id_aktivitas_workflow" type="hidden">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                              <label for="nm_workflow_decision" class="control-label">Nama Workflow Decision</label>
                              <input name="nm_workflow_decision" type="text" class="form-control" id="nm_workflow_decision" placeholder="Contoh : Persetujuan Kabid Teknis - Approve">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="direct_id_aktivitas_workflow" class="control-label">Aksi Selanjutnya</label>
                            <select name="direct_id_aktivitas_workflow" class="selectpicker form-control" data-style="btn-default" id="direct_id_aktivitas_workflow">
                            </select>
                        </div>
                    </div>                      
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_decision" class="control-label">Buttons</label>
                            <div class="input-group">
                                <select name="id_decision" class="selectpicker form-control" data-style="btn-default" id="id_decision">
                                </select>                                
                                <span class="input-group-btn">
                                <button type="button" data-action="add" class="action btn waves-effect waves-light btn-primary"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <table id="datatables3-ss" class="table table-bordered">
                        <thead>
                          <tr>
                              <th>ID</th>
                              <th>Kode Workflow Decision</th>
                              <th>Nama Workflow Decision</th>
                              <th>Aksi Selanjutnya</th>
                              <th>Decision</th>
                              <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>                             
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
  </div>
</form>

<style type="text/css">
  .dd3-handle {
    background : white !important;
  }
  .dd3-content {
    background : white !important;
  }
</style>

<!-- Datatables -->
<script src="<?php echo base_url()?>berkas/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.colVis.js"></script>

<!--Nestable js-->
<script src="<?php echo base_url()?>berkas/plugins/nestable/jquery.nestable.js"></script>

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


  var kd_workflow= "<?php echo $this->input->get('kd_workflow') ? $this->input->get('kd_workflow') : null;?>";
  var aktivitas_workflow = null;

  // My Datatables
  var   urlDb   = "<?php echo base_url('admin/show_ki_aktivitas_workflow')?>";
  var   totalClmn;
  var   table1;
  var   table2;

  var set_nestable   = function () { 
            $.ajax({
                url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+"get_nest",
                dataType: "json",
                data: "kd_workflow="+kd_workflow,
                type: "POST",
                success: function(data) {
                  $('#page-ao').find('.dd-list').html(data.content);
                  $('.nm_workflow').html(data.nm_workflow);
                  $('#sv_order').attr('data-id', data.id_workflow);
                }
              })
            };  

  $(document).ready(function() {    

      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      table1  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lrf>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "initComplete": set_nestable,

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb+"/table1",
              "type": "POST",
              "data": function(param) {
                  param.kd_workflow    = kd_workflow;
              }              
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

      totalClmn2 = parseInt($("#datatables2-ss").find('tr:nth-child(1) th').length);
      table2  = $('#datatables2-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lrf>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          // "initComplete": set_title,
          "pageLength": 5,
          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb+"/table2",
              "type": "POST",
              "data": function(param) {
                  param.aktivitas_workflow    = aktivitas_workflow;
              }              
          },
          "columnDefs": [ 
            { 
                "targets": [ 0 ], 
                "orderable": false
            }, { 
                "targets": [ totalClmn2-1 ], 
                "orderable": false 
            }
          ],
          "fnDrawCallback": function( oSettings ) {
             $('.tooltip-hover').tooltipster();
          }
      }); 

      totalClmn3 = parseInt($("#datatables3-ss").find('tr:nth-child(1) th').length);
      table3  = $('#datatables3-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lrf>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          // "initComplete": set_title,
          "pageLength": 5,
          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb+"/table3",
              "type": "POST",
              "data": function(param) {
                  param.aktivitas_workflow    = aktivitas_workflow;
              }              
          },
          "columnDefs": [ 
            { 
                "targets": [ 0 ], 
                "orderable": false
            }, { 
                "targets": [ totalClmn2-1 ], 
                "orderable": false 
            }
          ],
          "fnDrawCallback": function( oSettings ) {
             $('.tooltip-hover').tooltipster();
          }
      });            
  });

  function refresh_pj(data) {
    var my_data   = data;
    $.ajax({
      url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+"pj",
      dataType: "json",
      data: "id_aktivitas_workflow="+data,
      type: "POST",
      success: function(data) {
        $('input[name="id_aktivitas_workflow"]').val(my_data);
        $('#id_user').html(data.select).selectpicker("refresh");
        aktivitas_workflow   = my_data;
        table2.ajax.reload(null, false);
      }
    })    
  }

  function refresh_ad(data) {
    var my_data   = data;
    $.ajax({
      url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+"ad",
      dataType: "json",
      data: "id_aktivitas_workflow="+data,
      type: "POST",
      success: function(data) {
        $('input[name="id_aktivitas_workflow"]').val(my_data);
        $('select[name="direct_id_aktivitas_workflow"]').html(data.select_wk).selectpicker("refresh");
        $('select[name="id_decision"]').html(data.select_ad).selectpicker("refresh");
        aktivitas_workflow   = my_data;
        table3.ajax.reload(null, false);
      }
    })    
  }  

  var mode;
  function show_modal(data) {

    if (mode == "pj") {
      refresh_pj(data);
      $('#form-field-pj').children('.modal').find('.modal-title').text("Atur Penanggung Jawab");
      $('#form-field-pj').children('.modal').modal('show');
    } else if (mode == "ad") {
      refresh_ad(data);
      $('#form-field-ad').children('.modal').find('.modal-title').text("Atur Decision");
      $('#form-field-ad').children('.modal').modal('show');
    } else if (mode == "add-ak") {
      $('#form-field-ak').children('.modal').find('.modal-title').text("Tambah Aktivitas");
      $('#form-field-ak').children('.modal').modal('show');
    } else if (mode == "edit-ak") {
      $.ajax({
        url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+"detail-ak",
        dataType: "json",
        data: "id_aktivitas_workflow="+data,
        type: "POST",
        success: function(data) {
          $('#form-field-ak').find('input[name="id_aktivitas_workflow"]').val(data.id_aktivitas_workflow);
          $('#form-field-ak').find('input[name="nm_aktivitas_workflow"]').val(data.nm_aktivitas_workflow);
          $('#form-field-ak').find('select[name="id_aktivitas"]').html(data.id_aktivitas).selectpicker("refresh");
          $('#form-field-ak').find('select[name="perusahaan_cfg"]').html(data.pcfg).selectpicker("refresh");
          $('#form-field-ak').find('select[name="berkas_cfg"]').html(data.rcfg).selectpicker("refresh");
          $('#form-field-ak').find('select[name="syarat_cfg"]').html(data.scfg).selectpicker("refresh");
          $('#form-field-ak').find('input[name="id_perusahaan_bio_cfg"]').val(data.id_perusahaan_bio_cfg);
          $('#form-field-ak').find('input[name="id_rekam_berkas_cfg"]').val(data.id_rekam_berkas_cfg);
          $('#form-field-ak').find('input[name="id_syarat_izin_cfg"]').val(data.id_syarat_izin_cfg);
        }
      })
      $('#form-field-ak').children('.modal').find('.modal-title').text("Ubah Aktivitas");
      $('#form-field-ak').children('.modal').modal('show');
    }

    id_aktivitas_workflow   = data;
  }

  function reset_default() {
    $('.form-field')[0].reset();
    mode  = undefined;
    table1.ajax.reload(set_nestable, null, false);
    $('.form-field').children('.modal').modal('hide');
    $('#page-ap').css('display', "block");
    $('#page-ao').css('display', "none");
  }

  $(document).on('click', ".action", function() {
        var self        = this;

        var action  = $(this).attr('data-action');

        if (action == "atur") {
          var id_aktivitas_workflow = $(this).attr('data-id');
          var atur        = $(this).attr('data-atur');

          mode  = atur;
          show_modal(id_aktivitas_workflow);           
        } else if (action == "add") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm  = $('#form-field-'+mode).serialize();

          var id_aktivitas_workflow   = $('input[name="id_aktivitas_workflow"]').val();

          if (mode == "pj") {
            var text = "User";
          } else if (mode == "ad") {
            var text = "Decision";
          }

          $.ajax({
            url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+action+"-"+mode,
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: text+' telah ditetapkan',
                  type: "success",
                });
                // table2.ajax.reload(null, false);
                if (mode == "pj") {
                  table2.ajax.reload(null, false);
                  refresh_pj(id_aktivitas_workflow);
                } else if (mode == "ad") {
                  table3.ajax.reload(null, false);
                  refresh_ad(id_aktivitas_workflow);
                }                 
            }
          })
        } else if (action == "del") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var id_aktivitas_workflow   = $('input[name="id_aktivitas_workflow"]').val();

          if (mode == "pj") {
            var dataForm  = "id_user=" + $(this).attr('data-id');
            var text = "User";
          } else if (mode == "ad") {
            var dataForm  = "id_workflow_decision=" + $(this).attr('data-id');
            var text = "Decision";
          }


          $.ajax({
            url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+action+"-"+mode,
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: text+' telah ditetapkan',
                  type: "success",
                });
                if (mode == "pj") {
                  table2.ajax.reload(null, false);
                  refresh_pj(id_aktivitas_workflow);
                } else if (mode == "ad") {
                  table3.ajax.reload(null, false);
                  refresh_ad(id_aktivitas_workflow);
                }                
            }
          })
        } else if (action == "src-wkflw") {
          kd_workflow   = $('#kd_workflow').val();
          window.history.pushState(null, null, '<?php echo base_url(uri_string());?>'+'?kd_workflow='+kd_workflow);
          table1.ajax.reload(set_nestable, null, false);
        } else if (action == "order") {
          $('#page-ap').css('display', "none");
          $('#page-ao').css('display', "block");
        } else if (action == "order-cancel") {
          $('#page-ap').css('display', "block");
          $('#page-ao').css('display', "none");
          reset_default();
        } else if (action == "sv_order") {
          var data      = $('#nestable_list_2_output').val();
          var id_workflow= $(this).attr('data-id');
          var text      = "Urutan";
          
          var dataForm  = "id_workflow="+id_workflow+"&data="+data;

          $.ajax({
            url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+"sv_order",
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: text+' telah ditetapkan',
                  type: "success",
                });
                reset_default();
            }
          })          
        } else if (action == "add-ak") {
          mode  = "add-ak";
          show_modal();
        } else if (action == "edit-ak") {
          mode    = "edit-ak";
          var data= $(this).attr('data-id');
          show_modal(data);
        } else if (action == "simpan-ak") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm    = $('#form-field-ak').serialize()+"&kd_workflow="+kd_workflow;

          $.ajax({
            url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+mode,
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
        } else if (action == "aktif-ak") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
            var aktivitas_workflow= $(this).attr('data-id_aktivitas_workflow');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/ki_aktivitas_workflow_action')?>/"+action,
              dataType: "json",
              data: 'aktivitas_workflow='+aktivitas_workflow+'&status='+status,
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
                reset_default();
              }
            })
        } 
    })

  	var Nestable = function () {

	    var updateOutput = function (e) {
	        var list = e.length ? e : $(e.target),
	            output = list.data('output');
	        if (window.JSON) {
	            output.val(window.JSON.stringify(list.nestable('serialize')));
	        } else {
	            output.val('JSON browser support required for this demo.');
	        }
	    };

	    $('#nestable_list_2').nestable({
	    	maxDepth 	: 1
	    }).on('change', updateOutput);

	    // output initial serialised data
	    updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));

	  }();

</script>

