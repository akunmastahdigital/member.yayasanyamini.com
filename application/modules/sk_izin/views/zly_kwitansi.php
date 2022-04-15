<style>
    *{
        font-family:'Calibry';
        /* line-height:'25px'; */
    }
</style>

<table>

    <tr>
        <td style="width:100%;text-align:center"><img src="<?php echo base_url() ?>berkas/header.png"></td>
    </tr>
    <tr>
        <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:100%;text-align:center"><b>TANDA TERIMA</b><br></td>
    </tr>

    <tr>
        <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
    </tr>
    

    <tr>
        <td style="width:4%"></td>
        <td style="width:25%"><b>Sudah Diterima dari</b></td>
        <td style="width:3%">:</td>
        <td style="width:65%">#idx1#</td>
    </tr>
    <tr>
        <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
    </tr>

    <?php if (count($multiple_ziswaf) > 0) { ?>
        <tr>
            <td style="width:4%"></td>
            <td style="width:25%"><b>Donasi </b></td>
            <td style="width:3%">:</td>
            <td style="width:65%">
                <?php 
                    foreach($multiple_ziswaf as $mz) {
                        $condition 	= [];
                        $condition[]= ['id_jenis_izin', $mz['id_jenis_izin'], 'where'];
                        $jenis_izin = $this->M_admin->get_master_spec('m_jenis_izin', 'jenis_izin', $condition)->row_array()['jenis_izin'];
                        echo "- ".$jenis_izin.' ( Rp '.number_format($mz['sub_total'],0,".",".").' )';
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:4%"></td>
            <td style="width:25%"><b>Total Uang </b></td>
            <td style="width:3%">:</td>
            <td style="width:65%"><?php echo $jumlah ?></td>
        </tr>
        <tr>
            <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:4%"></td>
            <td style="width:25%"><b>Terbilang </b></td>
            <td style="width:3%">:</td>
            <td style="width:1%; background-color: #eee;"></td>
            <td style="width:63%; background-color: #eee;"><?php echo $terbilang ?></td>
            <td style="width:1%; background-color: #eee;"></td>
        </tr>
    <?php } else { ?>
    <tr>
        <td style="width:4%"></td>
        <td style="width:25%"><b>Donasi </b></td>
        <td style="width:3%">:</td>
        <td style="width:65%">#idx4#</td>
    </tr>
    <tr>
        <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:4%"></td>
        <td style="width:25%"><b>Uang Sejumlah </b></td>
        <td style="width:3%">:</td>
        <td style="width:65%"><?php echo $jumlah ?></td>
    </tr>
    <tr>
        <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:4%"></td>
        <td style="width:25%"><b>Terbilang </b></td>
        <td style="width:3%">:</td>
        <td style="width:1%; background-color: #eee;"></td>
        <td style="width:63%; background-color: #eee;"><?php echo $terbilang ?></td>
        <td style="width:1%; background-color: #eee;"></td>
    </tr>
    <?php } ?>
    <tr>
        <td style="line-height: 10px;font-size:3px;">&nbsp;</td>
    </tr>
    <tr>
        <td style="width:5%;"></td>
        <td style="width:60%; font-size:10px; line-height:15px; text-align:justify"><br><br>“Mudah-mudahan Allah memberi pahala atas apa yang engkau berikan, memberikan berkah atas apa yang masih ada di tanganmu dan menjadikannya sebagai pembersih bagimu."</td>
        <td style="width:5%;"></td>
        <td style="width:30%;text-align:center; font-size:12px;">Jakarta, <?php echo $tgl_permohonan ?><br>Panitia Ziswaf Yamini<br>
        <img width="120" src="<?php echo base_url() ?>berkas/ttd.png"></td>
    </tr>
</table>