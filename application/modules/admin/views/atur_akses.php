
<style type="text/css">
 input[type="checkbox"]{
  width: 15px; /*Desired width*/
  height: 15px; /*Desired height*/
  
}
/*{
  
  font-size: 25%;
  
}*/
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
<?php 

foreach ($getJabatanById as $g) {
  $role = $g->nm_role;
  $id_role = $g->id_role;
}

?>

      <div class="row">
          <div class="col-sm-12">
              <div class="card-box table-responsive">
                  <h4 class="m-t-0 header-title"><?php echo $title .' '. $role;?></b> 
                  </h4>

                  <p class="text-muted font-13 m-b-30">
                      <?php echo $title .' '. $role;?>
                      <button type="button" onclick="window.location='<?php echo base_url();?>admin/hak_akses'" class="btn btn-xs btn-success">Kembali</button>
                  </p>

                  <div class="row">
                    <div class="col-md-12">
                         <form class="form-field">
                           <input type="hidden" name="id_role" value="<?php echo $id_role;?>">
                            <?php echo $getMenuTree;?>
                            <div class="col-md-11"></div>
                            <div class="col-md-1"> 
                              <button type="submit" class="btn btn-xl btn-info" id="myButton">Simpan</button>
                            </div>
                         </form>
                    </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>

  <?php $this->load->view('copyright'); ?>

  </div>
</div>

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

<script type="text/javascript">

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

        if (action == "aktif") {
            var check   = $(this).prop("checked");
            if (check) {
                var status  = "1";
            } else {
                var status  = "0";
            }
            var id_role     = $(this).attr('data-id_role');
            var id_menu_bo  = $(this).attr('data-id_menu_bo');
            var nama        = $(this).closest("tr").find("td:eq(1)").text();

            $.ajax({
              url : "<?php echo base_url('admin/atur_akses_action')?>/"+action,
              dataType: "json",
              data: 'id_role='+id_role+'&status='+status+'&id_menu_bo='+id_menu_bo,
              type: "POST",
              success: function(data) {
                if (data.status == 1) {
                  var text    = 'aktifkan';

                } else if (data.status == 0) {
                  var text    = 'nonaktifkan';

                }
                  // swal({
                  //   title: "Berhasil!",
                  //   text: nama+' telah di'+text,
                  //   type: "success",
                  // });
              }
            })
            
        }
    })
     
</script>

<script>
$(document).ready(function(){
    $('#myButton').click(function(){

           swal({
                    title: "Berhasil!",
                    text: "Data Berhasil Disimpan",
                    type: "success",
                  });
    });
});
</script>





