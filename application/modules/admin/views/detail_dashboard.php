
<style type="text/css">
  .vertical-center {
  min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
  min-height: 100vh; /* These two lines are counted as one :-)       */

  display: flex;
  align-items: center;
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
                         <form class="form-field">
                           <div class="col-md-5 "></div>
                            <div class="col-md-4">
                            <button type="button" class="btn btn-success get-detail get">LIHAT DETAIL DASHBOARD</button>
                            </div>  
                         </form>
                    </div>
                  </div>
              </div>
          </div>
      </div>




       <div class="row">
          <div class="col-sm-12">
            <div class="container">
              <div class="card-box table-responsive">
                 <div class="container panel-detail" id="accordion">
                    <form class="form-field">
                                  data
                    </form>
                </div>  
              </div>
            </div>
            </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>






<script type="text/javascript">

  
  $(document).on('click', ".get-detail", function(e) {
    e.preventDefault();
    getAktivitas();
  /*  set_title();*/
  })

  var tampilkanData = $.ajax({
      url : "<?php echo base_url('admin/detailDashboardAction')?>/"+"getDetailPermeja",
      dataType: "json",
      type: "POST"
  })

  var id_aktivitas;

  $(document).on('click', ".action", function(e) {
    e.preventDefault();
    var self        = this;
    var action  = $(this).attr('data-action');
    if (action == "detail") {
      var kd = $(self).attr('href');
      id_aktivitas = $(self).attr('data-id');
      tampilkanData.done(function( msg ){

        $(kd).find('.panel-body').html('');
        $(kd).find('.panel-body').html(msg);
        
        getDataPermeja();

      });
    }
    //alert(id_aktivitas);
  })

  function getDataPermeja(){
   // alert(id_aktivitas);
   $('.loadingmessage').show();
     $.ajax({
         url : "<?php echo base_url('admin/showDataDetail')?>",
         dataType: "html",
         data: "id_aktivitas="+id_aktivitas,
         type: "POST",
         success: function(res) {
          // alert(id_aktivitas);
          //res = JSON.parse(response);
           // console.log(response);
              $('.showData').html();
              $('.showData').html(res);
              $('.loadingmessage').hide(); 
        }
      })  
  }

    
    function getAktivitas(){
      $('.panel-detail').text("Harap Menunggu . . . .");
      $('.loadingmessage').show(); 
       $.ajax({
            url : "<?php echo base_url('admin/detailDashboardAction')?>/"+"getAktivitas",
            dataType: "json",
            type: "POST",
            success: function(data) {
            //alert('success');
            //console.log(data);
            //$('.panel-detail').replaceWith(data.dataAktivitas);
            $('.panel-detail').html();
            $('.panel-detail').html(data.dataAktivitas);
            $('.loadingmessage').hide(); 
            /*html = $.parseHTML(test);
            $('.panel-detail').load(html);*/

        }
      })  
    }

</script>

 
 





