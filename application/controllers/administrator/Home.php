<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AZ_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('az_auth');
        az_check_auth('dashboard');
        $this->load->helper('az_crud');
        $this->load->helper('az_config');
    }

	public function index(){
		$this->load->library('AZApp');
		$app = $this->azapp;
		$data_header['title'] = azlang('Dashboard');
		$data_header['breadcrumb'] = array('dashboard');
		$app->set_data_header($data_header);
		$this->load->helper('az_config');
		$this->load->helper('az_core');

		// DIAGRAM KEPUASAN KOMPONEN
			// Grafik Puas
			$this->db->where('kepuasan = "puas" ');
			$this->db->where('is_active = "1" ');
			$this->db->join('responden_detail', 'responden_detail.idresponden = responden.idresponden');
			$this->db->select('COUNT(idlayanan_petugas) as puas_petugas, COUNT(idlayanan_fasilitas) as puas_fasilitas, COUNT(idlayanan_prosedur) as puas_prosedur, COUNT(idlayanan_waktu) as puas_waktu');
			$respon_puas = $this->db->get('responden');
			// echo "<pre>"; print_r($this->db->last_query()); die();

			// Grafik Tidak Puas
			$this->db->where('kepuasan = "tidak_puas" ');
			$this->db->where('is_active = "1" ');
			$this->db->join('responden_detail', 'responden_detail.idresponden = responden.idresponden');
			$this->db->select('COUNT(idlayanan_petugas) as tidak_puas_petugas, COUNT(idlayanan_fasilitas) as tidak_puas_fasilitas, COUNT(idlayanan_prosedur) as tidak_puas_prosedur, COUNT(idlayanan_waktu) as tidak_puas_waktu');
			$respon_tidak_puas = $this->db->get('responden');
			// echo "<pre>"; print_r($this->db->last_query()); die();


		// DIAGRAM KEPUASAN PER KOMPONEN (UNIT)
			// $arr_puas = array();
			// $arr_tidak_puas = array();

			// 1. Data Komponen Petugas
				$subquery_petugas_puas = $this->db
					->select('responden_detail.idlayanan_petugas, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_petugas')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_petugas IS NOT NULL', null, false)
					->where('responden.kepuasan', 'puas')
					->group_by('responden_detail.idlayanan_petugas, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$petugas_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_petugas_puas) AS petugas_puas");
				$petugas_puas_5 = $this->db->query("SELECT * FROM ($subquery_petugas_puas) AS petugas_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				$subquery_petugas_tidak_puas = $this->db
					->select('responden_detail.idlayanan_petugas, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_petugas')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_petugas IS NOT NULL', null, false)
					->where('responden.kepuasan', 'tidak_puas')
					->group_by('responden_detail.idlayanan_petugas, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$petugas_tidak_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_petugas_tidak_puas) AS petugas_tidak_puas");
				$petugas_tidak_puas_5 = $this->db->query("SELECT * FROM ($subquery_petugas_tidak_puas) AS petugas_tidak_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				// $total_komponen_petugas = $petugas_puas->num_rows() + $petugas_tidak_puas->num_rows();

				// $arr_puas[] = $total_komponen_petugas ? round(($petugas_puas->num_rows() / $total_komponen_petugas) * 100) : 0;
				// $arr_tidak_puas[] = $total_komponen_petugas ? round(($petugas_tidak_puas->num_rows() / $total_komponen_petugas) * 100) : 0;

			// 2. Data Komponen Fasilitas
				$subquery_fasilitas_puas = $this->db
					->select('responden_detail.idlayanan_fasilitas, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_fasilitas')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_fasilitas IS NOT NULL', null, false)
					->where('responden.kepuasan', 'puas')
					->group_by('responden_detail.idlayanan_fasilitas, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$fasilitas_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_fasilitas_puas) AS fasilitas_puas");
				$fasilitas_puas_5 = $this->db->query("SELECT * FROM ($subquery_fasilitas_puas) AS fasilitas_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				$subquery_fasilitas_tidak_puas = $this->db
					->select('responden_detail.idlayanan_fasilitas, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_fasilitas')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_fasilitas IS NOT NULL', null, false)
					->where('responden.kepuasan', 'tidak_puas')
					->group_by('responden_detail.idlayanan_fasilitas, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$fasilitas_tidak_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_fasilitas_tidak_puas) AS fasilitas_tidak_puas");
				$fasilitas_tidak_puas_5 = $this->db->query("SELECT * FROM ($subquery_fasilitas_tidak_puas) AS fasilitas_tidak_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				// $total_komponen_fasilitas = $fasilitas_puas->num_rows() + $fasilitas_tidak_puas->num_rows();

				// $arr_puas[] = $total_komponen_fasilitas ? round(($fasilitas_puas->num_rows() / $total_komponen_fasilitas) * 100) : 0;
				// $arr_tidak_puas[] = $total_komponen_fasilitas ? round(($fasilitas_tidak_puas->num_rows() / $total_komponen_fasilitas) * 100) : 0;

			// 3. Data Komponen Prosedur
				$subquery_prosedur_puas = $this->db
					->select('responden_detail.idlayanan_prosedur, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_prosedur')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_prosedur IS NOT NULL', null, false)
					->where('responden.kepuasan', 'puas')
					->group_by('responden_detail.idlayanan_prosedur, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$prosedur_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_prosedur_puas) AS prosedur_puas");
				$prosedur_puas_5 = $this->db->query("SELECT * FROM ($subquery_prosedur_puas) AS prosedur_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				$subquery_prosedur_tidak_puas = $this->db
					->select('responden_detail.idlayanan_prosedur, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_prosedur')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_prosedur IS NOT NULL', null, false)
					->where('responden.kepuasan', 'tidak_puas')
					->group_by('responden_detail.idlayanan_prosedur, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$prosedur_tidak_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_prosedur_tidak_puas) AS prosedur_tidak_puas");
				$prosedur_tidak_puas_5 = $this->db->query("SELECT * FROM ($subquery_prosedur_tidak_puas) AS prosedur_tidak_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				// $total_komponen_prosedur = $prosedur_puas->num_rows() + $prosedur_tidak_puas->num_rows();

				// $arr_puas[] = $total_komponen_prosedur ? round(($prosedur_puas->num_rows() / $total_komponen_prosedur) * 100) : 0;
				// $arr_tidak_puas[] = $total_komponen_prosedur ? round(($prosedur_tidak_puas->num_rows() / $total_komponen_prosedur) * 100) : 0;
			
			// 4. Data Komponen Waktu
				$subquery_waktu_puas = $this->db
					->select('responden_detail.idlayanan_waktu, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_waktu')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_waktu IS NOT NULL', null, false)
					->where('responden.kepuasan', 'puas')
					->group_by('responden_detail.idlayanan_waktu, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$waktu_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_waktu_puas) AS waktu_puas");
				$waktu_puas_5 = $this->db->query("SELECT * FROM ($subquery_waktu_puas) AS waktu_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				$subquery_waktu_tidak_puas = $this->db
					->select('responden_detail.idlayanan_waktu, nama_layanan, COUNT(*) AS jumlah', false)
					->from('responden')
					->join('responden_detail', 'responden_detail.idresponden = responden.idresponden')
					->join('layanan', 'layanan.idlayanan = responden_detail.idlayanan_waktu')
					->where('responden.is_active', 1)
					->where('responden_detail.idlayanan_waktu IS NOT NULL', null, false)
					->where('responden.kepuasan', 'tidak_puas')
					->group_by('responden_detail.idlayanan_waktu, nama_layanan')
					->order_by('jumlah', 'DESC')
					->get_compiled_select(); // subquery di-compile jadi string SQL

				$waktu_tidak_puas = $this->db->query("SELECT sum(jumlah) as total_data FROM ($subquery_waktu_tidak_puas) AS waktu_tidak_puas");
				$waktu_tidak_puas_5 = $this->db->query("SELECT * FROM ($subquery_waktu_tidak_puas) AS waktu_tidak_puas LIMIT 5");
				// echo "<pre>"; print_r($this->db->last_query()); die();

				// $total_komponen_waktu = $waktu_puas->num_rows() + $waktu_tidak_puas->num_rows();

				// $arr_puas[] = $total_komponen_waktu ? round(($waktu_puas->num_rows() / $total_komponen_waktu) * 100) : 0;
				// $arr_tidak_puas[] = $total_komponen_waktu ? round(($waktu_tidak_puas->num_rows() / $total_komponen_waktu) * 100) : 0;

		// array data
		$data['respon_puas'] = $respon_puas;
		$data['respon_tidak_puas'] = $respon_tidak_puas;

		// $data['arr_puas'] = $arr_puas;
		// $data['arr_tidak_puas'] = $arr_tidak_puas;
		$data['petugas_puas'] = $petugas_puas;
		$data['petugas_tidak_puas'] = $petugas_tidak_puas;
		$data['fasilitas_puas'] = $fasilitas_puas;
		$data['fasilitas_tidak_puas'] = $fasilitas_tidak_puas;
		$data['prosedur_puas'] = $prosedur_puas;
		$data['prosedur_tidak_puas'] = $prosedur_tidak_puas;
		$data['waktu_puas'] = $waktu_puas;
		$data['waktu_tidak_puas'] = $waktu_tidak_puas;
		
		$data['petugas_puas_5'] = $petugas_puas_5;
		$data['petugas_tidak_puas_5'] = $petugas_tidak_puas_5;
		$data['fasilitas_puas_5'] = $fasilitas_puas_5;
		$data['fasilitas_tidak_puas_5'] = $fasilitas_tidak_puas_5;
		$data['prosedur_puas_5'] = $prosedur_puas_5;
		$data['prosedur_tidak_puas_5'] = $prosedur_tidak_puas_5;
		$data['waktu_puas_5'] = $waktu_puas_5;
		$data['waktu_tidak_puas_5'] = $waktu_tidak_puas_5;
		
		// echo "<pre>"; print_r($data); //die();

		$view = $this->load->view('administrator/home/v_home', $data, true);
		$app->add_content($view);

		// $js = az_add_js('administrator/home/vjs_home');
		// $app->add_js($js);

		echo $app->render();	
	}

	function get_data() {
		$date1 = Date('d-m-Y');
		$date2 = Date('d-m-Y');

		$p_date1 = $this->input->post("date1");
		$p_date2 = $this->input->post("date2");

		if (strlen($p_date1) > 0) {
			$date1 = $p_date1;
		}
		if (strlen($p_date2) > 0) {
			$date2 = $p_date2;
		}

		$idoutlet = $this->input->post('idoutlet');
		$sess_idoutlet = $this->session->userdata('idoutlet');
		if (strlen($sess_idoutlet) > 0) {
			$idoutlet = $sess_idoutlet;
		}

		$woutlet = '';
		$outlet_name = '';
		if (strlen($idoutlet) > 0) {
			$woutlet = " transaction.idoutlet = '".$idoutlet."' AND ";
			$this->db->where('idoutlet', $idoutlet);
			$routlet = $this->db->get('outlet');
			if ($routlet->num_rows() > 0) {
				$outlet_name = $routlet->row()->outlet_name;
			}
		}

		if (strlen($date1) > 0 && strlen($date2) > 0) {
			$woutlet .= " date(transaction_date) >= '".Date('Y-m-d', strtotime($date1))."' and date(transaction_date) <= '".Date('Y-m-d', strtotime($date2))."' AND ";
		}

		$data['idoutlet'] = $idoutlet;
		$data['outlet_name'] = $outlet_name;

		$penjualan = $this->db->query("SELECT * FROM (SELECT COUNT(*) AS total_pekerjaan
							FROM transaction_detail
							JOIN transaction
								ON transaction.idtransaction = transaction_detail.idtransaction
							WHERE ".$woutlet." transaction_status IN ('PEMBAYARAN DIVERIFIKASI', 'PESANAN SUDAH DIVERIFIKASI', 'SELESAI DIKERJAKAN')) AS total_pekerjaan, 
						(SELECT COUNT(*) AS belum_dikerjakan
							FROM transaction_detail
							JOIN transaction
								ON transaction.idtransaction = transaction_detail.idtransaction
							WHERE ".$woutlet." transaction_status = 'PEMBAYARAN DIVERIFIKASI') AS belum_dikerjakan,
						(SELECT COUNT(*) AS sedang_dikerjakan
							FROM transaction_detail
							JOIN transaction
								ON transaction.idtransaction = transaction_detail.idtransaction
							WHERE ".$woutlet." transaction_status = 'PESANAN SUDAH DIVERIFIKASI') AS sedang_dikerjakan,
						(SELECT COUNT(*) AS selesai
							FROM transaction_detail
							JOIN transaction
								ON transaction.idtransaction = transaction_detail.idtransaction
							WHERE ".$woutlet." transaction_status = 'SELESAI DIKERJAKAN') AS selesai");
			
		$total_pekerjaan = 0;
		$belum_dikerjakan = 0;
		$sedang_dikerjakan = 0;
		$selesai = 0;
		if ($penjualan->num_rows() > 0) {
			$total_pekerjaan = $penjualan->row()->total_pekerjaan;
			$belum_dikerjakan = $penjualan->row()->belum_dikerjakan;
			$sedang_dikerjakan = $penjualan->row()->sedang_dikerjakan;
			$selesai = $penjualan->row()->selesai;
			$total_pekerjaan = $belum_dikerjakan + $sedang_dikerjakan;
		}

		$data['total_pekerjaan'] = $total_pekerjaan;
		$data['belum_dikerjakan'] = $belum_dikerjakan;
		$data['sedang_dikerjakan'] = $sedang_dikerjakan;
		$data['selesai'] = $selesai;

		$this->db->where('status', 1);
		$this->db->order_by('sequence');
		$kategori = $this->db->get('product_category');

		$arr_kategori = array();
		foreach ($kategori->result() as $key => $value) {
			$detil = $this->db->query("SELECT * FROM (SELECT COUNT(*) AS belum_dikerjakan
							FROM transaction_detail
							JOIN transaction
								ON transaction.idtransaction = transaction_detail.idtransaction
							JOIN product
								ON transaction_detail.idproduct = product.idproduct
							JOIN product_subcategory 
								ON product_subcategory.idproduct_subcategory = product.idproduct_subcategory	
							JOIN product_category 
								ON product_subcategory.idproduct_category = product_category.idproduct_category
							WHERE ".$woutlet." transaction_status = 'PEMBAYARAN DIVERIFIKASI'
								AND product_subcategory.idproduct_category = ".$value->idproduct_category.") AS belum_dikerjakan,
						(SELECT COUNT(*) AS sedang_dikerjakan
							FROM transaction_detail
							JOIN transaction
								ON transaction.idtransaction = transaction_detail.idtransaction
							JOIN product
								ON transaction_detail.idproduct = product.idproduct
							JOIN product_subcategory 
								ON product_subcategory.idproduct_subcategory = product.idproduct_subcategory	
							JOIN product_category 
								ON product_subcategory.idproduct_category = product_category.idproduct_category
							WHERE ".$woutlet." transaction_status = 'PESANAN SUDAH DIVERIFIKASI'
								AND product_subcategory.idproduct_category = ".$value->idproduct_category.") AS sedang_dikerjakan");
			
			$k_belum_dikerjakan = $detil->row()->belum_dikerjakan;
			$k_sedang_dikerjakan = $detil->row()->sedang_dikerjakan;

			$arr_kategori[] = array(
				'nama_kategori' => $value->product_category_name,
				'belum_dikerjakan' => $k_belum_dikerjakan,
				'sedang_dikerjakan' => $k_sedang_dikerjakan,
			);
		}

		$data['kategori'] = $arr_kategori;

		$vdata = $this->load->view('home/v_data', $data, true);

		$return = array(
			'data' => $vdata
		);
		echo json_encode($return);
	}
}