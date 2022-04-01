<!-- LAYOUT SIUP -->
<style>
	.l { border-left: 1px solid black; }
	.t { border-top: 1px solid black; }
	.r { border-right: 1px solid black; }
	.b { border-bottom: 1px solid black; }
</style>


<!-- CONTENT1 -->
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;" border="1">
	<tbody>
		
		<?php 
		foreach ($getTTD as $g) {
			$id_histori_permohonan = $g->id_histori_permohonan;
			$ttd = $g->ttd;
		

		?>

		<tr style="line-height: 100px;text-align: center;">
		
			<td style="width: 50%;"><img src="<?php echo base_url();?>berkas/core/images/tanda_tangan/<?php echo $ttd;?>" height="50px" width="50px"></td>
		
		</tr>

		<tr style="line-height: 22px;text-align: center;">
			<td style="width: 50%;"><?php echo $g->nm_user;?></td>
		</tr>

		<tr style="line-height: 22px;text-align: center;">
			<td style="width: 50%;"><?php echo $g->nm_role;?></td>
		</tr>



		<?php
		}

		?>
	</tbody>
</table>





