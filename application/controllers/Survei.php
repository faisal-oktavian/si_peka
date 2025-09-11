<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends AZ_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$app = $this->azapp;

        $this->db->where('status', 1);
        $this->db->where('is_active', 1);
        $ruangan = $this->db->get('ruangan');

        $data['ruangan'] = $ruangan;

		$v = $this->load->view('v_survei', $data, true);
		$app->add_content($v);

		// $js = az_add_js('home/vjs_home');
		// $app->add_js($js);

		echo $app->render();	
	}
}