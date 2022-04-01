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
                  <button type="button" data-action="add" class="action btn btn-sm waves-effect btn-primary m-b-5 tooltip-hover pull-right submit btn-modal" title="Tambah Grup Perusahaan"> 
                    <i class="fa fa-plus"></i> Tambah Grup Perusahaan
                  </button>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title;?>
                  </p>
                  <div class="panel-group panel-group-joined panel-datag" id="accordion">
                      <!-- content datag -->
                      Tidak ada data
                  </div>

              </div>
          </div>
      </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>

<form class="form-field" id="form-field-grup">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Grup Perusahaan</h4>
            </div>
            <div class="modal-body">
                <input name="id_perusahaan_bio_grup" type="hidden">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="teks_judul" class="control-label">Teks Judul</label>
                            <input name="teks_judul" type="text" class="form-control" id="teks_judul" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <b for="teks_subjudul">Sub Judul</b>
                          <textarea id="teks_subjudul" name="teks_subjudul" class="form-control" rows="3" placeholder="Isi jika diperlukan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-teal tooltip-hover" title="Tampil Pertama">
                            <input name="show_first" type="checkbox" id="show_first" value="1">
                            <label for="show_first" class="btn btn-rounded btn-teal waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Pertama</strong>
                            </label>
                        </div>                         
                    </div>
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-orange tooltip-hover" title="Tampil di Frontend">
                            <input name="show_pg_fe" type="checkbox" id="show_pg_fe" value="1">
                            <label for="show_pg_fe" class="btn btn-rounded btn-orange waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Frontend</strong>
                            </label>
                        </div>                         
                    </div>                    
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-brown tooltip-hover" title="Tampil di Backend">
                            <input name="show_pg_be" type="checkbox" id="show_pg_be" value="1">
                            <label for="show_pg_be" class="btn btn-rounded btn-brown waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Backend</strong>
                            </label>
                        </div>                         
                    </div>
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-primary">
                            <input name="aktif" type="checkbox" id="aktif" value="1">
                            <label for="aktif" class="btn btn-rounded btn-primary waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Aktifkan</strong>
                            </label>
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

<form class="form-field" id="form-field-child">
  <div class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >×</button>
                <h4 class="modal-title">Data Perusahaan</h4>
            </div>
            <div class="modal-body">
                <input name="id_perusahaan_bio_s" type="hidden">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode_formula" class="control-label">Kode Formula</label>
                            <input name="kode_formula" type="text" class="form-control" id="kode_formula" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="teks_judul_c" class="control-label">Teks Judul</label>
                            <input name="teks_judul" type="text" class="form-control" id="teks_judul_c" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <b for="sub_teks_judul">Sub Judul</b>
                          <textarea id="sub_teks_judul" name="sub_teks_judul" class="form-control" rows="3" placeholder="Isi jika diperlukan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_input" class="control-label">Jenis Input</label>
                            <select name="jenis_input" class="selectpicker tg-canvas" data-style="btn-default" id="jenis_input" >
                               <?php echo $sl_jenis_input;?>
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipe_data" class="control-label">Tipe Data</label>
                            <select name="tipe_data" class="selectpicker" data-style="btn-default" id="tipe_data" >
                               <?php echo $sl_tipe_data;?>
                            </select>
                        </div>    
                    </div>
                </div>
                <!-- jenis input sistem -->
                <div id="cv-tbl" class="row m-b-30 row-bordered d-hide">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Canvas Input Tabel</label>
                        <div class="row">
                          <div class="col-md-5" >
                            <select data-cv="tbl" class="tag-detect" name="teks_judul_tbl[]" multiple data-role="tagsinput">
                                <option value="Amsterdam">Amsterdam</option>
                            </select>          
                          </div>
                          <div class="col-md-7 ">          
                            <table id="cv-tbl-vw" class="table table-responsive table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th>No</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="text-center">. . .</td>
                                </tr>
                              </tbody>
                            </table>  
                          </div>                      
                        </div>
                    </div>
                  </div>
                </div>
                <div id="cv-select" class="row m-b-30 row-bordered d-hide">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Canvas Input Select</label>
                        <div class="row">
                          <div class="col-md-5" >
                            <select data-cv="select" class="tag-detect" name="teks_judul_select[]" multiple data-role="tagsinput">
                                <option value="Amsterdam">Amsterdam</option>
                            </select>          
                          </div>
                          <div class="col-md-7 ">          
                            <select id="cv-select-vw" class="selectpicker" data-style="btn-default">
                            </select> 
                          </div>                      
                        </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="table_tujuan_s" class="control-label">Tabel Tujuan (single)</label>
                            <input name="table_tujuan_s" type="text" class="form-control" id="table_tujuan_s" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pk_tujuan_s" class="control-label">Primary Key Tujuan (single)</label>
                            <input name="pk_tujuan_s" type="text" class="form-control" id="pk_tujuan_s" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="table_tujuan_p" class="control-label">Tabel Tujuan (plural)</label>
                            <input name="table_tujuan_p" type="text" class="form-control" id="table_tujuan_p" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pk_tujuan_p" class="control-label">Primary Key Tujuan (plural)</label>
                            <input name="pk_tujuan_p" type="text" class="form-control" id="pk_tujuan_p" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="attribute" class="control-label">Attribute</label>
                            <input name="attribute" type="text" class="form-control" id="attribute" placeholder="Contoh : Data Pemilik">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <b for="keterangan_c">Keterangan</b>
                          <textarea id="keterangan_c" name="keterangan" class="form-control" rows="3" placeholder="Isi jika diperlukan"></textarea>
                        </div>                        
                    </div>
                </div>

                <div class="row m-b-10">
                    <div class="col-md-4">
                      <div class="row m-b-10">
                        <div class="col-md-6">
                            <div class="btn-switch btn-switch-brown tooltip-hover" title="Special Metode Input, isi refrensi">
                                <input name="special" type="checkbox" id="special_c" value="1">
                                <label for="special_c" class="btn btn-rounded btn-brown waves-effect waves-light">
                                    <em class="glyphicon glyphicon-ok"></em>
                                    <strong> Special</strong>
                                </label>
                            </div>                         
                        </div>
                        <div class="col-md-6">
                            <div class="btn-switch btn-switch-primary">
                                <input name="aktif" type="checkbox" id="aktif_c" value="1">
                                <label for="aktif_c" class="btn btn-rounded btn-primary waves-effect waves-light">
                                    <em class="glyphicon glyphicon-ok"></em>
                                    <strong> Aktifkan</strong>
                                </label>
                            </div>                    
                        </div>
                      </div>
                      <div class="row m-b-10">
                        <div class="col-md-6">
                            <div class="btn-switch btn-switch-teal">
                                <input name="wajib_isi" type="checkbox" id="wajib_isi_c" value="1">
                                <label for="wajib_isi_c" class="btn btn-rounded btn-teal waves-effect waves-light">
                                    <em class="glyphicon glyphicon-ok"></em>
                                    <strong> Wajib Isi</strong>
                                </label>
                            </div>                         
                        </div>
                        <div class="col-md-6">
                            <div class="btn-switch btn-switch-orange tooltip-hover" title="Bisa Multivalue">
                                <input name="multivalue" type="checkbox" id="multivalue_c" value="1">
                                <label for="multivalue_c" class="btn btn-rounded btn-orange waves-effect waves-light">
                                    <em class="glyphicon glyphicon-ok"></em>
                                    <strong> Multivalue</strong>
                                </label>
                            </div>                         
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="table_refrensi" class="control-label">Tabel Refrensi</label>
                            <input name="table_refrensi" type="text" class="form-control" id="table_refrensi">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pk_refrensi" class="control-label">Primary Key Refrensi</label>
                            <input name="pk_refrensi" type="text" class="form-control" id="pk_refrensi">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nm_refrensi" class="control-label">Kolom Refrensi</label>
                            <input name="nm_refrensi" type="text" class="form-control" id="nm_refrensi">
                        </div>
                    </div>                    
                </div>                

                <!-- <div class="row text-center m-b-10">
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-teal">
                            <input name="wajib_isi" type="checkbox" id="wajib_isi_c" value="1">
                            <label for="wajib_isi_c" class="btn btn-rounded btn-teal waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Wajib Isi</strong>
                            </label>
                        </div>                         
                    </div>
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-orange tooltip-hover" title="Bisa Multivalue">
                            <input name="multivalue" type="checkbox" id="multivalue_c" value="1">
                            <label for="multivalue_c" class="btn btn-rounded btn-orange waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Multivalue</strong>
                            </label>
                        </div>                         
                    </div>
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-brown tooltip-hover" title="Special Metode Input">
                            <input name="special" type="checkbox" id="special_c" value="1">
                            <label for="special_c" class="btn btn-rounded btn-brown waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Special</strong>
                            </label>
                        </div>                         
                    </div>
                    <div class="col-md-3">
                        <div class="btn-switch btn-switch-primary">
                            <input name="aktif" type="checkbox" id="aktif_c" value="1">
                            <label for="aktif_c" class="btn btn-rounded btn-primary waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Aktifkan</strong>
                            </label>
                        </div>                    
                    </div>
                </div> -->

                <div class="row text-center m-b-10">
                    <div class="col-md-2">
                        <div class="btn-switch btn-switch-orange tooltip-hover" title="Tampil Pertama">
                            <input name="show_first" type="checkbox" id="show_first_c" value="1">
                            <label for="show_first_c" class="btn btn-rounded btn-orange waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Pertama</strong>
                            </label>
                        </div>                    
                    </div>
                    <div class="col-md-2">
                        <div class="btn-switch btn-switch-purple tooltip-hover" title="Tampil di Frontend">
                            <input name="show_pg_fe" type="checkbox" id="show_pg_fe_c" value="1">
                            <label for="show_pg_fe_c" class="btn btn-rounded btn-purple waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Frontend</strong>
                            </label>
                        </div>                    
                    </div>
                    <div class="col-md-2">
                        <div class="btn-switch btn-switch-brown tooltip-hover" title="Tampil di Backend">
                            <input name="show_pg_be" type="checkbox" id="show_pg_be_c" value="1">
                            <label for="show_pg_be_c" class="btn btn-rounded btn-brown waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Backend</strong>
                            </label>
                        </div>                         
                    </div>
                    <div class="col-md-2">
                        <div class="btn-switch btn-switch-danger tooltip-hover" title="Tampil di Select">
                            <input name="show_select" type="checkbox" id="show_select_c" value="1">
                            <label for="show_select_c" class="btn btn-rounded btn-danger waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Select</strong>
                            </label>
                        </div>                    
                    </div>                  
                    <div class="col-md-2">
                        <div class="btn-switch btn-switch-teal tooltip-hover" title="Tampil di Kolom Tabel Frontend">
                            <input name="show_tbl_fe" type="checkbox" id="show_tbl_fe_c" value="1">
                            <label for="show_tbl_fe_c" class="btn btn-rounded btn-teal waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Tabel FE</strong>
                            </label>
                        </div>                         
                    </div>                    
                    <div class="col-md-2">
                        <div class="btn-switch btn-switch-inverse tooltip-hover" title="Tampil di Kolom Tabel Backend">
                            <input name="show_tbl_be" type="checkbox" id="show_tbl_be_c" value="1">
                            <label for="show_tbl_be_c" class="btn btn-rounded btn-inverse waves-effect waves-light">
                                <em class="glyphicon glyphicon-ok"></em>
                                <strong> Tabel BE</strong>
                            </label>
                        </div>                         
                    </div>
                </div>                 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="button" data-action="simpan-child" class="action btn btn-info waves-effect waves-light">Simpan</button>
            </div>
        </div>
    </div>
  </div>
</form>

<!-- Datatables -->
<script src="<?php echo base_url()?>berkas/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url()?>berkas/plugins/datatables/dataTables.tuning.js"></script>

<!-- Tags Input -->
<script src="<?php echo base_url()?>berkas/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
<!-- <script src="<?php echo base_url()?>berkas/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script> -->

<script type="text/javascript">
  $(document).ready(function() {
    get_datag();
  })

  // My Datatables
  var   urlDb   = "<?php echo base_url('admin/show_ki_berkas_prsh_grup')?>";
  var   totalClmn;
  var   table1;

  var id_group;
  var id_child;
  function set_datatables() {

      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      table1  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "pageLength": 5,
          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb+'/table1',
              "type": "POST",
              "data": function(param) {
                  param.id_group    = id_group;
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
  };

  function get_datag() {
    $('.panel-datag').text("Processing . . .");
    $.ajax({
      url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+"get_dt_group",
      dataType: "json",
      type: "POST",
      success: function(data) {
        $('.panel-datag').html(data.datag);
      }
    })    
  }

  var mode;
  function show_modal(data) {

    if (mode == "add") {
      $('#form-field-grup').children('.modal').find('.modal-title').text("Tambah Grup Perusahaan");
      $('#form-field-grup').children('.modal').modal('show');
        
    } else if (mode == "edit") {
      $.ajax({
        url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+"detail",
        dataType: "json",
        data: "id_perusahaan_bio_grup="+data,
        type: "POST",
        success: function(data) {
          $('#form-field-grup').find('input[name="id_perusahaan_bio_grup"]').val(data.id_perusahaan_bio_grup);
          $('#form-field-grup').find('input[name="teks_judul"]').val(data.teks_judul);
          $('#form-field-grup').find('textarea[name="teks_subjudul"]').text(data.teks_subjudul);
          $('#form-field-grup').find('input[name="show_first"]').prop('checked', data.ck_show_first);
          $('#form-field-grup').find('input[name="show_pg_fe"]').prop('checked', data.ck_show_pg_fe);
          $('#form-field-grup').find('input[name="show_pg_be"]').prop('checked', data.ck_show_pg_be);
          $('#form-field-grup').find('input[name="aktif"]').prop('checked', data.ck_aktif);
        }
      })
      $('#form-field-grup').children('.modal').find('.modal-title').text("Ubah Grup Perusahaan");
      $('#form-field-grup').children('.modal').modal('show'); 
    } else if (mode == "add-child") {
      $('#form-field-child').children('.modal').find('.modal-title').text("Tambah Data Perusahaan");
      $('#form-field-child').children('.modal').modal('show'); 
    } else if (mode == "edit-child") {
      $.ajax({
        url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+"detail-child",
        dataType: "json",
        data: "id_perusahaan_bio_s="+data,
        type: "POST",
        success: function(data) {   
          $('#form-field-child').find('input[name="id_perusahaan_bio_s"]').val(data.id_perusahaan_bio_s);
          $('#form-field-child').find('input[name="id_perusahaan_bio_grup"]').val(data.id_perusahaan_bio_grup);
          $('#form-field-child').find('input[name="nama_bio"]').val(data.nama_bio);
          $('#form-field-child').find('input[name="kode_formula"]').val(data.kode_formula);
          $('#form-field-child').find('input[name="teks_judul"]').val(data.teks_judul);
          $('#form-field-child').find('input[name="table_tujuan_s"]').val(data.table_tujuan_s);
          $('#form-field-child').find('input[name="pk_tujuan_s"]').val(data.pk_tujuan_s);
          $('#form-field-child').find('input[name="table_tujuan_p"]').val(data.table_tujuan_p);
          $('#form-field-child').find('input[name="pk_tujuan_p"]').val(data.pk_tujuan_p);
          $('#form-field-child').find('input[name="attribute"]').val(data.attribute);
          $('#form-field-child').find('input[name="table_refrensi"]').val(data.table_refrensi);
          $('#form-field-child').find('input[name="pk_refrensi"]').val(data.pk_refrensi);
          $('#form-field-child').find('input[name="nm_refrensi"]').val(data.nm_refrensi);

          $('#form-field-child').find('textarea[name="sub_teks_judul"]').val(data.sub_teks_judul);
          $('#form-field-child').find('textarea[name="keterangan"]').text(data.keterangan);

          $('#form-field-child').find('select[name="jenis_input"]').html(data.sl_jenis_input).selectpicker("refresh");
          $('#form-field-child').find('select[name="tipe_data"]').html(data.sl_tipe_data).selectpicker("refresh");

          // input tbl
          df_cv_tbl     = data.jl_teks_judul_tbl;
          $('#form-field-child').find('select[name="teks_judul_tbl[]"]').tagsinput('removeAll');
          var idx   = 0;
          $.each(data.sl_teks_judul_tbl, function(index, value) {
            $('#form-field-child').find('select[name="teks_judul_tbl[]"]').tagsinput('add', value.id);
            var Ttext   = value.text+'<span data-role="remove"></span>';
            $('#form-field-child').find('select[name="teks_judul_tbl[]"] option:eq('+idx+')').text(value.text);
            $('#form-field-child').find('select[name="teks_judul_tbl[]"]').siblings('div.bootstrap-tagsinput').children('span.tag:eq('+idx+')').html(Ttext);
            idx ++;
          });
          set_view_tbl(data.lbl_teks_judul_tbl);

          // input select
          var idx = 0;
          df_cv_select  = data.jl_teks_judul_select;
          $('#form-field-child').find('select[name="teks_judul_select[]"]').tagsinput('removeAll');
          $.each(data.sl_teks_judul_select, function(index, value) {
            $('#form-field-child').find('select[name="teks_judul_select[]"]').tagsinput('add', value.id);
            var Ttext   = value.text+'<span data-role="remove"></span>';
            $('#form-field-child').find('select[name="teks_judul_select[]"] option:eq('+idx+')').text(value.text);
            $('#form-field-child').find('select[name="teks_judul_select[]"]').siblings('div.bootstrap-tagsinput').children('span.tag:eq('+idx+')').html(Ttext);
            idx ++;
          });
          set_view_select(data.lbl_teks_judul_select);

          $('#form-field-child').find('input[name="wajib_isi"]').prop('checked', data.ck_wajib_isi);
          $('#form-field-child').find('input[name="multivalue"]').prop('checked', data.ck_multivalue);
          $('#form-field-child').find('input[name="special"]').prop('checked', data.ck_special);
          $('#form-field-child').find('input[name="show_first"]').prop('checked', data.ck_show_first);
          $('#form-field-child').find('input[name="show_select"]').prop('checked', data.ck_show_select);
          $('#form-field-child').find('input[name="show_tbl_be"]').prop('checked', data.ck_show_tbl_be);
          $('#form-field-child').find('input[name="show_tbl_fe"]').prop('checked', data.ck_show_tbl_fe);
          $('#form-field-child').find('input[name="show_pg_be"]').prop('checked', data.ck_show_pg_be);
          $('#form-field-child').find('input[name="show_pg_fe"]').prop('checked', data.ck_show_pg_fe);
          $('#form-field-child').find('input[name="aktif"]').prop('checked', data.ck_aktif);

          shhi_canvas(data.jenis_input);
        }
      })
      $('#form-field-child').children('.modal').find('.modal-title').text("Ubah Data Perusahaan");
      $('#form-field-child').children('.modal').modal('show'); 
    }     
  }

  function refresh_group() {
    get_datag();
    $('#form-field-grup').children('.modal').modal('hide');
    $('.form-field')[0].reset();
  }

  function refresh_child() {
    table1.ajax.reload(null,false);
    $('#form-field-child').children('.modal').modal('hide');
    $('.form-field')[0].reset();
  }

  var datatables_c = $.ajax({
      url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+"get_dt_child",
      dataType: "json",
      type: "POST"
    })

  $(document).on('click', ".action", function() {
        var self        = this;

        var action  = $(this).attr('data-action');

        if (action == "show-group") {
          var kd    = $(self).attr('href');
          id_group  = $(self).attr('data-id');

          datatables_c.done(function( msg ) {    
            $('.panel-body').html('');
            $(kd).children('.panel-body').html(msg);
            set_datatables();
          });
          datatables_c.fail(function( jqXHR, textStatus ) {    
            alert( "Request failed: " + textStatus );    
          });

        } else if (action == "add") {
          mode  = 'add';
          show_modal('');

        } else if (action == "edit") {
          mode  = 'edit';
          var id  = $(self).attr('data-id');
          show_modal(id);

        } else if (action == "simpan") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm    = $('#form-field-grup').serialize();

          $.ajax({
            url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+mode,
            dataType: "json",
            data: dataForm,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: 'Grup Perusahaan telah disimpan',
                  type: "success",
                });
                refresh_group();
            }
          })

        } else if (action == "add-child") {
          id_group  = $(self).attr('data-id');
          mode  = 'add-child';
          show_modal('');

        } else if (action == "edit-child") {
          mode      = 'edit-child';
          id_child  = $(self).attr('data-id');
          show_modal(id_child);

        } else if (action == "simpan-child") {
          var nama        = $(this).closest("tr").find("td:eq(1)").text();
          var dataForm    = $('#form-field-child').serialize();

          $.ajax({
            url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+mode,
            dataType: "json",
            data: dataForm+"&id_group="+id_group,
            type: "POST",
            success: function(data) {
                swal({
                  title: "Berhasil!",
                  text: 'Data Perusahaan telah disimpan',
                  type: "success",
                });
                refresh_child();
            }
          })

        } else if (action == "aktif_ch") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
            var perusahaan_bio_s= $(this).attr('data-id');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/ki_berkas_prsh_action')?>/"+action,
              dataType: "json",
              data: 'perusahaan_bio_s='+perusahaan_bio_s+'&status='+status,
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
                refresh_child();
              }
            })
        } 
    })

  function shhi_canvas(jenis) {
    if (jenis == "tbl") {
      $('#cv-tbl').removeClass('d-hide').addClass('d-show');
      $('#cv-select').removeClass('d-show').addClass('d-hide');
    } else if (jenis == "select") {
      $('#cv-select').removeClass('d-hide').addClass('d-show');
      $('#cv-tbl').removeClass('d-show').addClass('d-hide');
    } else if (jenis == "text" || jenis == "number" || jenis == "file" || jenis == "email" || jenis == "date") {
      $('#cv-tbl').removeClass('d-show').addClass('d-hide');
      $('#cv-select').removeClass('d-show').addClass('d-hide');
    }    
  }

  $(document).on('change', ".tg-canvas", function() {
    var jenis   = $(this).val();
    shhi_canvas(jenis);
  })

  var df_cv_select  = 1;
  var df_cv_tbl     = 1;

  function set_view_tbl(data) {
    var content = '<th>No.</th>';
    $(data).each(function( index, value ) {
      content   += '<th>'+value+'</th>';
    })

    // set content tbl
    $('#cv-tbl-vw').children('thead').html(content);
    $('#cv-tbl-vw').children('tbody').children('tr').children('td:eq(0)').attr('colspan', parseInt(data.length)+1);
  }

  function set_view_select(data) {
    var content = '';
    $(data).each(function( index, value ) {
      content   += '<option value="">'+value+'</option>';
    })

    // set content select
    $('#cv-select-vw').html(content).selectpicker('refresh');    
  }

  $('.tag-detect').on('itemAdded itemRemoved', function(event) {
    var self        = this;

    var tag         = $(this).attr('data-cv');
    var data        = [];
    $(this).children('option').each(function () {
      data.push($(this).text());
    })

    if (tag == "tbl") {
      if (df_cv_tbl < data.length) {
        // /do some function if add
        // if (true) { 
          set_view_tbl(data);
        // } else {
          // event.cancel = true;
        // }
      } else {
          set_view_tbl(data);
      }
      df_cv_tbl     = data.length;
    } else if (tag == "select") {
      if (df_cv_select < data.length) {
        // /do some function if add
        // if (true) {        
          set_view_select(data);
        // } else {
          // event.cancel = true;
        // }          
      } else {
        set_view_select(data);
      }
      df_cv_select  = data.length;
    }
  });

</script>