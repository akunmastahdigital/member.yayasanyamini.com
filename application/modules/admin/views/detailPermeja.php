
    <?php 
    if ($page == 'aktivitas') {?>
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a class="action collapsed"
             data-id="<?php echo $dataAktivitas['id_aktivitas']?>"
             data-toggle="collapse"
             data-action="detail" 
             data-parent="#accordion" 
             href="#<?php echo $dataAktivitas['id_aktivitas']?>"><?php echo $dataAktivitas['nama_aktivitas'];?><span class="badge badge-grey"><?php echo $getJumlahTotal ;?></span></a>
        </h4>
      </div>
        <div id="<?php echo $dataAktivitas['id_aktivitas'];?>" class="panel-collapse collapse">
          <div class="panel-body">
              Content Table
          </div>
      </div>
    </div>
    <?php
    }elseif ($page == 'detailPermeja') {  
    ?>

    <table id="datatables-ss" class="table table-striped table-bordered">
    <thead>
      <tr>
          <th style="text-align: center;">NAMA</th>
          <th style="text-align: center;">JUMLAH</th>
      </tr>
    </thead>

    <tbody class="showData">

    </tbody>

  </table> 

    <?php
    }
    ?>

