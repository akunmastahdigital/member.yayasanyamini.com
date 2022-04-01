<style>
	.l { border-left: 1px solid black; }
	.t { border-top: 1px solid black; }
	.r { border-right: 1px solid black; }
	.b { border-bottom: 1px solid black; }
</style>

<!-- MARGIN -->
<table style="width: 530px; height: 10px; margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 18px;">
			<td class="" style="font-size: 16px; text-align:center; width: 100%;" colspan="7">Laporan Perizinan <?php echo $izin;?></td>
		</tr>
		<tr style="line-height: 18px;">
			<td class="" style="font-size: 12px; text-align:center; width: 100%;" colspan="7">
					<?php if ($date_start!='') {
						echo 'Dari tanggal '.date('d/M/Y', strtotime($date_start));
					} else { echo ''; } ?>
						
					<?php if ($date_end!='') {
						echo 'Sampai tanggal '.date('d/M/Y', strtotime($date_end));
					} else { echo ''; } ?>
			</td>
		</tr>
		<tr style="line-height: 20px;">
			<td class="" style="width: 100%;" colspan="6"></td>
		</tr>
		<tr style="line-height: 18px;">
			<td class="l t r b" style="width: 100%;"><b>Total : <?php echo $total;?></b></td>
		</tr>
	</tbody>
</table>

<table style="width: 530px; height: 10px; margin-left: auto; margin-right: auto;" border="1">
	<thead>
		<tr style="line-height: 18px;">
			<th class="l t r b" style="width:5%" rowspan="2"><b>No</b></th>
            <th class="l t r b" style="width:20%" rowspan="2"><b>No Permohonan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Tgl Permohonan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Tgl Terbit</b></th>
            <th class="l t r b" style="width:10%" rowspan="2"><b>Pemohon</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Perusahaan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>no NPWP</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>modal disetor</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>alamat</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>rt/rw</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Provinsi</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kab/Kota</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kecamatan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kelurahan</b></th>
            <th class="l t r b"  colspan="6"><b>Jenis Klasifikasi TDP</b></th>
            <th class="l t r b" colspan="4"><b>Jenis Klasifikasi SIUP</b></th>
            <th class="l t r b" style="width:20%" rowspan="2"><b>No Terbit</b></th>
            <th class="l t r b" style="width:20%" rowspan="2"><b>Jenis Permohonan</b></th>
		</tr>
		<tr style="line-height: 18px;">
            
            <th class="l t r b" style="width:5%"><b>PT</b></th>
            <th class="l t r b" style="width:5%"><b>CV</b></th>
            <th class="l t r b" style="width:5%"><b>PO</b></th>
            <th class="l t r b" style="width:5%"><b>KOP</b></th>
            <th class="l t r b" style="width:5%"><b>PMA</b></th>
            <th class="l t r b" style="width:5%"><b>BUL</b></th>

            <th class="l t r b" style="width:5%"><b>Pm</b></th>
            <th class="l t r b" style="width:5%"><b>PK</b></th>
            <th class="l t r b" style="width:5%"><b>PM</b></th>
            <th class="l t r b" style="width:5%"><b>PB</b></th>


		</tr>
	</thead>
	<tbody>
		<?php $no = 1;foreach($gtl->result_array() as $gtl) { ?>
		<tr style="line-height: 18px;">
			<td class="l t r b" style="width:5%"><?php echo $no;?></td>
            <td class="l t r b" style="width:20%"><?php echo $gtl['no_permohonan'];?></td>
            <td class="l t r b" style="width:15%"><?php echo date('Y-m-d', strtotime($gtl['tgl_permohonan']));?></td>

           	<td class="l t r b" style="width:20%"><?php
           		if ($gtl['tgl_terbit'] == null or $gtl['tgl_terbit'] == '') {
           			echo '';
           		}else{
           			echo date('Y-m-d', strtotime($gtl['tgl_terbit']));
           		}
           		?>
           	</td>
            <td class="l t r b" style="width:10%"><?php echo $gtl['nama_pemohon'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['nilai_string'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['npwp'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['modal_disetor'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['alamat'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['rt_rw'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['provinsi'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['kabupaten'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['kecamatan'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['kelurahan'];?></td>

          	<?php 
          		if ($gtl['id_bentuk_usaha'] == 87) {
          			$perorangan = 'v';
          		}elseif ($gtl['id_bentuk_usaha'] == 88) {
          			$pma = 'v';
          		}elseif ($gtl['id_bentuk_usaha'] == 89) {
          			$pt = 'v';
          		}elseif ($gtl['id_bentuk_usaha'] == 90) {
          			$cv = 'v';
          		}elseif ($gtl['id_bentuk_usaha'] == 91) {
          			$koperasi = 'v';
          		}elseif ($gtl['id_bentuk_usaha'] == 92) {
          			$bentuk_lainnya = 'v';
          		}

          		if ($gtl['modal_disetor'] > 0 && $gtl['modal_disetor'] <= 50000000) {
          			$Pmikro = 'v';
          			$PKecil = '';
          			$PMenengah = '';
          			$PBesar = '';
          		}elseif ($gtl['modal_disetor'] >= 51000000 && $gtl['modal_disetor'] <= 500000000) {
          			$Pmikro = '';
          			$PKecil = 'v';
          			$PMenengah = '';
          			$PBesar = '';
          		}elseif ($gtl['modal_disetor'] >= 501000000 && $gtl['modal_disetor'] <= 1000000000) {
          			$Pmikro = '';
          			$PKecil = '';
          			$PMenengah = 'v';
          			$PBesar = '';                   
          		}elseif ($gtl['modal_disetor'] >= 10000000000) {
          			$Pmikro = '';
          			$PKecil = '';
          			$PMenengah = '';
          			$PBesar = 'v';
          		}else{
                $Pmikro = '';
                $PKecil = '';
                $PMenengah = '';
                $PBesar = '';
                }
          	?>


            <th class="l t r b" style="width:5%"><b><?php echo $pt;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $cv;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $perorangan;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $koperasi;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $pma;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $bentuk_lainnya;?></b></th>

            <th class="l t r b" style="width:5%"><b><?php echo $Pmikro;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $PKecil;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $PMenengah;?></b></th>
            <th class="l t r b" style="width:5%"><b><?php echo $PBesar;?></b></th>

            <td class="l t r b" style="width:15%"><?php echo $gtl['no_izin'];?></td>
            <td class="l t r b" style="width:20%"><?php echo $gtl['nama_izin'].' - '.$gtl['jenis_izin'];?></td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>
