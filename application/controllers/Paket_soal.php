<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;


class Paket_soal extends RestController {

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
         date_default_timezone_set('Hongkong');
        $data = array(
                    'nomor' => $this->post('nomor'),
                    'deskripsi' => $this->post('deskripsi'),
                    'waktu' => $this->post('waktu'),
                    'tipe' => $this->post('tipe'),
                    // 'id_mapel' => $this->post('id_mapel'),
                    'id_bab' => $this->post('id_bab'),
                    // 'id_kelas' => $this->post('id_kelas'),
                    'id_level' => $this->post('id_level'),
                    'id_sub_bab' => $this->post('id_sub_bab'),
                    'id_konsep' => $this->post('id_konsep'),
                    'id_utbk' => $this->post('id_utbk'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('paket_soal', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        date_default_timezone_set('Hongkong');
        $id = $this->put('id');
        $update_jml_soal = $this->put('update_jml_soal');
        $data_nomor = $this->put('data_nomor');
        $data;
        $update;
        if($update_jml_soal === "true"){
            $data = array(
                    'nomor' => $this->put('nomor'),
                    'deskripsi' => $this->put('deskripsi'),
                    'waktu' => $this->put('waktu'),
                    'tipe' => $this->put('tipe'),
                    // 'id_mapel' => $this->put('id_mapel'),
                    'id_bab' => $this->put('id_bab'),
                    'id_sub_bab' => $this->put('id_sub_bab'),
                    'id_konsep' => $this->put('id_konsep'),
                    // 'id_kelas' => $this->put('id_kelas'),
                    'id_level' => $this->put('id_level'),
                    'id_utbk' => $this->put('id_utbk'),
                    'jml_soal' => $this->put('jml_soal'),
                    'update_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id);
                $update = $this->db->update('paket_soal', $data);
        }
        if($data_nomor !== null){
            $data = $data_nomor;
            $update =  $this->db->update_batch('paket_soal', $data, 'id');}
        if($update_jml_soal !== "true" || $data_nomor === null){
            $data = array(
                    'deskripsi' => $this->put('deskripsi'),
                    'waktu' => $this->put('waktu'),
                    'tipe' => $this->put('tipe'),
                    // 'id_mapel' => $this->put('id_mapel'),
                    'id_bab' => $this->put('id_bab'),
                    'id_sub_bab' => $this->put('id_sub_bab'),
                    'id_konsep' => $this->put('id_konsep'),
                    // 'id_kelas' => $this->put('id_kelas'),
                    'id_level' => $this->put('id_level'),
                    'status' => $this->put('status'),
                    'id_utbk' => $this->put('id_utbk'),
                    'update_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('id', $id);
                $update = $this->db->update('paket_soal', $data);
        }
        
      
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
        $delete = $this->db->delete('paket_soal');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        // $tipe = $this->get( 'tipe' );
        // $id_mapel = $this->get( 'id_mapel' );
        // $id_kelas = $this->get( 'id_kelas' );
        $id_bab = $this->get( 'id_bab' );
        $id_level = $this->get( 'id_level' );
        $id_utbk = $this->get( 'id_utbk' );
        $tipe = $this->get( 'tipe' );
        
        $jsonData = $this->db->get('paket_soal')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( count($jsonData) == 0 )
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => count($jsonData)
                ], 404 );
            }
            else
            {
                // Set the response and exit
                //111
                if($id_bab !== null && $id_level !== null && $id_utbk !== null){

                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_bab', $id_bab);
                    $this->db->where('id_level', $id_level);
                    $this->db->where('id_utbk', $id_utbk);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                //101
                }else if($id_bab !== null && $id_level === null && $id_utbk !== null){
                $this->db->select("*");
                $this->db->from("paket_soal");
                $this->db->where('id_bab', $id_bab);
                $this->db->where('id_utbk', $id_utbk);
                $this->db->order_by('nomor', 'ASC');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
                //110
                }else if($id_bab !== null && $id_level !== null && $id_utbk === null && $tipe === null){
                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_bab', $id_bab);
                    $this->db->where('id_level', $id_level);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                //011
                }else if($id_bab === null && $id_level !== null && $id_utbk !== null && $tipe === null){
                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_level', $id_level);
                    $this->db->where('id_utbk', $id_utbk);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                //010
                }else if($id_bab === null && $id_level !== null && $id_utbk === null && $tipe === null){
                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_level', $id_level);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                //001
                }else if($id_bab === null && $id_level === null && $id_utbk !== null && $tipe === null){
                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_utbk', $id_utbk);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                //100
                }else if($id_bab !== null && $id_level === null && $id_utbk === null && $tipe === null){
                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_bab', $id_bab);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                //
                }else if($id_bab !== null && $id_level !== null && $id_utbk !== null && $tipe === null){

                    $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->where('id_bab', $id_bab);
                    $this->db->where('id_level', $id_level);
                    $this->db->where('id_utbk', $id_utbk);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                ///000
                }else if($id_bab === null && $id_level === null && $id_utbk === null && $tipe !== null){

                  
                    if($tipe === "BAB"){
                         $this->db->select("*,tingkat_kesulitan.deskripsi as nama_level,paket_soal.deskripsi as nama_paket");     
                    }else{
                        $this->db->select("*");     
                    }
                    $this->db->from("paket_soal");
                    if($tipe === "BAB"){
                        $this->db->join('tingkat_kesulitan','tingkat_kesulitan.id = paket_soal.id_level');     
                    }
                    $this->db->where('tipe', $tipe);
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                ///000
                }else{
                      $this->db->select("*");
                    $this->db->from("paket_soal");
                    $this->db->order_by('nomor', 'ASC');
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                    // $this->db->select('*,tingkat_kesulitan.deskripsi as nama_level,paket_soal.deskripsi as nama_paket');
                    // $this->db->from('paket_soal');
                    // $this->db->join('tingkat_kesulitan','tingkat_kesulitan.id = paket_soal.id_level');      
                    //  $jsonData = $this->db->get()->result();
                    // $this->response( $jsonData, 200 );
                }
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("paket_soal");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}