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
            <td class="" style="font-size: 16px; text-align:center; width: 100%;" colspan="7">Laporan Perizinan <?php echo $izin;?></td>
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
            <th class="l t r b" style="width:15%" rowspan="2"><b>Provinsi</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kab/Kota</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kecamatan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kelurahan</b></th>

            <th class="l t r b" style="width:15%" rowspan="2"><b>No Kendaraan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>No Uji</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Jenis Kendaraan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Kode Trayek</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Asal Tujuan</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Nama Badan Hukum</b></th>
            <th class="l t r b" style="width:15%" rowspan="2"><b>Nama Pemilik</b></th>

            <th class="l t r b"  colspan="3"><b>Jenis Izin</b></th>

            <th class="l t r b" style="width:20%" rowspan="2"><b>No Izin Terbit</b></th>
            <th class="l t r b" style="width:20%" rowspan="2"><b>Masa Berlaku</b></th>
            <th class="l t r b" style="width:20%" rowspan="2"><b>Jenis Permohonan</b></th>
        </tr>
        <tr style="line-height: 18px;">
            
            <th class="l t r b" style="width:10%"><b>Lokal</b></th>
            <th class="l t r b" style="width:10%"><b>AKDP</b></th>
            <th class="l t r b" style="width:10%"><b>Barang</b></th>
           
          


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


            <?php 
            $query = $this->db->get_where('v_data_kendaraan', array('id_permohonan' => $gtl['id_permohonan']))->result_array();
                foreach ($query as $row) {
                    # code...
                }

            ?>




                


            <td class="l t r b" style="width:10%"><?php echo $gtl['nama_pemohon'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['alamat_stnk'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['provinsi'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['kabupaten'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['kecamatan'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['kelurahan'];?></td>

            <td class="l t r b" style="width:15%"><?php echo $row['no_kendaraan'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['no_uji'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['jenis_kendaraan'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['kode_trayek'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['asal_tujuan_trayek'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['nama_badan_hukum'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $row['nama_pemilik'];?></td>

          

     

            <?php if ($gtl['id_jenis_izin'] == '25' || $gtl['id_jenis_izin'] == '42' || $gtl['id_jenis_izin'] == '39' || $gtl['id_jenis_izin'] == '35') {?>
            <th class="l t r b" style="width:10%"><b>v</b></th>
            <th class="l t r b" style="width:10%"><b></b></th>
            <th class="l t r b" style="width:10%"><b></b></th>
            <?php }elseif ($gtl['id_jenis_izin'] == '26' || $gtl['id_jenis_izin'] == '36' || $gtl['id_jenis_izin'] == '40' || $gtl['id_jenis_izin'] == '43') {?>
            <th class="l t r b" style="width:10%"><b></b></th>
            <th class="l t r b" style="width:10%"><b>v</b></th>
            <th class="l t r b" style="width:10%"><b></b></th>
            <?php }elseif($gtl['id_jenis_izin'] == '27' || $gtl['id_jenis_izin'] == '28' || $gtl['id_jenis_izin'] == '41' || $gtl['id_jenis_izin'] == '44'){?>
            <th class="l t r b" style="width:10%"><b></b></th>
            <th class="l t r b" style="width:10%"><b></b></th>
            <th class="l t r b" style="width:10%"><b>v</b></th>
            <?php }else{ ?>
            <th class="l t r b" style="width:10%"><b></b></th>
            <th class="l t r b" style="width:10%"><b></b></th>
            <th class="l t r b" style="width:10%"><b></b></th>
            <?php }?>

            <td class="l t r b" style="width:15%"><?php echo $gtl['no_izin'];?></td>
            <td class="l t r b" style="width:15%"><?php echo $gtl['masa_berlaku'];?></td>   
            <td class="l t r b" style="width:20%"><?php echo $gtl['nama_izin'].' - '.$gtl['jenis_izin'];?></td>
        </tr>
        <?php $no++;} ?>
    </tbody>
</table>
