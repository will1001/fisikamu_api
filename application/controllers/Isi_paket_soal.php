<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;


class Isi_paket_soal extends RestController {

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
                    'id_paket' => $this->post('id_paket'),
                    'id_tryout_part' => $this->post('id_tryout_part'),
                    'id_soal' => $this->post('id_soal'),
                    'no_soal' => $this->post('no_soal'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('isi_paket_soal', $data);
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
        $data_nomor = $this->put('data_nomor');
        $data;
        $update;
        if($data_nomor !== null){
            $data = $data_nomor;
            $update =  $this->db->update_batch('isi_paket_soal', $data, 'id');
        }else{
             $data = array(
                    'id_paket' => $this->put('id_paket'),
                    'id_soal' => $this->put('id_soal'),
                    'no_soal' => $this->put('no_soal'),
                    'update_at' => date("Y-m-d H:i:s")
            );
        $this->db->where('id', $id);
        $update = $this->db->update('isi_paket_soal', $data);
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
        $delete = $this->db->delete('isi_paket_soal');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_tryout_part = $this->get( 'id_tryout_part' );
        $tipe = $this->get( 'tipe' );
        
        $jsonData = $this->db->get('isi_paket_soal')->result();
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
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
             if($tipe==="tryout"){
                    $this->db->select("isi_paket_soal.id,isi_paket_soal.id_tryout_part,tipe,isi_paket_soal.id_paket,id_soal,deskripsi,waktu,soal,jml_soal,tipe,pil_a,pil_b,pil_c,pil_d,pil_e,tipe_soal,jawaban,pembahasan,bank_soal.id_mapel,bank_soal.id_tingkat_kesulitan,bank_soal.id_kelas,bank_soal.id_bab_soal,tryout_part.nama_part"); 
             }else{
                 $this->db->select("isi_paket_soal.id,isi_paket_soal.id_tryout_part,tipe,isi_paket_soal.id_paket,id_soal,deskripsi,waktu,soal,jml_soal,tipe,pil_a,pil_b,pil_c,pil_d,pil_e,tipe_soal,jawaban,pembahasan,bank_soal.id_mapel,bank_soal.id_tingkat_kesulitan,bank_soal.id_kelas,bank_soal.id_bab_soal");
             }
                
                $this->db->from("isi_paket_soal");
                $this->db->join('paket_soal', 'paket_soal.id = isi_paket_soal.id_paket','left');
                $this->db->join('bank_soal', 'bank_soal.id = isi_paket_soal.id_soal','left');
                if($tipe==="tryout"){
                    $this->db->join('tryout_part', 'tryout_part.id = isi_paket_soal.id_tryout_part','left');    
                    $this->db->where('isi_paket_soal.id_tryout_part', $id_tryout_part);
                }
                $this->db->where('isi_paket_soal.id_paket', $id);
                $this->db->order_by('no_soal', 'ASC'); 
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}