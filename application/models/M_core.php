<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_core extends CI_Model {

    // Core
    function get_tbl($paramTable, $paramSelect, $condition) {
        $this->db->select($paramSelect);
        if ($condition) {
            foreach ($condition as $c) {
                if(is_array($c[1])) {
                    $this->db->$c[2]($c[1]);
                } else {
                    $this->db->$c[2]($c[0], $c[1]);
                }
            }
        }
        return $this->db->get($paramTable);
    }

    function update_tbl($paramTable, $data, $condition) {
        if ($condition) {
            foreach ($condition as $c) {
                $this->db->$c[2]($c[0], $c[1]);
            }
        }
        return $this->db->update($paramTable, $data);
    }

    function update_tbl_batch($paramTable, $data, $id) {
        $this->db->update_batch($paramTable, $data, $id);
    }   

    function insert_tbl_normal($paramTable, $data) {
        $this->db->insert($paramTable, $data);
        return $this->db->insert_id();
    }

    function insert_tbl_batch($paramTable, $data) {
        $this->db->insert_batch($paramTable, $data);
    }

    function reqDetect($e) {
        if($e == 1) {
            $d['attr']   = 'required';
            $d['symbol'] = '&nbsp;<i class="text-danger fa fa-asterisk"></i>';
        } else {
            $d['attr']   = '';
            $d['symbol'] = '';
        }
        return $d;
    }

    function t_plural_group_1($id_permohonan, $core) {
        $query = 'select 
                    tpl.id_permohonan,
                    tpl.id_'.$core.'_s,
                    tpl.id_'.$core.'_p,
                    tpl.aktif

                   from t_'.$core.'_p tpl
                   where tpl.id_permohonan = '.$id_permohonan.' and tpl.aktif = 1
                   group by tpl.id_'.$core.'_s, tpl.id_'.$core.'_p';
        $tpg = $this->db->query($query);
        return $tpg;
    }

    function t_plural_group_index_1($id_permohonan, $core) {
        $query = 'select * from 
                    (select 
                        tpl.id_permohonan,
                        tpl.id_'.$core.'_s,
                        tpl.id_'.$core.'_p,
                        tpl.index,
                        tpl.aktif

                        from t_'.$core.'_p tpl
                        where tpl.id_permohonan = '.$id_permohonan.' and tpl.aktif = 1
                        group by tpl.id_'.$core.'_s, tpl.id_'.$core.'_p, tpl.index) bp2

                   group by bp2.index';
        $tpgi = $this->db->query($query);
        return $tpgi;
    }

    function t_plural_group_index_2($id_perusahaan, $core) {
        $query = 'select * from (select 
                    bp.id_perusahaan,
                    bp.id_'.$core.'_s,
                    bp.id_'.$core.'_p,
                    bp.index,
                    bp.aktif

                   from t_'.$core.'_p bp
                   where bp.id_perusahaan = '.$id_perusahaan.' and bp.aktif = 1
                   group by bp.id_'.$core.'_s, bp.id_'.$core.'_p, bp.index) bp2

                   group by bp2.index';
        $bpgi = $this->db->query($query);
        return $bpgi;
    }

    function t_plural_group_2($id_perusahaan, $core) {
        $query = 'select 
                    bp.id_perusahaan,
                    bp.id_'.$core.'_s,
                    bp.id_'.$core.'_p,
                    bp.aktif

                   from t_'.$core.'_p bp
                   where bp.id_perusahaan = '.$id_perusahaan.' and bp.aktif = 1
                   group by bp.id_'.$core.'_s, bp.id_'.$core.'_p';
        $bpg = $this->db->query($query);
        return $bpg;
    }

    function get_core($cond, $type) {
        $query = 'select  
                    `msi`.`id_'.$type.'_s`  AS  `id_'.$type.'_s` ,
                    `tsi`.`id_permohonan`  AS  `id_permohonan` ,
                    group_concat(  `tsi`.`nilai_string`  separator  \', \'  )  AS  `nilai_string` ,
                    group_concat(  `tsi`.`nilai_num`  separator  \', \'  )  AS  `nilai_num`  

                from (  `m_'.$type.'_s`  `msi`  
                    left  join `t_'.$type.'_s`  `tsi`  
                        on ( (  `tsi`.`id_'.$type.'_s`  =  `msi`.`id_'.$type.'_s`  ) )  ) 

                where ( '.$cond.' and (  `msi`.`aktif`  =1 ) and (  `tsi`.`aktif`  =1 ) ) 

                group  by  `tsi`.`id_permohonan` ,`msi`.`id_'.$type.'_s` ';
        $gc = $this->db->query($query);
        return $gc;
    }

    function kekata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
            $temp = " ". $angka[$x];
        } else if ($x <20) {
            $temp = $this->kekata($x - 10). " belas";
        } else if ($x <100) {
            $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
        } else if ($x <200) {
            $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x <1000) {
            $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
        } else if ($x <2000) {
            $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x <1000000) {
            $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x <1000000000) {
            $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x <1000000000000) {
            $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
            $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
        }     
            return $temp;
    }
 
 
    function terbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim($this->kekata($x));
        } else {
            $hasil = trim($this->kekata($x));
        }     
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }     
        return $hasil;
    }


}