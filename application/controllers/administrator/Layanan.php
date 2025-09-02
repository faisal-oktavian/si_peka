<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_auth');
        az_check_auth('layanan');
        $this->table = 'layanan';
        $this->controller = 'layanan';
        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$azapp = $this->azapp;
		$crud = $azapp->add_crud();
		$this->load->helper('az_role');

		$crud->set_column(array('#', 'Nama Layanan', 'Urutan', 'Status', azlang('Action')));
		$crud->set_id($this->controller);
		$crud->set_default_url(true);

		$crud->add_aodata('vf_nama_layanan', 'vf_nama_layanan');
		$crud->add_aodata('vf_is_active', 'vf_is_active');

		$filter = $this->load->view('administrator/layanan/vf_layanan', '', true);
		$crud->set_top_filter($filter);

		$v_modal = $this->load->view('administrator/layanan/v_layanan', '', true);
		$crud->set_form('form');
		$crud->set_modal($v_modal);
		$crud->set_modal_title(azlang("Layanan"));
		$v_modal = $crud->generate_modal();

		$js = az_add_js('administrator/layanan/vjs_layanan');
		$azapp->add_js($js);

		$crud->set_callback_edit('
			check_copy();
        ');
		
		$crud = $crud->render();
		$crud .= $v_modal;	
		$azapp->add_content($crud);

		$data_header['title'] = azlang('Layanan');
		$data_header['breadcrumb'] = array('layanan');
		$azapp->set_data_header($data_header);
		
		echo $azapp->render();	
	}

	public function get() {
		$this->load->library('AZApp');
		$crud = $this->azapp->add_crud();

		$nama_layanan = $this->input->get('vf_nama_layanan');
		$is_active = $this->input->get('vf_is_active');

		$crud->set_select('idlayanan, nama_layanan, sequence, is_active');
		$crud->set_select_table('idlayanan, nama_layanan, sequence, is_active');
		$crud->set_filter('nama_layanan, sequence, is_active');
		$crud->set_sorting('nama_layanan, sequence, is_active');
		$crud->set_select_align(' , center, center');
		$crud->set_id($this->controller);
		$crud->add_where('status = "1" ');
		if (strlen($nama_layanan) > 0) {
			$crud->add_where('layanan.nama_layanan = "' . $nama_layanan . '"');
		}
		if (strlen($is_active) > 0) {
			$crud->add_where('layanan.is_active = "' . $is_active . '"');
		}
		$crud->set_custom_style('custom_style');
		$crud->set_table($this->table);
		$crud->set_order_by('idlayanan DESC');
		echo $crud->get_table();
	}

	function custom_style($key, $value, $data) {

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
			$idlayanan = azarr($data, 'idlayanan');
			$btn = $value;

			$btn .= '<button class="btn btn-info btn-xs btn-copy btn-edit-layanan" data_id="'.$idlayanan.'"><i class="fa fa-file"></i> Copy</button>';

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

		$this->form_validation->set_rules('nama_layanan', 'Nama Layanan', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('sequence', 'Urutan', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('is_active', 'Status', 'required|trim|max_length[200]');
		
		$err_code = 0;
		$err_message = '';

		if($this->form_validation->run() == TRUE){

			$data_save = array(
				'nama_layanan' => azarr($data_post, 'nama_layanan'),
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
		az_crud_edit('idlayanan, nama_layanan, sequence, is_active');
	}

	public function delete() {
		$id = $this->input->post('id');

		az_crud_delete($this->table, $id);
	}
}