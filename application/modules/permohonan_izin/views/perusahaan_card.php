<!-- START LOOP M_GRUP -->
<!-- <form class="form-horizontal form-pbio" role="form"> -->
<?php 
$nogrup = 1;
foreach($m_grup as $mgp) { 
?>
<div class="row form-pbio">
<div class="div-grup">
  <div class="card-box table-responsive">
      <!-- <h4 class="m-t-0 header-title">Bagian <?php echo $nogrup++.' : '.$mgp['teks_judul'];?></h4> -->
      <h4 class="m-t-0 header-title"><?php echo $mgp['teks_judul'];?></h4>
      <p class="text-muted font-13 m-b-30"><?php echo $mgp['teks_subjudul'];?></p>

      <div class="row">
        <div class="col-md-12">
        <!-- GET TBL M_SINGLE -->
        <?php
        $condition    = [];
        $condition[]  = ['aktif', 1, 'where'];
        $condition[]  = ['show_pg_be', 1, 'where'];

        //if show first
        if($id_perusahaan == 0) {
          $condition[]  = ['show_first', 1, 'where'];
        }
        
        $condition[]  = ['id_perusahaan_bio_grup', $mgp['id_perusahaan_bio_grup'], 'where'];
        $condition[]  = ['kd_perusahaan_bio_s', 'asc', 'order_by'];
        $m_single     = $this->M_core->get_tbl('m_perusahaan_bio_s', '*', $condition)->result_array(); 
        ?>

        <!-- START LOOP M_SINGLE -->
        <?php
        $no = 1;
        foreach($m_single as $msi) {
        $reqDt  = $this->M_core->reqDetect($msi['wajib_isi']);
        ?>

        <!-- GET TBL T_SINGLE -->
        <?php
        $condition    = [];
        $condition[]  = ['aktif', 1, 'where'];
        $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
        $condition[]  = ['id_perusahaan_bio_s', $msi['id_perusahaan_bio_s'], 'where'];
        $condition[]  = ['index', 'asc', 'order_by'];
        $t_single     = $this->M_core->get_tbl($msi['table_tujuan_s'], '*', $condition);
        ?>

          <!-- FILE -->
          <?php
          if($msi['jenis_input'] == 'file') {
            //FILE NON MULTIVALUE
            if($msi['multivalue'] == 0) { 
              if($t_single->num_rows() == 0) {
              ?>  
                <div class="row">
                  <div class="div-label-file">
                    <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-file">
                    <input class="form-control input-file <?php echo $msi['class']?>" 
                           id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>[]" value="" 
                           placeholder="<?php echo $msi['sub_teks_judul'];?>" <?php echo $msi['attribute']?>
                           <?php echo $reqDt['attr'];?>> 
                  </div>
                  <div class="div-fln-file">
                    <input class="form-control fln-file" 
                           id="<?php echo $msi['nama_perusahaan_bio'];?>_fln" type="text" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>_fln[]" value="" 
                           placeholder="filename"> 
                  </div>
                  <div class="div-cttn-file">
                    <input class="form-control cttn-file" 
                           id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="" 
                           placeholder="catatan"> 
                  </div>
                </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                ?>
                  <div class="row">
                    <div class="div-label-file">
                      <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-file" style="display:block;">
                      <input class="form-control input-file <?php echo $msi['class']?>"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>[]"
                             placeholder="<?php echo $msi['sub_teks_judul'];?>"
                             <?php echo $reqDt['attr'];?> <?php echo $msi['attribute']?>> 
                    </div>
                    <div class="div-fln-file">
                      <input class="form-control fln-file" 
                             id="<?php echo $msi['nama_perusahaan_bio'];?>_fln" type="hidden" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>_fln[]" value="<?php echo $tsi['file_name_asli']?>" 
                             placeholder="filename" style="display:none;"> 
                             <a onclick="showFilePbio(this)" 
                                data-id="<?php echo $tsi[$msi['pk_tujuan_s']]?>" data-index="<?php echo $tsi['index']?>">
                                <u><?php echo $tsi['file_name_asli']?></u>
                             </a>
                    </div>
                    <div class="div-cttn-file">
                      <input class="form-control cttn-file cttn-val"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $tsi['catatan']?>" 
                             placeholder="catatan"> 
                    </div>
                  </div>
                <?php
                }
              }
            ?>
            <?php
            //FILE MULTIVALUE
            } else {
              if($t_single->num_rows() == 0) {
              ?>
              <div class="file-multiple">
                <div class="row">
                  <div class="div-label-file">
                    <span class="file-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-file">
                    <input class="form-control input-file <?php echo $msi['class']?>"
                           id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>[]" class="file-value" <?php echo $reqDt['attr'];?>
                           placeholder="<?php echo $msi['sub_teks_judul'];?>" <?php echo $msi['attribute']?>> 
                  </div>
                  <div class="div-fln-file">
                    <input class="form-control fln-file" 
                           id="<?php echo $msi['nama_perusahaan_bio'];?>_fln" type="text" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>_fln[]"
                           placeholder="filename"> 
                  </div>
                  <div class="div-cttn-file">
                    <input class="form-control cttn-file cttn-val"
                           id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" 
                           placeholder="catatan"> 
                  </div>
                  <div class="col-md-2">
                    <div class="file-button">
                      <button type="button" class="btn btn-primary add-file-row-pbio">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                  $indexArr[] = $tsi['index'];
                }
                foreach($t_single->result_array() as $tsi) {
                  $last_index = max($indexArr);
                ?>
                <div class="file-multiple">
                  <div class="row">
                    <div class="div-label-file">
                      <span class="file-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-file">
                      <input class="form-control input-file file-value <?php echo $msi['class']?>"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>[]"
                             <?php echo $reqDt['attr'];?>
                             placeholder="<?php echo $msi['sub_teks_judul'];?>" <?php echo $msi['attribute']?>> 
                    </div>
                    <div class="div-fln-file">
                      <input class="form-control fln-file" 
                             id="<?php echo $msi['nama_perusahaan_bio'];?>_fln" type="text" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>_fln[]" value="<?php echo $tsi['file_name_asli']?>" 
                             placeholder="filename" style="display:none;"> 
                             <a onclick="showFilePbio(this)" 
                                data-id="<?php echo $tsi[$msi['pk_tujuan_s']]?>" data-index="<?php echo $tsi['index']?>">
                                <u><?php echo $tsi['file_name_asli']?></u>
                             </a>
                    </div>
                    <div class="div-cttn-file">
                      <input class="form-control cttn-file cttn-val"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $tsi['catatan']?>"
                             placeholder="catatan"> 
                    </div>
                    <?php
                    if($tsi['index'] == $last_index) {
                    ?>
                    <div class="col-md-2">
                      <div class="file-button">
                        <button type="button" class="btn btn-primary add-file-row-pbio">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <?php
                    }
                    ?>
                  </div>
                </div>
                <?php
                }
              }
            }
          }
          ?>


          <!-- TEXT/NUMBER/EMAIL/DATE/CURRENCY -->
          <?php
          if(($msi['jenis_input'] == 'text') || ($msi['jenis_input'] == 'number') || 
            ($msi['jenis_input'] == 'email') || ($msi['jenis_input'] == 'date') || 
            ($msi['jenis_input'] == 'currency')) {
            // NON MULTIVALUE
            if($msi['multivalue'] == 0) { 
              if($t_single->num_rows() == 0) {
              ?>  
                <div class="row">
                  <div class="div-label-tne">
                    <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-tne">
                    <input class="form-control input-tne <?php echo $msi['class']?>" 
                           id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>[]" value="" data-val=""
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"
                           <?php echo $reqDt['attr'];?>
                           <?php echo $msi['attribute']?>> 
                  </div>
                  <div class="div-cttn-tne">
                    <input class="form-control cttn-tne cttn-val" 
                           id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="" 
                           placeholder="catatan"> 
                  </div>
                </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                ?>
                  <div class="row">
                    <div class="div-label-tne">
                      <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-tne">
                      <input class="form-control input-tne <?php echo $msi['class']?>"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>[]" 
                             data-val="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>" 
                             value="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>" 
                             placeholder="<?php echo $msi['sub_teks_judul'];?>"
                             <?php echo $msi['attribute']?>
                             <?php echo $reqDt['attr'];?>> 
                    </div>
                    <div class="div-cttn-tne">
                      <input class="form-control cttn-tne cttn-val"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>" type="text" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $tsi['catatan']?>" 
                             placeholder="catatan"> 
                    </div>
                  </div>
                <?php
                }
              }
            ?>
            <?php
            // MULTIVALUE
            } else {
              if($t_single->num_rows() == 0) {
              ?>
              <div class="text-multiple">
                <div class="row">
                  <div class="div-label-tne">
                    <span class="text-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-tne">
                    <input class="form-control input-tne text-value <?php echo $msi['class']?>"
                           id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>[]" data-val="" value=""
                           <?php echo $reqDt['attr'];?> 
                           <?php echo $msi['attribute']?>
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"> 
                  </div>
                  <div class="div-cttn-tne">
                    <input class="form-control cttn-tne cttn-val"
                           id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" 
                           placeholder="catatan"> 
                  </div>
                  <div class="col-md-2">
                    <div class="text-button">
                      <button type="button" class="btn btn-primary add-text-row-pbio">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                  $indexArr[] = $tsi['index'];
                }
                foreach($t_single->result_array() as $tsi) {
                  $last_index = max($indexArr);
                ?>
                <div class="text-multiple">
                  <div class="row">
                    <div class="div-label-tne">
                      <span class="text-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-tne">
                      <input class="form-control input-tne <?php echo $msi['class']?>"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>[]" class="text-value" 
                             data-val="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>" 
                             value="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>"
                             <?php echo $reqDt['attr'];?> 
                             <?php echo $msi['attribute']?>
                             placeholder="<?php echo $msi['sub_teks_judul'];?>"> 
                    </div>
                    <div class="div-cttn-tne">
                      <input class="form-control cttn-tne cttn-val"
                             id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                             name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $tsi['catatan']?>"
                             placeholder="catatan"> 
                    </div>
                    <?php
                    if($tsi['index'] == $last_index) {
                    ?>
                    <div class="col-md-2">
                      <div class="text-button">
                        <button type="button" class="btn btn-primary add-text-row-pbio">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <?php
                    }
                    ?>
                  </div>
                </div>
                <?php
                }
              }
            }
          }
          ?>


          <!-- SELECT -->
          <?php
          if(($msi['jenis_input'] == 'select') && ($msi['special'] == null)) {
            // CTTN            
            if($t_single->num_rows() != 0) {
              $dcttn      = $t_single->row_array();
              $cttn       = $dcttn['catatan'];
            } else {
              $cttn = '';
            }

            //SELECT NON MULTIVALUE
            if($msi['multivalue'] == 0) {
              $multiple = '';
            //SELECT MULTIVALUE
            } else if($msi['multivalue'] == 1) {
              $multiple = 'multiple';
            }
            ?>  
            <div class="row" style="margin-bottom: 15px;">
              <div class="div-label-select">
                <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
              </div>
              <div class="div-input-select">
                <select class="form-control input-select <?php echo $msi['class']?>"
                        name="<?php echo $msi['nama_perusahaan_bio'];?>[]" 
                        id="<?php echo $msi['nama_perusahaan_bio'];?>"
                        <?php echo $multiple?> <?php echo $reqDt['attr'];?> <?php echo $msi['attribute']?>>
                  <option value=""><?php echo '- Pilih '.$msi['teks_judul'].' -';?></option>

                  <!-- GET TBL M_PLURAL -->
                  <?php
                  $condition    = [];
                  $condition[]  = ['aktif', 1, 'where'];
                  $condition[]  = ['kd_perusahaan_bio_p', 'asc', 'order_by'];
                  $condition[]  = ['id_perusahaan_bio_s', $msi['id_perusahaan_bio_s'], 'where'];
                  $m_plural     = $this->M_core->get_tbl('m_perusahaan_bio_p', '*', $condition)->result_array();

                  foreach($m_plural as $mpl) {
                    $condition    = [];
                    $condition[]  = ['aktif', 1, 'where'];
                    $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
                    $condition[]  = ['id_perusahaan_bio_s', $msi['id_perusahaan_bio_s'], 'where'];
                    $condition[]  = ['id_perusahaan_bio_p', $mpl['id_perusahaan_bio_p'], 'where'];
                    $condition[]  = ['index', 'asc', 'order_by'];
                    $t_plural     = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);

                    if($t_plural->num_rows() == 0) {
                      $selected = '';
                    } else {
                      $selected = 'selected';
                    }
                  ?>
                    <option value="<?php echo $mpl['id_perusahaan_bio_p'];?>" <?php echo $selected;?>><?php echo $mpl['teks_judul'];?></option>
                  <?php 
                  } 
                  ?>
                </select>
              </div>
              <div class="div-cttn-select">
                <input class="form-control cttn-select cttn-val"
                       id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                       name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $cttn?>"
                       placeholder="catatan"> 
              </div>
            </div>
          <?php
          }
          ?>



          <!-- SELECT SPECIAL-->
          <?php
          if(($msi['jenis_input'] == 'select') && ($msi['special'] == 1)) {
            // CTTN            
            if($t_single->num_rows() != 0) {
              $dcttn      = $t_single->row_array();
              $cttn       = $dcttn['catatan'];
            } else {
              $cttn = '';
            }

            $condition    = [];
            $condition[]  = ['aktif', 1, 'where'];
            $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
            $condition[]  = ['id_perusahaan_bio_s', $msi['id_perusahaan_bio_s'], 'where'];
            $t_plural     = $this->M_core->get_tbl('t_perusahaan_bio_p', '*', $condition);
            
            if($t_plural->num_rows() > 0) {
              $tpl = $t_plural->row_array();
              $val = $tpl['nilai_num'];
            } else {
              $val = 0;
            }

            ?>  
            <div class="row" style="margin-bottom: 15px;">
              <div class="div-label-select">
                <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
              </div>
              <div class="div-input-select">
                <select class="form-control input-select <?php echo $msi['class']?>"
                        name="<?php echo $msi['nama_perusahaan_bio'];?>_num[]" 
                        id="<?php echo $msi['nama_perusahaan_bio'];?>"
                        <?php echo $reqDt['attr'];?> <?php echo $msi['attribute']?>
                        
                        data-class_ref="<?php echo $msi['class_ref']?>"
                        data-tbl_ref1="<?php echo $msi['tbl_ref1']?>"
                        data-pk_ref1="<?php echo $msi['pk_ref1']?>"
                        data-nm_ref1="<?php echo $msi['nm_ref1']?>"

                        data-tbl_ref2="<?php echo $msi['tbl_ref2']?>"
                        data-pk_ref2="<?php echo $msi['pk_ref2']?>"
                        data-nm_ref2="<?php echo $msi['nm_ref2']?>"

                        data-judul_ref1="<?php echo $msi['judul_ref1']?>"
                        data-judul_ref2="<?php echo $msi['judul_ref2']?>"

                        data-text_ref1="<?php echo $msi['text_ref1']?>"
                        data-text_ref2="<?php echo $msi['text_ref2']?>"

                        data-val="<?php echo $val;?>"
                        >
                  <option value=""><?php echo '- Pilih '.$msi['teks_judul'].' -';?></option>
                </select>
                <input type="hidden" name="<?php echo $msi['nama_perusahaan_bio'];?>_string[]">
              </div>
              <div class="div-cttn-select">
                <input class="form-control cttn-select"
                       id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                       name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $cttn?>"
                       placeholder="catatan"> 
              </div>
            </div>
          <?php
          }
          ?>



          <!-- TBL -->
          <?php
          //TBL MULTIVALUE 
          if($msi['jenis_input'] == 'tbl') {
            //CTTN
            if($t_single->num_rows() != 0) {
              $dcttn      = $t_single->row_array();
              $cttn       = $dcttn['catatan'];
            } else {
              $cttn = '';
            }

          ?>
            <div class="row" style="margin-bottom:15px;">
              <div class="div-label-tbl">
                <span><?php echo $no++.'. '.$msi['teks_judul'];?></span>
              </div>
              <div class="div-input-tbl" style="overflow-x: auto;">
                <table class="table table-bordered table-hover">
                  <thead>
                  <tr>  
                    <th class="text-center">No</th>

                    <!-- GET TBL M_PLURAL -->
                    <?php
                    $condition    = [];
                    $condition[]  = ['aktif', 1, 'where'];
                    $condition[]  = ['kd_perusahaan_bio_p', 'asc', 'order_by'];
                    $condition[]  = ['id_perusahaan_bio_s', $msi['id_perusahaan_bio_s'], 'where'];
                    $m_plural     = $this->M_core->get_tbl('m_perusahaan_bio_p', '*', $condition);

                    $idmpl = [];
                    foreach($m_plural->result_array() as $mpl) {
                      $idmpl[] = $mpl['id_perusahaan_bio_p'];
                    ?>
                      <th name="<?php echo $mpl['id_perusahaan_bio_p'];?>" class="text-center"><?php echo $mpl['teks_judul'];?></th>
                    <?php 
                    } 
                    ?>
                    <th class="text-center">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $t_plural_group = $this->M_core->t_plural_group_2($id_perusahaan, 'perusahaan_bio');
                    
                    $idtpl = [];
                    foreach($t_plural_group->result_array() as $tpg) {
                      $idtpl[] = $tpg['id_perusahaan_bio_p'];
                    }

                    $idmtpl = array_intersect($idmpl, $idtpl);
                    $jml_mtpl = sizeOf($idmtpl);
                    ?>

                    <?php 
                    if($jml_mtpl == 0) {
                    ?>
                      <tr style="display: none;">
                        <td class="text-center number"></td>
                        <?php
                        foreach($m_plural->result_array() as $mpl) {
                        ?>
                          <td>
                            <input type="<?php echo $mpl['jenis_input'];?>" data-val="" value=""
                            name="<?php echo $mpl['nama_perusahaan_bio_p'];?>[]" disabled
                            class="form-control" placeholder="<?php echo $mpl['teks_judul'];?>">
                          </td>
                        <?php 
                        } 
                        ?>
                        <td class="text-center">
                          <button type="button" class="btn btn-danger del-tbl-row-pbio">
                            <i class="fa fa-minus"></i>
                          </button>
                        </td>
                      </tr>
                    <?php  
                    } else {
                      $t_plural_group_index = $this->M_core->t_plural_group_index_2($id_perusahaan, 'perusahaan_bio');
                      $jml_tpgi             = $t_plural_group_index->num_rows(); 
                      for($i=0;$i<$jml_tpgi;$i++) {
                      ?>
                        <tr>
                          <td class="text-center number"></td>
                          <?php
                          foreach($m_plural->result_array() as $mpl) {

                          $condition    = [];
                          $condition[]  = ['aktif', 1, 'where'];
                          $condition[]  = ['id_perusahaan', $id_perusahaan, 'where'];
                          $condition[]  = ['id_perusahaan_bio_s', $msi['id_perusahaan_bio_s'], 'where'];
                          $condition[]  = ['id_perusahaan_bio_p', $mpl['id_perusahaan_bio_p'], 'where'];
                          $condition[]  = ['index', $i+1, 'where'];
                          $t_plural     = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);
                            
                            if($t_plural->num_rows() == 0) {
                            ?>
                              <td>
                                <input type="<?php echo $mpl['teks_judul'];?>" data-val="" value=""
                                name="<?php echo $mpl['nama_perusahaan_bio_p'];?>[]" 
                                class="form-control input-tbl" placeholder="<?php echo $mpl['teks_judul'];?>" value="">
                              </td>
                            <?php
                            } else {
                              $tpl = $t_plural->row_array();
                            ?>
                              <td>
                                <input type="<?php echo $mpl['jenis_input'];?>" 
                                name="<?php echo $mpl['nama_perusahaan_bio_p'];?>[]"
                                class="form-control input-tbl" 
                                placeholder="<?php echo $mpl['teks_judul'];?>" 
                                data-val="<?php echo $tpl['nilai_'.$mpl['tipe_data']]?>"
                                value="<?php echo $tpl['nilai_'.$mpl['tipe_data']]?>">
                              </td>
                            <?php
                            }                          
                          } 
                          ?>
                          <td class="text-center">
                            <button type="button" style="display:none" 
                            class="btn btn-danger del-tbl-row-pbio">
                              <i class="fa fa-minus"></i>
                            </button>
                          </td>
                        </tr>
                      <?php 
                      }
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="<?php echo $m_plural->num_rows()+1?>"></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-primary add-tbl-row-pbio">
                          <i class="fa fa-plus"></i>
                        </button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="div-cttn-tbl">
                <input class="form-control cttn-tbl cttn-val"
                       id="<?php echo $msi['nama_perusahaan_bio'];?>_cttn" type="text" 
                       name="<?php echo $msi['nama_perusahaan_bio'];?>_cttn[]" value="<?php echo $cttn?>"
                       placeholder="catatan"> 
              </div>
            </div>
          <?php
          }
          ?>

        <!-- END LOOP M_SINGLE -->
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
</div>
<!-- END LOOP M_GRUP -->
<?php 
} 
?>
<!-- </form> -->

<script type="text/javascript">
  $(document).ready(function() {
    //btn
    $('.form-pbio').find('.div-btn-submit').css('display', 'none');     
    $('.form-pbio').find('.btn-submit').css('disabled', true);

    //grup
    $('.form-pbio').find('.div-grup').attr('class', 'div-grup col-md-12');

    //file
    $('.form-pbio').find('.div-label-file').attr('class', 'div-label-file col-md-6');
    $('.form-pbio').find('.div-input-file').css('display', 'none');
    $('.form-pbio').find('.div-fln-file').attr('class', 'div-fln-file col-md-6');
    $('.form-pbio').find('.div-cttn-file').css('display', 'none');

    //tne
    $('.form-pbio').find('.div-label-tne').attr('class', 'div-label-tne col-md-6');
    $('.form-pbio').find('.div-input-tne').attr('class', 'div-input-tne col-md-6');
    $('.form-pbio').find('.div-cttn-tne').css('display', 'none');

    //select
    $('.form-pbio').find('.div-label-select').attr('class', 'div-label-select col-md-6');
    $('.form-pbio').find('.div-input-select').attr('class', 'div-input-select col-md-6');
    $('.form-pbio').find('.div-cttn-select').css('diplay', 'none');
    
    //tbl
    $('.form-pbio').find('.div-label-tbl').attr('class', 'div-label-tbl col-md-12');
    $('.form-pbio').find('.div-input-tbl').attr('class', 'div-input-tbl col-md-12');
    $('.form-pbio').find('.div-cttn-tbl').css('diplay', 'none');
  })

  //APPEND FILE 
  $(document).on('click', ".add-file-row-pbio", function() {
    var content   = $(this).closest('.row').clone();
    
    var button  = '<button type="button" class="btn btn-danger del-file-row-pbio">' +
                    '<i class="fa fa-minus"></i>' +
                  '</button>';
    var lb_awal = $('.file-label', content).text();
    var jml_row = $(this).closest('.file-multiple').find('.row').length;
    var label   = lb_awal + " ("+jml_row+") ";

    $('input', content).val('');
    $('.file-label', content).text(label);
    $('.file-label', content).removeClass('active');
    $('.file-button', content).html(button);
    $(this).closest('.file-multiple').append(content);
  })

  $(document).on('click', ".del-file-row-pbio", function() {
    $(this).closest('.row').remove();
  })

  //SHOW FILE
  function showFilePbio(e) {
    var id    = $(e).data('id');
    var index = $(e).data('index');
    var data  = {"id": id, "index": index};
    $.ajax({
        url : "<?php echo base_url('permohonan_izin/show_file/perusahaan_bio')?>",
        dataType: "html",
        data: data,
        type: "POST",
        success: function(data){
          $('#showFileObj').load().html(data);
          $('#showFile').modal('show'); 
        }
    });   
  }


  //APPEND TEXT 
  $(document).on('click', ".add-text-row-pbio", function() {
    var content   = $(this).closest('.row').clone();
    
    var button  = '<button type="button" class="btn btn-danger del-text-row-pbio">' +
                    '<i class="fa fa-minus"></i>' +
                  '</button>';
    var lb_awal = $('.text-label', content).text();
    var jml_row = $(this).closest('.text-multiple').find('.row').length;
    var label   = lb_awal + " ("+jml_row+") ";

    $('input', content).val('');
    $('.text-label', content).text(label);
    $('.text-label', content).removeClass('active');
    $('.text-button', content).html(button);
    $(this).closest('.text-multiple').append(content);
  })

  $(document).on('click', ".del-text-row-pbio", function() {
    $(this).closest('.row').remove();
  })


  //APPEND TBL 
  $(document).on('click', ".add-tbl-row-pbio", function() {
    var jml_row   = $(this).closest('table').find('tbody tr').length;
    var content   = $(this).closest('table').find('tbody tr:eq(0)').clone();
    
    content.removeAttr('style');
    $('input', content).removeAttr('disabled');
    $('input', content).val('');
    $('button', content).css('display', 'block');
    $('.number', content).text('');
    $(this).closest('table').find('tbody').append(content);
  })

  $(document).on('click', ".del-tbl-row-pbio", function() {
    $(this).closest('tr').remove();
  })


  //TEXT SPECIAL
  function getApiSi(e, url_ctrl) {
    var x = $(e).val();
    $.ajax({
      type: "POST",
      url: base_url+url_ctrl,
      data: {param : x},
      datatype: "json",
      success: function(response) {
        var res = JSON.parse(response);
        if(res == false) {
          $(e).val('');
          swal("Gagal!", "Data tidak valid!", "error");
        } else {
          swal("Berhasil!", "Data valid!", "success");        
        }
      }
    });
  }

  //SELECT SPECIAL
  $('.ch1').each(function(i, e) {
    //define
    var tbl_ref1 = $(e).data('tbl_ref1');
    var pk_ref1  = $(e).data('pk_ref1');
    var nm_ref1  = $(e).data('nm_ref1');
    var judul_ref1  = $(e).data('judul_ref1');
    var judul_ref2  = $(e).data('judul_ref2');
    var text_ref1  = $(e).data('text_ref1');
    var text_ref2  = $(e).data('text_ref2');

    var val = $(e).data('val');

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>chained/getDataCh1/",
      data: { 
              tbl_ref1 : tbl_ref1,
              pk_ref1 : pk_ref1,
              nm_ref1 : nm_ref1,
              judul_ref1 : judul_ref1,
              judul_ref2 : judul_ref2,
              text_ref1 : text_ref1,
              text_ref2 : text_ref2,
              val : val
            },
      dataType:"html",
      success: function(response) {
        $(e).html(response);
      }
    });
  });

  $('.ch2').each(function(i, e) {
    //define
    var tbl_ref1  = $(e).data('tbl_ref1');
    var pk_ref1   = $(e).data('pk_ref1');
    var nm_ref1   = $(e).data('nm_ref1');
    var judul_ref1  = $(e).data('judul_ref1');
    var judul_ref2  = $(e).data('judul_ref2');
    var text_ref1  = $(e).data('text_ref1');
    var text_ref2  = $(e).data('text_ref2');

    var val = $(e).data('val');

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>chained/getDataCh2/",
      data: { 
              tbl_ref1 : tbl_ref1,
              pk_ref1 : pk_ref1,
              nm_ref1 : nm_ref1,
              judul_ref1 : judul_ref1,
              judul_ref2 : judul_ref2,
              text_ref1 : text_ref1,
              text_ref2 : text_ref2,
              val : val
            },
      dataType:"html",
      success: function(response) {
        $(e).html(response);
      }
    });
  });

  function showCh2(e) {
    //define
    var pk_ref1 = $(e).data('pk_ref1');

    var tbl_ref2  = $(e).data('tbl_ref2');
    var pk_ref2   = $(e).data('pk_ref2');
    var nm_ref2   = $(e).data('nm_ref2');

    var judul_ref1  = $(e).data('judul_ref1');
    var judul_ref2  = $(e).data('judul_ref2');

    var text_ref1  = $(e).data('text_ref1');
    var text_ref2  = $(e).data('text_ref2');

    var class_ref = $(e).data('class_ref');
    var kode      = $(e).val();

    var string    = $(e).find('option:selected').text();
    $(e).siblings().val(string);

    if(class_ref != '') {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>chained/showCh2/",
        data: { 
                pk_ref1 : pk_ref1,
                tbl_ref2 : tbl_ref2,
                pk_ref2 : pk_ref2,
                nm_ref2 : nm_ref2,
                judul_ref1 : judul_ref1,
                judul_ref2 : judul_ref2,
                text_ref1 : text_ref1,
                text_ref2 : text_ref2,
                kode : kode
              },
        dataType: "html",
        success: function(response){
          $('.'+class_ref).html(response);
        }
      });
    }
  }
</script>
