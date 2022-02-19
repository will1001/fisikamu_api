<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Transaction_history extends RestController {

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
                    'id_user' => $this->post('id_user'),
                    'id_paket' => $this->post('id_paket'),
                    'payment_type' => $this->post('payment_type'),
                    'jumlah' => $this->post('jumlah'),
                    'status' => $this->post('status'),
                    'kode_unik' => $this->post('kode_unik'),
                    'description' => $this->post('description'),
                    'created_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('transaction_history', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        // date_default_timezone_set('Hongkong');

        $id = $this->put('id');
        $data = array(
                    'id_user' => $this->put('id_user'),
                    'id_paket' => $this->put('id_paket'),
                    'payment_type' => $this->put('payment_type'),
                    'jumlah' => $this->put('jumlah'),
                    'status' => $this->put('status'),
                    'kode_unik' => $this->put('kode_unik'),
                    'description' => $this->put('description'),
                    // 'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('transaction_history', $data);
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
        $delete = $this->db->delete('transaction_history');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_user = $this->get( 'id_user' );
        $id_paket = $this->get( 'id_paket' );

        $jsonData = $this->db->get('transaction_history')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
             if ( count($jsonData) == 0 )
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No datas were found'
                ], 404 );
            }else  if($id_user !== null && $id_paket !== null){
                $this->db->select("*");
                $this->db->from("transaction_history");
                $this->db->where('id_user', $id_user);
                $this->db->where('id_paket', $id_paket);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
            else
            {
                // Set the response and exit
                
                $this->db->select("*");
                $this->db->from("transaction_history");
                $this->db->join('users','users.id = transaction_history.id_user');
                $this->db->join('paket_app','paket_app.id = transaction_history.id_paket');
                // $this->db->join('sub_bab_soal','sub_bab_soal.id = video_materi.id_sub_bab');
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("transaction_history");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}