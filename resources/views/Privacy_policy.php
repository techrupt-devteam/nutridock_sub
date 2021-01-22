<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('common','',TRUE);
		$this->load->helper('functions_helper');
    }


	public function index()
	{
		
		$data['title'] = 'Nutridock';
		$this->load->view('header',$data);
		$this->load->view('privacy_policy');
		$this->load->view('footer');
	}
}
