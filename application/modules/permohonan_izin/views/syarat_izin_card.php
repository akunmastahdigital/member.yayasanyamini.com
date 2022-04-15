<!-- START LOOP M_GRUP -->
<!-- <form class="form-horizontal form-si" role="form"> -->
<style>
  table.table-bordered thead th, table.table-bordered thead td, table.table-bordered tbody th, table.table-bordered tbody td {
        vertical-align: middle;
    }
    thead{
      background: #3ac9d6;
      color: #fff;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
      background:none;
    }
</style>

<?php 
$nogrup = 1;
$table_multi = 0;
foreach($m_grup as $mgp) { 
?>
<div class="row form-si">
<div class="div-grup">
  <div class="card-box table-responsive">
      <h4 class="m-t-0 header-title">Bagian <?php echo $nogrup++.' : '.$mgp['teks_judul'];?></h4>
      <p class="text-muted font-13 m-b-30"><?php echo $mgp['teks_subjudul'];?></p>

      <div class="row m-b-10">
        <div class="col-md-12">
        <!-- GET TBL M_SINGLE -->
        <?php
        $condition    = [];
        $condition[]  = ['aktif', 1, 'where'];
        
        //if show first
        if($id_permohonan == 0) {
          $condition[]  = ['show_first', 1, 'where'];
        }
        
        $condition[]  = ['id_syarat_izin_grup', $mgp['id_syarat_izin_grup'], 'where'];
        $condition[]  = ['kd_syarat_izin_s', 'asc', 'order_by'];
        $m_single     = $this->M_core->get_tbl('m_syarat_izin_s', '*', $condition)->result_array(); 
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
        $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
        $condition[]  = ['id_syarat_izin_s', $msi['id_syarat_izin_s'], 'where'];
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
                <div class="row m-b-10">
                  <div class="div-label-file">
                    <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-file">
                    <input class="form-control input-file" 
                           id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_syarat_izin'];?>[]" value="" 
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"
                           <?php echo $reqDt['attr'];?>> 
                  </div>
                  <div class="div-fln-file">
                    <input class="form-control fln-file" 
                           id="<?php echo $msi['nama_syarat_izin'];?>_fln" type="text" 
                           name="<?php echo $msi['nama_syarat_izin'];?>_fln[]" value="" 
                           placeholder="filename"> 
                  </div>
                  <!-- <div class="div-cttn-file">
                    <input class="form-control cttn-file cttn-val" 
                           id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="" 
                           placeholder="catatan"> 
                  </div>
                  <div class="div-act-file">
                    <button type="button" class="btn btn-success btn-sm"
                              onclick="save_cttn(null, null, '<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)" 
                              <?php echo $permission;?>>
                        Simpan catatan
                      </button>
                  </div> -->
                </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                ?>
                  <div class="row m-b-10">
                    <div class="div-label-file">
                      <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-file" style="display:block;">
                      <input class="form-control input-file"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_syarat_izin'];?>[]"
                             placeholder="<?php echo $msi['sub_teks_judul'];?>"
                             <?php echo $reqDt['attr'];?>"> 
                    </div>
                    <div class="div-fln-file">
                      <input class="form-control fln-file" 
                             id="<?php echo $msi['nama_syarat_izin'];?>_fln" type="hidden" 
                             name="<?php echo $msi['nama_syarat_izin'];?>_fln[]" value="<?php echo $tsi['file_name_asli']?>" 
                             placeholder="filename" style="display:none;"> 
                             <a onclick="showFileSi(this)" 
                                data-id="<?php echo $tsi[$msi['pk_tujuan_s']]?>" data-index="<?php echo $tsi['index']?>">
                                <u><?php echo $tsi['file_name_asli']?></u>
                             </a>&nbsp;
                             <a class="btn btn-sm btn-danger" target="_blank" href="<?php echo $tsi['file_lokasi'].'/'.$tsi['file_name_hash']?>" download="<?php echo $tsi['file_name_asli']?>"><i class="fa fa-download"></i> &nbsp;Download File</a>
                    </div>
                    <!-- <div class="div-cttn-file">
                      <input class="form-control cttn-file cttn-val"
                             id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                             name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $tsi['catatan']?>" 
                             placeholder="catatan"> 
                    </div>
                    <div class="div-act-file">
                      <button type="button" class="btn btn-success btn-sm"
                              onclick="save_cttn(<?php echo $tsi[$msi['pk_tujuan_s']]?>,<?php echo $tsi['index']?>,'<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)" 
                              <?php echo $permission;?>>
                        Simpan catatan
                      </button>
                    </div> -->
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
                <div class="row m-b-10">
                  <div class="div-label-file">
                    <span class="file-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-file">
                    <input class="form-control input-file"
                           id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_syarat_izin'];?>[]" class="file-value" <?php echo $reqDt['attr'];?>
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"> 
                  </div>
                  <div class="div-fln-file">
                    <input class="form-control fln-file" 
                           id="<?php echo $msi['nama_syarat_izin'];?>_fln" type="text" 
                           name="<?php echo $msi['nama_syarat_izin'];?>_fln[]"
                           placeholder="filename"> 
                  </div>
                  <!-- <div class="div-cttn-file">
                    <input class="form-control cttn-file cttn-val"
                           id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" 
                           placeholder="catatan"> 
                  </div>
                  <div class="div-act-file">
                    <button type="button" class="btn btn-success btn-sm"
                            onclick="save_cttn(null, null, '<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)">
                      Simpan catatan
                    </button>
                  </div> -->
                  <div class="col-md-2">
                    <div class="file-button">
                      <button type="button" class="btn btn-primary add-file-row-si">
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
                  <div class="row m-b-10">
                    <div class="div-label-file">
                      <span class="file-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-file">
                      <input class="form-control input-file file-value"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_syarat_izin'];?>[]"
                             <?php echo $reqDt['attr'];?>
                             placeholder="<?php echo $msi['sub_teks_judul'];?>"> 
                    </div>
                    <div class="div-fln-file">
                      <input class="form-control fln-file" 
                             id="<?php echo $msi['nama_syarat_izin'];?>_fln" type="text" 
                             name="<?php echo $msi['nama_syarat_izin'];?>_fln[]" value="<?php echo $tsi['file_name_asli']?>" 
                             placeholder="filename" style="display:none;"> 
                             <a onclick="showFileSi(this)" 
                                data-id="<?php echo $tsi[$msi['pk_tujuan_s']]?>" data-index="<?php echo $tsi['index']?>">
                                <u><?php echo $tsi['file_name_asli']?></u>
                             </a>
                    </div>
                    <!-- <div class="div-cttn-file">
                      <input class="form-control cttn-file cttn-val"
                             id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                             name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $tsi['catatan']?>"
                             placeholder="catatan"> 
                    </div>
                    <div class="div-act-file">
                      <button type="button" class="btn btn-success btn-sm"
                              onclick="save_cttn(<?php echo $tsi[$msi['pk_tujuan_s']]?>,<?php echo $tsi['index']?>,'<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)"
                              <?php echo $permission;?>>
                        Simpan catatan
                      </button>
                    </div> -->
                    <?php
                    if($tsi['index'] == $last_index) {
                    ?>
                    <div class="col-md-2">
                      <div class="file-button">
                        <button type="button" class="btn btn-primary add-file-row-si">
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
                <div class="row m-b-10">
                  <div class="div-label-tne">
                    <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-tne">
                    <input class="form-control input-tne" 
                           id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_syarat_izin'];?>[]" value="" data-val=""
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"
                           <?php echo $reqDt['attr'];?>
                           <?php echo $msi['attribute']?>> 
                  </div>
                  <!-- <div class="div-cttn-tne">
                    <input class="form-control cttn-tne cttn-val" 
                           id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="" 
                           placeholder="catatan"> 
                  </div>
                  <div class="div-act-tne">
                    <button type="button" class="btn btn-success btn-sm"
                            onclick="save_cttn(null, null, '<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)"
                            <?php echo $permission;?>>
                      Simpan catatan
                    </button>
                  </div> -->
                </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                ?>
                  <div class="row m-b-10">
                    <div class="div-label-tne">
                      <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-tne">
                      <input class="form-control input-tne"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_syarat_izin'];?>[]" 
                             data-val="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>" 
                             value="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>" 
                             placeholder="<?php echo $msi['sub_teks_judul'];?>" readonly
                             <?php echo $msi['attribute']?>
                             <?php echo $reqDt['attr'];?>> 
                    </div>
                    <!-- <div class="div-cttn-tne">
                      <input class="form-control cttn-tne cttn-val"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="text" 
                             name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $tsi['catatan']?>" 
                             placeholder="catatan"> 
                    </div>
                    <div class="div-act-tne">
                      <button type="button" class="btn btn-success btn-sm"
                              onclick="save_cttn(<?php echo $tsi[$msi['pk_tujuan_s']]?>,<?php echo $tsi['index']?>,'<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)"
                              <?php echo $permission;?>>
                        Simpan catatan
                      </button>
                    </div> -->
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
                <div class="row m-b-10">
                  <div class="div-label-tne">
                    <span class="text-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-tne">
                    <input class="form-control input-tne text-value"
                           id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_syarat_izin'];?>[]" data-val="" value=""
                           <?php echo $reqDt['attr'];?> 
                           <?php echo $msi['attribute']?>
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"> 
                  </div>
                  <!-- <div class="div-cttn-tne">
                    <input class="form-control cttn-tne cttn-val"
                           id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                           name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" 
                           placeholder="catatan"> 
                  </div>
                  <div class="div-act-tne">
                    <button type="button" class="btn btn-success btn-sm"
                            onclick="save_cttn(null, null, '<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)"
                            <?php echo $permission;?>>
                      Simpan catatan
                    </button>
                  </div> -->
                  <div class="col-md-2">
                    <div class="text-button">
                      <button type="button" class="btn btn-primary add-text-row-si">
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
                  <div class="row m-b-10">
                    <div class="div-label-tne">
                      <span class="text-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-tne">
                      <input class="form-control input-tne"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_syarat_izin'];?>[]" class="text-value" 
                             data-val="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>"
                             value="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>"
                             <?php echo $reqDt['attr'];?> 
                             <?php echo $msi['attribute']?>
                             placeholder="<?php echo $msi['sub_teks_judul'];?>"> 
                    </div>
                    <!-- <div class="div-cttn-tne">
                      <input class="form-control cttn-tne cttn-val"
                             id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                             name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $tsi['catatan']?>"
                             placeholder="catatan"> 
                    </div>
                    <div class="div-act-tne">
                      <button type="button" class="btn btn-success btn-sm"
                              onclick="save_cttn(<?php echo $tsi[$msi['pk_tujuan_s']]?>,<?php echo $tsi['index']?>,'<?php echo $msi['pk_tujuan_s']?>', '<?php echo $msi['table_tujuan_s']?>', '<?php echo $msi['id_syarat_izin_s']?>', this)"
                              <?php echo $permission;?>>
                        Simpan catatan
                      </button>
                    </div> -->
                    <?php
                    if($tsi['index'] == $last_index) {
                    ?>
                    <div class="col-md-2">
                      <div class="text-button">
                        <button type="button" class="btn btn-primary add-text-row-si">
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

          <?php
          if($msi['jenis_input'] == 'textarea') {
            // NON MULTIVALUE
            if($msi['multivalue'] == 0) { 
              if($t_single->num_rows() == 0) {
              ?>  
                <div class="row m-b-10">
                  <div class="div-label-textarea">
                    <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-textarea">
                    <textarea class="form-control input-textarea" 
                           id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_syarat_izin'];?>[]" value="" data-val=""
                           placeholder="<?php echo $msi['sub_teks_judul'];?>"
                           <?php echo $reqDt['attr'];?>
                           <?php echo $msi['attribute']?> rows="4"></textarea>
                  </div>
                </div>
              <?php
              } else {
                foreach($t_single->result_array() as $tsi) {
                ?>
                  <div class="row m-b-10">
                    <div class="div-label-textarea">
                      <span><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-textarea">
                      <textarea class="form-control input-textarea"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_syarat_izin'];?>[]" 
                             data-val="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>" 
                             placeholder="<?php echo $msi['sub_teks_judul'];?>" readonly
                             <?php echo $msi['attribute']?>
                             <?php echo $reqDt['attr'];?> rows="4"><?php echo $tsi['nilai_'.$msi['tipe_data']]?></textarea>
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
                <div class="row m-b-10">
                  <div class="div-label-textarea">
                    <span class="text-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                  </div>
                  <div class="div-input-textarea">
                    <textarea class="form-control input-textarea text-value"
                           id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                           name="<?php echo $msi['nama_syarat_izin'];?>[]" data-val="" value=""
                           <?php echo $reqDt['attr'];?> 
                           <?php echo $msi['attribute']?>
                           placeholder="<?php echo $msi['sub_teks_judul'];?>" rows="4"> </textarea>
                  </div>
                  <div class="col-md-2">
                    <div class="text-button">
                      <button type="button" class="btn btn-primary add-text-row-si">
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
                  <div class="row m-b-10">
                    <div class="div-label-textarea">
                      <span class="text-label"><?php echo $no++.'. '.$msi['teks_judul'];?> <?php echo $reqDt['symbol'];?></span>
                    </div>
                    <div class="div-input-textarea">
                      <textarea class="form-control input-textarea"
                             id="<?php echo $msi['nama_syarat_izin'];?>" type="<?php echo $msi['jenis_input'];?>" 
                             name="<?php echo $msi['nama_syarat_izin'];?>[]" class="text-value" 
                             data-val="<?php echo $tsi['nilai_'.$msi['tipe_data']]?>"
                             <?php echo $reqDt['attr'];?> 
                             <?php echo $msi['attribute']?>
                             placeholder="<?php echo $msi['sub_teks_judul'];?>" rows="4"><?php echo $tsi['nilai_'.$msi['tipe_data']]?></textarea>
                    </div>
                    <?php
                    if($tsi['index'] == $last_index) {
                    ?>
                    <div class="col-md-2">
                      <div class="text-button">
                        <button type="button" class="btn btn-primary add-text-row-si">
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

              $cval = $dcttn[$msi['pk_tujuan_s']];
              $cidx = $dcttn['index'];
              $cttn = $dcttn['catatan'];
            
            } else {
              $cval = '';
              $cidx = '';
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
                <select class="form-control input-select"
                        name="<?php echo $msi['nama_syarat_izin'];?>[]" 
                        id="<?php echo $msi['nama_syarat_izin'];?>"
                        <?php echo $multiple?> <?php echo $reqDt['attr'];?>>
                  <option value=""><?php echo '- Pilih '.$msi['teks_judul'].' -';?></option>

                  <!-- GET TBL M_PLURAL -->
                  <?php
                  $condition    = [];
                  $condition[]  = ['aktif', 1, 'where'];
                  $condition[]  = ['kd_syarat_izin_p', 'asc', 'order_by'];
                  $condition[]  = ['id_syarat_izin_s', $msi['id_syarat_izin_s'], 'where'];
                  $m_plural     = $this->M_core->get_tbl('m_syarat_izin_p', '*', $condition)->result_array();

                  foreach($m_plural as $mpl) {
                    $condition    = [];
                    $condition[]  = ['aktif', 1, 'where'];
                    $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
                    $condition[]  = ['id_syarat_izin_s', $msi['id_syarat_izin_s'], 'where'];
                    $condition[]  = ['id_syarat_izin_p', $mpl['id_syarat_izin_p'], 'where'];
                    $condition[]  = ['index', 'asc', 'order_by'];
                    $t_plural     = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);

                    if($t_plural->num_rows() == 0) {
                      $selected = '';
                    } else {
                      $selected = 'selected';
                    }
                  ?>
                    <option value="<?php echo $mpl['id_syarat_izin_p'];?>" <?php echo $selected;?>><?php echo $mpl['teks_judul'];?></option>
                  <?php 
                  } 
                  ?>
                </select>
              </div>
              <!-- <div class="div-cttn-select">
                <input class="form-control cttn-select cttn-val"
                       id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                       name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $cttn?>"
                       placeholder="catatan"> 
              </div>
              <div class="div-act-select">
                <button type="button" class="btn btn-success btn-sm"
                        onclick="save_cttn(<?php echo $cval;?>,<?php echo $cidx;?>,'<?php echo $msi['pk_tujuan_s']?>','<?php echo $msi['table_tujuan_s']?>','<?php echo $msi['id_syarat_izin_s']?>',this)"
                        <?php echo $permission;?>>
                  Simpan catatan
                </button>
              </div> -->
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

              $cval = $dcttn[$msi['pk_tujuan_s']];
              $cidx = $dcttn['index'];
              $cttn = $dcttn['catatan'];

            } else {
              $cval = '';
              $cidx = '';
              $cttn = '';

            }

            $condition    = [];
            $condition[]  = ['aktif', 1, 'where'];
            $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
            $condition[]  = ['id_syarat_izin_s', $msi['id_syarat_izin_s'], 'where'];
            $t_plural     = $this->M_core->get_tbl('t_syarat_izin_p', '*', $condition);
            
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
                        name="<?php echo $msi['nama_syarat_izin'];?>_num[]" 
                        id="<?php echo $msi['nama_syarat_izin'];?>"
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
                <input type="hidden" name="<?php echo $msi['nama_syarat_izin'];?>_string[]">
              </div>
              <!-- <div class="div-cttn-select">
                <input class="form-control cttn-select"
                       id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                       name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $cttn?>"
                       placeholder="catatan"> 
              </div>
              <div class="div-act-select">
                <button type="button" class="btn btn-success btn-sm"
                        onclick="save_cttn(<?php echo $cval;?>,<?php echo $cidx;?>,'<?php echo $msi['pk_tujuan_s']?>','<?php echo $msi['table_tujuan_s']?>','<?php echo $msi['id_syarat_izin_s']?>',this)"
                        <?php echo $permission;?>>
                  Simpan catatan
                </button>
              </div> -->
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

              $cval = $dcttn[$msi['pk_tujuan_s']];
              $cidx = $dcttn['index'];
              $cttn = $dcttn['catatan'];
            
            } else {
              $cval = '';
              $cidx = '';
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
                    $condition[]  = ['kd_syarat_izin_p', 'asc', 'order_by'];
                    $condition[]  = ['id_syarat_izin_s', $msi['id_syarat_izin_s'], 'where'];
                    $m_plural     = $this->M_core->get_tbl('m_syarat_izin_p', '*', $condition);

                    $idmpl = [];
                    foreach($m_plural->result_array() as $mpl) {
                      $idmpl[] = $mpl['id_syarat_izin_p'];
                    ?>
                      <th name="<?php echo $mpl['id_syarat_izin_p'];?>" class="text-center"><?php echo $mpl['teks_judul'];?></th>
                    <?php 
                    } 
                    ?>
                    <th class="text-center">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $t_plural_group = $this->M_core->t_plural_group_1($id_permohonan, 'syarat_izin');
                    
                    $idtpl = [];
                    foreach($t_plural_group->result_array() as $tpg) {
                      $idtpl[] = $tpg['id_syarat_izin_p'];
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
                            name="<?php echo $mpl['nama_syarat_izin_p'];?>[]" disabled
                            class="form-control" placeholder="<?php echo $mpl['teks_judul'];?>">
                          </td>
                        <?php 
                        } 
                        ?>
                        <td class="text-center">
                          <button type="button" class="btn btn-danger del-tbl-row-si">
                            <i class="fa fa-minus"></i>
                          </button>
                        </td>
                      </tr>
                    <?php  
                    } else {
                      $t_plural_group_index = $this->M_core->t_plural_group_index_1($id_permohonan, 'syarat_izin');
                      $jml_tpgi             = $t_plural_group_index->num_rows(); 
                      for($i=0;$i<$jml_tpgi;$i++) {
                      ?>
                        <tr>
                          <td class="text-center number"></td>
                          <?php
                          foreach($m_plural->result_array() as $mpl) {

                          $condition    = [];
                          $condition[]  = ['aktif', 1, 'where'];
                          $condition[]  = ['id_permohonan', $id_permohonan, 'where'];
                          $condition[]  = ['id_syarat_izin_s', $msi['id_syarat_izin_s'], 'where'];
                          $condition[]  = ['id_syarat_izin_p', $mpl['id_syarat_izin_p'], 'where'];
                          $condition[]  = ['index', $i+1, 'where'];
                          $t_plural     = $this->M_core->get_tbl($msi['table_tujuan_p'], '*', $condition);
                            
                            if($t_plural->num_rows() == 0) {
                            ?>
                              <td>
                                <input type="<?php echo $mpl['teks_judul'];?>" data-val="" value=""
                                name="<?php echo $mpl['nama_syarat_izin_p'];?>[]" 
                                class="form-control input-tbl" placeholder="<?php echo $mpl['teks_judul'];?>" value="">
                              </td>
                            <?php
                            } else {
                              $tpl = $t_plural->row_array();
                            ?>
                              <td>
                                <input type="<?php echo $mpl['jenis_input'];?>" 
                                name="<?php echo $mpl['nama_syarat_izin_p'];?>[]"
                                class="form-control input-tbl" 
                                placeholder="<?php echo $mpl['teks_judul'];?>" 
                                data-val="<?php echo $tpl['nilai_'.$mpl['tipe_data']]?>"
                                value="<?php echo $tpl['nilai_'.$mpl['tipe_data']]?>">
                              </td>
                            <?php
                            }                          
                          } 
                          ?>

                          <?php
                          if($i == ($jml_tpgi - 1)) {
                          ?>
                          
                          <td class="text-center">
                            <button type="button" style="" 
                                    class="btn btn-danger del-tbl-row-si" 
                                    onclick="del_tbl_row_si(<?php echo $id_permohonan;?>, <?php echo $msi['id_syarat_izin_s']?>, <?php echo $i+1;?>, this)">
                              <i class="fa fa-minus"></i>
                            </button>
                          </td>
                          
                          <?php
                          } else {
                          ?>

                          <td class="text-center">
                            <button type="button" style="display:none" 
                            class="btn btn-danger del-tbl-row-si">
                              <i class="fa fa-minus"></i>
                            </button>
                          </td>

                          <?php
                          }
                          ?>

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
                        <button type="button" class="btn btn-primary add-tbl-row-si">
                          <i class="fa fa-plus"></i>
                        </button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <!-- <div class="div-cttn-tbl">
                <input class="form-control cttn-tbl cttn-val"
                       id="<?php echo $msi['nama_syarat_izin'];?>_cttn" type="text" 
                       name="<?php echo $msi['nama_syarat_izin'];?>_cttn[]" value="<?php echo $cttn?>"
                       placeholder="catatan"> 
              </div>
              <div class="div-act-tbl">
                <button type="button" class="btn btn-success btn-sm"
                        onclick="save_cttn(<?php echo $cval;?>,<?php echo $cidx;?>,'<?php echo $msi['pk_tujuan_s']?>','<?php echo $msi['table_tujuan_s']?>','<?php echo $msi['id_syarat_izin_s']?>',this)"
                        <?php echo $permission;?>>
                  Simpan catatan
                </button>
              </div> -->
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

<?php if (count($data_multi_ziswaf) > 0){ ?>
  <div class="row form-si">
    <div class="div-grup">
      <div class="card-box table-responsive">
          <h4 class="m-t-0 header-title">Multi Ziswaf</h4>
          <p class="text-muted font-13 m-b-30"></p>

          <div class="row m-b-10">
            <div class="col-md-12">
              <div class="row" style="margin-bottom:15px;">
                <div class="div-input-tbl" style="overflow-x: auto;">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                          <th class="text-center">NO</th>
                          <th class="text-center">Jenis Ziswaf</th>
                          <th class="text-center">Jenis Infaq <br>(Tampil Jika Memilih Infaq)</th>
                          <th class="text-center">Jumlah Uang</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $total = 0; for ($i=0; $i < count($data_multi_ziswaf) ; $i++) { ?>
                        <tr>
                          <td class="no text-center"><?php echo $i + 1 ?></td>
                          <td class="jenis-ziswaf">
                            <select id="ziswaf" name="jenis_ziswaf[]" class="form-control" required disabled>
                              <?php 
                                foreach ($option as $opt) {
                                  if($opt['id_jenis_izin'] == $data_multi_ziswaf[$i]['id_jenis_izin']){
                                    $selected = "selected";
                                  }else{
                                    $selected = "";
                                  }
                                    echo "<option value='".$opt['id_jenis_izin']."'".$selected.">".$opt['teks_menu']."</option>";
                                } 
                              ?>
                            </select>
                          </td>
                          <td class="jenis-infaq">
                            <select id="infaq" name="jenis_infaq_multi[]" class="form-control" disabled>
                                <option value=""></option>
                                <option <?php ("Sedekah Quran" == $data_multi_ziswaf[$i]['jenis_infaq'] ) ? "selected" : "" ?> value="Sedekah Quran">Sedekah Quran</option>
                                <option <?php ("Bingkisan untuk guru ngaji" == $data_multi_ziswaf[$i]['jenis_infaq'] ) ? "selected" : "" ?> value="Bingkisan untuk guru ngaji">Bingkisan untuk guru ngaji</option>
                                <option <?php ("Sedekah Quran" == $data_multi_ziswaf[$i]['jenis_infaq'] ) ? "selected" : "" ?> value="Beasiswa Pendidikan Quran Yatim Piatu">Beasiswa Pendidikan Quran Yatim Piatu</option>
                                <option <?php ("Beasiswa Pendidikan Quran Yatim Piatu" == $data_multi_ziswaf[$i]['jenis_infaq'] ) ? "selected" : "" ?> value="Training guru Quran">Training guru Quran</option>
                                <option <?php ("BBQ" == $data_multi_ziswaf[$i]['jenis_infaq'] ) ? "selected" : "" ?> value="BBQ">BBQ</option>
                                <option <?php ("Pengembangan Dakwah Qur'an" == $data_multi_ziswaf[$i]['jenis_infaq'] ) ? "selected" : "" ?> value="Pengembangan Dakwah Qur'an">Pengembangan Dakwah Qur'an</option>
                            </select>
                          </td>
                          <td class="jumlah_uang">
                              <input type="text" class="form-control text-right" disabled placeholder="Rp 100.000" data-name="jmlh_transaksi_multi[]" value="Rp <?php echo number_format($data_multi_ziswaf[$i]['sub_total'],0,".",".") ?>">
                          </td>
                        </tr>
                      <?php $total += $data_multi_ziswaf[$i]['sub_total']; } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3" class="text-right"><strong><h4>Total</h4></strong></td>
                        <td colspan="1" style="font-weight: bold">
                          <input class="form-control text-right" readonly value="Rp <?php echo number_format($total,0,".",".")?>">
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
<?php } ?>
<!-- </form> -->
<script type="text/javascript">
  $(document).ready(function() {
    //btn
    $('.form-si').find('.div-btn-submit').css('display', 'none');     
    $('.form-si').find('.btn-submit').css('disabled', true);

    //grup
    $('.form-si').find('.div-grup').attr('class', 'div-grup col-md-12');

    //file
    $('.form-si').find('.div-label-file').attr('class', 'div-label-file col-md-4');
    $('.form-si').find('.div-input-file').css('display', 'none');
    $('.form-si').find('.div-fln-file').attr('class', 'div-fln-file col-md-4');
    $('.form-si').find('.div-cttn-file').attr('class', 'div-cttn-file col-md-2');
    $('.form-si').find('.div-act-file').attr('class', 'div-act-file col-md-2');

    //tne
    $('.form-si').find('.div-label-tne').attr('class', 'div-label-tne col-md-4');
    $('.form-si').find('.div-input-tne').attr('class', 'div-input-tne col-md-4');
    $('.form-si').find('.div-cttn-tne').attr('class', 'div-cttn-tne col-md-2');
    $('.form-si').find('.input-tne').attr('requred', false);
    $('.form-si').find('.cttn-tne').attr('requred', false);
    $('.form-si').find('.cttn-tne').attr('disabled', false);  
    $('.form-si').find('.div-act-tne').attr('class', 'div-act-tne col-md-2');

    //tne
    $('.form-si').find('.div-label-textarea').attr('class', 'div-label-textarea col-md-4');
    $('.form-si').find('.div-input-textarea').attr('class', 'div-input-textarea col-md-4');
    $('.form-si').find('.div-cttn-textarea').attr('class', 'div-cttn-textarea col-md-2');
    $('.form-si').find('.input-textarea').attr('requred', false);
    $('.form-si').find('.cttn-textarea').attr('requred', false);
    $('.form-si').find('.cttn-textarea').attr('disabled', false);  
    $('.form-si').find('.div-act-textarea').attr('class', 'div-act-textarea col-md-2');

    //select
    $('.form-si').find('.div-label-select').attr('class', 'div-label-select col-md-4');
    $('.form-si').find('.div-input-select').attr('class', 'div-input-select col-md-4');
    $('.form-si').find('.div-cttn-select').attr('class', 'div-cttn-select col-md-2');
    $('.form-si').find('.input-select').attr('requred', false);
    $('.form-si').find('.cttn-select').attr('requred', false);
    $('.form-si').find('.cttn-select').attr('disabled', false);
    $('.form-si').find('.div-act-select').attr('class', 'div-act-select col-md-2');
    
    //tbl
    $('.form-si').find('.div-label-tbl').attr('class', 'div-label-tbl col-md-12');
    $('.form-si').find('.div-input-tbl').attr('class', 'div-input-tbl col-md-12');
    $('.form-si').find('.div-cttn-tbl').attr('class', 'div-cttn-tbl col-md-6');
    $('.form-si').find('.input-tbl').attr('requred', false);
    $('.form-si').find('.cttn-tbl').attr('requred', false);
    $('.form-si').find('.cttn-tbl').attr('disabled', false);
    $('.form-si').find('.div-act-tbl').attr('class', 'div-act-tbl col-md-6');
  })

  //APPEND FILE 
  $(document).on('click', ".add-file-row-si", function() {
    var content   = $(this).closest('.row').clone();
    
    var button  = '<button type="button" class="btn btn-danger del-file-row-si">' +
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

  $(document).on('click', ".del-file-row-si", function() {
    $(this).closest('.row').remove();
  })



  //SHOW FILE
  function showFileSi(e) {
    var id    = $(e).data('id');
    var index = $(e).data('index');
    var data  = {"id": id, "index": index};
    $.ajax({
        url : "<?php echo base_url('permohonan_izin/show_file/syarat_izin')?>",
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
  $(document).on('click', ".add-text-row-si", function() {
    var content   = $(this).closest('.row').clone();
    
    var button  = '<button type="button" class="btn btn-danger del-text-row-si">' +
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

  $(document).on('click', ".del-text-row-si", function() {
    $(this).closest('.row').remove();
  })


  //APPEND TBL 
  $(document).on('click', ".add-tbl-row-si", function() {
    var jml_row   = $(this).closest('table').find('tbody tr').length;
    var content   = $(this).closest('table').find('tbody tr:eq(0)').clone();
    
    content.removeAttr('style');
    $('input', content).removeAttr('disabled');
    $('input', content).val('');
    $('button', content).css('display', 'block');
    $('.number', content).text('');
    $(this).closest('table').find('tbody').append(content);
  })

  $(document).on('click', ".del-tbl-row-si", function() {
    $(this).closest('tr').remove();
  })

  function del_tbl_row_si(id_permohonan, id_syarat_izin_s, index, e) {
    $.ajax({
      type: "POST",
      url: base_url+'permohonan_izin/del_tbl_row/syarat_izin',
      data: {
              id_permohonan : id_permohonan,
              id_syarat_izin_s : id_syarat_izin_s,
              index : index,
              },
      datatype: "json",
      success: function(response) {
        var res = JSON.parse(response);
        if(res == false) {
          swal("Gagal!", "Gagal menghapus data!", "error");
        } else {
          swal("Berhasil!", "Berhasil menghapus data!", "success");        
        }
      }
    });
  }


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

  function save_cttn(idt, index, pk, tbl, idm, e) {
    var cttn = $(e).parent().siblings().find('.cttn-val').val();
    var data = {"idt": idt, "index": index, "pk": pk, "tbl": tbl, "idm": idm, "cttn": cttn};
    // console.log(data);
    $.ajax({
      type: "POST",
      url: base_url+"permohonan_izin/save_cttn/"+"<?php echo $id_permohonan;?>",
      data: data,
      datatype: "json",
      success: function(response) {
        var res = JSON.parse(response);
        if(res == false) {
          swal("Gagal!", "Gagal menambahkan catatan!", "error");
        } else {
          swal("Berhasil!", "Berhasil menambahkan catatan!", "success");        
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
