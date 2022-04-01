<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canvas_tl extends MY_Controller {
    function __construct() {
        parent::__construct();      
    }


    //final argo & worktime
    public function histori_datetime($id_permohonan) { 
        $condition      = [];
        $condition[]    = ['id_permohonan', $id_permohonan, 'where'];
        $condition[]    = ['id_histori_permohonan', 'asc', 'order_by'];
        $t_histori      = $this->M_core->get_tbl('v_histori_permohonan', '*', $condition)->result_array();

        foreach($t_histori as $ths) {
            $dths[$ths['id_histori_permohonan']]['id_histori_permohonan'] = $ths['id_histori_permohonan'];
            $dths[$ths['id_histori_permohonan']]['id_workflow_decision']  = $ths['id_workflow_decision'];
            $dths[$ths['id_histori_permohonan']]['id_decision']           = $ths['id_decision'];
            $dths[$ths['id_histori_permohonan']]['id_aktivitas_workflow'] = $ths['id_aktivitas_workflow'];
            $dths[$ths['id_histori_permohonan']]['id_aktivitas']          = $ths['id_aktivitas'];
            $dths[$ths['id_histori_permohonan']]['waktu_in']              = $ths['waktu_in'];
        }

        $minArr      = min(array_keys($dths));
        $maxArr      = max(array_keys($dths));
        $startDate[] = $dths[$minArr]['waktu_in']; 

        //pending loop
        foreach($dths as $k => $v) {
            if($v['id_decision'] == 4) {
                $endDate[] = $v['waktu_in'];

                $condition      = [];
                $condition[]    = ['id_permohonan', $id_permohonan, 'where'];
                $condition[]    = ['id_histori_permohonan >', $v['id_histori_permohonan'], 'where'];
                $condition[]    = ['', 1, 'limit'];
                $thsnxt         = $this->M_core->get_tbl('t_histori_permohonan', '*', $condition)->row_array();
                if($thsnxt['waktu_in'] != null) {
                    $startDate[]    = $thsnxt['waktu_in'];
                } 
            }
        }

        //pending
        if($dths[$maxArr]['id_decision'] == 4) {
            // $endDate[] = $dths[$maxArr]['waktu_in']; 
        
        //reject
        } else if($dths[$maxArr]['id_decision'] == 3) {
            $endDate[] = $dths[$maxArr]['waktu_in']; 
        
        //cetak
        } else if($dths[$maxArr]['id_aktivitas'] == 14) {
            $endDate[] = $dths[$maxArr]['waktu_in']; 
        
        //progress
        } else {
             // $endDate[] = date('2017-07-10 14:00:00');
             $endDate[] = date('Y-m-d H:i:s');
        }

        //count argo
        $argo_sec = [];
        $argo_his = [];

        $countArr = count($startDate);
        for($i=0;$i<$countArr;$i++) {
            $startDateMask[$i] = $this->get_mask_datetime($startDate[$i], $endDate[$i])['start'];
            $endDateMask[$i]   = $this->get_mask_datetime($startDate[$i], $endDate[$i])['end'];
            
            $argo_sec[]   = $this->get_worktime($startDateMask[$i], $endDateMask[$i]);
            $argo_his[]	  = $this->convert_his($this->get_worktime($startDateMask[$i], $endDateMask[$i]));
        }

        $worktime_total = $this->convert_his(array_sum($argo_sec));
        $get_argo       = $this->get_argo($id_permohonan, $worktime_total);

        $d['argo']       = $get_argo['argo_now'];
        $d['argo_label'] = $get_argo['argo_now_label'];

        echo '<pre>';
        var_dump($startDateMask);
        var_dump($endDateMask);
        var_dump($argo_sec);
        var_dump($argo_his);
        
        return $d;
    }

    //core argo new
    private function get_argo($id_permohonan, $worktime_total) {
        $condition      = [];
        $condition[]    = ['id_permohonan', $id_permohonan, 'where'];
        $vpi            = $this->M_core->get_tbl('v_permohonan_izin', '*', $condition)->row_array();

        $condition      = [];
        $condition[]    = ['id_nama_izin', $vpi['id_nama_izin'], 'where'];
        $mai            = $this->M_core->get_tbl('m_argo_izin', '*', $condition)->row_array();

        $his_sec  = $this->convert_seconds($worktime_total);   
        $mai_sec  = $this->convert_seconds($mai['total_hour']);   
        $argo     = $this->convert_his($mai_sec - $his_sec);

        if($argo < 0) {
            $d['argo_now'] = '-'.$this->convert_his($his_sec - $mai_sec);
        } else {
            $d['argo_now'] = $argo;
        }

        if($d['argo_now'] <= $mai['danger_hour']) {
            $label = 'label label-danger';
        } else if($d['argo_now'] <= $mai['warning_hour'] && $d['argo_now'] > $mai['danger_hour']) {
            $label = 'label label-warning';
        } else {
            $label = 'label label-success';
        }

        $d['argo_now_label'] = '<span class="'.$label.'">'.$d['argo_now'].'</span>';

        return $d;
    }
   
    private function get_worktime($datetime_start_mask=null, $datetime_end_mask=null) {
        //try
        // $datetime_start_mask = '2017-08-08 14:42:11';
        // $datetime_end_mask = '2017-08-10 13:38:59';

        //define 
        $date_start = date('Y-m-d', strtotime($datetime_start_mask));
        $date_end   = date('Y-m-d', strtotime($datetime_end_mask));
        $time_start = date('H:i:s', strtotime($datetime_start_mask));
        $time_end   = date('H:i:s', strtotime($datetime_end_mask));

        // arrays
        $worktime   = [];
        $skipdays   = $this->get_weekends();
        $skipdates  = $this->get_holidays();

        // variables
        $i  = 0;
        $ts = [];
        $te = [];
        $current = $date_start;

        // same dates
        if($current == $date_end) {
            $timestamp = strtotime($date_start);

            // if NOT weekend & holiday
            if (!in_array(date("l", $timestamp), $skipdays)&&!in_array(date("Y-m-d", $timestamp), $skipdates)) {
                $ts[] = $time_start;
                $te[] = $time_end;

            // if weekend & holiday            
            } else {
                $ts[] = '00:00:00';
                $te[] = '00:00:00';
            }


        // different dates
        } else if($current < $date_end) {
            
            // timestamp & date array
            $timestamp_arr  = [];
            $date_arr       = [];
            while ($current < $date_end) {
                $timestamp_arr[$i]  = strtotime($date_start." +".$i." day");
                $date_arr[$i]       = date("Y-m-d", $timestamp_arr[$i]);
                $current            = date("Y-m-d", $timestamp_arr[$i]);
                $i++;
            }

            // ts & te array
            $i2 = 0;
            $end = count($date_arr)-1;
            foreach($date_arr as $key => $val) {
                $timestamp  = strtotime($val);
                $day        = date("l", $timestamp);
                $get_time   = $this->get_time($day);
                
                // if NOT weekend & holiday
                if (!in_array(date("l", $timestamp), $skipdays)&&!in_array(date("Y-m-d", $timestamp), $skipdates)) {
                    
                    // ts & te default
                    $ts[$i2] = $get_time['start'];
                    $te[$i2] = $get_time['end'];

                    // ts & te first
                    if($i2 == 0) {
                        $ts[$i2] = $time_start;
                        $te[$i2] = $get_time['end'];
                    } 

                    // ts & te last
                    if($i2 == $end) {
                        $ts[$i2] = $get_time['start'];
                        $te[$i2] = $time_end;
                    }
                
                // if weekend & holiday
                } else {
                    $ts[$i2] = '00:00:00';
                    $te[$i2] = '00:00:00';

                }

                $i2++;
            }

        // wrong dates
        } else {
            $ts[] = '00:00:00';
            $te[] = '00:00:00';
        }


        // calculate worktime
        $worktime_sec = []; 
        for($x=0;$x<count($date_arr);$x++) {
            $worktime_sec[$x] = $this->convert_seconds($te[$x]) - $this->convert_seconds($ts[$x]); 
        }

        $res['worktime_sec_total'] = array_sum($worktime_sec);


        // echo '<pre>';
        // var_dump($ts);
        // var_dump($te);
        // var_dump($date_arr);
        // var_dump($worktime_sec);
        // var_dump($this->convert_his($res['worktime_sec_total']));
        
        return $res['worktime_sec_total'];
    }

    private function get_holidays() {
        $condition      = [];
        $condition[]    = ['aktif', 1, 'where'];
        $get_holidays   = $this->M_core->get_tbl('m_holidays', '*', $condition)->result_array();
        
        $days_array = []; 
        
        foreach($get_holidays as $ghdy) {
            $days_array[] = $ghdy['date'];
        }

        return $days_array;
    }

    private function get_weekends() {
        $condition      = [];
        $condition[]    = ['aktif', 1, 'where'];
        $condition[]    = ['weekend', 1, 'where'];
        $get_weekends   = $this->M_core->get_tbl('s_worktime', '*', $condition)->result_array();
        
        $days_array = []; 
        
        foreach($get_weekends as $gwk) {
            $days_array[] = $gwk['day'];
        }

        return $days_array;
    }

    private function get_time($day) {
        $condition      = [];
        $condition[]    = ['aktif', 1, 'where'];
        $condition[]    = ['day', $day, 'where'];
        $get_time       = $this->M_core->get_tbl('s_worktime', 'time', $condition)->row_array()['time'];
        
        $time = explode('-', $get_time);
        $res['start'] = $time[0];
        $res['end']   = $time[1]; 

        return $res;
    }


    // mask time
    private function get_mask_datetime($datetime_start_real, $datetime_end_real) {
        // datetime start
        $timestamp_start = strtotime($datetime_start_real);
        $day_start       = date("l",$timestamp_start);

        // get start end time by start real
        $se_time1 = $this->get_start_end_time_by_real($day_start);
        $worktime_start1 = $se_time1['start_time'];
        $worktime_end1   = $se_time1['end_time'];

        // explode start real
        $explode_start = explode(' ',$datetime_start_real);
        $date_start    = $explode_start[0];
        $time_start    = $explode_start[1];
        
        // datetime end
        $timestamp_end = strtotime($datetime_end_real);
        $day_end       = date("l",$timestamp_end);

        // get start end time by end real
        $se_time2 = $this->get_start_end_time_by_real($day_end);
        $worktime_start2 = $se_time2['start_time'];
        $worktime_end2   = $se_time2['end_time'];

        // explode end real
        $explode_end = explode(' ',$datetime_end_real);
        $date_end    = $explode_end[0];
        $time_end    = $explode_end[1];

        // count date diff
        $date_s    = date_create($date_start);
        $date_e    = date_create($date_end);
        $diff      = date_diff($date_s, $date_e);
        $date_diff = $diff->format("%R%a");

        // date diff < 0
        if($date_diff < 0) {
            $md_start = $this->get_mask_date_start_zero();
            $md_end   = $this->get_mask_date_end_zero();
        
        } else if($date_diff == 0) {

            // formula a-c
            if(($time_start > $worktime_end1 && $time_start <= '23:59') && ($time_end > $worktime_end2 && $time_end <= '23:59')) {
                $md_start = $this->get_mask_date_start_zero();
                $md_end   = $this->get_mask_date_end_zero();

            // formula a-d
            } else if(($time_start > $worktime_end1 && $time_start <= '23:59') && ($time_end > '00:00' && $time_end < $worktime_start2)) {
                $md_start = $this->get_mask_date_start_zero();
                $md_end   = $this->get_mask_date_end_zero();

            // formula b-d
            } else if(($time_start > '00:00' && $time_start < $worktime_start1) && ($time_end > '00:00' && $time_end < $worktime_start2)) {
                $md_start = $this->get_mask_date_start_zero();
                $md_end   = $this->get_mask_date_end_zero();

            } else {
                $md_start = $this->get_mask_date_start($date_start, $time_start, $worktime_start1, $worktime_end1);
                $md_end   = $this->get_mask_date_end($date_end, $time_end, $worktime_start2, $worktime_end2);
            }
        
        // date diff == 1
        } else if($date_diff == 1) {

            // formula a-d
            if(($time_start > $worktime_end1 && $time_start <= '23:59') && ($time_end > '00:00' && $time_end < $worktime_start2)) {
                $md_start = $this->get_mask_date_start_zero();
                $md_end   = $this->get_mask_date_end_zero();
            } else {
                $md_start = $this->get_mask_date_start($date_start, $time_start, $worktime_start1, $worktime_end1);
                $md_end   = $this->get_mask_date_end($date_end, $time_end, $worktime_start2, $worktime_end2);

            }

        // date diff > 1
        } else if($date_diff > 1) {
            $md_start = $this->get_mask_date_start($date_start, $time_start, $worktime_start1, $worktime_end1);
            $md_end   = $this->get_mask_date_end($date_end, $time_end, $worktime_start2, $worktime_end2);

        }

        //result mask
        $dt['start'] = $md_start['date_start_new'].' '.$md_start['time_start_new'];
        $dt['end']   = $md_end['date_end_new'].' '.$md_end['time_end_new'];

        return $dt;
    }

    private function get_mask_date_start($date_start, $time_start, $worktime_start1, $worktime_end1) {
        if($time_start > $worktime_end1 && $time_start <= '23:59') {
            $dt['date_start_new'] = date('Y-m-d', strtotime($date_start.' + 1 day'));
            $dt['time_start_new'] = $worktime_start1;

        } else if($time_start > '00:00' && $time_start < $worktime_start1) {
            $dt['date_start_new'] = $date_start;
            $dt['time_start_new'] = $worktime_start1;
        
        } else {
            $dt['date_start_new'] = $date_start;
            $dt['time_start_new'] = $time_start; 
        }

        return $dt;
    }

    private function get_mask_date_end($date_end, $time_end, $worktime_start2, $worktime_end2) {
        if($time_end > $worktime_end2 && $time_end <= '23:59') {
            $dt['date_end_new'] = $date_end;
            $dt['time_end_new'] = $worktime_end2;
        
        } else if($time_end > '00:00' && $time_end < $worktime_start2) {
            $dt['date_end_new'] = date('Y-m-d', strtotime($date_end.' - 1 day'));
            $dt['time_end_new'] = $worktime_end2;
        
        } else {
            $dt['date_end_new'] = $date_end;
            $dt['time_end_new'] = $time_end;
        }

        return $dt;
    }

    private function get_mask_date_start_zero() {
        $dt['date_start_new'] = '0000-00-00';
        $dt['time_start_new'] = '00:00:00';

        return $dt;
    }

    private function get_mask_date_end_zero() {
        $dt['date_end_new'] = '0000-00-00';
        $dt['time_end_new'] = '00:00:00';

        return $dt;
    }

    private function get_start_end_time_by_real($day) {
        $condition      = [];
        $condition[]    = ['aktif', 1, 'where'];
        $condition[]    = ['day', $day, 'where'];
        $swk            = $this->M_core->get_tbl('s_worktime', '*', $condition)->row_array();

        $expl = explode('-', $swk['time']);
        $dt['start_time'] = $expl[0];
        $dt['end_time']   = $expl[1];

        return $dt;
    }

 
    //tools
    private function convert_seconds($timestamp) {
        $timeselections = explode(':', $timestamp);
        $seconds =  ($timeselections[0] * 3600)      //Hours to Seconds
                 +  ($timeselections[1] * 60)        //Minutes to Seconds
                 +  ($timeselections[2]);           //Seconds to Seconds
        return $seconds;
    }

    private function convert_his($seconds) {
        $sec = $seconds;
        $H   = floor($sec / 3600);
        $i   = ($sec / 60) % 60;
        $s   = $sec % 60;
        $his = sprintf("%02d:%02d:%02d", $H, $i, $s);
        return $his;
    }

    private function get_jenis_izin($id_jenis_izin) {
        $condition      = [];
        $condition[]    = ['id_jenis_izin', $id_jenis_izin, 'where'];
        $jiz            = $this->M_permohonan_izin->get_master_spec('m_jenis_izin', 'kd_jenis_izin, id_nama_izin', $condition)->row_array();

        $kd_jenis_izin = $jiz['kd_jenis_izin'];

        $condition      = [];
        $condition[]    = ['id_nama_izin', $jiz['id_nama_izin'], 'where'];
        $nama_izin      = $this->M_permohonan_izin->get_master_spec('m_nama_izin', 'akronim', $condition)->row_array()['akronim'];      

        $data_jenis = array();

        $data       = $this->M_permohonan_izin->get_parent_izin($kd_jenis_izin)->row_array();
        while ($data) { 
            $parent_kd  = substr($data['kd_jenis_izin'], 0, -2);
            $data_jenis[] = $data['jenis_izin'];
            $data       = $this->M_permohonan_izin->get_parent_izin($parent_kd)->row_array();
        }
        $data_jenis     = array_reverse($data_jenis);

        $response       = $nama_izin.' - ';
        
        $i = 0;
        $count = count($data_jenis);
        foreach ($data_jenis as $dj) {
            $pref = " - ";
            if(++$i === $count) {
                $pref = "  ";
            }
            $response   .= $dj.$pref;
        }
        return $response;
    }


    //info
    
    /*cols formula for masking worktime

    #START
    (a) 17.01 - 23.59 = +1 day | 08:00
    (d) 00.00 - 07.59 = +0 day | 08:00

    #END
    (c) 17.01 - 23.59 = +0 day | 17:00
    (d) 00.00 - 07.59 = -1 day | 17:00


      node |  <0  |  0  |  1  |  >1  |
    -------|------|-----|-----|------|
     a - c |   X  |  X  |  V  |   V  |
     a - d |   X  |  X  |  X  |   V  |
     b - c |   X  |  V  |  V  |   V  |
     b - d |   X  |  X  |  V  |   V  |

    */



}