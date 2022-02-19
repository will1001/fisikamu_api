<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;


class Tryout_part extends RestController {

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
                    'id_mapel' => $this->post('id_mapel'),
                    'nama_part' => $this->post('nama_part'),
                    'create_at' => date("Y-m-d H:i:s")
                );

        $insert = $this->db->insert('tryout_part', $data);
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
                    'id_paket' => $this->put('id_paket'),
                    'id_mapel' => $this->put('id_mapel'),
                    'nama_part' => $this->put('nama_part'),
                    'update_at' => date("Y-m-d H:i:s")
                );
        $this->db->where('id', $id);
        $update = $this->db->update('tryout_part', $data);
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
        $delete = $this->db->delete('tryout_part');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        
    }

    public function index_get()
    {
       
        $id = $this->get( 'id' );
        $id_paket = $this->get('id_paket');
        $jsonData = $this->db->get('tryout_part')->result();
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
                if($id_paket !== null){
                    $this->db->select("*");
                    $this->db->from("tryout_part");
                    $this->db->where('id_paket', $id_paket);
                    $this->db->order_by('id',"desc");
                    $jsonData = $this->db->get()->result();
                    $this->response( $jsonData, 200 );
                }
                else{
                    // Set the response and exit
                    $this->response( $jsonData, 200 );
                }
            }
        }
        else
        {
                $this->db->select("*");
                $this->db->from("tryout_part");
                $this->db->where('id', $id);
                $jsonData = $this->db->get()->result();
                $this->response( $jsonData, 200 );
        }
    }
}