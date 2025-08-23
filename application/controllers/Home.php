<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AZ_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$app = $this->azapp;

		$v = $this->load->view('v_home', '', true);
		$app->add_content($v);

		// $js = az_add_js('home/vjs_home');
		// $app->add_js($js);

		echo $app->render();	
	}
}