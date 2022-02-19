<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class bank_soal extends RestController {

    function __construct()
    {
        // Construct the parent class
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
         $this->load->database();
    }

    public function index_post()
    {
        $id = $this->post( 'id' );

        date_default_timezone_set('Hongkong');
        $data = array(
                    'soal' => $this->post('soal'),
                    'pil_a' => $this->post('pil_a'),
                    'pil_b' => $this->post('pil_b'),
                    'pil_c' => $this->post('pil_c'),
                    'pil_d' => $this->post('pil_d'),
                    'pil_e' => $this->post('pil_e'),
                    'tipe_soal' => $this->post('tipe_soal'),
                    'kategori_soal' => $this->post('kategori_soal'),
                    'tahun_soal' => $this->post('tahun_soal'),
                    'jawaban' => $this->post('jawaban'),
                    'pembahasan' => $this->post('pembahasan'),
                    // 'id_mapel' => $this->post('id_mapel'),
                    'id_tingkat_kesulitan' => $this->post('id_tingkat_kesulitan'),
                    // 'id_kelas' => $this->post('id_kelas'),
                    'id_bab_soal' => $this->post('id_bab_soal'),
                    'id_sub_bab' => $this->post('id_sub_bab'),
                    'id_konsep' => $this->post('id_konsep'),
                    'id_utbk' => $this->post('id_utbk'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        

        if($id === null){
            $insert = $this->db->insert('bank_soal', $data);
            if ($insert) {
                $this->response($data, 200);
            } else {
                $this->response(array('status' => 'fail', 502));
            }
            
        }else{
            $this->db->where('id', $id);
            $delete = $this->db->delete('bank_soal');
            if ($delete) {
                $this->response(array('status' => $id), 201);
            } else {
                $this->response(array('status' => 'fail', 502));
            }
        }
        
        
    }
    public function index_put()
    {
        date_default_timezone_set('Hongkong');
        $id = $this->put('id');
        $tryout_used = $this->put('tryout_used');
        $data;
        if($tryout_used !== null){
            $data = array(
                    'tryout_used' => $this->put('tryout_used'),
                );
        }else{
            $data = array(
                    'soal' => $this->put('soal'),
                    'pil_a' => $this->put('pil_a'),
                    'pil_b' => $this->put('pil_b'),
                    'pil_c' => $this->put('pil_c'),
                    'pil_d' => $this->put('pil_d'),
                    'pil_e' => $this->put('pil_e'),
                    'tipe_soal' => $this->put('tipe_soal'),
                    'kategori_soal' => $this->put('kategori_soal'),
                    'tahun_soal' => $this->put('tahun_soal'),
                    'jawaban' => $this->put('jawaban'),
                    'pembahasan' => $this->put('pembahasan'),
                    // 'id_mapel' => $this->put('id_mapel'),
                    'id_tingkat_kesulitan' => $this->put('id_tingkat_kesulitan'),
                    'id_bab_soal' => $this->put('id_bab_soal'),
                    'id_sub_bab' => $this->put('id_sub_bab'),
                    // 'id_kelas' => $this->put('id_kelas'),
                    'id_konsep' => $this->put('id_konsep'),
                    'id_utbk' => $this->put('id_utbk'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        }
        
        $this->db->where('id', $id);
        $update = $this->db->update('bank_soal', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('bank_soal');
        if ($delete) {
            $this->response(array('status' => $id), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
        
        $id = $this->get( 'id' );
        $last = $this->get( 'last' );
        $cari = $this->get( 'cari' );
        // $this->response( $last, 200 );
        // $id_mapel = $this->get( 'id_mapel' );
        // $id_kelas = $this->get( 'id_kelas' );
        $id_bab_soal = $this->get( 'id_bab_soal' );
        $id_sub_bab = $this->get( 'id_sub_bab' );
        $tipe = $this->get( 'tipe' );
        $kategori_soal = $this->get( 'kategori_soal' );
        $id_tingkat_kesulitan = $this->get( 'id_tingkat_kesulitan' );
        $id_konsep = $this->get( 'id_konsep' );
        $tahun_soal = $this->get( 'tahun_soal' );
        $id_utbk = $this->get( 'id_utbk' );
        
        $jsonData = $this->db->get('bank_soal')->result();
        if ( $id === null && $last === null && $cari === null)
        {
            // Check if the datas data store contains datas
            if ( $jsonData )
            {
                // Set the response and exit
                $this->db->select("*");
                $this->db->from("bank_soal");
                if($cari !== ""){
                    $this->db->like('soal', $cari);
                }
                if($id_bab_soal !== ""){
                    $this->db->where('id_bab_soal', $id_bab_soal);
                }
                if($id_sub_bab !== ""){
                    $this->db->where('id_sub_bab', $id_sub_bab);
                }
                if($id_konsep !== ""){
                    $this->db->where('id_konsep', $id_konsep);
                }
                if($kategori_soal !== ""){
                    $this->db->where('kategori_soal', $kategori_soal);
                }
                if($tahun_soal !== ""){
                    $this->db->where('tahun_soal', $tahun_soal);
                }
                if($id_tingkat_kesulitan !== ""){
                    $this->db->where('id_tingkat_kesulitan', $id_tingkat_kesulitan);
                }
                 if($id_utbk !== ""){
                    $this->db->where('id_utbk', $id_utbk);
                }
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No datas were found'
                ], 404 );
            }
        }else if($id === null && $last !== null && $cari === null){
                $this->db->select("*");
                $this->db->from("bank_soal");
                $this->db->order_by('id',"desc")->limit(1);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }else if(
            $id === null && 
            $last === null && 
            $cari !== null &&
            $id_bab_soal !== null &&
            $id_sub_bab !== null &&
            $id_konsep !== null &&
            $kategori_soal !== null &&
            $id_tingkat_kesulitan !== null &&
            $tahun_soal !== null &&
            $id_utbk !== null 
         ){
          $this->db->select("*");
            $this->db->from("bank_soal");
            if($cari !== ""){
                $this->db->like('soal', $cari);
            }
            if($id_bab_soal !== ""){
                $this->db->where('id_bab_soal', $id_bab_soal);
            }
            if($id_sub_bab !== ""){
                $this->db->where('id_sub_bab', $id_sub_bab);
            }
            if($id_konsep !== ""){
                $this->db->where('id_konsep', $id_konsep);
            }
            if($kategori_soal !== ""){
                $this->db->where('kategori_soal', $kategori_soal);
            }
            if($tahun_soal !== ""){
                $this->db->where('tahun_soal', $tahun_soal);
            }
            if($id_tingkat_kesulitan !== ""){
                $this->db->where('id_tingkat_kesulitan', $id_tingkat_kesulitan);
            }
             if($id_utbk !== ""){
                $this->db->where('id_utbk', $id_utbk);
            }
            $jsonData = $this->db->get()->result();
            $this->response( $jsonData, 200 );
        }
        
        else
        {
            $this->db->select("*");
            $this->db->from("bank_soal");
            $this->db->where('id', $id);
            $jsonData = $this->db->get()->result();
            $this->response( $jsonData, 200 );
        }
    }
}