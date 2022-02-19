<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;


class Hasil_nilai extends RestController {

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
                    'nilai' => $this->post('nilai'),
                    'nomor_salah' => $this->post('nomor_salah'),
                    'create_at' => date("Y-m-d H:i:s"),
                );

        $insert = $this->db->insert('hasil_nilai', $data);
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
        $data = array(
                    'id_user' => $this->put('id_user'),
                    'id_paket' => $this->put('id_paket'),
                    'nilai' => $this->put('nilai'),
                    'nomor_salah' => $this->put('nomor_salah'),
                    'create_at' => date("Y-m-d H:i:s"),
                );
        $this->db->where('id', $id);
        $update = $this->db->update('hasil_nilai', $data);
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
        $delete = $this->db->delete('hasil_nilai');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('hasil_nilai')->result();
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
                $this->db->select("*");
                $this->db->from("hasil_nilai");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}