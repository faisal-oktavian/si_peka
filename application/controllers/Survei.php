<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends AZ_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->helper('az_crud');
        $this->load->helper('az_config');

        // $this->hmac_key = $this->config->item('hmac_key');

        // // OTP Email
        // $this->load->library('email');
        // $this->load->database();
        // $this->load->helper(['url', 'date']);
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

    // // Kirim OTP ke email pasien
    // public function send_otp() {
    //     $email = $this->input->post('email');

    //     // jika email kosong
    //     if (empty($email)) {
    //         $ret_err = array(
    //             'status' => false,
    //             'message' => 'Email tidak boleh kosong',
    //         );

    //         echo json_encode($ret_err);
    //         return;
    //     }

    //     // validasi format email
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $ret_err = array(
    //             'status' => false,
    //             'message' => 'Format email tidak valid',
    //         );

    //         echo json_encode($ret_err);
    //         return;
    //     }

    //     // Validasi Domain Email
    //     $allowed_domains = ['gmail.com', 'yahoo.com'];
    //     $domain = substr(strrchr($email, "@"), 1);
    //     if (!in_array(strtolower($domain), $allowed_domains)) {
    //         $ret_err = array(
    //             'status' => false,
    //             'message' => 'Gunakan email resmi atau pribadi yang valid',
    //         );

    //         echo json_encode($ret_err);
    //         return;
    //     }

    //     // Cek waktu resend
    //     $this->db->where('email', $email);
    //     $this->db->order_by('idotp_log', 'DESC');
    //     $check = $this->db->get('otp_log')->row();

    //     if ($check && strtotime($check->resend_at) > time()) {
    //         $ret_err = array(
    //             'status' => false,
    //             'message' => 'Silakan kirim ulang setelah 1 menit',
    //         );

    //         echo json_encode($ret_err);
    //         return;
    //     }

    //     // Generate OTP
    //     $otp = rand(100000, 999999);
    //     $now = date('Y-m-d H:i:s');
    //     $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    //     $resend_at = date('Y-m-d H:i:s', strtotime('+1 minute'));

    //     // Simpan ke tabel otp_log
    //     $this->db->insert('otp_log', [
    //         'email' => $email,
    //         'otp_code' => $otp,
    //         'created_at' => $now,
    //         'expires_at' => $expires,
    //         'resend_at' => $resend_at
    //     ]);

    //     // Kirim email OTP
    //     $this->email->set_newline("\r\n");
    //     $this->email->from('printsoftprogrammer@gmail.com', 'Survei Kepuasan Pasien');
    //     $this->email->to($email);
    //     $this->email->subject('Kode OTP Survei Kepuasan Pasien');
    //     $this->email->message("Kode OTP Anda adalah: <b>$otp</b><br>Berlaku selama 5 menit.");

    //     $status = $this->email->send();

    //     if (!$this->email->send()) {
    //         // echo $this->email->print_debugger(['headers']);
    //     }

    //     // Logging aktivitas
    //     $this->_log_activity($email, 'Kirim OTP', $status ? 'Sukses kirim' : 'Gagal kirim');

    //     echo json_encode([
    //         'status' => $status,
    //         'message' => $status ? 'OTP telah dikirim ke email Anda' : 'Gagal mengirim OTP'
    //     ]);
    // }

    // // verifikasi OTP
    // public function verify_otp() {
    //     $email = $this->input->post('email');
    //     $otp = $this->input->post('otp');
    //     $start_time = microtime(true);

    //     $this->db->where('email', $email);
    //     $this->db->where('otp_code', $otp);
    //     $this->db->order_by('idotp_log', 'DESC');
    //     $log = $this->db->get('otp_log')->row();


    //     if (!$log) {
    //         $this->_log_activity($email, 'Verifikasi OTP', 'OTP tidak valid');

    //         $ret_err = array(
    //             'status' => false,
    //             'message' => 'OTP tidak valid',
    //         );

    //         echo json_encode($ret_err);
    //         return;
    //     }

    //     if (strtotime($log->expires_at) < time()) {
    //         $this->_log_activity($email, 'Verifikasi OTP', 'OTP kedaluwarsa');

    //         $ret_err = array(
    //             'status' => false,
    //             'message' => 'OTP sudah kedaluwarsa',
    //         );

    //         echo json_encode($ret_err);
    //         return;
    //     }

    //     // Hitung durasi verifikasi
    //     $duration = microtime(true) - $start_time;
    //     $this->_log_activity($email, 'Verifikasi OTP', 'OTP valid', $duration);

    //     $return = array(
    //         'status' => true,
    //         'message' => 'OTP valid',
    //     );

    //     echo json_encode($return);
    // }

    // // Kirim ulang OTP
    // public function resend_otp() {
    //     $email = $this->input->post('email');
    //     if (empty($email)) {
    //         echo json_encode(['status' => false, 'message' => 'Email tidak boleh kosong']);
    //         return;
    //     }
    //     $this->send_otp();
    // }

    // // Log aktivitas
    // private function _log_activity($email, $activity, $description = '', $duration = null, $start_time = null, $end_time = null) {
    //     $ip = $this->input->ip_address();
    //     $user_agent = $this->input->user_agent();
    //     $now = date('Y-m-d H:i:s');

    //     $this->db->insert('activity_log', [
    //         'email' => $email,
    //         'ip_address' => $ip,
    //         'user_agent' => $user_agent,
    //         'activity' => $activity,
    //         'description' => $description,
    //         'duration' => $duration,
    //         'created_at' => $now,
    //         'start_time' => $start_time,
    //         'end_time' => $end_time,
    //     ]);
    // }

	public function save() {
        $err_code = 0;
        $err_message = '';

        $post = $this->input->post();

		$this->db->trans_begin();

        $nama_pasien = $post['nama_pasien'];
        $no_rm = $post['no_rm'];
        $idruangan = $post['idruangan'];
        $kepuasan = $post['kepuasan'];
        // $device_id = $post['device_id'];
        // $email = $post['email'] ?? 'unknown';
        // $selfie_path = $post['selfie_path'];

        // if(empty($device_id)){
        //     $device_id = 'unknown-'.bin2hex(random_bytes(8));
        // }
        // // Hash device_id (HMAC-SHA256)
        // $device_hash = hash_hmac('sha256', $device_id, $this->hmac_key);


        // Data layanan dan deskripsi sekarang akan menjadi array asosiatif
        $idlayanan_petugas = $post['idlayanan_petugas'] ?? [];
        $description_petugas = $post['description_petugas'] ?? []; // Ini adalah array asosiatif [id_layanan => deskripsi]
        $idlayanan_fasilitas = $post['idlayanan_fasilitas'] ?? [];
        $description_fasilitas = $post['description_fasilitas'] ?? [];
        $idlayanan_prosedur = $post['idlayanan_prosedur'] ?? [];
        $description_prosedur = $post['description_prosedur'] ?? [];
        $idlayanan_waktu = $post['idlayanan_waktu'] ?? [];
        $description_waktu = $post['description_waktu'] ?? [];

        // // untuk menghitung waktu pengisian survei mulai dari membuka halam survei sampai klik kirim survei
        // $start_time = $post['start_time_survei']; // waktu dari JS
        // if (!empty($start_time)) {
        //     $start_timestamp = strtotime($start_time);
        //     $end_timestamp = time();
        //     $duration = $end_timestamp - $start_timestamp;

        //     $start_time = date("d-m-Y H:i:s", strtotime($start_time));
        //     $end_time = date('Y-m-d H:i:s');

        //     $this->_log_activity($email, 'Isi Survei', 'Durasi pengisian survei', $duration, $start_time, $end_time);
        // }

        $data_save = array(
            'nama_pasien' => $nama_pasien,
            'no_rm' => $no_rm,
            'idruangan' => $idruangan,
            'kepuasan' => $kepuasan,
            'tanggal_input' => date('Y-m-d H:i:s'),
            // 'ip_address' => $_SERVER['REMOTE_ADDR'],
            // 'device_hash' => $device_hash,
            // 'ip_address_2' => $this->input->ip_address(),
            // 'user_agent' => $this->input->user_agent(),
            // 'selfie_path' => $selfie_path,
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
            $err_message = "Terima kasih atas saran dan masukan bagi RSUD Sumberglagah Salam sehat.";
        }

        $response = array(
            'err_code' => $err_code,
            'err_message' => $err_message,
        );

        echo json_encode($response);
    }

    // // Validasi selfie survei
    // public function upload_selfie() {

    //     $upload_dir = FCPATH . 'uploads/selfie/';
    //     if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    //     // === Kiriman Base64 dari Kamera ===
    //     if ($this->input->post('selfie_data')) {
    //         $img = $this->input->post('selfie_data');
    //         $img = str_replace('data:image/jpeg;base64,', '', $img);
    //         $img = str_replace('data:image/png;base64,', '', $img);
    //         $img = str_replace(' ', '+', $img);

    //         $img = preg_replace('#^data:image/\w+;base64,#i', '', $img);
    //         $img = str_replace(' ', '+', $img);
    //         $data = base64_decode($img);

    //         if ($data === false || strlen($data) < 1000) {
    //             echo json_encode(['status' => false, 'message' => 'Data gambar tidak valid']);
    //             return;
    //         }

    //         $filename = 'selfie_' . time() . '.jpg';
    //         $path = $upload_dir . $filename;

    //         if (file_put_contents($path, $data, LOCK_EX) === false) {
    //             echo json_encode(['status' => false, 'message' => 'Gagal menyimpan file']);
    //             return;
    //         }

    //         if (filesize($path) < 1000) {
    //             echo json_encode(['status' => false, 'message' => 'File kosong (hasil base64 tidak valid)']);
    //             return;
    //         }

    //         file_put_contents($path, $data, LOCK_EX);
    //         clearstatcache();
    //         $size = filesize($path);
    //         if ($size < 5000) {
    //             echo json_encode(['status' => false, 'message' => "File terlalu kecil ($size bytes)."]);
    //             return;
    //         }
    //         // Kompres gambar
    //         $this->_compress_image($path, $path, 70);

    //         echo json_encode(['status' => true, 'path' => 'uploads/selfie/' . $filename]);
    //         return;
    //     }

    //     // === Kiriman File Manual ===
    //     if (!empty($_FILES['selfie_file']['name'])) {
    //         $config['upload_path'] = $upload_dir;
    //         $config['allowed_types'] = 'jpg|jpeg|png';
    //         $config['max_size'] = 5120;
    //         $config['file_name'] = 'selfie_' . time();
    //         $this->load->library('upload', $config);

    //         if (!$this->upload->do_upload('selfie_file')) {
    //             echo json_encode(['status' => false, 'message' => $this->upload->display_errors('', '')]);
    //             return;
    //         }

    //         $file = $this->upload->data();
    //         $path = $upload_dir . $file['file_name'];
    //         $this->_compress_image($path, $path, 70);

    //         echo json_encode(['status' => true, 'path' => 'uploads/selfie/' . $file['file_name']]);
    //         return;
    //     }

    //     echo json_encode(['status' => false, 'message' => 'Tidak ada data gambar yang dikirim.']);
    // }

    // private function _compress_image($source, $destination, $quality) {
        
    //     if (!file_exists($source) || filesize($source) == 0) {
    //         echo json_encode(['status' => false, 'message' => 'File tidak ditemukan atau kosong']);
    //         exit;
    //     }

    //     $info = @getimagesize($source);
    //     if ($info === false) {
    //         echo json_encode(['status' => false, 'message' => 'Gagal membaca informasi gambar (mungkin file rusak)']);
    //         exit;
    //     }

    //     $mime = isset($info['mime']) ? $info['mime'] : '';
    //     if ($mime == 'image/jpeg') {
    //         $image = imagecreatefromjpeg($source);
    //     } elseif ($mime == 'image/png') {
    //         $image = imagecreatefrompng($source);
    //     } else {
    //         echo json_encode(['status' => false, 'message' => 'Format gambar tidak didukung (' . $mime . ')']);
    //         exit;
    //     }

    //     imagejpeg($image, $destination, $quality);
    //     imagedestroy($image);
    // }
}