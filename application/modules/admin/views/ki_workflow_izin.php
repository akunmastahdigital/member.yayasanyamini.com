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
          <div class="col-md-3">
              <div class="panel">
                  <div class="panel-heading head-border">
                      <h4 class="header-title">Nama Izin</h4>
                  </div>
                  <div class="panel-body" style="overflow:auto">
                    <?php echo $list_menu;?>
                  </div>
              </div>
          </div>      
          <div class="col-sm-9">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title nama_izin">
                    <b><?php echo $title;?></b> 
                  </h4>
                  <button type="button" data-action="add" class="action btn btn-sm waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Syarat Izin"> 
                    <i class="fa fa-plus"></i> Tambah Mode Workflow
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
                          <th>Keterangan</th>
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

  <?php $this->load->view('copyright'); ?>

  </div>
</div>

<form id="form-field">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Workflow Izin</h4>
            </div>
            <div class="modal-body">
                <input name="id_workflow" type="hidden">
                <input name="id_jenis_izin" type="hidden">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kd_workflow" class="control-label">Kode Workflow</label>
                            <input name="kd_workflow" type="text" class="form-control" id="kd_workflow">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nm_workflow" class="control-label">Nama Workflow</label>
                            <input name="nm_workflow" type="text" class="form-control" id="nama_syarat">
                        </div>
                    </div>                    
                </div>
                <div class="row m-b-20">
                    <div class="col-md-12">
                        <b for="keterangan">Keterangan</b>
                        <textarea id="keterangan" name="keterangan" class="form-control" maxlength="225" rows="3" placeholder="Tuliskan keterangan anda kurang dari 225 character"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                      <h4>Aktivitas Workflow</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="btn-switch btn-switch-primary">
                            <input name="aktif" type="checkbox" id="aktif" value="1">
                            <label for="aktif" class="btn btn-rounded btn-primary waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Aktifkan</strong>
                            </label>
                        </div> 
                        &nbsp;
                        <input name="kd_workflow" type="hidden">
                        <button type="button" data-action="edit-akw" class="action btn btn-rounded btn-teal waves-effect waves-light"> 
                            <i class="fa fa-pencil">&nbsp;</i> Ubah Aktivitas
                        </button>
                    </div>                    
                </div>  
                <div class="row m-t-20 text-center" style="background-color: #f3f3f3;">
					          <div class="custom-dd-empty dd text-center " id="nestable_list_2" style="margin:10px">
                        <ol class="dd-list" id="aktivitas_workflow">
                        </ol>
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

<style type="text/css">
  .dd3-handle {
  	background : white !important;
  }
  .dd3-content {
  	background : white !important;
  }

  .collapsibleList li{
    list-style-image : url('<?php echo base_url();?>berkas/plugins/collapsiblelists/img/button.png');
    cursor : auto;
  }

  li.collapsibleListOpen{
    list-style-image : url('<?php echo base_url();?>berkas/plugins/collapsiblelists/img/button-open.png');
    cursor : pointer;
  }

  li.collapsibleListClosed{
    list-style-image : url('<?php echo base_url();?>berkas/plugins/collapsiblelists/img/button-closed.png');
    cursor : pointer;
  }

  ul.collapsibleList {
    padding-left:15px;
  }
</style>


<script src="<?php echo base_url()?>berkas/plugins/collapsiblelists/CollapsibleLists.js"></script>
<script type="text/javascript">
  CollapsibleLists.apply();
</script>

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

  var set_title   = function () { 
            $.ajax({
                url : "<?php echo base_url('admin/ki_syarat_izin_action')?>/"+"get_jenis_izin",
                dataType: "json",
                data: "jenis_izin="+jenis_izin,
                type: "POST",
                success: function(data) {
                  $('.nama_izin').text(data.nama_izin);
                  $('.jenis_izin').text(data.jenis_izin);
                }
              })
            };  


  var jenis_izin;
  $(document).on('click', ".get-syarat", function() {
    jenis_izin   = $(this).attr('data-izin');
    kd_jenis_izin= $(this).attr('data-kd_izin');
    table1.ajax.reload(set_title, null, false);
  })

  // My Datatables
  var   urlDb   = "<?php echo base_url('admin/show_ki_workflow_izin')?>";
  var   totalClmn;
  var   table1;

  $(document).ready(function() {

      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      table1  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lrf>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          // "initComplete": set_title,

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb,
              "type": "POST",
              "data": function(param) {
                  param.jenis_izin    = jenis_izin;
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
  });

  var mode;
  function show_modal(data) {

    if (mode == "add") {
      $('#form-field').find('input[name="id_jenis_izin"]').val(jenis_izin);
      $('#form-field').children('.modal').find('.modal-title').text("Tambah Mode");
      $('#form-field').children('.modal').modal('show');
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/ki_workflow_izin_action')?>/"+"detail",
        dataType: "json",
        data: "id_workflow="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_workflow"]').val(data.id_workflow);
          $('#form-field').find('input[name="id_jenis_izin"]').val(data.id_jenis_izin);
          $('#form-field').find('input[name="kd_workflow"]').val(data.kd_workflow);
          $('#form-field').find('input[name="nm_workflow"]').val(data.nm_workflow);
          $('#form-field').find('textarea[name="keterangan"]').text(data.keterangan);
          $('#form-field').find('input[name="aktif"]').prop('checked', data.ck_aktif);
          $('#form-field').find('#aktivitas_workflow').html(data.aktivitas_workflow);
        }
      })
      $('#form-field').children('.modal').find('.modal-title').text("Ubah Syarat");
      $('#form-field').children('.modal').modal('show');
        
    }
  }

  function reset_default() {
    $('#form-field')[0].reset();
    mode  = undefined;
    table1.ajax.reload(set_title, null, false);
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
            var nm_workflow = $(this).attr('data-id_workflow');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/ki_workflow_izin_action')?>/"+action,
              dataType: "json",
              data: 'id_workflow='+nm_workflow+'&status='+status+'&jenis_izin='+jenis_izin,
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
            url : "<?php echo base_url('admin/ki_workflow_izin_action')?>/"+mode,
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: 'Syarat telah disimpan',
                  type: "success",
                });
                reset_default();
            }
          })
        } else if (action == "edit-akw") {
          var kd_workflow   = $(this).siblings('input').val();
          setTimeout(function(){
            window.location.href   = "<?php echo base_url('admin/ki_aktivitas_workflow');?>?kd_workflow="+kd_workflow;
          }, 100);
        } 
    })

  	var Nestable = function () {

	    var updateOutput = function (e) {
	        var list = e.length ? e : $(e.target),
	            output = list.data('output');
	        if (window.JSON) {
	            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
	        } else {
	            output.val('JSON browser support required for this demo.');
	        }
	    };

	    // activate Nestable for list 2
	    $('#nestable_list_2').nestable({
	    	maxDepth 	: 0
	    }).on('change', updateOutput);

	    // output initial serialised data
	    updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));

	}();

</script>

