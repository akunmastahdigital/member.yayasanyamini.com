<option value="0"><?php echo $judul_ref1;?></option>

<?php 
foreach($get_dch1->result_array() as $gdch1) { 
	$selected = '';	
	if($gdch1[$pk_ref1] == $val) {
		$selected = 'selected';
	}
?>

	<option value="<?php echo $gdch1[$pk_ref1]?>" <?php echo $selected?>><?php echo $gdch1[$text_ref1]?> - <?php echo $gdch1[$nm_ref1]?></option>

<?php 
	} 
?>