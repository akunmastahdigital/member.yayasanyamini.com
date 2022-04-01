<!-- LAYOUT SIUP -->
<style>
	.l { border-left: 1px solid black; }
	td b {border: 1px solid black;
		 border-radius:50%;
		}
	.t { border-top: 1px solid black; }
	.t1 { border-top: 0.5px solid black; }
	.r { border-right: 1px solid black; }
	.b { border-bottom: 1px solid black; }
</style>

<!-- Header
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
	<tbody>
		<tr>
			<td style="width: 5%;" rowspan="4"></td>
			<td style="width: 10%;" rowspan="4">
				<img src="<?php echo base_url();?>berkas/core/images/dpmptsp/bekasi_logo.png">
			</td>
			<td style="width:85%; text-align:center;font-weight:bold; font-size:0.7em">PEMERINTAH KOTA BEKASI</td>
		</tr>
		<tr>
			<td style="width:85%; text-align:center;font-weight:bold; font-size:0.7em">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</td>
		</tr>
		<tr>
			<td style="width:85%; text-align:center;font-size:0.6em">Jl. Jend A. Yani No. 1 Telp. (021) 22102950 22120754 Kota Bekasi</td>
		</tr>
		<tr>
			<td style="width:85%; text-align:center; font-size:0.6em">Website : Htpp://dpmptsp.kotabekasi.go.id e-mail : dpmptsp@kotabekasi.go.id</td>
		</tr>
	</tbody>
</table>



Garis
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	</tbody>
</table>
 -->
<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 12.0mm;">
      <td style="width: 100%;text-align: center;color: red;" colspan="4">
      	<?php if($type == 'pvw') { ?>
		[DRAFT PREVIEW]
		<?php } ?>
      </td>
    </tr>
  </tbody>
</table>

<!--Content -->
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	<!-- <tr>
		<td class="t1" style="font-size:3px;"></td>
	</tr> -->
	<tr>
		<td style="width:100%; letter-spacing:2px; font-weight:bold; font-size:0.8em;text-align:center;"><!-- KARTU IZIN USAHA ANGKUTAN --></td>
	</tr>
	<tr>
		<td style="width:24%; font-size:0.6em;"></td>
		<td   style="width:5%; font-size:0.6em;"></td>
		<td  style="width:11.5%; letter-spacing:2px; font-size:0.6em;text-align:left;"><!-- Nomor: --></td>
		<td  style="width:36%; font-size:0.8em;">#idx1#</td>
	</tr>
	</tbody>
</table>

<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 4px;">
      <td style="width: 100%;" colspan="4"></td>
    </tr>
  </tbody>
</table>

<!--Content -->
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	<tr style=" line-height:20px">
	<td  style="text-align:left; width:25%; font-size:0.6em;"><!-- Nama Pemilik / Perusahaan --></td>
	<td style="width: 3%;font-size:0.6em;" ><!-- : --></td>
	<td style="width: 72%;text-weight:bold;font-size:0.8em;" >#idx2# / #idx3#</td>
	</tr>
	</tbody>
</table>

<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 12px;">
      <td style="width: 100%;" colspan="4"></td>
    </tr>
  </tbody>
</table>

<!--Content -->
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	<tr style="line-height:20px">
	<td  style="text-align:left; width:25%; font-size:0.6em;"><!-- Alamat Pemilik --></td>
	<td style="width: 3%;font-size:0.6em;" ><!-- : --></td>
	<td style="width: 72%;font-size:0.7em;" >#idx4#</td>
	</tr>
	</tbody>
</table>

<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 12px;">
      <td style="width: 100%;" colspan="4"></td>
    </tr>
  </tbody>
</table>

<!--Content -->
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	<tr style="line-height:20px">
	<td  style="text-align:left; width:25%; font-size:0.6em;"><!-- Masa Berlaku --></td>
	<td style="width: 3%;font-size:0.6em;" ><!-- : --></td>
	<td style="width: 72%;font-size:0.7em;" >#idx12#</td>
	</tr>
	</tbody>
</table>

<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 12px;">
      <td style="width: 100%;" colspan="4"></td>
    </tr>
  </tbody>
</table>

<!--Content -->
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	<tr style="font-size:0.6em; line-height:13px">
	<td  style="text-align:center; width:15%; "><!-- No. Kend/STNK --></td>
	<td  style="text-align:center; width:15%;" ><!-- No. Uji --></td>
	<td  style="text-align:center; width:17;" ><!-- Jenis Kendaraan --></td>
	<td  style="text-align:center; width:20%;" ><!-- Kode Trayek --></td>
	<td  style="text-align:center; width:30%;" ><!-- Asal Tujuan Trayek --></td>
	</tr>
	<tr style="line-height:22px">
	<td  style="text-align:center; width:15%; font-size:0.7em;">#idx6#</td>
	<td  style="text-align:center; width:15%;font-size:0.7em;" >#idx7#</td>
	<td  style="text-align:center; width:17%;font-size:0.7em;" >#idx8#</td>
	<td  style="text-align:center; width:20%;font-size:0.7em;" >#idx9#</td>
	<td style="text-align:center; width:30%;font-size:0.7em;" >#idx10#</td>
	</tr>
	</tbody>
</table>

<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 5px;">
      <td style="width: 100%;" colspan="4"></td>
    </tr>
  </tbody>
</table>

<!--Content -->
<table style="width: 100%; margin-left: auto; margin-right: auto;">
	<tbody>
	<tr style="font-size:0.2em;">
		<td  style="width:35%"></td>
		<td style="text-align:right; width:67%;"></td>
	</tr>
	<tr style="font-size:0.5em;">
	<td  style="width:30%"><!-- PERHATIAN : --></td>
	<td style="width:20%;"><img src="berkas/core/images/tanda_tangan/non_retribusi.png" width="50px"></td>
	<!-- <td style="text-align:center; width:12.5%;"></td> -->
	<td style="width: 12%;" rowspan="6">
	<img src="<?php echo base_url('sk_izin/qr_code').'/'.$id_permohonan?>">	</td>
	<td style="width:34%;"><span style="text-align:center;font-size:1.2em !important;">#idx11#</span></td>
	</tr>
	<tr style="font-size:0.5em;">
	<td  style="width:2.5%;"><!-- 1. --></td>
	<td style="text-align:justify; width:32.5%"><!-- Kartu tanda bukti ini harus dibawa bersama kendaraan tercantum diatas jangan sampai rusak/hilang dan tidak boleh dipinjamkan kepada siapapun --></td>
	<td style="width:5%;"></td>
	<td style="text-align:center; width:15%;">
		<table>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td></td>
			</tr>
			<tr>
				<td  style="font-size:0.2em;"></td>
			</tr>
		</table>	
	</td>
		<td style="width:15%;"></td>
		<td style="width:32%;text-align:center;line-height:6px;font-weight:bold;font-size:1.0em;"rowspan="5">KA. DINAS PENANAMAN MODAL & PELAYANAN<br><img src="berkas/core/images/tanda_tangan/kadis.png" width="63px"></td>
	</tr>
	<tr style="font-size:0.5em;">
	<td  style="width:2.5%;"><!-- 2. --></td>
	<td style="text-align:justify; width:32.5%"><!-- Satu bulan sebelum masa berlakunya habis dapat dimohon untuk diperbaharui --></td>
	<td style="width:5%;"></td>
	<td style="text-align:center; width:15%;">
		<table>
			<tr>
				<td ><!-- Berdasarkan --></td>
			</tr>
			<tr>
				<td ><!-- Perda Kota Bekasi --></td>
			</tr>
		</table>
	</td>
	</tr>
	<tr style="font-size:0.5em;">
	<td  style="width:2.5%;"><!-- 3. --></td>
	<td style="text-align:justify; width:32.5%"><!-- Kartu ini bukan merupakan izin trayek --></td>
	<td style="width:5%;"></td>
	<td style="text-align:center; width:15%;">
		<table>
			<tr>
				<td ><!-- No. 18 Tahun 2001 --></td>
			</tr>
			<tr>
				<td  style="font-size:0.2em;"></td>
			</tr>
		</table>
	</td>
	</tr>
	<tr style="font-size:0.8em;">
		<td  style="width:35%"></td>
	</tr>
	<tr>
		<td class="" style="width:67%"></td>
		<td style=" width:37%;font-size:0.5em;font-weight:bold;text-align:center;"><span style="">Drs. AMIT RIYADI, M.Si</span><br>NIP. 19590511 1986603 1005</td>
	</tr>
	</tbody>
</table>