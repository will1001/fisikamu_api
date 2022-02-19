<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Invoice_settings extends RestController {

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
                    'id_bab' => $this->post('id_bab'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('invoice_settings', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }
    public function index_put()
    {
        $id = $this->put('id');
        $data = array(
                    'bank' => $this->put('bank'),
                    'no_rek' => $this->put('no_rek'),
                    'nama_rek' => $this->put('nama_rek')
                );
        $this->db->where('id', $id);
        $update = $this->db->update('invoice_settings', $data);
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
        $delete = $this->db->delete('invoice_settings');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        
        $jsonData = $this->db->get('invoice_settings')->result();
        if ( $id === null )
        {
            // Check if the datas data store contains datas
            if ( $jsonData)
            {
                // Set the response and exit
             
                $this->response( $jsonData, 200 );
            }
            else {
                $this->db->select("*");
                $this->db->from("invoice_settings");
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("invoice_settings");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}