<!-- LAYOUT SIUP -->
<style>
	.l { border-left: 1px solid black; }
	.t { border-top: 1px solid black; }
	.r { border-right: 1px solid black; }
	.b { border-bottom: 1px solid black; }
</style>
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 12px;">
			<td style="width: 50%;font-weight: bold">ASLI</td>
			<td style="width: 50%;font-weight: bold;text-align: right;">No. #idx20#</td>
		</tr>
	</tbody>
</table>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>





<!-- HEADER -->

<!-- MARGIN -->
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 10px;">
			<td style="width: 100%;text-align: center;color: red;" colspan="4">
				<?php if($type == 'pvw') { ?>
				[DRAFT PREVIEW]
				<?php } ?>
			</td>
		</tr>
	</tbody>
</table>

<!-- CONTENT1 -->
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 22px;text-align: center;">
			<td style="width: 10%;"></td>
			<td style="width: 32%;" class="l t r">NOMOR TDP</td>
			<td style="width: 32%;" class="t r">BERLAKU S/D TANGGAL</td>
			<td style="width: 4%;"></td>
			<!-- <td style="width: 6%;" rowspan="2" class="l t r b">#idx2#</td> -->

			<!-- abal -->
			<?php if (in_array($id_jenis_izin, [14, 10, 34, 12, 8])) { ?>
				<td style="width: 6%;" rowspan="2" class="l t r b">#idx22-1#</td>
				<td style="width: 6%;" rowspan="2" class="l t r b">#idx22-2#</td>
			<?php } else { ?>
				<td style="width: 6%;" rowspan="2" class="l t r b">0</td>
				<td style="width: 6%;" rowspan="2" class="l t r b">0</td>
			<?php }	?>

			<td style="width: 10%;"></td>
		</tr>

		<tr style="line-height: 22px;text-align: center;">
			<td style="width: 10%;"></td>
			<td style="width: 32%;" class="l t b r">#idx1#</td>
			<td style="width: 32%;" class="t b r">#idx2#</td>
			<!-- <td style="width: 32%;" class="t b r">24 Maret 2020</td> -->
			<td style="width: 4%;"></td>
			<td style="width: 10%;"></td>
		</tr>
	</tbody>
</table>


<!-- MARGIN -->
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 12px;">
			<td style="width: 100%;" colspan="4"></td>
		</tr>
	</tbody>
</table>


<!-- CONTENT2 -->
<?php if ($bentuk_usaha == 'pt' || $bentuk_usaha == 'pma') {?>
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 22px;">
			<td style="width: 100%;" colspan="4" class="l t r"><u>AGENDA PENDAFTARAN</u></td>
		</tr>
		<?php if ($status_perusahaan == 'Cabang' || $status_perusahaan == 'Cabang Pembantu') {?>
		<tr style="line-height: 22px;">
			<td style="width: 12%;" class="l b">NOMOR</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 50%;font-weight: bold;" class="b">
				  <!-- #idx3# -->
			</td> 
			<td style="width: 12%;" class="b">TANGGAL</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;" class="b r">
				<!-- #idx4# -->
			</td>
		</tr>
		<?php } else { ?>
		<tr style="line-height: 22px;">
			<td style="width: 12%;" class="l b">NOMOR</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 50%;font-weight: bold;" class="b">
				  #idx3#
			</td> 
			<td style="width: 12%;" class="b">TANGGAL</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;" class="b r">
				#idx4#
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
 
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l b t">NAMA PERUSAHAAN</td>
			<td style="width: 3%;" class="b t">:</td>
			<td style="width: 65%;font-weight: bold; font-size: 1.2em;" class="b t r">#idx5# #idx6#
			</td>
		</tr>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l b">STATUS</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 65%;font-weight: bold;" class="b r">#idx7#
			</td>
		</tr>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l">ALAMAT</td>
			<td style="width: 3%;">:</td>
			<td style="width: 65%;font-weight: bold;" class="r">#idx8# RT/RW #idx9#</td>
		</tr>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l"></td>
			<td style="width: 3%;"></td>
			<td style="width: 16%;font-weight: bold;">KELURAHAN : </td>
			<td style="width: 49%;font-weight: bold;" class="r">#idx10#</td>
		</tr>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l b"></td>
			<td style="width: 3%;" class="b"></td>
			<td style="width: 16.2%;font-weight: bold;" class="b">KECAMATAN : </td>
			<td style="width: 48.8%;font-weight: bold;" class="b r">#idx11#  #idx21#</td>
			
		</tr>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l b">NOMOR TELEPON</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 30%;font-weight: bold;" class="b">#idx12#
			</td>
			<td style="width: 12%;" class="b">FAX</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;font-weight: bold;" class="b r">#idx13#</td>
		</tr>
		<tr style="line-height: 22px;">
			<td style="width: 32%;" class="l b">PENANGGUNG JAWAB</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 65%;font-weight: bold;" class="b r">#idx14#			
			</td>
		</tr>
		
		<tr style="line-height: 20px;">
			<td style="width: 32%;" class="l b">KEGIATAN USAHA POKOK (KBLI)</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 65%;font-weight: bold;" class="b r">#idx16#
			</td>
		</tr>

		<?php if ($bentuk_usaha == 'pt' || $bentuk_usaha == 'pma') {?>
		<tr style="line-height: 20px;">
			<td style="width: 100%;font-weight: bold;" class="l b r"><u>PENGESAHAN MENTERI KEHAKIMAN</u></td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 12%;" class="l b">NOMOR</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 50%;font-weight: bold;" class="b">#idx17#
			</td>
			<td style="width: 12%;" class="b">TANGGAL</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;font-weight: bold;" class="b r">#idx18#
			</td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 100%;font-weight: bold;" class="l b r"><u>PERSETUJUAN MENTERI KEHAKIMAN ATAS AKTE PERUBAHAN ANGGARAN DASAR</u></td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 12%;" class="l b">NOMOR</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 50%;font-weight: bold;" class="b">#idx23#</td>
			<td style="width: 12%;" class="b">TANGGAL</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;font-weight: bold;" class="b r">#idx24#</td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 100%;font-weight: bold;" class="l b r"><u>PENERIMAAN LAPORAN PERUBAHAN ANGGARAN DASAR</u></td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 12%;" class="l b">NOMOR</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 50%;font-weight: bold;" class="b">-</td>
			<td style="width: 12%;" class="b">TANGGAL</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;font-weight: bold;" class="b r">-</td>
		</tr>
		<?php } ?>

		<?php if ($bentuk_usaha == 'koperasi') {?>
		<tr style="line-height: 20px;">
			<td style="width: 100%;font-weight: bold;" class="l b r"><u>PENGESAHAN MENTERI KOPERASI</u></td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 12%;" class="l b">NOMOR</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 50%;font-weight: bold;" class="b">#idx17#
			</td>
			<td style="width: 12%;" class="b">TANGGAL</td>
			<td style="width: 3%;" class="b">:</td>
			<td style="width: 20%;font-weight: bold;" class="b r">#idx18#
			</td>
		</tr>	
		<?php } ?>	

	</tbody>
</table>

<!-- MARGIN -->
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 10px;">
			<td style="width: 100%;" colspan="4"></td>
		</tr>
	</tbody>
</table>

<!-- FOOTER -->
<table style="width: 530px; height: 10px;margin-left: auto; margin-right: auto;">
	<tbody>
		<tr style="line-height: 10px;">
			<td style="width: 20%;" rowspan="5">
				<img src="<?php echo base_url('sk_izin/qr_code').'/'.$id_permohonan?>">
			</td>
			<td style="width: 33.5%;"></td>
			<td style="width: 36%;">&nbsp;&nbsp;&nbsp;BEKASI, #idx19#</td>
			<td style="width: 3%;"></td>
			<td style="width: 15%;"></td>
		</tr>
		<tr style="line-height: 2px;">
			<td style="width: 30%;"></td>
			<td style="width: 22%;"></td>
			<td style="width: 3%;"></td>
			<td style="width: 25%;"></td>
		</tr>
		<tr style="line-height: 15px;">
			<td style="width: 35%;"></td>
			<td style="width: 50%;" style="text-align: justify;" colspan="3">KEPALA DINAS PENANAMAN MODAL DAN &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; PELAYANAN
			TERPADU SATU PINTU<br><span style="text-align: center;">SELAKU</span><br>KEPALA KANTOR PENDAFTARAN PERUSAHAAN</td>
		</tr>
		<tr style="line-height: 5px;">
			<td style="width: 80%;" colspan="4"></td>
		</tr>
		<tr style="line-height: 2px;">
			<td style="width: 35%;" colspan="4"></td>
			
			<td style="width: 80%;" colspan="4"><img src="berkas/core/images/tanda_tangan/stempel.png" width="150px"></td>
			<!-- berkas/core/images/tanda_tangan/stempel_sekda.png -->
		</tr>
		<tr style="line-height: 12px;">
			<td style="width: 30%" rowspan="3"><img src="berkas/core/images/tanda_tangan/non_retribusi.png" width="150px"></td>
			<td style="width: 10%;" class=""></td>
			<td style="width: 10%;" class=""></td>
			<td style="width: 50%;text-align: center;font-weight: bold;" colspan="3"><u>Drs. AMIT RIYADI, M. Si</u></td>
		</tr>
		<tr style="line-height: 12px;">
			<td style="width: 10%;" class=""></td>
			<td style="width: 10%;" class=""></td>			
			<td style="width: 50%;text-align: center;" colspan="2">Pembina Utama Muda</td>
		</tr>
		<tr style="line-height: 20px;">
			<td style="width: 10%;" class=""></td>
			<td style="width: 10%;" class=""></td>			
			<td style="width: 50%;text-align: center;" colspan="3">NIP. 19590511 198603 1 005</td>
		</tr>
	</tbody>
</table>