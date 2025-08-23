<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komponen extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_auth');
        az_check_auth('komponen');
        $this->table = 'komponen';
        $this->controller = 'komponen';
        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$azapp = $this->azapp;
		$crud = $azapp->add_crud();
		$this->load->helper('az_role');

		$crud->set_column(array('#', 'Nama Komponen', 'Status Kepuasan', 'Wajib Pilih Unit', 'Urutan', 'Status', azlang('Action')));
		$crud->set_id($this->controller);
		$crud->set_default_url(true);

		$crud->add_aodata('vf_nama_komponen', 'vf_nama_komponen');
		$crud->add_aodata('vf_status_kepuasan', 'vf_status_kepuasan');
		$crud->add_aodata('vf_is_unit', 'vf_is_unit');
		$crud->add_aodata('vf_is_active', 'vf_is_active');

		$filter = $this->load->view('administrator/komponen/vf_komponen', '', true);
		$crud->set_top_filter($filter);

		$v_modal = $this->load->view('administrator/komponen/v_komponen', '', true);
		$crud->set_form('form');
		$crud->set_modal($v_modal);
		$crud->set_modal_title(azlang("Komponen"));
		$v_modal = $crud->generate_modal();

		$js = az_add_js('administrator/komponen/vjs_komponen');
		$azapp->add_js($js);

		$crud->set_callback_edit('
			check_copy();
        ');
		
		$crud = $crud->render();
		$crud .= $v_modal;	
		$azapp->add_content($crud);

		$data_header['title'] = azlang('Komponen');
		$data_header['breadcrumb'] = array('komponen');
		$azapp->set_data_header($data_header);
		
		echo $azapp->render();	
	}

	public function get() {
		$this->load->library('AZApp');
		$crud = $this->azapp->add_crud();

		$nama_komponen = $this->input->get('vf_nama_komponen');
		$status_kepuasan = $this->input->get('vf_status_kepuasan');
		$is_unit = $this->input->get('vf_is_unit');
		$is_active = $this->input->get('vf_is_active');

		$crud->set_select('idkomponen, nama_komponen, status_kepuasan, is_unit, sequence, is_active');
		$crud->set_select_table('idkomponen, nama_komponen, status_kepuasan, is_unit, sequence, is_active');
		$crud->set_filter('nama_komponen, status_kepuasan, is_unit, sequence, is_active');
		$crud->set_sorting('nama_komponen, status_kepuasan, is_unit, sequence, is_active');
		$crud->set_select_align(' ,center, center, center, center');
		$crud->set_id($this->controller);
		$crud->add_where('status = "1" ');
		if (strlen($nama_komponen) > 0) {
			$crud->add_where('komponen.nama_komponen = "' . $nama_komponen . '"');
		}
        if (strlen($status_kepuasan) > 0) {
			$crud->add_where('komponen.status_kepuasan = "' . $status_kepuasan . '"');
		}
        if (strlen($is_unit) > 0) {
			$crud->add_where('komponen.is_unit = "' . $is_unit . '"');
		}
		if (strlen($is_active) > 0) {
			$crud->add_where('komponen.is_active = "' . $is_active . '"');
		}
		$crud->set_custom_style('custom_style');
		$crud->set_table($this->table);
		$crud->set_order_by('idkomponen DESC');
		echo $crud->get_table();
	}

	function custom_style($key, $value, $data) {

        if ($key == 'status_kepuasan') {
			$lbl = 'default';
			$tlbl = '-';
			if ($value == "PUAS") {
				$lbl = 'success';
				$tlbl = 'Puas';
			}
			else if ($value == "TIDAK PUAS") {
				$lbl = 'danger';
				$tlbl = 'Tidak Puas';
			}
			return "<label class='label label-".$lbl."'>".$tlbl."</label>";
		}

        if ($key == 'is_unit') {
			$lbl = 'info';
			$tlbl = '-';
			if ($value == "1") {
				$lbl = 'default';
				$tlbl = 'Ya';
			}
			else if ($value == "0") {
				$lbl = 'warning';
				$tlbl = 'Tidak';
			}
			return "<label class='label label-".$lbl."'>".$tlbl."</label>";
		}

        if ($key == 'sequence') {
			$sequence = az_thousand_separator($value);

			return $sequence;
		}

		if ($key == 'is_active') {
			$lbl = 'danger';
			$tlbl = 'TIDAK AKTIF';
			if ($value) {
				$lbl = 'success';
				$tlbl = 'AKTIF';
			}
			return "<label class='label label-".$lbl."'>".$tlbl."</label>";
		}

		if ($key == 'action') {
			$idkomponen = azarr($data, 'idkomponen');
			$btn = $value;

			$btn .= '<button class="btn btn-info btn-xs btn-copy btn-edit-komponen" data_id="'.$idkomponen.'"><i class="fa fa-file"></i> Copy</button>';

			return $btn;
		}
		return $value;
	}

	public function save(){
		$data = array();
		$data_post = $this->input->post();
		$idpost = azarr($data_post, 'id'.$this->table);
		$data['sMessage'] = '';
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		$this->form_validation->set_rules('nama_komponen', 'Nama Komponen', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('status_kepuasan', 'Status Kepuasan', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('is_unit', 'Opsi Unit', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('sequence', 'Urutan', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('is_active', 'Status', 'required|trim|max_length[200]');
		
		$err_code = 0;
		$err_message = '';

		if($this->form_validation->run() == TRUE){

			$data_save = array(
				'nama_komponen' => azarr($data_post, 'nama_komponen'),
				'status_kepuasan' => azarr($data_post, 'status_kepuasan'),
				'is_unit' => azarr($data_post, 'is_unit'),
				'sequence' => az_crud_number(azarr($data_post, 'sequence')),
				'is_active' => azarr($data_post, 'is_active'),
			);

			$response_save = az_crud_save($idpost, $this->table, $data_save);
			$err_code = azarr($response_save, 'err_code');
			$err_message = azarr($response_save, 'err_message');
			$insert_id = azarr($response_save, 'insert_id');
		}
		else {
			$err_code++;
			$err_message = validation_errors();
		}

		$data["sMessage"] = $err_message;
		echo json_encode($data);
	}

	public function edit() {
		az_crud_edit('idkomponen, nama_komponen, status_kepuasan, is_unit, sequence, is_active');
	}

	public function delete() {
		$id = $this->input->post('id');

		az_crud_delete($this->table, $id);
	}
}