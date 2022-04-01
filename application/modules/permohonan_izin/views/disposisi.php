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
                  <!-- <h4 class="page-title"></h4> -->
              </div>
          </div>
      </div>
      <!-- end page title end breadcrumb -->


      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><b>Permohonan yang belum di <?php echo $page;?></b> 
                      <span class="label label-danger"><?php echo $jml_tugas;?></span>
                  </h4>
                  <?php 
                  if($jml_tugas == 0) {
                    $disabled = 'disabled';
                  } else {
                    $disabled = '';
                  }
                  ?>
                  <button class="btn btn-sm btn-icon waves-effect btn-primary m-b-5 tooltip-hover pull-right submit" title="Lakukan Disposisi !" <?php echo $disabled?>> 
                    <i class="fa fa-send"></i> Lakukan Disposisi  
                  </button>

                  <p class="text-muted font-13 m-b-30">
                      Dibawah ini adalah list daftar permohonan yang belum di <?php echo $page;?>
                  </p>

                  <form id="formS" method="POST" action="<?php echo base_url('permohonan_izin/delegasikan');?>">
                  <input type="hidden" name="page" value="<?php echo $this->uri->uri_string()?>">
                  <table id="datatables-ss" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                          <th>ID</th>
                          <th>No Permohonan</th>  
                          <th>Tgl Permohonan</th>
                          <th>Pemohon</th>
                          <th>Perusahaan</th>
                          <th>Jenis Permohonan</th>
                          <th>Aksi</th>
                      </tr>
                    </thead>

                    <tbody>
                      <!-- Content -->
                    </tbody>
                  </table>
                  </form>
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
  var   urlDb   = "<?php echo base_url('permohonan_izin/show_disposisi')?>";
  var   page   = "<?php echo $this->uri->segment(3);?>";
  var   totalClmn;
  var   tbl_dsPs;
  $(document).ready(function() {
      totalClmn = parseInt($("#datatables-ss").find('tr:nth-child(1) th').length);
      tbl_dsPs  = $('#datatables-ss').DataTable({ 
          
          "PaginationType": "bootstrap",
          responsive: true,
          dom: '<"tbl-top clearfix"lfr>,t,<"tbl-footer clearfix"<"tbl-info pull-left"i><"tbl-pagin pull-right"p>>',

          "processing": true, 
          "serverSide": true, 
          "deferRender": true,
          "order": [], 

          "ajax": {
              "url": urlDb,
              "type": "POST",
              "data": function(param) {
                  param.page    = page;
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
          ]
      });
  });

  $(document).on('click', ".submit", function() {
    $('#formS').submit();
  })

  $(document).on('click', '.select_delegasi', function () {
  	var id_wk_next 	= $(this).attr('data-id_aktivitas_workflow');
  	var self 		= this;

  	$.ajax({
      	url : "<?php echo base_url('permohonan_izin/select_delegasi')?>/"+id_wk_next,
      	dataType: "json",
      	type: "POST",
      	success: function(data){
	        $(self).html(data);
          $(self).removeClass('select_delegasi');
      	}
  	});    
  });

</script>