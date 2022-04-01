<option value="0"><?php echo $judul_ref1;?></option>
<?php 
foreach($get_dch2->result_array() as $gdch2) { 
	$selected = '';	
	if($gdch2[$pk_ref1] == $val) {
		$selected = 'selected';
	}
?>

	<option value="<?php echo $gdch2[$pk_ref1]?>" <?php echo $selected?>><?php echo $gdch2[$text_ref1]?> - <?php echo $gdch2[$nm_ref1]?></option>

<?php 
	} 
?>