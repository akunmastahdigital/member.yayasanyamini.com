<form id="ret-form">
  <input type="hidden" name="no_permohonan" value="<?php echo $no_permohonan;?>">
  <div class="row">
    <div class="col-sm-12">
      <div class="card-box table-responsive">
        <h4 class="m-t-0 header-title">Data Bangunan</b></h4>
          <p class="text-muted font-13 m-b-30">
            <?php echo $desc;?>
          </p>

          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center" style="width:12%;">Item</th>
                    <th class="text-center">Luas (M2)</th>
                    <th class="text-center">Nilai Tarif (RP)</th>
                    <th class="text-center">Biaya Bangunan (RP)</th>
                    <th class="text-center" style="width:8%;">KJ</th>
                    <th class="text-center" style="width:8%;">GB</th>
                    <th class="text-center" style="width:8%;">LB</th>
                    <th class="text-center" style="width:8%;">TB</th>
                    <th class="text-center">Nilai Bangunan (RP)</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $condition       = [];
                    $condition[]     = ['aktif', 1, 'where'];
                    $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                    $condition[]     = ['formula', 'f1', 'where'];
                    $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                    $grf = $get_ret_formula->row_array();

                    $f1 = str_replace('$var', $id_permohonan, $grf['query']);
                    $query_f1 = $this->db->query($f1);
                  ?>

                  <?php $index = 1;foreach($query_f1->result_array() as $qf1) {?>
                  <tr>
                    <td>
                      <select class="form-control" name="tarif[]">
                        <?php foreach($get_tarif->result_array() as $gtr) { ?>
                        <?php 
                          if($gtr['id_ret_jenis_tarif'] == $qf1['id_ret_jenis_tarif']) {
                            $selected = 'selected';
                          } else {
                            $selected = '';
                          }
                        ?>
                        <option value="<?php echo $gtr['id_ret_jenis_tarif'];?>" <?php echo $selected;?>><?php echo $gtr['item'];?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
                      <input name="value[]" class="text-right form-control" type="text" value="<?php echo $qf1['value']?>">
                    </td>
                    <td>
                      <input name="nilai_tarif[]" class="text-right form-control" type="text" 
                      value="<?php echo number_format($qf1['nilai_tarif'])?>" disabled readonly>
                    </td>
                    <td>
                      <input name="f1[]" class="text-right form-control" type="text" value="<?php echo number_format($qf1['total'])?>" disabled readonly>
                    </td>
                    <td>
                      <?php 
                        $condition   = [];
                        $condition[] = ['aktif', 1, 'where'];
                        $condition[] = ['kode', 'k10', 'where'];
                        $condition[] = ['index', $index, 'where'];
                        $g_vkf_kj    = $this->M_core->get_tbl('v_ret_nilai_koef', '*', $condition)->row_array();
                      ?>
                      <input name="nilai_koef_kj[]" class="text-right form-control" type="hidden" 
                      value="<?php echo $g_vkf_kj['nilai_koef'];?>" readonly>

                      <select class="form-control" name="koef_kj[]" required>
                        <?php foreach($get_koef['kj']->result_array() as $kj) { ?>
                        <?php 
                          if($kj['id_ret_nilai_koef'] == $g_vkf_kj['id_ret_nilai_koef']) {
                            $selected = 'selected';
                          } else {
                            $selected = '';
                          }
                        ?>
                        <option value="<?php echo $kj['id_ret_nilai_koef'];?>" <?php echo $selected;?>><?php echo $kj['nilai_koef'];?></option>
                        <?php } ?>
                      </select>

                    </td>
                    <td>
                      <?php 
                        $condition   = [];
                        $condition[] = ['aktif', 1, 'where'];
                        $condition[] = ['kode', 'k20', 'where'];
                        $condition[] = ['index', $index, 'where'];
                        $g_vkf_gb    = $this->M_core->get_tbl('v_ret_nilai_koef', '*', $condition)->row_array();
                      ?>
                      <input name="nilai_koef_gb[]" class="text-right form-control" type="hidden" 
                      value="<?php echo $g_vkf_gb['nilai_koef'];?>" readonly>

                      <select class="form-control" name="koef_gb[]" required>
                        <?php foreach($get_koef['gb']->result_array() as $gb) { ?>
                        <?php 
                          if($gb['id_ret_nilai_koef'] == $g_vkf_gb['id_ret_nilai_koef']) {
                            $selected = 'selected';
                          } else {
                            $selected = '';
                          }
                        ?>
                        <option value="<?php echo $gb['id_ret_nilai_koef'];?>" <?php echo $selected;?>><?php echo $gb['nilai_koef'];?></option>
                        <?php } ?>
                      </select>

                    </td>
                    <td>
                      <?php 
                        $condition   = [];
                        $condition[] = ['aktif', 1, 'where'];
                        $condition[] = ['kode', 'k30', 'where'];
                        $condition[] = ['index', $index, 'where'];
                        $g_vkf_lb    = $this->M_core->get_tbl('v_ret_nilai_koef', '*', $condition)->row_array();
                      ?>
                      <input name="nilai_koef_lb[]" class="text-right form-control" type="hidden" 
                      value="<?php echo $g_vkf_lb['nilai_koef'];?>" readonly>

                      <select class="form-control" name="koef_lb[]" required>
                        <?php foreach($get_koef['lb']->result_array() as $lb) { ?>
                        <?php 
                          if($lb['id_ret_nilai_koef'] == $g_vkf_lb['id_ret_nilai_koef']) {
                            $selected = 'selected';
                          } else {
                            $selected = '';
                          }
                        ?>
                        <option value="<?php echo $lb['id_ret_nilai_koef'];?>" <?php echo $selected;?>><?php echo $lb['nilai_koef'];?></option>
                        <?php } ?>
                      </select>

                    </td>
                    <td>
                      <?php 
                        $condition   = [];
                        $condition[] = ['aktif', 1, 'where'];
                        $condition[] = ['kode', 'k40', 'where'];
                        $condition[] = ['index', $index, 'where'];
                        $g_vkf_tb    = $this->M_core->get_tbl('v_ret_nilai_koef', '*', $condition)->row_array();
                      ?>
                      <input name="nilai_koef_tb[]" class="text-right form-control" type="hidden" 
                      value="<?php echo $g_vkf_tb['nilai_koef'];?>" readonly>

                      <select class="form-control" name="koef_tb[]" required> 
                        <?php foreach($get_koef['tb']->result_array() as $tb) { ?>
                        <?php 
                          if($tb['id_ret_nilai_koef'] == $g_vkf_tb['id_ret_nilai_koef']) {
                            $selected = 'selected';
                          } else {
                            $selected = '';
                          }
                        ?>
                        <option value="<?php echo $tb['id_ret_nilai_koef'];?>" <?php echo $selected;?>><?php echo $tb['nilai_koef'];?></option>
                        <?php } ?>
                      </select>

                    </td>
                    <td>
                      <?php
                        $condition       = [];
                        $condition[]     = ['aktif', 1, 'where'];
                        $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                        $condition[]     = ['formula', 'f3', 'where'];
                        $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                        $grf = $get_ret_formula->row_array();

                        $f3 = str_replace('$var', $id_permohonan, $grf['query']);
                        $query_f3 = $this->db->query('SELECT f3.* FROM ('.$f3.') f3 WHERE f3.`index` = '.$index);
                        $qf3 = $query_f3->row_array();
                      ?>
                      <input name="f3[]" class="text-right form-control" type="text" 
                      value="<?php echo number_format($qf3['total']);?>" readonly>
                    </td>
                    <td>
                      <?php if($index == $query_f1->num_rows()) { $last = 'y'; } else { $last = 'x'; }?>
                      <button type="button" class="btn btn-sm btn-icon waves-effect btn-danger m-b-5 del-row"
                              data-index="<?php echo $index;?>" data-last="<?php echo $last;?>"> 
                        <i class="fa fa-minus"></i>
                      </button>
                    </td>
                  </tr>
                  <?php $index++; } ?>

                </tbody>
                <tfoot>
                  <tr>
                    <?php
                      $condition       = [];
                      $condition[]     = ['aktif', 1, 'where'];
                      $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                      $condition[]     = ['formula', 'f4', 'where'];
                      $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                      $grf = $get_ret_formula->row_array();

                      $f4 = str_replace('$var', $id_permohonan, $grf['query']);
                      $query_f4 = $this->db->query($f4);
                      $qf4 = $query_f4->row_array();
                    ?>
                    <td colspan="8" class="text-right"><b>Total :</b></td>
                    <td>
                      <input name="f4[]" class="text-right form-control" type="text" 
                      value="<?php echo number_format($qf4['total']);?>" readonly>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-icon waves-effect btn-primary m-b-5 add-row"> 
                        <i class="fa fa-plus"></i> 
                      </button>
                    </td>
                  </tr>
                </tfoot>
              </table>                        
            </div>
          </div>

      </div>
    </div>
  </div>      

  <div class="row">
    <div class="col-sm-6">
      <div class="card-box table-responsive">
        <h4 class="m-t-0 header-title">Koefisien</h4>
        <p class="text-muted font-13 m-b-30">
          Koefisien
        </p>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center" colspan="2">Prosentase Biaya (%)</th>
                  <th class="text-center">Biaya IMB (RP)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $condition       = [];
                  $condition[]     = ['aktif', 1, 'where'];
                  $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                  $condition[]     = ['formula', 'f5', 'where'];
                  $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                  $grf = $get_ret_formula->row_array();

                  $f5 = str_replace('$var', $id_permohonan, $grf['query']);
                  $query_f5 = $this->db->query('SELECT f5.* FROM ('.$f5.') f5 WHERE f5.`kode` = \'k50\' ORDER BY f5.`index` ASC');
                ?>
                <?php foreach($query_f5->result_array() as $qf5) { ?>
                <tr>
                  <input name="koef_ja[]" type="hidden" value="<?php echo $qf5['id_ret_nilai_koef'];?>" readonly>
                  <td><?php echo $qf5['item_koef'];?></td>
                  <td>
                    <input name="nilai_koef_ja[]" class="text-right form-control" type="text" 
                    value="<?php echo $qf5['nilai_koef'];?>" readonly>
                  </td>
                  <td>
                    <input name="f5[]" class="text-right form-control" type="text" value="<?php echo number_format($qf5['total']);?>" readonly>
                  </td>
                </tr>
                <?php } ?>

                <?php
                  $condition       = [];
                  $condition[]     = ['aktif', 1, 'where'];
                  $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                  $condition[]     = ['formula', 'f5', 'where'];
                  $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                  $grf = $get_ret_formula->row_array();

                  $f5 = str_replace('$var', $id_permohonan, $grf['query']);
                  $query_f5 = $this->db->query('SELECT f5.* FROM ('.$f5.') f5 WHERE f5.`kode` = \'k60\' ORDER BY f5.`index` ASC');
                ?>
                <?php foreach($query_f5->result_array() as $qf5) { ?>
                <tr>
                  <input name="koef_jt[]" type="hidden" value="<?php echo $qf5['id_ret_nilai_koef'];?>" readonly>
                  <td><?php echo $qf5['item_koef'];?></td>
                  <td>
                    <input name="nilai_koef_jt[]" class="text-right form-control" type="text" 
                    value="<?php echo $qf5['nilai_koef'];?>" readonly>
                  </td>
                  <td>
                    <input name="f5[]" class="text-right form-control" type="text" value="<?php echo number_format($qf5['total']);?>" readonly>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <?php
                    $condition       = [];
                    $condition[]     = ['aktif', 1, 'where'];
                    $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                    $condition[]     = ['final', 1, 'where'];
                    $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                    $grf = $get_ret_formula->row_array();

                    $f7 = str_replace('$var', $id_permohonan, $grf['query']);
                    $query_f7 = $this->db->query($f7);
                    $qf7 = $query_f7->row_array();
                    // $qf7['total_tarif']
                  ?>
                  <td colspan="2" class="text-right"><b>Total :</b></td>
                  <td>
                    <input name="f7[]" class="text-right form-control" type="text" value="<?php echo number_format($qf7['total']);?>" readonly>
                  </td>
                </tr>
              </tfoot>                        
            </table>                        
          </div>

        </div>
      </div>
    </div>

    <div class="col-sm-6">
      <div class="card-box table-responsive">
        <h4 class="m-t-0 header-title">Koefisien</b> 
        </h4>
        <p class="text-muted font-13 m-b-30">
            Koefisien Lainnya
        </p>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center" colspan="2">Prosentase Biaya (%)</th>
                  <th class="text-center">Biaya IMB (RP)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $condition       = [];
                  $condition[]     = ['aktif', 1, 'where'];
                  $condition[]     = ['id_jenis_izin', $id_jenis_izin, 'where'];
                  $condition[]     = ['formula', 'f6', 'where'];
                  $get_ret_formula = $this->M_core->get_tbl('m_ret_formula', '*', $condition);
                  $grf = $get_ret_formula->row_array();

                  $f6 = str_replace('$var', $id_permohonan, $grf['query']);
                  $query_f6 = $this->db->query($f6);
                ?>
                <?php foreach($query_f6->result_array() as $qf6) { ?>
                <tr>
                  <input name="koef_ret[]" type="hidden" value="<?php echo $qf6['id_ret_nilai_koef'];?>" readonly>
                  <td><?php echo $qf6['item_koef'];?></td>
                  <td>
                    <input name="nilai_koef_ret[]" class="text-right form-control" type="text" 
                    value="<?php echo $qf6['nilai_koef'];?>" readonly>
                  </td>
                  <td>
                    <input name="" class="text-right form-control" type="text" value="" readonly>
                  </td>
                </tr>
                <?php } ?>                        
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class="text-right"><b>JUMLAH RETRIBUSI</b></td>
                  <td>
                    <input name="f7[]" 
                    class="text-right form-control" type="text" value="<?php echo number_format($qf7['total_tarif']);?>" readonly>
                  </td>
                </tr>
              </tfoot>                        
            </table>                        
          </div>

          <div class="col-md-12">
            <button type="button" class="pull-right btn waves-effect btn-danger m-b-5" id="ret-submit"> 
              <i class="fa fa-calculator"></i> Hitung Retribusi
            </button>
          </div>
        </div>
      </div>
    </div>   
  </div>    
</form>