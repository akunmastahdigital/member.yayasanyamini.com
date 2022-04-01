<?php 
if ($page == 'accord') { ?>

  <div class="panel">
      <div class="panel-heading">
          <div class="panel-title">
              <a class="action collapsed" data-action="show-group" 
              data-id="<?php echo $datag['id'];?>"
              data-toggle="collapse" 
              data-parent="#accordion" 
              href="#<?php echo $datag['hc'];?>">
                 <?php echo $datag['no'].'. '.$datag['teks_judul'];?>
              </a>
          <button type="button" data-action="add-child" data-id="<?php echo $datag['id'];?>" class="action btn btn-xs waves-effect btn-primary tooltip-hover pull-right" title="Tambah Data"> 
            <i class="fa fa-plus"></i>
          </button>
          <button type="button" data-action="edit" data-id="<?php echo $datag['id'];?>" class="action btn btn-xs waves-effect btn-info m-r-5 tooltip-hover pull-right" title="Edit Grup Perusahaan"> 
            <i class="fa fa-pencil"></i>
          </button>                      
          </div>
          <!-- <div class="pull-right"> -->
          <!-- </div>                 -->
      </div>
      <!-- <div id="<?php echo $datag['hc'];?>" class="panel-collapse collapse <?php echo $datag['no']==1 ? 'in' : '';?>"> -->
      <div id="<?php echo $datag['hc'];?>" class="panel-collapse collapse">
          <div class="panel-body">
              Content Table
          </div>
      </div>
  </div>

<?php 
} elseif($page == 'dt_child') { ?>
  <table id="datatables-ss" class="table table-striped table-bordered">
    <thead>
      <tr>
          <th>ID</th>
          <th>Kode Bio</th>
          <th>Teks Judul</th>
          <th>Jenis Input</th>
          <th>Status</th>
          <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
    </tbody>

  </table> 
<?php } else { ?>

<?php } ?>
