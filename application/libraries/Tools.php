<?php
class Tools
{
    
    function importdata($file,$table1,$table2,$table3,$startRow,$checkPrimary=FALSE)
    {

        $CI=& get_instance();
        $CI->load->database();

        $CI->db->trans_start();

        $CI->load->library('phpexcel');
        $CI->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel();
        try{
            $inputFileType = IOFactory::identify($file);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
        } catch (Exception $ex) {
            die("Tidak dapat mengakses file ".$ex->getMessage());
        }

        $ID_NAME = null;

        $sheet1 = $objPHPExcel->getSheet(0);
        $highestRow = $sheet1->getHighestRow();
        $highestColumn = $sheet1->getHighestColumn();
        
        for ($row = $startRow; $row <= $highestRow; $row++){
            $rowData = $sheet1->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
            $startCol=0;
            if($checkPrimary==TRUE)
            {
                $startCol=0;
            }else{
                $startCol=1;
            }
                    
            $fields = $CI->db->list_fields('tbl_m_name');
            $countfield=count($fields);
            
            $datacol=array();
            $dataxl=array();

            $kode_user = $CI->session->userdata('kode_user');
            $date = date('Y-m-d');
            $kolom_kode = 1;
            $kolom_date = 2;

            for($col=$startCol;$col < $countfield;$col++)
            {
                $datacol[]=$fields[$col]; //nama field 

                //input data
                if($colXl == 0) {
                    $dataxl[] = null; //AI
                } elseif($colXl == $kolom_kode) {
                    $dataxl[] = $kode_user;
                } elseif($colXl == $kolom_date) {
                    $dataxl[] = $date;
                } else {
                    $dataxl[]=$rowData[0][$colXl];
                }
                $colXl++;  
            }

            $data=array_combine($datacol,$dataxl);
            $CI->db->insert($table1,$data); 
            $ID_NAME = $CI->db->insert_id();
        }

        $sheet2 = $objPHPExcel->getSheet(1);
        $highestRow = $sheet2->getHighestRow();
        $highestColumn = $sheet2->getHighestColumn();

        for ($row = $startRow; $row < $highestRow -1; $row++){
            $rowData = $sheet2->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

            $startCol=0;
            if($checkPrimary==TRUE)
            {
                $startCol=0;
            }else{
                $startCol=1;
            }
                    
            $fields = $CI->db->list_fields('tbl_m_office');
            $countfield=count($fields);
            
            $datacol=array();
            $dataxl=array();
            $colXl=0;

            $kolom_id_name=1;

            $kolom_date=2;
            
            for($col=$startCol; $col < $countfield; $col++)
            {
                $datacol[]=$fields[$col];

                if($colXl==$kolom_date) { //to check the row
                    $date_o = trim($rowData[0][$colXl]);
                } 

                //input data
                if($colXl == $kolom_id_name) {
                    $dataxl[] = $ID_NAME;
                } else {
                    $dataxl[]=$rowData[0][$colXl];
                }

                $colXl++;                 
            }

            if($date_o || $date_o == 1) {
                $data=array_combine($datacol,$dataxl);
                $CI->db->insert($table2,$data);        
            }
        }

        $sheet3 = $objPHPExcel->getSheet(2);
        $highestRow = $sheet3->getHighestRow();
        $highestColumn = $sheet3->getHighestColumn();

        for ($row = $startRow; $row < $highestRow -1; $row++){
            $rowData = $sheet3->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

            $startCol=0;
            if($checkPrimary==TRUE)
            {
                $startCol=0;
            }else{
                $startCol=1;
            }
                    
            $fields = $CI->db->list_fields('tbl_m_misc');
            $countfield=count($fields);
            
            $datacol=array();
            $dataxl=array();
            $colXl=0;

            $kolom_id_name=1;

            $kolom_date=2;

            for($col=$startCol; $col < $countfield; $col++)
            {
                $datacol[]=$fields[$col];

                if($colXl==$kolom_date) { //to check the row
                    $date_m = $rowData[0][$colXl];
                } 

                //input data
                if($colXl == $kolom_id_name) {
                    $dataxl[] = $ID_NAME;
                } else {
                    $dataxl[]=$rowData[0][$colXl];
                }

                $colXl++;                   
            }

            if($date_m != "" || $date_m == "empty") {
                $data=array_combine($datacol,$dataxl);
                $CI->db->insert($table3,$data);        
            }
        }

        $CI->db->trans_complete();

    }        
}
?>
