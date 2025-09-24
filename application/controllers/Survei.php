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

		$this->db->trans_begin();

        $nama_pasien = $post['nama_pasien'];
        $no_rm = $post['no_rm'];
        $idruangan = $post['idruangan'];
        $kepuasan = $post['kepuasan'];

        // Data layanan dan deskripsi sekarang akan menjadi array asosiatif
        $idlayanan_petugas = $post['idlayanan_petugas'] ?? [];
        $description_petugas = $post['description_petugas'] ?? []; // Ini adalah array asosiatif [id_layanan => deskripsi]
        $idlayanan_fasilitas = $post['idlayanan_fasilitas'] ?? [];
        $description_fasilitas = $post['description_fasilitas'] ?? [];
        $idlayanan_prosedur = $post['idlayanan_prosedur'] ?? [];
        $description_prosedur = $post['description_prosedur'] ?? [];
        $idlayanan_waktu = $post['idlayanan_waktu'] ?? [];
        $description_waktu = $post['description_waktu'] ?? [];

        $data_save = array(
            'nama_pasien' => $nama_pasien,
            'no_rm' => $no_rm,
            'idruangan' => $idruangan,
            'kepuasan' => $kepuasan,
            'tanggal_input' => date('Y-m-d H:i:s'),
        );        

        $res = $this->db->insert('responden', $data_save);
        $id_responden = $this->db->insert_id();

        // Simpan detail layanan, satu baris per layanan
        $detail_data = array();

        if (is_array($idlayanan_petugas)) {
            foreach ($idlayanan_petugas as $id_layanan) {
                $detail_data[] = array(
                    'idresponden' => $id_responden,
                    
					'idlayanan_petugas' => $id_layanan,
                    'description_layanan_petugas' => $description_petugas[$id_layanan] ?? null, // Ambil deskripsi berdasarkan ID
					
					'idlayanan_fasilitas' => null,
                    'description_layanan_fasilitas' => null,
					
					'idlayanan_prosedur' => null,
                    'description_layanan_prosedur' => null,
					
					'idlayanan_waktu' => null,
                    'description_layanan_waktu' => null,
                );
            }
        }

        if (is_array($idlayanan_fasilitas)) {
            foreach ($idlayanan_fasilitas as $id_layanan) {
                $detail_data[] = array(
                    'idresponden' => $id_responden,
                    
					'idlayanan_petugas' => null,
                    'description_layanan_petugas' => null,
					
					'idlayanan_fasilitas' => $id_layanan,
                    'description_layanan_fasilitas' => $description_fasilitas[$id_layanan] ?? null,
					
					'idlayanan_prosedur' => null,
                    'description_layanan_prosedur' => null,
					
					'idlayanan_waktu' => null,
                    'description_layanan_waktu' => null,
                );
            }
        }

        if (is_array($idlayanan_prosedur)) {
            foreach ($idlayanan_prosedur as $id_layanan) {
                $detail_data[] = array(
                    'idresponden' => $id_responden,
                    
					'idlayanan_petugas' => null,
                    'description_layanan_petugas' => null,
					
					'idlayanan_fasilitas' => null,
                    'description_layanan_fasilitas' => null,
					
					'idlayanan_prosedur' => $id_layanan,
                    'description_layanan_prosedur' => $description_prosedur[$id_layanan] ?? null,
					
					'idlayanan_waktu' => null,
                    'description_layanan_waktu' => null,
                );
            }
        }

        if (is_array($idlayanan_waktu)) {
            foreach ($idlayanan_waktu as $id_layanan) {
                $detail_data[] = array(
                    'idresponden' => $id_responden,
					
					'idlayanan_petugas' => null,
                    'description_layanan_petugas' => null,
					
					'idlayanan_fasilitas' => null,
                    'description_layanan_fasilitas' => null,
					
					'idlayanan_prosedur' => null,
                    'description_layanan_prosedur' => null,

                    'idlayanan_waktu' => $id_layanan,
                    'description_layanan_waktu' => $description_waktu[$id_layanan] ?? null,
                );
            }
        }

		if (!empty($detail_data)) {
            $this->db->insert_batch('responden_detail', $detail_data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $err = $this->db->error();
            $err_code = $err["code"];
            $err_message = $err["message"];
        } 
		else {
            $this->db->trans_commit();
            $err_message = "Terima kasih atas partisipasi Anda mengisi survei kepuasan pasien.";
        }

        $response = array(
            'err_code' => $err_code,
            'err_message' => $err_message,
        );

        echo json_encode($response);
    }
}