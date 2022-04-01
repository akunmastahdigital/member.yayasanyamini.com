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
			<td class="" style="font-size: 16px; text-align:center; width: 100%;" colspan="7">Database Laporan Penerbitan <?php echo $izin;?></td>
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
            <th class="l t r b" style="width:15%" rowspan="2"><b>alamat</b></th>
             <th class="l t r b" style="width:10%" rowspan="2"><b>Nama Perusahaan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Alamat Perusahaan</b></th>
           
            <th class="l t r b" style="width:20%" rowspan="2"><b>Nomor Izin Terbit</b></th>
            <th class="l t r b" style="width:10%" rowspan="2"><b>Masa Berlaku</b></th>
            <th class="l t r b" style="width:10%" rowspan="2"><b>Keterangan</b></th>
		    
        </tr>
		<tr style="line-height: 18px;">
        


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
            <td class="l t r b" style="width:10%"><?php echo $gtl['nama_lengkap_pemohon'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['alamat_tempat_tinggal'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['nama_rs'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['alamat_praktek'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['no_izin'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['masa_berlaku'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['keterangan'];?></td>


		</tr>
		<?php $no++;} ?>
	</tbody>
</table>
