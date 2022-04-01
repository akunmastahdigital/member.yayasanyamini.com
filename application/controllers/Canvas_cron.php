<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canvas_cron extends MY_Controller {
    function __construct() {
        parent::__construct();      
    }

    public function debuging() { 
        $d = [];
        $d['date_added'] = date('Y-m-d');
        $d['time_added'] = date('H:i:S');
        $insert = $this->M_core->insert_tbl_normal('s_cronjob', $d);
    }
}