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
			<th class="l t r b" style="width:5%"><b>No</b></th>
            <th class="l t r b" style="width:20%"><b>No Permohonan</b></th>
            <th class="l t r b" style="width:15%"><b>Tgl Permohonan</b></th>
            <th class="l t r b" style="width:15%"><b>Tgl Terbit</b></th>
            <th class="l t r b" style="width:10%"><b>Pemohon</b></th>
            <th class="l t r b" style="width:15%"><b>Perusahaan</b></th>
            <th class="l t r b" style="width:15%"><b>no NPWP</b></th>
            <th class="l t r b" style="width:15%"><b>modal disetor</b></th>
            <th class="l t r b" style="width:15%"><b>alamat</b></th>
            <th class="l t r b" style="width:15%"><b>rt/rw</b></th>
            <th class="l t r b" style="width:15%"><b>Provinsi</b></th>
            <th class="l t r b" style="width:15%"><b>Kab/Kota</b></th>
            <th class="l t r b" style="width:15%"><b>Kecamatan</b></th>
            <th class="l t r b" style="width:15%"><b>Kelurahan</b></th>
            <th class="l t r b" style="width:20%"><b>Jenis Permohonan</b></th>
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
            <td class="l t r b" style="width:20%"><?php echo $gtl['nama_izin'].' - '.$gtl['jenis_izin'];?></td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>
