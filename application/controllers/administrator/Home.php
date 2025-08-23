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

		$view = $this->load->view('administrator/home/v_home', '', true);
		$app->add_content($view);

		$js = az_add_js('administrator/home/vjs_home');
		$app->add_js($js);

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

	function test_pdf() {
		$this->load->library('Lite');
		$this->lite->pdf(91, '', true);
	}

	function dirsize($dir) {
	    if(is_file($dir)) return array('size'=>filesize($dir),'howmany'=>0);
	    if($dh=opendir($dir)) {
	        $size=0;
	        $n = 0;
	        while(($file=readdir($dh))!==false) {
	            if($file=='.' || $file=='..') continue;
	            $n++;
	            $data = $this->dirsize($dir.'/'.$file);
	            $size += $data['size'];
	            $n += $data['howmany'];
	        }
	        closedir($dh);
	        return array('size'=>$size,'howmany'=>$n);
	    } 
	    return array('size'=>0,'howmany'=>0);
	}

	function check_disk()
	{
		$this->load->helper('az_config');
		
		$file_transaction = $this->dirsize(APPPATH_FRONT.'assets/transaction_image');
		$file_transaction_size = $file_transaction['size'];
		
		$member_profile = $this->dirsize(APPPATH_FRONT.'assets/member_profile');
		$member_profile_size = $member_profile['size'];

		$category = $this->dirsize(APPPATH_FRONT.'assets/product_category');
		$category_size = $category['size'];

		$slideshow = $this->dirsize(APPPATH_FRONT.'assets/slideshow');
		$slideshow_size = $slideshow['size'];
			
		$product_image = $this->dirsize(APPPATH_FRONT.'assets/product_image');
		$product_image_size = $product_image['size'];

		$total_file_size = $member_profile_size + $category_size + $file_transaction_size + $slideshow_size + $product_image_size;

		$data['member_profile'] = $member_profile_size;
		$data['category'] = $category_size;
		$data['file_transaction'] = $file_transaction_size;
		$data['slideshow'] = $slideshow_size;
		$data['product_image'] = $product_image_size;
		$data['file_size'] = $total_file_size;

		$db = $this->db->query("SHOW TABLE STATUS");
		$total_db = 0;
		foreach ($db->result() as $key => $value) {
			$total_db += $value->Data_length + $value->Index_length;
		}

		$data['db_size'] = $total_db;

		$back_file_def = $this->dirsize(DEFPATH);
		$back_file_def_size = $back_file_def['size'];
		$back_file = $this->dirsize(APPPATH);
		$back_file_size = $back_file['size'];
		$system_file = $this->dirsize(BASEPATH);
		$system_file_size = $system_file['size'];

		$front_file_def = $this->dirsize(AZPATH.'/application/liteprint/default');
		$front_file_def_size = $front_file_def['size'];
		

		$arr_front = array('assets/benefit', 'assets/fonts', 'assets/helper', 'assets/images', 'assets/logo', 'assets/plugins', 'config', 'controllers', 'core', 'logs', 'views');
		$front_file_size = 0;
		foreach ($arr_front as $key => $value) {
			$rfront_file = $this->dirsize(APPPATH_FRONT.$value);
			$front_file_size += $rfront_file['size'];	
		}


		$total_file_system = $back_file_size + $front_file_size + $system_file_size;
		$data['file_system_size'] = $total_file_system;

		$app_size = az_get_config('disk_space', 'config_app');

		$mtotal_file_system = floor($total_file_system / 1024 / 1024);
		$mtotal_db = floor($total_db / 1024 / 1024);
		$mtotal_file_size = floor($total_file_size / 1024 / 1024);

		$ptotal_file_system = ($mtotal_file_system / $app_size) * 100;
		$ptotal_db = ($mtotal_db / $app_size) * 100;
		$ptotal_file_size = ($mtotal_file_size / $app_size) * 100;
		$free = $app_size - ($mtotal_file_system + $mtotal_db + $mtotal_file_size);
		$ptotal_free = ($free / $app_size) * 100;

		$data['free'] = $free * 1024 * 1024;
		$data['percent_file_system'] = $ptotal_file_system;
		$data['percent_db'] = $ptotal_db;
		$data['percent_file'] = $ptotal_file_size;
		$data['percent_free'] = $ptotal_free;
		echo json_encode($data);
	}

	function tesss() {
		$this->load->helper('az_config');
		$this->load->helper('liteprint_notification');
		send_wa(61, 'wa_pay');
	}


	private function import_account() {
		$this->load->library('AZApp');
		$azapp = $this->azapp;	
		$azapp->add_phpexcel();
        $objPHPExcel = PHPExcel_IOFactory::load(APPPATH.'assets/import_account_2.xlsx');
        $sheet0 = $objPHPExcel->setActiveSheetIndex(0);	
		$i = 2;
    	do {
        	$a = 'A';
        	$nama = $sheet0->getCell($a.$i)->getValue(); $a++; 
        	$nomor = $sheet0->getCell($a.$i)->getValue(); $a++;
        	$nama_kategori = $sheet0->getCell($a.$i)->getValue(); $a++; 


        	$this->db->where('account_category_name', $nama_kategori);
        	$the_nama_kategori = $this->db->get('account_category');
        	$idaccount_category = NULL;
        	if ($the_nama_kategori->num_rows() > 0) {
        		$idaccount_category = $the_nama_kategori->row()->idaccount_category;
        	}
        	else {
        		$arr_loc['account_category_name'] = $nama_kategori;
        		$this->db->insert('account_category', $arr_loc);
        		$idaccount_category = $this->db->insert_id();
        	}

        	$i++;

    		if (strlen($nama) == 0) {
    			continue;
    		}

    		$arr_data = array(
    			'account_name' => ltrim($nama),
    			'account_code' => $nomor,
    			'idaccount_category' => $idaccount_category,
    		);

    		$this->db->insert('account', $arr_data);



    	} while (strlen($nama) > 0);
	}

	function format_account() {
		$this->load->library('AZApp');
		$azapp = $this->azapp;	
		$azapp->add_phpexcel();
        $objPHPExcel = PHPExcel_IOFactory::load(APPPATH.'assets/import_account_2.xlsx');
        $sheet0 = $objPHPExcel->setActiveSheetIndex(0);	
		$i = 2;
		$idaccount_parent = NULL;
    	for ($inc=0; $inc < 144; $inc++) { 
        	$a = 'A';
        	$nama = $sheet0->getCell($a.$i)->getValue();


        	$thename = ltrim($nama);
    		$this->db->where('account_name', $thename);
    		$acc = $this->db->get('account');
    		if ($acc->num_rows() > 0) {
    			$idaccount = $acc->row()->idaccount;
    		}

        	if (substr($nama, 0, 3) == '   ') {
        		$arr_up = array(
        			'idaccount_parent' => $idaccount_parent
        		);
        		$this->db->where('idaccount', $idaccount);
        		$this->db->update('account', $arr_up);
        	}
        	else {
        		
        		$idaccount_parent = $idaccount;
        	}

        	$i++;
    	}
	}
}