<option value="0"><?php echo $judul_ref2;?></option>
<?php foreach($get_sch2->result_array() as $gsch2) { ?>
	<option value="<?php echo $gsch2[$pk_ref2]?>"><?php echo $gsch2[$text_ref2]?> - <?php echo $gsch2[$nm_ref2]?></option>
<?php } ?>