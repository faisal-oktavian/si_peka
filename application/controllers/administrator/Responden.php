<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Responden extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_auth');
        az_check_auth('responden');
        $this->table = 'responden';
        $this->controller = 'responden';
        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$azapp = $this->azapp;
		$crud = $azapp->add_crud();
		$this->load->helper('az_role');

		$crud->set_column(array('#', 'Tanggal Input', 'No. RM', 'Nama Pasien', 'Ruangan', 'Kepuasan', azlang('Action')));
		$crud->set_id($this->controller);
		$crud->set_default_url(true);
        $crud->set_btn_add(false);

        $date1 = $azapp->add_datetime();
		$date1->set_id('date1');
		$date1->set_name('date1');
		$date1->set_format('DD-MM-YYYY');
		// $date1->set_value('01-'.Date('m-Y'));
		$data['date1'] = $date1->render();

		$date2 = $azapp->add_datetime();
		$date2->set_id('date2');
		$date2->set_name('date2');
		$date2->set_format('DD-MM-YYYY');
		// $date2->set_value(Date('t-m-Y'));
		$data['date2'] = $date2->render();

        $crud->add_aodata('date1', 'date1');
		$crud->add_aodata('date2', 'date2');    
		$crud->add_aodata('vf_no_rm', 'vf_no_rm');
		$crud->add_aodata('vf_nama_pasien', 'vf_nama_pasien');
		$crud->add_aodata('idf_ruangan', 'idf_ruangan');
		$crud->add_aodata('vf_kepuasan', 'vf_kepuasan');

        $modal = $azapp->add_modal();
		$modal->set_id('detail-responden');
		$modal->set_modal_title('Detail Responden');
		$modal->set_modal('<div class="container-responden"></div>');
		$azapp->add_content($modal->render());

		$filter = $this->load->view('administrator/responden/vf_responden', $data, true);
		$crud->set_top_filter($filter);

		$js = az_add_js('administrator/responden/vjs_responden');
		$azapp->add_js($js);
		
		$crud = $crud->render();
		$azapp->add_content($crud);

		$data_header['title'] = azlang('Responden');
		$data_header['breadcrumb'] = array('responden');
		$azapp->set_data_header($data_header);
		
		echo $azapp->render();	
	}

	public function get() {
		$this->load->library('AZApp');
		$crud = $this->azapp->add_crud();

		$date1 = $this->input->get('date1');
		$date2 = $this->input->get('date2');
		$no_rm = $this->input->get('vf_no_rm');
		$nama_pasien = $this->input->get('vf_nama_pasien');
		$idruangan = $this->input->get('idf_ruangan');
		$kepuasan = $this->input->get('vf_kepuasan');

		$role_name = $this->session->userdata('role_name');
		$idrole = $this->session->userdata('idrole');
		$sess_idruangan = $this->session->userdata('idruangan');


		$crud->set_select('idresponden, date_format(tanggal_input, "%d-%m-%Y %H:%i:%s") as txt_tanggal_input, no_rm, nama_pasien, nama_ruangan, kepuasan');
		$crud->set_select_table('idresponden, txt_tanggal_input, no_rm, nama_pasien, nama_ruangan, kepuasan');
		$crud->set_filter('no_rm, nama_pasien, nama_ruangan, kepuasan');
		$crud->set_sorting('no_rm, nama_pasien, nama_ruangan, kepuasan');
		$crud->set_select_align(' , , , , center');
        $crud->add_join_manual('ruangan', 'responden.idruangan = ruangan.idruangan');
		$crud->set_id($this->controller);

		if (strlen($idrole) > 0 && !in_array($role_name, array('administrator', 'kabid_yanmed', 'kasi_yanmed', 'kasi_keperawatan_dan_kebidanan') ) ) {
			$crud->add_where('responden.idruangan = "'.$sess_idruangan.'" ');
		}
        if (strlen($date1) > 0 && strlen($date2) > 0) {
            $crud->add_where('date(responden.tanggal_input) >= "'.Date('Y-m-d', strtotime($date1)).'"');
            $crud->add_where('date(responden.tanggal_input) <= "'.Date('Y-m-d', strtotime($date2)).'"');
        }
		if (strlen($no_rm) > 0) {
			$crud->add_where('responden.no_rm = "' . $no_rm . '"');
		}
		if (strlen($nama_pasien) > 0) {
			$crud->add_where('responden.nama_pasien = "' . $nama_pasien . '"');
		}
        if (strlen($idruangan) > 0) {
			$crud->add_where('responden.idruangan = "' . $idruangan . '"');
		}
        if (strlen($kepuasan) > 0) {
			$crud->add_where('responden.kepuasan = "' . $kepuasan . '"');
		}
		$crud->set_custom_style('custom_style');
		$crud->set_table($this->table);
		$crud->set_order_by('idresponden DESC');
		echo $crud->get_table();
	}

	function custom_style($key, $value, $data) {

		if ($key == 'kepuasan') {
			$lbl = 'default';
			$tlbl = '-';
			if ($value == "puas") {
				$lbl = 'success';
				$tlbl = 'Puas';
			}
            else if ($value == "tidak_puas") {
                $lbl = 'danger';
                $tlbl = 'Tidak Puas';
            }
			return "<label class='label label-".$lbl."'>".$tlbl."</label>";
		}

		if ($key == 'action') {
			$idresponden = azarr($data, 'idresponden');

			$btn = '<button class="btn btn-info btn-xs btn-copy btn-detail-responden" data_id="'.$idresponden.'"><i class="fa fa-list"></i> Detail</button>';

			return $btn;
		}
		return $value;
	}

	public function detail_data()
	{
		$id = $this->input->get('id');

		$this->db->where('responden.idresponden', $id);
		$this->db->select('no_rm, nama_pasien, kepuasan');
		$responden = $this->db->get('responden');
        // echo "<pre>"; print_r($this->db->last_query()); die();

		if ($responden->num_rows() > 0) {
			$total_data = 1;

			// layanan petugas
			$this->db->where('responden_detail.idresponden', $id);
			$this->db->where('idlayanan_petugas IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_petugas = layanan.idlayanan', 'left');
			$resp_petugas = $this->db->get('responden_detail');

			// layanan fasilitas
			$this->db->where('responden_detail.idresponden', $id);
			$this->db->where('idlayanan_fasilitas IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_fasilitas = layanan.idlayanan', 'left');
			$resp_fasilitas = $this->db->get('responden_detail');

			// layanan prosedur
			$this->db->where('responden_detail.idresponden', $id);
			$this->db->where('idlayanan_prosedur IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_prosedur = layanan.idlayanan', 'left');
			$resp_prosedur = $this->db->get('responden_detail');

			// layanan waktu
			$this->db->where('responden_detail.idresponden', $id);
			$this->db->where('idlayanan_waktu IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_waktu = layanan.idlayanan', 'left');
			$resp_waktu = $this->db->get('responden_detail');

			$arr_data = array();
			foreach ($resp_petugas->result() as $key => $value) {
				$arr_data[$key] = array(
					'layanan_petugas' => $value->nama_layanan,
					'description_layanan_petugas' => $value->description_layanan_petugas,
				);
			}

			foreach ($resp_fasilitas->result() as $key => $value) {
				$arr_data[$key]['layanan_fasilitas'] = $value->nama_layanan;
				$arr_data[$key]['description_layanan_fasilitas'] = $value->description_layanan_fasilitas;
			}

			foreach ($resp_prosedur->result() as $key => $value) {
				$arr_data[$key]['layanan_prosedur'] = $value->nama_layanan;
				$arr_data[$key]['description_layanan_prosedur'] = $value->description_layanan_prosedur;
			}
			
			foreach ($resp_waktu->result() as $key => $value) {
				$arr_data[$key]['layanan_waktu'] = $value->nama_layanan;
				$arr_data[$key]['description_layanan_waktu'] = $value->description_layanan_waktu;
			}

			// echo "<pre>"; print_r($arr_data); die();

			$data['responden'] = $responden;
			$data['arr_data'] = $arr_data;


			$view = $this->load->view('administrator/responden/v_detail', $data, true);
			$ret = array('success' => true, 'view' => $view);
		} else {
			$ret = array('success' => false, 'message' => "Data Transaksi tidak valid");
		}

		echo json_encode($ret);
	}
}