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

		$this->db->where('status', 1);
        $this->db->where('is_active', 1);
		$this->db->order_by('sequence', 'ASC');
        $layanan = $this->db->get('layanan');

        $data['ruangan'] = $ruangan;
        $data['layanan'] = $layanan;

		$v = $this->load->view('v_survei', $data, true);
		$app->add_content($v);

		$js = az_add_js('vjs_survei');
		$app->add_js($js);

		echo $app->render();	
	}

	public function save() {
		$err_code = 0;
		$err_message = '';

		$post = $this->input->post();

		$nama_pasien = $post['nama_pasien'];
		$no_rm = $post['no_rm'];
		$idruangan = $post['idruangan'];
		$kepuasan = $post['kepuasan'];
		$idlayanan_petugas = $post['idlayanan_petugas'];
		$description_petugas = $post['description_petugas'];
		$idlayanan_fasilitas = $post['idlayanan_fasilitas'];
		$description_fasilitas = $post['description_fasilitas'];
		$idlayanan_prosedur = $post['idlayanan_prosedur'];
		$description_prosedur = $post['description_prosedur'];
		$idlayanan_waktu = $post['idlayanan_waktu'];
		$description_waktu = $post['description_waktu'];

		if ($idlayanan_petugas == 0 || $idlayanan_petugas == '') {
			$idlayanan_petugas = null;
		} 
		if ($description_petugas == 0 || $description_petugas == '') {
			$description_petugas = null;
		} 
		if ($idlayanan_fasilitas == 0 || $idlayanan_fasilitas == '') {
			$idlayanan_fasilitas = null;
		} 
		if ($description_fasilitas == 0 || $description_fasilitas == '') {
			$description_fasilitas = null;
		} 
		if ($idlayanan_prosedur == 0 || $idlayanan_prosedur == '') {
			$idlayanan_prosedur = null;
		} 
		if ($description_prosedur == 0 || $description_prosedur == '') {
			$description_prosedur = null;
		} 
		if ($idlayanan_waktu == 0 || $idlayanan_waktu == '') {
			$idlayanan_waktu = null;
		} 
		if ($description_waktu == 0 || $description_waktu == '') {
			$description_waktu = null;
		} 

        $data_save = array(
            'nama_pasien' => $nama_pasien,
            'no_rm' => $no_rm,
            'idruangan' => $idruangan,
            'kepuasan' => $kepuasan,
			'idlayanan_petugas' => $idlayanan_petugas,
            'description_petugas' => $description_petugas,
            'idlayanan_fasilitas' => $idlayanan_fasilitas,
            'description_fasilitas' => $description_fasilitas,
            'idlayanan_prosedur' => $idlayanan_prosedur,
            'description_prosedur' => $description_prosedur,
            'idlayanan_waktu' => $idlayanan_waktu,
            'description_waktu' => $description_waktu,
			'tanggal_input' => date('Y-m-d H:i:s'),
        );
		// echo '<pre>'; print_r($data_save); die();

		$res = $this->db->insert('responden', $data_save);
		if ($res) {
			$err_message = "Terima kasih atas partisipasi Anda mengisi survei kepuasan pasien.";
		}
		else {
			$err = $this->db->error();
			$err_code = $err["code"];
			$err_message = $err["message"];
		}

        $response = array(
			'err_code' => $err_code,
			'err_message' => $err_message,
        );

        echo json_encode($response);
	}
}