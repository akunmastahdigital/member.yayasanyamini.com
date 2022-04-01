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
			<td class="" style="font-size: 16px; text-align:center; width: 100%;" colspan="10">Laporan Jumlah Izin per Meja</td>
		</tr>
		<tr style="line-height: 18px;">
			<td class="" style="font-size: 12px; text-align:center; width: 100%;" colspan="10">
				Pada tanggal <?php echo date('d/M/Y');?>
			</td>
		</tr>
		<tr style="line-height: 20px;">
			<td class="" style="width: 100%;" colspan="6"></td>
		</tr>
	</tbody>
</table>

<table style="width: 530px; height: 10px; margin-left: auto; margin-right: auto;" border="1">
	<thead>
		<tr style="line-height: 18px;">
            <th class="l t r b" style="width:5%">No</th>
            <th class="l t r b" style="width:15%">Nama Personil</th>
            <th class="l t r b" style="width:15%">Jabatan</th>
            <th class="l t r b">SIUP</th>
            <th class="l t r b">SIUP & TDP</th>
            <th class="l t r b">TDP</th>
            <th class="l t r b">IPTM</th>
            <th class="l t r b">SIUJK</th>
            <th class="l t r b">SIPA</th>
            <th class="l t r b">IMB</th>
            <th class="l t r b">TOTAL</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;foreach($gtl->result_array() as $gtl) { ?>
		<tr style="line-height: 18px;">
			<td class="l t r b" style="width:5%"><?php echo $no;?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['nm_personil'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['nm_jabatan'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_siup'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_siup_tdp'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_tdp'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_iptm'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_siujk'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_sipa'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_imb'];?></td>
            <td class="l t r b" style=""><?php echo $gtl['jml_total'];?></td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>
