<style>
    table tbody tr td {
        vertical-align:middle !important;
        text-align: center  !important;
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
                  <h4 class="m-t-0 header-title"><b><?php echo $title;?></b> 
                  </h4>

                   <button type="button" data-action="add" class="action btn btn-sm waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah User Back Office"> 
                    <i class="fa fa-plus"></i> Tambah User Back Office
                  </button>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>

                  <table id="datatables-ss" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                          <th class="text-center" width="150">Foto</th>
                          <th class="text-center">Nama</th>
                          <th class="text-center">No Whatsapp</th>
                          <th class="text-center">Nama URL Website</th>
                          <th class="text-center">Aksi</th>
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

<form id="form-field2">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">User BackOffice</h4>
            </div>
            <div class="modal-body">
                <input name="id_user" type="hidden">
                <input name="id_personil" type="hidden">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nm_user" class="control-label">Nama User</label>
                            <input name="nm_user" type="text" class="form-control" id="nm_user" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_wa" class="control-label">No Whatsaap</label>
                            <input name="no_wa" type="text" class="form-control" id="no_wa" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input name="email" type="text" class="form-control" id="email" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input name="username" type="text" class="form-control" id="username" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label> <div class="pull-right"><input type="checkbox" onchange="document.getElementById('password_user').type = this.checked ? 'text' : 'password'"> Tampilkan</div>
                            <input name="password" type="password" class="form-control" id="password_user" >
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_role" class="control-label">Role</label>
                            <select name="id_role" class="selectpicker" data-style="btn-default" id="id_role" required>
                              <option selected value="">-Pilih Role-</option>
                                <?php echo $ListRole?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kelas" class="control-label">Kelas</label>
                            <select name="id_kelas" class="selectpicker" data-style="btn-default" id="id_kelas" required>
                              <option selected value="">-Pilih Kelas-</option>
                                <?php echo $ListKelas?>
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kecamatan" class="control-label">Cluster</label>
                            <select name="id_kecamatan" class="selectpicker" data-style="btn-default" id="id_kecamatan" required>
                              <option selected value="">-Pilih Cluster-</option>
                                <?php echo $ListCluster?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kelompok" class="control-label">Kelompok</label>
                            <select name="id_kelompok" class="selectpicker" data-style="btn-default" id="id_kelompok" required>
                              <option selected value="">-Pilih Kelompok-</option>
                                <?php echo $ListKelompok?>
                            </select>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="url_website" class="control-label">URL Website</label>
                            <input name="url_website" type="text" class="form-control" id="url_website">
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="button" data-action="simpan2" class="action btn btn-info waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
  </div>
</form>

<form id="form-field">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">User BackOffice</h4>
            </div>
            <div class="modal-body">
                <input name="id_user" type="hidden">
                <input name="id_personil" type="hidden">
                
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="form-group">
                            <label for="nm_user" class="control-label">Nama User</label>
                            <input name="nm_user" type="text" class="form-control" id="nm_user" >
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_wa" class="control-label">No Whatsaap</label>
                                    <input name="no_wa" type="text" class="form-control" id="no_wa" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input name="email" type="text" class="form-control" id="email" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="form-group text-center">
                            <img class="img-responsive img-thumbnail img-rounded foto_profil" src="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input name="username" type="text" class="form-control" id="username" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label> <div class="pull-right"><input type="checkbox" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> Tampilkan</div>
                            <input name="password" type="password" class="form-control" id="password" >
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_role" class="control-label">Role</label>
                            <select name="id_role" class="selectpicker" data-style="btn-default" id="id_role" >
                              <option selected value="">-Pilih Role-</option>
                                <?php echo $ListRole?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kelas" class="control-label">Kelas</label>
                            <select name="id_kelas" class="selectpicker" data-style="btn-default" id="id_kelas" >
                              <option selected value="">-Pilih Kelas-</option>
                                <?php echo $ListKelas?>
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kecamatan" class="control-label">Cluster</label>
                            <select name="id_kecamatan" class="selectpicker" data-style="btn-default" id="id_kecamatan" >
                              <option selected value="">-Pilih Cluster-</option>
                                <?php echo $ListCluster?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kelompok" class="control-label">Kelompok</label>
                            <select name="id_kelompok" class="selectpicker" data-style="btn-default" id="id_kelompok" >
                              <option selected value="">-Pilih Kelompok-</option>
                                <?php echo $ListKelompok?>
                            </select>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="url_website" class="control-label">URL Website</label>
                            <input name="url_website" type="text" class="form-control" id="url_website">
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
  function show_modal(data, data_img) {

    if (mode == "add") {
      $('#form-field2').children('.modal').find('.modal-title').text("Tambah User BackOffice");
      $('#form-field2').children('.modal').modal('show');
        
    } else if (mode == "edit") {
        console.log(data_img)
          $('.foto_profil').attr("src", data_img);
      $.ajax({
        url : "<?php echo base_url('admin/userbo_action')?>/"+"detail",
        dataType: "json",
        data: "id_user="+data,
        type: "POST",
        success: function(data) {
          $('#form-field').find('input[name="id_user"]').val(data.id_user);
          $('#form-field').find('input[name="id_personil"]').val(data.id_personil);
          $('#form-field').find('input[name="nm_user"]').val(data.nm_user);
          $('#form-field').find('input[name="no_wa"]').val(data.no_wa); 
          $('#form-field').find('input[name="email"]').val(data.email);
          $('#form-field').find('input[name="url_website"]').val(data.url_website);
          $('#form-field').find('input[name="username"]').val(data.username);
          $('#form-field').find('input[name="password"]').val(data.sandi_user);

          $('#form-field').find('select[name="id_role"]').html(data.sl_role);
          $('#form-field').find('select[name="id_role"]').selectpicker("refresh");
          
          $('#form-field').find('select[name="id_kelas"]').html(data.sl_target);
          $('#form-field').find('select[name="id_kelas"]').selectpicker("refresh");

          $('#form-field').find('select[name="id_kelompok"]').html(data.sl_unitkerja);
          $('#form-field').find('select[name="id_kelompok"]').selectpicker("refresh");

          $('#form-field').find('select[name="id_kecamatan"]').html(data.sl_kecamatan);
          $('#form-field').find('select[name="id_kecamatan"]').selectpicker("refresh");
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

        if (action == "aktif") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
            var id_role     = $(this).attr('data-id_role');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/userbo_action')?>/"+action,
              dataType: "json",
              data: 'id_role='+id_role+'&status='+status,
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
          var data_img  = $(this).attr('data-img');
          show_modal(data, data_img);

        } else if (action == "simpan") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm    = $('#form-field').serialize();

          $.ajax({
            url : "<?php echo base_url('admin/userbo_action')?>/"+mode,
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
            else if (action == "simpan2") {
        //   var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm    = $('#form-field2').serialize();

          $.ajax({
            url : "<?php echo base_url('admin/userbo_action')?>/"+mode,
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: 'Data telah disimpan',
                  type: "success",
                });
                reset_default();
            }
          })
        }
        if (action == "del") {
            var data  = $(this).attr('data-id');
            var nama  = $(this).attr('data-nama');
               swal({
                  title: "Apakah anda yakin?",
                  text: 'Anda Akan Menghapus User '+nama,
                  html: true,
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: 'btn-warning',
                  confirmButtonText: "Ya!",
                  closeOnConfirm: false
                } , function () {
                     $.ajax({
                         url : "<?php echo base_url('admin/userbo_action')?>/"+action,
                         dataType: "json",   //expect json to be returned
                         data: "data="+data,
                         type: "POST",
                         success: function(data){
                             table1.ajax.reload(null, false);
                         }
                     })
                  swal("Ya!", 'Anda Menghapus User Ini.', "success");
              });
              reset_default();

        }
    })

</script>