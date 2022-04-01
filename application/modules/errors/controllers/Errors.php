<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {	
	function error_404() {
		$d['page'] 		= 'e_404';
		$this->load->view('404');
	}
}