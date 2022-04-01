<!-- LAYOUT SIUP -->
<style>
  .l { border-left: 1px solid black; }
  .t { border-top: 1px solid black; }
  .r { border-right: 1px solid black; }
  .b { border-bottom: 1px solid black; }
</style>

<!-- MARGIN -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr style="line-height: 35px;">
      <td style="width: 100%;" colspan="4"></td>
    </tr>
  </tbody>
</table>

<!-- CONTENT -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;line-height: 15px;">
  <tbody>
  <!-- space -->
    <tr>
      <td class="l t" style="width:20%;font-size: 1px;text-align:center;font-weight:bold;"></td>
      <td class="t" style="width:20%;font-size: 1px;text-align:center;font-weight:bold;"></td>
      <td class="t" style="width:20%;font-size: 1px;text-align:center;"></td>
      <td class="t" style="width:40%;font-size: 1px;text-align:center;"></td>
    </tr>
    <tr>
      <td class="l" style="width:12%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="l" style="width:40%;font-size: 0.8em;text-align:center;font-weight:bold;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>

    <tr>
      <td class="l b" style="width:12%;font-size: 0.6em;text-align:left;font-weight:bold;" rowspan="7"><img src="<?php echo base_url();?>berkas/core/images/bekasi_logo.png">
      </td>
      <td class="r" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;">PEMERINTAH KOTA BEKASI</td>
      <td class="l" style="width:43%;font-size: 0.8em;text-align:center;font-weight:bold;">SSRD</td>
      <td class="r" style="width:7%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>

    <tr>
      <td class="r" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;">BADAN PENDAPATAN DAERAH</td>
      <td class="" style="width:43%;font-size: 0.8em;text-align:right;font-weight:bold;">(SURAT SETORAN RETRIBUSI DAERAH)</td>
      <td class="r" style="width:7%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>

    <tr>
      <td class="r" style="width:38%;font-size: 0.8em;text-align:left;">Jl. Ir. H. Juanda No.100</td>
      <td class="l" style="width:43%;font-size: 0.8em;text-align:center;">Tahun : <?php echo $tahun;?></td>
      <td class="r" style="width:7%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>

    <tr>
      <td class="r" style="width:38%;font-size: 0.8em;text-align:left;">Telp. (021) 88397963, Fax. (021) 88397965</td>
      <td class="l" style="width:40%;font-size: 0.8em;text-align:center;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>

    <tr>
      <td class="r" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;">BEKASI</td>
      <td class="l" style="width:40%;font-size: 0.8em;text-align:center;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>

    <tr>
      <td class="b r" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="l b" style="width:40%;font-size: 0.8em;text-align:center;"></td>
      <td class="b r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>
  </tbody>
</table>


<!-- CONTENT -->
<table style="width: 100%; margin-left: auto; margin-right: auto;line-height: 15px;">
  <tbody>

    <tr>
      <td class="l" style="width:12%;font-size: 0.8em;text-align:left;font-weight:bold;line-height: 10px;"></td>
      <td class="" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;line-height: 10px;"></td>
      <td class="" style="width:40%;font-size: 0.8em;text-align:center;font-weight:bold;line-height: 10px;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold;line-height: 10px;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:15%;font-size: 0.8em;text-align:left;letter-spacing:2px;">Nama</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;">:</td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:left;"><?php echo $nama_pemohon;?></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:right;"></td>
      <td class="r" style="width:50%;font-size: 0.6em;text-align:right;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:15%;font-size: 0.8em;text-align:left;letter-spacing:2px;">Alamat</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;">:</td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:left;"><?php echo $alamat_pemohon;?></td>
      <td class="" style="width:50%;font-size: 0.6em;text-align:right;"></td>
      <td class="r" style="width:15%;font-size: 0.6em;text-align:right;"></td>
    </tr>

    <tr>
      <td class="l" style="width:12%;font-size: 0.8em;text-align:left;font-weight:bold;line-height: 10px;"></td>
      <td class="" style="width:38%;font-size: 0.8em;text-align:left;font-weight:bold;line-height: 10px;"></td>
      <td class="" style="width:40%;font-size: 0.8em;text-align:center;font-weight:bold;line-height: 10px;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold;line-height: 10px;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:20%;font-size: 0.8em;text-align:left;">Menyetor berdasarkan *)</td>
      <td class="" style="width:5%;font-size: 0.8em;text-align:left;">:</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">SKRD</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">STRD</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">Lain-lain</td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:20%;font-size: 0.8em;text-align:left;"></td>
      <td class="" style="width:5%;font-size: 0.8em;text-align:left;"></td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">SKRDT</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">SPTRD</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:20%;font-size: 0.8em;text-align:left;"></td>
      <td class="" style="width:5%;font-size: 0.8em;text-align:left;"></td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">SKRDKB</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">SK Pembetulan</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:20%;font-size: 0.8em;text-align:left;"></td>
      <td class="" style="width:5%;font-size: 0.8em;text-align:left;"></td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">SKRDKBT</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;">Sk Keberatan</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;"></td>
      <td class="" style="width:15%;font-size: 0.6em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:20%;font-size: 0.8em;text-align:left;"></td>
      <td class="" style="width:5%;font-size: 0.8em;text-align:left;">:</td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:left;">Masa Retribusi</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;">:</td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:left;"><?php echo $masa_retribusi;?></td>

      <td class="" style="width:5%;font-size: 0.6em;text-align:left;">Tahun</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;">:</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;"><?php echo $tahun;?></td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:left;">No. Urut</td>
      <td class="" style="width:5%;font-size: 0.6em;text-align:left;">:</td>
      <td class="r" style="width:15%;font-size: 0.6em;text-align:left;"><?php echo $no_skrd;?></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.8em;text-align:center;line-height:20px;font-weight:bold;">NO</td>
      <td class="l t r b" style="width:25%;font-size: 0.8em;text-align:center;line-height:20px;font-weight:bold;">KODE REKENING</td>
      <td class="l t r b" style="width:30%;font-size: 0.8em;text-align:center;line-height:20px;font-weight:bold;">JENIS RETRIBUSI DAERAH</td>
      <td class="l t r b" style="width:25%;font-size: 0.8em;text-align:center;line-height:20px;font-weight:bold;">JUMLAH Rp.</td>
      <td class="" style="width:2%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;">1</td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;">#</td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"><?php echo $izin;?></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"><?php echo $total;?></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r b" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:6%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="l t r b" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;">Jumlah Setoran Retribusi</td>
      <td class="l t r b" style="width:25%;font-size: 0.6em;line-height:12px;text-align:center;"><?php echo $total;?></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>


    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:10%;font-size: 0.6em;line-height:12px;text-align:center;">Dengan huruf</td>
      <td class="l t r b" style="width:76%;font-size: 0.6em;line-height:12px;text-align:left;"><?php echo $total_terbilang;?></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r " style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r " style="width:30%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l t r " style="width:28%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:normal;"></td>
      <td class="l r" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:normal;">Diterima oleh,</td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;">Bekasi, <?php echo $tgl_terbit;?></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l r" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:normal;">Petugas Tempat Pembayaran</td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:10%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:normal;">Tanggal</td>
      <td class="" style="width:5%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;">:</td>
      <td class="r" style="width:15%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:center;">Penyetor</td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:10%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:normal;">Tanda Tangan</td>
      <td class="" style="width:5%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;">:</td>
      <td class="r" style="width:15%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:10%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:normal;">Nama Terang</td>
      <td class="" style="width:5%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;">:</td>
      <td class="r" style="width:15%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;"></td>
      <td class="l r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:center;"><?php echo $nama_pemohon;?></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="l b r" style="width:28%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="b" style="width:10%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:normal;"></td>
      <td class="b" style="width:5%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;"></td>
      <td class="b" style="width:15%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;"></td>
      <td class="r b l" style="width:28%;font-size: 0.6em;line-height:12px;text-align:center;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="l" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:30%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;">*) Berit tanda V pada kotak</td>
      <td class="l t r b" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:normal;"></td>
      <td class="" style="width:30%;font-size: 0.6em;line-height:12px;text-align:center;font-weight:bold;">sesuai dengan ketepatan yang dimiliki</td>
      <td class="" style="width:21%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="" style="width:2%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
      <td class="r" style="width:5%;font-size: 0.6em;line-height:12px;text-align:left;font-weight:bold;"></td>
    </tr>

    <tr>
      <td class="l b" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;"></td>
      <td class="b" style="width:85%;font-size: 0.8em;text-align:left;"></td>
      <td class="r b" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>

    <tr>
      <td class="" style="width:8%;font-size: 0.8em;text-align:left;font-weight:bold;">MODEL</td>
      <td class="" style="width:5%;font-size: 0.8em;text-align:left;font-weight:bold;">:</td>
      <td class="" style="width:8%;font-size: 0.8em;text-align:left;font-weight:bold;">DPD-12</td>
      <td class="" style="width:75%;font-size: 0.8em;text-align:left;"></td>
    </tr>


 
  </tbody>
</table>