<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_survei extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_auth');
        az_check_auth('role_report_survei');
        $this->table = 'responden';
        $this->controller = 'report_survei';
        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$azapp = $this->azapp;
		$crud = $azapp->add_crud();
		$this->load->helper('az_role');

		$crud->set_single_filter(false);
		$crud->set_btn_add(false);

		$date1 = $azapp->add_datetime();
		$date1->set_id('date1');
		$date1->set_name('date1');
		$date1->set_format('DD-MM-YYYY');
		$date1->set_value('01-'.Date('m-Y'));
		$data['date1'] = $date1->render();

		$date2 = $azapp->add_datetime();
		$date2->set_id('date2');
		$date2->set_name('date2');
		$date2->set_format('DD-MM-YYYY');
		$date2->set_value(Date('t-m-Y'));
		$data['date2'] = $date2->render();

		$date1 = $this->input->get('date1');
		$date2 = $this->input->get('date2');
		$no_rm = $this->input->get('no_rm');
		$nama_pasien = $this->input->get('nama_pasien');
		$idruangan = $this->input->get('idruangan');
		$kepuasan = $this->input->get('kepuasan');
        $nama_ruangan = '';

		if ($date1 == null) {
			$date1 = '01-'.Date('m-Y');
		}
        if ($date2 == null) {
			$date2 = Date('t-m-Y');
		}
        if (strlen($idruangan) > 0) {
            $this->db->where('idruangan', $idruangan);
            $ruangan = $this->db->get('ruangan');

            $nama_ruangan = $ruangan->row()->nama_ruangan;
        }
		
		$the_filter = array();
		$the_filter = array(
			'date1' => $date1,
			'date2' => $date2,
			'no_rm' => $no_rm,
			'nama_pasien' => $nama_pasien,
			'idruangan' => $idruangan,
			'kepuasan' => $kepuasan,
		);

		$get_data = $this->get_data($the_filter);

		$data['arr_data'] = $get_data;
		// echo "<pre>"; print_r($data);die;


        $data['f_date1'] = $date1;
		$data['f_date2'] = $date2;
		$data['f_no_rm'] = $no_rm;
		$data['f_nama_pasien'] = $nama_pasien;
		$data['f_idruangan'] = $idruangan;
		$data['f_nama_ruangan'] = $nama_ruangan;
		$data['f_kepuasan'] = $kepuasan;

		$js = az_add_js('administrator/report_survei/vjs_report_survei', $data, true);
		$azapp->add_js($js);

		$view = $this->load->view('administrator/report_survei/v_report_survei', $data, true);
		$azapp->add_content($view);

		$data_header['title'] = 'Laporan Survei';
		$data_header['breadcrumb'] = array('report');
		$azapp->set_data_header($data_header);
		
		echo $azapp->render();
	}

	function get_data($the_data) {

		$date1 = azarr($the_data, 'date1');
		$date2 = azarr($the_data, 'date2');
		$no_rm = azarr($the_data, 'no_rm');
		$nama_pasien = azarr($the_data, 'nama_pasien');
		$idruangan = azarr($the_data, 'idruangan');
		$kepuasan = azarr($the_data, 'kepuasan');

        // testing
        // $this->db->where('no_rm IN  ("25149125", "14222125") ');
        
        
        $this->db->where('date(responden.tanggal_input) >= "'.Date('Y-m-d', strtotime($date1)).'"');
        $this->db->where('date(responden.tanggal_input) <= "'.Date('Y-m-d', strtotime($date2)).'"');
        if (strlen($no_rm) > 0) {
			$this->db->where('responden.no_rm = "' . $no_rm . '"');
		}
		if (strlen($nama_pasien) > 0) {
			$this->db->where('responden.nama_pasien = "' . $nama_pasien . '"');
		}
        if (strlen($idruangan) > 0) {
			$this->db->where('responden.idruangan = "' . $idruangan . '"');
		}
        if (strlen($kepuasan) > 0) {
			$this->db->where('responden.kepuasan = "' . $kepuasan . '"');
		}

        $this->db->join('ruangan', 'responden.idruangan = ruangan.idruangan');
        $this->db->select('idresponden, date_format(tanggal_input, "%d-%m-%Y %H:%i:%s") as txt_tanggal_input, no_rm, nama_pasien, nama_ruangan, kepuasan');
        $responden = $this->db->get('responden');
        // echo "<pre>"; print_r($this->db->last_query());die;

        foreach ($responden->result() as $key => $value) {
            
            // layanan petugas
			$this->db->where('responden_detail.idresponden', $value->idresponden);
			$this->db->where('idlayanan_petugas IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_petugas = layanan.idlayanan', 'left');
			$resp_petugas = $this->db->get('responden_detail');

			// layanan fasilitas
			$this->db->where('responden_detail.idresponden', $value->idresponden);
			$this->db->where('idlayanan_fasilitas IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_fasilitas = layanan.idlayanan', 'left');
			$resp_fasilitas = $this->db->get('responden_detail');

			// layanan prosedur
			$this->db->where('responden_detail.idresponden', $value->idresponden);
			$this->db->where('idlayanan_prosedur IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_prosedur = layanan.idlayanan', 'left');
			$resp_prosedur = $this->db->get('responden_detail');

			// layanan waktu
			$this->db->where('responden_detail.idresponden', $value->idresponden);
			$this->db->where('idlayanan_waktu IS NOT NULL');
			$this->db->join('layanan', 'responden_detail.idlayanan_waktu = layanan.idlayanan', 'left');
			$resp_waktu = $this->db->get('responden_detail');
			
            foreach ($resp_petugas->result() as $pet_key => $pet_value) {
				$arr_data[$key][$pet_key] = array(
                    'idresponden' => $value->idresponden,
                    'tanggal_input' => $value->txt_tanggal_input,
                    'no_rm' => $value->no_rm,
                    'nama_pasien' => $value->nama_pasien,
                    'nama_ruangan' => $value->nama_ruangan,
                    'kepuasan' => $value->kepuasan,
					'layanan_petugas' => $pet_value->nama_layanan,
					'description_layanan_petugas' => $pet_value->description_layanan_petugas,
				);
			}

			foreach ($resp_fasilitas->result() as $fas_key => $fas_value) {
				$arr_data[$key][$fas_key]['layanan_fasilitas'] = $fas_value->nama_layanan;
				$arr_data[$key][$fas_key]['description_layanan_fasilitas'] = $fas_value->description_layanan_fasilitas;
			}

			foreach ($resp_prosedur->result() as $pro_key => $pro_value) {
				$arr_data[$key][$pro_key]['layanan_prosedur'] = $pro_value->nama_layanan;
				$arr_data[$key][$pro_key]['description_layanan_prosedur'] = $pro_value->description_layanan_prosedur;
			}
			
			foreach ($resp_waktu->result() as $wak_key => $wak_value) {
				$arr_data[$key][$wak_key]['layanan_waktu'] = $wak_value->nama_layanan;
				$arr_data[$key][$wak_key]['description_layanan_waktu'] = $wak_value->description_layanan_waktu;
			}
        }

        // echo "<pre>"; print_r($arr_data);die;
		
		return $arr_data;
	}
}