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
                  <tr style="display:none;">
                    <td>
                      <select class="form-control" name="tarif[]" disabled>
                        <?php foreach($get_tarif->result_array() as $gtr) { ?>
                        <option value="<?php echo $gtr['id_ret_jenis_tarif'];?>"><?php echo $gtr['item'];?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
                      <input name="value[]" class="text-right form-control" type="text" value="" disabled>
                    </td>
                    <td>
                      <input name="nilai_tarif[]" class="text-right form-control" type="text" value="" disabled readonly>
                    </td>
                    <td>
                      <input name="f1[]" class="text-right form-control" type="text" value="" disabled readonly>
                    </td>
                    <td>
                      <input name="nilai_koef_kj[]" class="text-center form-control" type="hidden" value="" readonly>
                      <select class="form-control" name="koef_kj[]" disabled>
                        <?php foreach($get_koef['kj']->result_array() as $kj) { ?>
                        <option value="<?php echo $kj['id_ret_nilai_koef'];?>"><?php echo $kj['nilai_koef'];?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
                      <input name="nilai_koef_gb[]" class="text-center form-control" type="hidden" value="" readonly>
                      <select class="form-control" name="koef_gb[]" required disabled>
                        <?php foreach($get_koef['gb']->result_array() as $gb) { ?>
                        <option value="<?php echo $gb['id_ret_nilai_koef'];?>"><?php echo $gb['nilai_koef'];?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
                      <input name="nilai_koef_lb[]" class="text-center form-control" type="hidden" value="" readonly>
                      <select class="form-control" name="koef_lb[]" required disabled>
                        <?php foreach($get_koef['lb']->result_array() as $lb) { ?>
                        <option value="<?php echo $lb['id_ret_nilai_koef'];?>"><?php echo $lb['nilai_koef'];?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
                      <input name="nilai_koef_tb[]" class="text-center form-control" type="hidden" value="" readonly>
                      <select class="form-control" name="koef_tb[]" required disabled> 
                        <?php foreach($get_koef['tb']->result_array() as $tb) { ?>
                        <option value="<?php echo $tb['id_ret_nilai_koef'];?>"><?php echo $tb['nilai_koef'];?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
                      <input name="f1[]" class="text-right form-control" type="text" value="" readonly>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-icon waves-effect btn-danger m-b-5 del-row"
                              data-index="0" data-last="false"> 
                        <i class="fa fa-minus"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                      <td colspan="8" class="text-right"><b>Total :</b></td>
                      <td>
                        <input name="f4[]" class="text-right form-control" type="text" value="" readonly>
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
                <?php foreach($get_koef['ja']->result_array() as $ja) { ?>
                <tr>
                  <input name="koef_ja[]" type="hidden" value="<?php echo $ja['id_ret_nilai_koef'];?>" readonly>
                  <td><?php echo $ja['item_koef'];?></td>
                  <td>
                    <input name="nilai_koef_ja[]" class="text-right form-control" type="text" 
                    value="<?php echo $ja['nilai_koef'];?>" readonly>
                  </td>
                  <td>
                    <input name="f5[]" class="text-right form-control" type="text" value="" readonly>
                  </td>
                </tr>
                <?php } ?>

                <?php foreach($get_koef['jt']->result_array() as $jt) { ?>
                <tr>
                  <input name="koef_jt[]" type="hidden" value="<?php echo $jt['id_ret_nilai_koef'];?>" readonly>
                  <td><?php echo $jt['item_koef'];?></td>
                  <td>
                    <input name="nilai_koef_jt[]" class="text-right form-control" type="text" 
                    value="<?php echo $jt['nilai_koef'];?>" readonly>
                  </td>
                  <td>
                    <input name="f5[]" class="text-right form-control" type="text" value="" readonly>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class="text-right"><b>Total :</b></td>
                  <td>
                    <input name="f7[]" class="text-right form-control" type="text" value="" readonly>
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
                <?php foreach($get_koef['ret']->result_array() as $ret) { ?>
                <tr>
                  <input name="koef_ret[]" type="hidden" value="<?php echo $ret['id_ret_nilai_koef'];?>" readonly>
                  <td><?php echo $ret['item_koef'];?></td>
                  <td>
                    <input name="nilai_koef_ret[]" class="text-right form-control" type="text" 
                    value="<?php echo $ret['nilai_koef'];?>" readonly>
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
                    <input name="f7[]" class="text-right form-control" type="text" value="" readonly>
                  </td>
                </tr>
              </tfoot>                        
            </table>                        
          </div>

          <div class="col-md-12">
            <button type="button" class="pull-right btn waves-effect btn-danger m-b-5" id="ret-submit"> 
              <i class="fa fa-calculator"></i> Simpan Nilai Retribusi
            </button>
          </div>
        </div>
      </div>
    </div>   
  </div>    
</form>
