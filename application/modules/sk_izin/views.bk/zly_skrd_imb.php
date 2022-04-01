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
      <td class="l" style="width:11%;font-size: 0.6em;text-align:left;font-weight:bold;" rowspan="7"><img src="<?php echo base_url();?>berkas/core/images/bekasi_logo.png">
      </td>
      <td class="r " style="width:32%;font-size: 0.6em;text-align:center;font-weight:bold;">PEMERINTAH KOTA BEKASI</td>
      <td class="l r " style="width:27%;font-size: 0.6em;text-align:center;letter-spacing:2px;font-weight:bold;">SKRD</td>
       <td class="l" style="width:10%;font-size: 0.6em;text-align:left;"> 
       <!--  <table>
          <tr>
            <td width="5%">&bull;</td>
            <td width="37%">Lembaran 1</td>
            <td width="5%">:</td>
            <td width="53%">Putih</td>
          </tr>
        </table> -->
      </td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold">NOMOR Urut SKRD</td>
      <td class=" r" style="width:10%;font-size: 0.6em;text-align:center;font-weight:bold"></td>
    </tr>


    <tr>
      <td class="r" style="width:32%;font-size: 0.6em;text-align:center;font-weight:bold;line-height: 7px">DINAS PENANAMAN MODAL DAN PELAYANAN</td>
      <td class="l r" style="width:27%;font-size: 0.65em;text-align:center;font-weight:bold">(Surat Ketetapan Retribusi Daerah)</td>
       <td class="" style="width:10%;font-size: 0.6em;text-align:left;">
      <!--  <table>
          <tr>
            <td width="5%">&bull;</td>
            <td width="37%">Lembaran 2</td>
            <td width="5%">:</td>
            <td width="53%">Merah</td>
          </tr>
        </table> -->
      </td>
      <td class="" style="width:10%;font-size: 0.6em;text-align:left;"></td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:left;"></td>
    </tr>


    <tr>
      <td class="r" style="width:32%;font-size: 0.6em;text-align:center;font-weight:bold;line-height: 5px">TERPADU SATU PINTU</td>
      <td class="l r" style="width:27%;font-size: 0.6em;text-align:center;"></td>
       <td class="" style="width:20%;font-size: 0.6em;text-align:left;">
        <!-- <table>
          <tr>
            <td width="3%"></td>
            <td width="5%">&bull;</td>
            <td width="37%">Lembaran 3</td>
            <td width="5%">:</td>
            <td width="50%">Kuning</td>
          </tr>
        </table> -->

      </td>
      <td class="r" style="width:10%;font-size: 0.6em;text-align:center"></td>
    </tr>


    <tr>
      <td class="r" style="width:32%;font-size: 0.6em;text-align:center;"></td>
      <td class="l r" style="width:27%;font-size: 0.7em;text-align:left;">
        <table>
          <tr>
            <td width="40%">Masa Retribusi</td>
            <td width="5%">:</td>
            <td width="55%"><?php echo $masa_retribusi;?></td>
          </tr>
        </table>
      </td>
       <td class="" style="width:10%;font-size: 0.6em;text-align:left;">
      <!--  <table>
          <tr>
            <td width="5%">&bull;</td>
            <td width="37%">Lembaran 4</td>
            <td width="5%">:</td>
            <td width="53%">Hijau</td>
          </tr>
        </table> -->
      </td>
      <td class="" style="width:10%;font-size: 1.2em;text-align:center;font-weight:bold" rowspan="3"><?php echo $no_skrd;?></td>
      <td class="r" style="width:10%;font-size: 1.2em;text-align:center;font-weight:bold" rowspan="3"></td>
    </tr>

    <tr>
      <td class="" style="width:32%;font-size: 0.6em;text-align:center;font-weight:bold;">Jl. Jend. A. Yani No. 1 Tlp. (021) 88855450 - 88961767 Ext.</td>
      <td class="l r" style="width:27%;font-size: 0.7em;text-align:left;">
        <table>
          <tr>
            <td width="40%">Bulan/Tahun</td>
            <td width="5%">:</td>
            <td width="55%"><?php echo $bulan.'/'.$tahun;?></td>
          </tr>
        </table>
      </td>
       <td class="" style="width:20%;font-size: 0.6em;text-align:left;">
      <!--  <table>
          <tr>
            <td width="5%">&bull;</td>
            <td width="37%">Lembaran 5</td>
            <td width="5%">:</td>
            <td width="53%">Biru</td>
          </tr>
        </table> -->
      </td>
     <!--  <td class="r" style="width:10%;font-size: 0.6em;text-align:center;">
      </td> -->
    </tr>
    <tr>
      <td class="r" style="width:32%;font-size: 0.6em;text-align:center;font-weight:bold;line-height:5px;">219/232</td>
      <td class="l r" style="width:27%;font-size: 0.6em;text-align:center;"></td>
      <td class="" style="width:20%;font-size: 0.6em;text-align:center;"></td>
      <!-- <td class="l r" style="width:10%;font-size: 0.6em;text-align:center;">
      </td> -->
    </tr>

    <tr>
      <td class="r" style="width:32%;font-size: 0.6em;text-align:center;letter-spacing:1px;font-weight:bold;line-height:3px;">BEKASI</td>
      <td class="l r" style="width:27%;font-size: 0.6em;text-align:center;"></td>
       <td class="l " style="width:20%;font-size: 0.6em;text-align:center;"></td>
      <td class=" r" style="width:10%;font-size: 0.6em;text-align:center;"></td>
    </tr>

    <!-- space -->
    <tr style="line-height:-10px;">
      <td class="b" style="width:20%;font-size: 1px;text-align:center;font-weight:bold;"></td>
      <td class="b" style="width:20%;font-size: 1px;text-align:center;font-weight:bold;"></td>
      <td class="b " style="width:20%;font-size: 1px;text-align:center;"></td>
      <td class="b " style="width:40%;font-size: 1px;text-align:center;"></td>
    </tr>
    
  </tbody>
</table>

<!-- Content2 -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr>
      <td class="l r" style="width: 100%; font-size:3px;"></td>
    </tr>
    <tr>
      <td class="l" style="width: 1%; font-size: 0.65em"></td>
      <td class="" style="width: 10%; font-size: 0.65em">NAMA</td>
      <td class="" style="width: 5%; font-size: 0.65em" >:</td>
      <td class="r" style="width: 84%; font-size: 0.65em"><?php echo $nama_pemohon;?></td>
    </tr>
    <tr>
      <td class="l" style="width: 1%; font-size: 0.65em"></td>
      <td class="" style="width: 10%; font-size: 0.65em">LOKASI</td>
      <td class="" style="width: 5%; font-size: 0.65em">:</td>
      <td class="r" style="width: 84%; font-size: 0.65em"><?php echo $alamat_pemohon;?></td>
    </tr>
    <tr>
      <td class="l r b" style="width: 100%; font-size:3px;"></td>
    </tr>
  </tbody>
</table>

<!-- Content3 -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr>
      <td class="l r" style="width: 100%; font-size:3px;"></td>
    </tr>
    <tr>
      <td class="l r" style="width: 100%; font-size: 0.7em; text-align:center; font-weight:bold">DASAR HUKUM PENGENAAN RETRIBUSI</td>
    </tr>
    <tr>
      <td class="l r" style="width: 100%; font-size: 0.7em; text-align:center">Perda No. 10 Tahun 2012</td>
    </tr>
    <tr>
      <td class="l r b" style="width: 100%; font-size:3px;"></td>
    </tr>
  </tbody>
</table>

<!-- Content4 -->
<!-- <table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
    <tr>
      <td class="l r" style="width: 50%; font-size:3px;"></td>
      <td class="r" style="width: 50%; font-size:3px;"></td>
    </tr>


    <tr>
      <td class="l r" style="width: 50%; font-size: 0.7em; text-align:left; font-weight:bold">
        <table>
          <tr>
            <td class="" style="width: 1%; font-size: 0.7em"></td>
            <td class="" style="width: 10%; font-size: 0.7em">NAMA</td>
            <td class="" style="width: 5%; font-size: 0.7em" >:</td>
            <td class="" style="width: 84%; font-size: 0.7em">#</td>
          </tr>
        </table>
      </td>

      <td class="l r" style="width: 50%; font-size: 0.7em; text-align:left; font-weight:bold">
        <table>
          <tr>
            <td class="" style="width: 1%; font-size: 0.7em"></td>
            <td class="" style="width: 25%; font-size: 0.7em">NOMOR BAP</td>
            <td class="" style="width: 5%; font-size: 0.7em" >:</td>
            <td class="" style="width: 59%; font-size: 0.7em">#</td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td class="l r" style="width: 50%; font-size: 0.7em; text-align:left; font-weight:bold">
        <table>
          <tr>
            <td class="" style="width: 1%; font-size: 0.7em"></td>
            <td class="" style="width: 10%; font-size: 0.7em">NPWRD</td>
            <td class="" style="width: 5%; font-size: 0.7em" >:</td>
            <td class="" style="width: 84%; font-size: 0.7em">#</td>
          </tr>
        </table>
      </td><td class="l r" style="width: 50%; font-size: 0.7em; text-align:left; font-weight:bold">
        <table>
          <tr>
            <td class="" style="width: 1%; font-size: 0.7em"></td>
            <td class="" style="width: 25%; font-size: 0.7em">TANGGAL BAP</td>
            <td class="" style="width: 5%; font-size: 0.7em" >:</td>
            <td class="" style="width: 59%; font-size: 0.7em">#</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td class="l r b" style="width: 50%; font-size:3px;"></td>
      <td class="r b" style="width: 50%; font-size:3px;"></td>
    </tr>
  </tbody>
</table> -->

<!-- Content5 -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
  <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r" style="width: 5%; font-size:3px;"></td>
      <td class="l r" style="width: 40%; font-size:3px;"></td>
      <td class="l r" style="width: 40%; font-size:3px;"></td>
      <td class="l r" style="width: 15%; font-size:3px;"></td>
    </tr>
    <!-- isi -->
    <tr style="font-weight:bold">
      <td class="l r b" style="width: 5%; font-size:0.7em; text-align:center">No.</td>
      <td class="l r b" style="width: 40%; font-size:0.7em; text-align:center">KODE REKENING</td>
      <td class="l r b" style="width: 40%; font-size:0.7em; text-align:center">JENIS PAJAK RETRIBUSI</td>
      <td class="l r b" style="width: 15%; font-size:0.7em; text-align:center">JUMLAH (Rp)</td>
    </tr>
      <tr>
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
    </tr>
    <tr style="font-size: 12px;">
      <td class="l r" style="width: 5%; font-size:0.7em; text-align:center">1</td>
      <td class="l r" style="width: 40%; font-size:0.7em; text-align:center"><?php echo $kode_rekening;?></td>
      <td class="l r" style="width: 40%; font-size:0.7em; text-align:left"><?php echo $izin;?></td>
      <td class="l r" style="width: 15%; font-size:0.7em; text-align:right"><?php echo $total;?></td>
    </tr>
    <tr >
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
    </tr>
    <tr>
      <td class="l r" style="width: 5%; font-size:0.7em; text-align:center"></td>
      <td class="l r" style="width: 40%; font-size:0.7em; text-align:center"></td>
      <td class="l r" style="width: 40%; font-size:0.7em; text-align:left"></td>
      <td class="l r" style="width: 15%; font-size:0.7em; text-align:right"></td>
    </tr>
    <tr >
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
    </tr>
    <tr style="font-size: 12px;">
      <td class="l r" style="width: 5%; font-size:0.7em; text-align:center"></td>
      <td class="l r" style="width: 40%; font-size:0.7em; text-align:center"></td>
      <td class="l r" style="width: 40%; font-size:0.7em; text-align:left"> </td>
      <td class="l r" style="width: 15%; font-size:0.7em; text-align:right;"></td>
    </tr>
     <tr>
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
      <td class="l r" ></td>
    </tr>
    <tr>
      <td class=" t" style="font-size:0.7em;"></td>
      <td class="r t" style="font-size:0.7em;" ></td>
      <td class="l r t" style="font-size:0.7em; text-align: left;" >Jumlah Ketetapan Pokok Retribusi</td>
      <td class="l r t" ></td>
    </tr>
    <tr>
      <td class="" style="font-size:0.7em;"></td>
      <td class="r" style="font-size:0.7em;" ></td>
      <td class="l r t" style="font-size:0.7em; text-align: left;" >Jumlah Sanksi : a. bunga</td>
      <td class="l r t" ></td>
    </tr>
    <tr>
      <td class="" style="font-size:0.7em;"></td>
      <td class="r" style="font-size:0.7em;" ></td>
      <td class="l r t" style="font-size:0.7em; text-align: left;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: b. kenaikan</td>
      <td class="l r t" ></td>
    </tr>
    <tr>
      <td class="" style="font-size:0.7em;"></td>
      <td class="r" style="font-size:0.7em;" ></td>
      <td class="l r t b" style="font-size:0.7em; text-align: left;" >Jumlah Keseluruhan</td>
      <td class="l r t b" style="font-size:0.7em; text-align: right;"><?php echo $total;?></td>
    </tr>
    <!-- space -->
   
  </tbody>
</table>


<!-- Content6 -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l t" style="width:1%; font-size: 2px"></td>
      <td class="r t" style="width:99%; font-size: 2px"></td>
    </tr>
  <tr style="font-weight:bold">
      <td class="l" style="width:1%; font-size: 0.8em"></td>
      <td class="r" style="width:99%; font-size: 0.8em">Dengan Huruf : TUJUH PULUH LIMA RUPIAH</td>
  </tr>
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l b" style="width:1%; font-size: 2px"></td>
      <td class="r b" style="width:99%; font-size: 2px"></td>
    </tr>
  </tbody>
  </table>

  <!-- Content7 -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l" style="width:1%; font-size: 2px"></td>
      <td class="r" style="width:99%; font-size: 2px"></td>
    </tr>
  <tr style="font-weight:bold">
    <td class="l" style="width:1%; font-size: 0.7em"></td>
    <td class="r" style="width:99%; font-size: 0.7em">PERHATIAN :</td>
  </tr>
  <tr style="">
    <td class="l" style="width:1%; font-size: 0.7em"></td>
    <td class="" style="width:2.5%; font-size: 0.7em">1.</td>
    <td class="r" style="width:96.5%; font-size: 0.7em">Harap penyetoran dilakukan melalui Kas Daerah pada Bank Jabar Banten Kas Pemkot Bekasi dengan menggunakan Surat Retribusi Daerah (SSRD).</td>
  </tr>
  <tr style="">
    <td class="l" style="width:1%; font-size: 0.7em"></td>
    <td class="" style="width:2.5%; font-size: 0.7em">2.</td>
    <td class="r" style="width:96.5%; font-size: 0.7em">SKRD ini berfungsi juga sebagai Nota Hitung dan Surat Pemberitahuan Retribusi Daerah (SKRD).</td>
  </tr>
 <!--  <tr style="">
    <td class="l" style="width:1%; font-size: 0.7em"></td>
    <td class="" style="width:2.5%; font-size: 0.7em">3.</td>
    <td class="r" style="width:96.5%; font-size: 0.7em">Tanda Bukti Setoran Tunai berlaku juga sebagai Surat Setoran Retribusi Daerah (SKRD).</td>
  </tr> -->
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l b" style="width:1%; font-size: 2px"></td>
    <td class="r b" style="width:99%; font-size: 2px"></td>
    </tr>
  </tbody>
  </table>

  <!-- Content8 -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l" style="width:70%; font-size: 2px"></td>
    <td class="r" style="width:30%; font-size: 2px"></td>
    </tr>
  <tr style="">
    <td class="l" style="width:70%; font-size: 0.7em"></td>
    <td class="r" style="width:30%; font-size: 0.7em">Bekasi, 
    </td>
  </tr>
  <tr style="font-weight:bold">
    <td class="l" style="width:70%; font-size: 0.7em"></td>
    <td class="r" style="width:30%; font-size: 0.7em; text-align: center;">a.n. Kepala Badan Pendapatan Daerah Kepala Bidang Pendapatan Daerah
    </td>
  </tr>
  <tr style="font-weight:bold;line-height:60px;">
    <td class="l" style="width:70%; font-size: 0.7em"></td>
    <td class="r" style="width:30%; font-size: 0.7em">
    </td>
  </tr>
  <tr style="font-weight:bold;text-align:center">
    <td class="l" style="width:70%; font-size: 0.7em"></td>
    <td class="r" style="width:30%; font-size: 0.7em">MAMAT RACHMAT, S.Sos, M.Si<br>
    NIP. 19601001 199803 1 001
    </td>
  </tr>
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l b" style="width:70%; font-size: 2px"></td>
    <td class="r b" style="width:30%; font-size: 2px"></td>
    </tr>
  </tbody>
  </table>

  <!-- margin -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l r" style="width:100%; font-size: 1px"></td>   
    </tr>  
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l r " style="width:100%; font-size: 1px"></td>
    </tr>
  </tbody>
  </table>



   <!-- content -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l" style="width:70%; font-size: 0.7em" line-height="5px"></td>
      <td class="" style="width:10%; font-size: 0.7em" line-height="5px">No.SKRD</td>
      <td class="" style="width:5%; font-size: 0.7em" line-height="5px">:</td>
      <td class="r" style="width:15%; font-size: 0.7em" line-height="5px"><?php echo $no_skrd;?></td>
    </tr>  
   <!-- isi -->
    <tr style="font-weight:bold">
      <td class="l" style="width:1%; font-size: 0.7em"></td>
      <td class="" style="width:33%; font-size: 0.7em"><!-- <img src="<?php echo base_url();?>berkas/core/images/bank_bjb.png"> --></td>   
      <td class="" style="width:21%; font-size: 0.7em;text-align:right">
       
        <table>
       <!--  <tr>
          <td style="font-size: 6px";></td>
        </tr> -->
        <tr>
          <td><u>TANDA TERIMA</u></td>
        </tr>

        </table>
      </td>
      <td style="width: 10%;"></td>
      <td class="r"></td>
    </tr>  

     <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r" style="width:100%; font-size: 2px"></td>
    </tr>  

    </tbody>
  </table>

 <!-- margin -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r" style="width:100%; font-size: 1px"></td>
    </tr>  
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r " style="width:100%; font-size: 1px"></td>
    </tr>
  </tbody>
  </table>

  <!-- margin -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l r" style="width:100%; font-size: 5px"></td>   
    </tr>  
  </tbody>
  </table>




   <!-- content -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
  <!-- isi -->
    <tr style="">
      <td class="l" style="width:1%; font-size: 0.7em"></td>
      <td class="" style="width:2.5%; font-size: 0.7em"></td>
      <td class="" style="width:18%; font-size: 0.7em">NAMA</td>
      <td class="" style="width:3%; font-size: 0.7em">:</td>
      <td class="r" style="width:75.5%; font-size: 0.7em"><?php echo $nama_pemohon;?></td>
    </tr> 
  <!-- space -->
    <tr style="">
      <td class="l r" style="width:100%; font-size: 7px"></td>   
    </tr> 
  <!-- isi -->
    <tr style="">
      <td class="l" style="width:1%; font-size: 0.7em"></td>
      <td class="" style="width:2.5%; font-size: 0.7em"></td>
      <td class="" style="width:18%; font-size: 0.7em">ALAMAT</td>
      <td class="" style="width:3%; font-size: 0.7em">:</td>
      <td class="r" style="width:75.5%; font-size: 0.7em"><?php echo $alamat_pemohon;?></td>
    </tr>  
  <!-- space -->
    <tr style="">
    <td class="l r" style="width:100%; font-size: 7px"></td>   
    </tr> 
  <!-- isi -->
    <tr style="">
      <td class="l" style="width:1%; font-size: 0.7em"></td>
      <td class="" style="width:2.5%; font-size: 0.7em"></td>
      <td class="" style="width:18%; font-size: 0.7em">BULAN</td>
      <td class="" style="width:3%; font-size: 0.7em">:</td>
      <td class="r" style="width:75.5%; font-size: 0.7em"><?php echo $bulan;?></td>
    </tr>
  <!-- space -->
    <tr style="">
      <td class="l r" style="width:100%; font-size: 7px"></td>   
    </tr> 
 
    <tr style="">
      <td class="l r" style="width:100%; font-size: 7px"></td>   
    </tr> 
  <!-- isi -->
  
  <!-- space -->
    <tr style="">
      <td class="l r" style="width:100%; font-size: 7px"></td>   
    </tr> 
  <!-- isi -->
  </tbody>
  </table>

<!-- margin -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
    <td class="l r" style="width:100%; font-size: 5px"></td>
    </tr>
  </tbody>
  </table>
  



 <!-- content -->
<table style="width: 100%; height: 10px; margin-left: auto; margin-right: auto;">
  <tbody>
   <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r" style="width:100%; font-size: 5px"></td>
    </tr>  
   <!-- isi -->
    <tr style="">
      <td class="l" style="width:70%; font-size: 0.7em"></td>
      <td class="r" style="width:30%; font-size: 0.7em">Bekasi, Tahun </td>
    </tr>  
    <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r" style="width:100%; font-size: 5px"></td>
    </tr>  

    <!-- isi -->
    <tr style="">
      <td class="l" style="width:33.3%; font-size: 0.7em;text-align:center"></td>
      <td class="" style="width:33.3%; font-size: 0.7em;text-align:center"></td>
      <td class="r" style="width:33.4%; font-size: 0.7em;text-align:center">Yang Menerima</td>
    </tr> 

    <tr style="line-height:65px;">
      <td class="l" style="width:33.3%; font-size: 0.7em;text-align:center"></td>
      <td class="" style="width:33.3%; font-size: 0.7em;text-align:center"></td>
      <td class="r" style="width:33.4%; font-size: 0.7em;text-align:center"></td>
    </tr> 

    <tr style="">
     <td class="l" style="width:33.3%; font-size: 0.7em;text-align:center; letter-spacing:-1px;"></td>
     <td class="" style="width:33.3%; font-size: 0.7em;text-align:center; letter-spacing:-1px;"></td>
     <td class="r" style="width:33.4%; font-size: 0.7em;text-align:center">( .......................... )</td>
    </tr> 
    <!-- space -->
    <tr style="font-weight:bold">
      <td class="l r b" style="width:100%; font-size: 5px"></td>
    </tr>  
  </tbody>
</table>
