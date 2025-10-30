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
		$sess_idruangan = $this->session->userdata('idruangan');
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
			'sess_idruangan' => $sess_idruangan,
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

	function print_excel(){
		$date1 = $this->input->get('date1');
		$date2 = $this->input->get('date2');
		$no_rm = $this->input->get('vf_no_rm');
		$nama_pasien = $this->input->get('vf_nama_pasien');
		$idruangan = $this->input->get('idf_ruangan');
		$kepuasan = $this->input->get('vf_kepuasan');

		$role_name = $this->session->userdata('role_name');
		$idrole = $this->session->userdata('idrole');
		$sess_idruangan = $this->session->userdata('idruangan');

		$sess_idruangan = $this->session->userdata('idruangan');
        
		if ($date1 == null) {
			$date1 = '01-'.Date('m-Y');
		}
        if ($date2 == null) {
			$date2 = Date('t-m-Y');
		}
        if (strlen($idruangan) > 0) {
            $this->db->where('idruangan', $idruangan);
            $ruangan = $this->db->get('ruangan');
        }
		
		$the_filter = array();
		$the_filter = array(
			'date1' => $date1,
			'date2' => $date2,
			'no_rm' => $no_rm,
			'nama_pasien' => $nama_pasien,
			'idruangan' => $idruangan,
			'sess_idruangan' => $sess_idruangan,
			'kepuasan' => $kepuasan,
		);

		$get_data = $this->get_data($the_filter);
		// echo "<pre>"; print_r($get_data);die;
		

		$app_name = az_get_config('app_name');
		$this->load->library('AZApp');
		$azapp = $this->azapp;
		$azapp->add_phpexcel();

		$file_excel = APPPATH . "assets/excel/laporan_survei.xlsx";
		if (!file_exists($file_excel)) {
			$file_excel = DEFPATH . "assets/excel/laporan_survei.xlsx";
		}
		$phpexcel = PHPExcel_IOFactory::load($file_excel);
		$sheet0 = $phpexcel->setActiveSheetIndex(0);

		$i = 0;
		$start_row = 6;

		$styleArray11 = array(
			'borders' => array(
				'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		
		$sheet0->setCellValue("A2", $app_name);

		if (strlen($date1) > 0 && strlen($date2) > 0) {
			$sheet0->setCellValue("A3", Date('d/m/Y', strtotime($date1)).' - '.Date('d/m/Y', strtotime($date2)));
		}

		foreach ($get_data as $key => $value) {
			foreach ($value as $v_key => $detail) {
				$sheet0->setCellValue("A".($start_row + $i), $key+1);
				$sheet0->setCellValue("B".($start_row + $i), $detail['tanggal_input']);
				$sheet0->setCellValue("C".($start_row + $i), $detail['no_rm']);
				$sheet0->setCellValue("D".($start_row + $i), $detail['nama_pasien']);
				$sheet0->setCellValue("E".($start_row + $i), $detail['nama_ruangan']);
				$sheet0->setCellValue("F".($start_row + $i), $detail['kepuasan']);
				$sheet0->setCellValue("G".($start_row + $i), !empty($detail['layanan_petugas']) ? $detail['layanan_petugas'] : '-' );
				$sheet0->setCellValue("H".($start_row + $i), !empty($detail['description_layanan_petugas']) ? $detail['description_layanan_petugas'] : '-' );
				$sheet0->setCellValue("I".($start_row + $i), !empty($detail['layanan_fasilitas']) ? $detail['layanan_fasilitas'] : '-' );
				$sheet0->setCellValue("J".($start_row + $i), !empty($detail['description_layanan_fasilitas']) ? $detail['description_layanan_fasilitas'] : '-' );
				$sheet0->setCellValue("K".($start_row + $i), !empty($detail['layanan_prosedur']) ? $detail['layanan_prosedur'] : '-' );
				$sheet0->setCellValue("L".($start_row + $i), !empty($detail['description_layanan_prosedur']) ? $detail['description_layanan_prosedur'] : '-' );
				$sheet0->setCellValue("M".($start_row + $i), !empty($detail['layanan_waktu']) ? $detail['layanan_waktu'] : '-' );
				$sheet0->setCellValue("N".($start_row + $i), !empty($detail['description_layanan_waktu']) ? $detail['description_layanan_waktu'] : '-' );
				$i++;						
			}
		}

		$sheet0->getStyle("A".$start_row.":N".($start_row + $i - 1))->applyFromArray($styleArray11);
		$sheet0->getStyle("A".$start_row.":N".($start_row + $i - 1))->applyFromArray($style);
		//write file and download
		$filename='Laporan Survei '.Date('d-m-Y H:i:s').'.xls'; 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');  
		$objWriter->save('php://output');
	}

	function get_data($the_data) {

		$date1 = azarr($the_data, 'date1');
		$date2 = azarr($the_data, 'date2');
		$no_rm = azarr($the_data, 'no_rm');
		$nama_pasien = azarr($the_data, 'nama_pasien');
		$idruangan = azarr($the_data, 'idruangan');
		$kepuasan = azarr($the_data, 'kepuasan');
		$sess_idruangan = azarr($the_data, 'sess_idruangan');
		$role_name = $this->session->userdata('role_name');
		$idrole = $this->session->userdata('idrole');

        // testing
        // $this->db->where('no_rm IN  ("25149125", "14222125") ');

		$arr_data = array();
        
		if (strlen($idrole) > 0 && !in_array($role_name, array('administrator', 'kabid_yanmed', 'kasi_yanmed', 'kasi_keperawatan_dan_kebidanan') ) ) {
			$this->db->where('responden.idruangan = "'.$sess_idruangan.'" ');
		}
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
				$arr_data[$key][$fas_key]['idresponden'] = $value->idresponden;
				$arr_data[$key][$fas_key]['tanggal_input'] = $value->txt_tanggal_input;
				$arr_data[$key][$fas_key]['no_rm'] = $value->no_rm;
				$arr_data[$key][$fas_key]['nama_pasien'] = $value->nama_pasien;
				$arr_data[$key][$fas_key]['nama_ruangan'] = $value->nama_ruangan;
				$arr_data[$key][$fas_key]['kepuasan'] = $value->kepuasan;
				
				$arr_data[$key][$fas_key]['layanan_fasilitas'] = $fas_value->nama_layanan;
				$arr_data[$key][$fas_key]['description_layanan_fasilitas'] = $fas_value->description_layanan_fasilitas;
			}

			foreach ($resp_prosedur->result() as $pro_key => $pro_value) {
				$arr_data[$key][$pro_key]['idresponden'] = $value->idresponden;
				$arr_data[$key][$pro_key]['tanggal_input'] = $value->txt_tanggal_input;
				$arr_data[$key][$pro_key]['no_rm'] = $value->no_rm;
				$arr_data[$key][$pro_key]['nama_pasien'] = $value->nama_pasien;
				$arr_data[$key][$pro_key]['nama_ruangan'] = $value->nama_ruangan;
				$arr_data[$key][$pro_key]['kepuasan'] = $value->kepuasan;

				$arr_data[$key][$pro_key]['layanan_prosedur'] = $pro_value->nama_layanan;
				$arr_data[$key][$pro_key]['description_layanan_prosedur'] = $pro_value->description_layanan_prosedur;
			}
			
			foreach ($resp_waktu->result() as $wak_key => $wak_value) {
				$arr_data[$key][$wak_key]['idresponden'] = $value->idresponden;
				$arr_data[$key][$wak_key]['tanggal_input'] = $value->txt_tanggal_input;
				$arr_data[$key][$wak_key]['no_rm'] = $value->no_rm;
				$arr_data[$key][$wak_key]['nama_pasien'] = $value->nama_pasien;
				$arr_data[$key][$wak_key]['nama_ruangan'] = $value->nama_ruangan;
				$arr_data[$key][$wak_key]['kepuasan'] = $value->kepuasan;
				
				$arr_data[$key][$wak_key]['layanan_waktu'] = $wak_value->nama_layanan;
				$arr_data[$key][$wak_key]['description_layanan_waktu'] = $wak_value->description_layanan_waktu;
			}
        }

        // echo "<pre>"; print_r($arr_data);die;
		
		return $arr_data;
	}
}