

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
          <div class="col-sm-6">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><?php echo $title;?></b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      
                  </p>

                  <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-6" for="example-email">Pilih Jabatan</label>
                                <div class="col-md-8">
                                  <select class="form-control" onChange="window.document.location.href=this.options[this.selectedIndex].value;" value="GO">
                                      <option selected="selected">-Pilih-</option>
                                      <?php foreach ($getJabatan as $g ) {
                                      ?>
                                      <option value="<?php echo base_url().'admin/atur_akses/'.$g->id_role;?>">
                                      <?php echo $g->nm_role;?>
                                      </option>
                                      <?php
                                      }
                                      ?>
                                  </select>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>

              </div>
          </div>

           <div class="col-sm-6">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><?php echo $title1;?></b> 
                  </h4>
                  <button type="button" data-action="add" class="action btn btn-xs waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Menu"> 
                                <i class="fa fa-plus"></i> Tambah Menu
                                </button>
                  <p class="text-muted font-13 m-b-30">
                      
                  </p>

                  <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" role="form">
                            <div class="form-group"> 
                              
                                <div class="col-md-12">
                                  <?php echo $treeMenu;?>
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


<form id="form-field">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Izin</h4>
            </div>
            <div class="modal-body">
                <input name="id_menu_bo" type="hidden">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nm_menu" class="control-label">Nama Menu</label>
                            <input name="nm_menu" type="text" class="form-control" id="nm_menu" placeholder="" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="url" class="control-label">URL</label>
                            <input name="url" type="text" class="form-control" id="url" placeholder="Contoh : admin/dm_izin">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="icon" class="control-label">Icon</label>
                            <input name="icon" type="text" class="form-control" id="icon" placeholder="Contoh : mdi mdi-database">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_parent" class="control-label">Parent Menu</label>
                             <select name="id_parent" class="selectpicker" data-style="btn-default" id="id_parent" >
                                <?php echo $ListMenuParent?>
                            </select>
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
  var   urlDb   = "<?php echo base_url('admin/show_userbo')?>";
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
      $('#form-field').children('.modal').find('.modal-title').text("Tambah Menu");
      $('#form-field').children('.modal').modal('show');
        
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/hak_akses_action')?>/"+"detail",
        dataType: "json",
        data: "id_menu_bo="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_menu_bo"]').val(data.id_menu_bo);
          
          $('#form-field').find('input[name="nm_menu"]').val(data.nm_menu);
          $('#form-field').find('input[name="url"]').val(data.url);
          var test = $('#form-field').find('select[name="id_parent"]').html(data.sl_parent);
          if ( test == 0) {
             $('#form-field').find('select[name="id_parent"]').html(data.id_parent);
             $('#form-field').find('select[name="id_parent"]').selectpicker("refresh");

          }else{
             $('#form-field').find('select[name="id_parent"]').html(data.sl_parent);
            $('#form-field').find('select[name="id_parent"]').selectpicker("refresh");
          }
         


          $('#form-field').find('input[name="icon"]').val(data.icon);
          
        }
      })
      $('#form-field').children('.modal').find('.modal-title').text("Ubah Menu");
      $('#form-field').children('.modal').modal('show');
        
    }
  }

  function reset_default() {
    $('#form-field')[0].reset();
    mode  = undefined;
    table1.ajax.reload(null,false);
    location.reload();
    $('#form-field').children('.modal').modal('hide');
  }

  $(document).on('click', ".action", function() {
        var self        = this;

        var action  = $(this).attr('data-action');

       if (action == "add") {
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
            url : "<?php echo base_url('admin/hak_akses_action')?>/"+mode,
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


