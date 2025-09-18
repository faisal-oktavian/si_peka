<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {
	public function __construct() {
        parent::__construct();

    }

	public function get_room(){
		$limit = 20;
		$q = $this->input->get("term");
		$page = $this->input->get("page");

		$offset = ($page - 1) * $limit;
		
		$this->db->order_by("nama_ruangan");
		if (strlen($q) > 0) {
			$this->db->like("nama_ruangan", $q);
		}
		$this->db->where('is_active','1');
		$this->db->select("idruangan as id, nama_ruangan as text");
		$this->db->where('status', '1');

		$data = $this->db->get("ruangan", $limit, $offset);
		
		if (strlen($q) > 0) {
			$this->db->like("nama_ruangan", $q);
		}
		$this->db->where('is_active','1');
		$this->db->where('status', '1');
		$cdata = $this->db->get("ruangan");
		$count = $cdata->num_rows();

		$endCount = $offset + $limit;
		$morePages = $endCount < $count;

		$results = array(
		  "results" => $data->result_array(),
		  "pagination" => array(
		  	"more" => $morePages
		  )
		);
		echo json_encode($results);
	}
}	
