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
        <!-- jenis izin -->
        <div class="col-md-4">
          <div class="card-box table-responsive menu-izin">
            <h4 class="m-t-0 header-title">Jenis Izin</b> </h4>

            <p class="text-muted font-13 m-b-30">
                Pilih jenis izin yang diinginkan
            </p>
            
            <div class="col-md-6">
              <?php echo $list_menuizin;?>
            </div>
          </div>
        </div>

        <!-- range tanggal -->
        <div class="col-md-8">
          <div class="card-box table-responsive">

              <h4 class="m-t-0 header-title">Range tanggal</b> 
              </h4>

              <p class="text-muted font-13 m-b-30">
                  Pilih tanggal yang diinginkan
              </p>

              <div class="col-md-12">
                <div class="text-left form-group">
                  <label class="col-md-4 control-label">Dari Tanggal</label>
                  <div class="col-md-8">
                     <input name="date_start" type="date" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 control-label">Sampai Tanggal</label>
                  <div class="col-md-8">
                     <input name="date_end" type="date" class="form-control">
                  </div>
                </div>

                <div class="form-group" style="margin-top: 100px;">
                  <div class="col-md-12">
                     <button class="btn btn-primary w-sm waves-effect m-t-20 waves-light pull-right" onclick="filter()"><i class="fa fa-filter"></i> Filter</button>
                  </div>
                </div>
              </div>

          </div>
        </div>

      </div>


      <div class="row">
        <div class="col-md-12">     
          <div class="card-box table-responsive">

            <h4 class="m-t-0 header-title"><b>List Perizinan Keluar</b> 
              <span class="label label-info total"><?php echo $total;?></span>
              

              <div class="button-list" style="float: right;">
                <!-- <a class="btn_pdf" target="_blank" href="">
                <button type="button" class="btn btn-danger w-sm waves-effect m-t-20 waves-light pull-right">
                <span class="fa fa-file-pdf-o"></span> Pdf</button> 
                </a>

                <a class="btn_excel" target="_blank" href="#">
                <button type="button" class="btn btn-success w-sm waves-effect m-t-20 waves-light pull-right">
                <span class="fa fa-file-excel-o"></span> Excel</button> 
                </a> -->
              </div>
            </h4>

            <p class="text-muted font-13 m-b-30">
               Dibawah ini merupakan list perizinan yang telah di keluarkan
            </p>

            <div class="col-md-12">
              <table id="datatables-ss1" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>No Permohonan</th>
                    <th>Tgl Permohonan</th>
                    <th>Pemohon</th>
                    <th>Perusahaan</th>
                    <th>Jenis Permohonan</th>
                    <th>Status</th>
                    <th>Waktu Terakhir</th>
                    <th>Durasi</th>
                    <th>Aktif</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- load dlaporan here -->
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>


  <?php $this->load->view('copyright'); ?>
  </div>
</div>

<!-- List menu izin -->
<style type="text/css">
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


  // Filter
  var id_nama_izin = '';
  var id_jenis_izin = '';
  var date_start = '';
  var date_end = '';

  function get_nama_izin(v, e) {
    var status = $(e).data('status');  
    if(status == 0) {
      $(e).data('status' , 1);
      $('.menu-izin').find('a').css('color', '');    
      $(e).css('color', 'rgb(255, 80, 80)');
      id_nama_izin = v;
      id_jenis_izin = '';
    }

    if(status == 1) {
      $(e).data('status' , 0);
      $('.menu-izin').find('a').css('color', '');
      id_nama_izin = '';
      id_jenis_izin = '';
    }
  }

  function get_jenis_izin(v, e) {
    var status = $(e).data('status');  
    if(status == 0) {
      $(e).data('status' , 1);
      $('.menu-izin').find('a').css('color', '');    
      $(e).css('color', 'rgb(255, 80, 80)');
      id_jenis_izin = v;
    }

    if(status == 1) {
      $(e).data('status' , 0);
      $('.menu-izin').find('a').css('color', '');
      id_jenis_izin = '';
    }

  }

  function filter() {
    //get data
    date_start = $('input[name="date_start"]').val();
    date_end   = $('input[name="date_end"]').val();

    //btn export
    // var url_pdf = '<?php echo base_url('laporan/laporan_export/pdf');?>'+
    // '?id_nama_izin='+id_nama_izin+'&id_jenis_izin='+id_jenis_izin+'&date_start='+date_start+'&date_end='+date_end;
    // var url_excel = '<?php echo base_url('laporan/laporan_export/excel');?>'+
    // '?id_nama_izin='+id_nama_izin+'&id_jenis_izin='+id_jenis_izin+'&date_start='+date_start+'&date_end='+date_end;
    // $('.btn_pdf').attr('href', url_pdf);
    // $('.btn_excel').attr('href', url_excel);

    //get total
    var url_control = base_url+"admin/permohonan_total/"+1;
    $.ajax({
      type : "POST",
      url : url_control,
      data : {id_nama_izin : id_nama_izin,
              id_jenis_izin : id_jenis_izin,
              date_start : date_start,
              date_end : date_end},
      datatype : "html",
      success: function(response) {
        res = JSON.parse(response);
        if(res.msg == 'not_valid') {
          $('.total').text('0');
        } else {
          $('.total').text(res.total);
        }
        //reload tbl
        tbl1.ajax.reload(null, false); 
      }
    });
  }

  // My Datatables
  var   urlDb1   = "<?php echo base_url('admin/permohonan_show')?>";
  var   totalClmn1;
  var   tbl1;
  $(document).ready(function() {
      totalClmn1 = parseInt($("#datatables-ss1").find('tr:nth-child(1) th').length);
      tbl1  = $('#datatables-ss1').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb1,
              "type": "POST",
              "data": function(param) {
                  param.id_nama_izin  = id_nama_izin;
                  param.id_jenis_izin = id_jenis_izin;
                  param.date_start    = date_start;
                  param.date_end      = date_end;
              }              
          },
          "columnDefs": [ 
            { 
                "targets": [ 0 ], 
                "orderable": false 
            }
          ]
      });
  });

  $(document).on('click', ".action", function() {
    var self        = this;

    var action  = $(this).attr('data-action');

    if (action == "aktif") {
        var check   = $(this).prop("checked");
        if (check) {
            var status  = 1;
        } else {
            var status  = 0;
        }
        var id_permohonan    = $(this).attr('data-id_permohonan');
        var nama             = $(this).closest("tr").find("td:eq(1)").text();

        $.ajax({
          url : "<?php echo base_url('admin/permohonan_aktivasi')?>/"+action,
          dataType: "json",
          data: 'id_permohonan='+id_permohonan+'&status='+status,
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

              tbl1.ajax.reload(null, false); 
          }
        })
    } 
  })



  
</script>