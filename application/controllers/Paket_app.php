<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Paket_app extends RestController {

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
                    'nama' => $this->post('nama'),
                    'deskripsi' => $this->post('deskripsi'),
                    'harga' => $this->post('harga'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('paket_app', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        $id = $this->put('id');
        date_default_timezone_set('Hongkong');
        $data = array(
                    'nama' => $this->put('nama'),
                    'deskripsi' => $this->put('deskripsi'),
                    'harga' => $this->put('harga'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('paket_app', $data);
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
        $delete = $this->db->delete('paket_app');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('paket_app')->result();
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
                $this->db->from("paket_app");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}